<?php namespace App\Controllers;

class Bulk extends BaseController
{
    public function compose()
    {
        $data['title'] = "compose";
        
        return view('sms/compose', $data);
    }
    public function sendCompose()
    {
        $phonegroupmodel = model("phonegroupmodel");
        $draftmodel = model("draftmodel");
        $request = $this->request->getPost();
        $recipients = [];
        $message 	= "";
        if ($request['source'] == "manual") {
            $recipients =  $request['recipients'];
        } elseif ($request['source'] == "upload") {
            $file = $_FILES['csv_file'];
            if (pathinfo($file['name'], PATHINFO_EXTENSION) != "csv") {
                set_message('warning', 'Invalid File', 'Only csv files are allowed');
                return redirect()->back() ;
            }
            $recipients = csv2Array($file['tmp_name']);
        } elseif ($request['source'] == "group") {
            $recipients = unserialize($phonegroupmodel->find($request['group_id'])->numbers);
        }
        if (isset($request['group'])) {
            if ($request["group"] == "new") {
                $data['name'] =  $request['new_group_name'];
                $data['numbers'] = $recipients;
                $phonegroupmodel->saveGroup($data);
            } else {
                $data['id'] =  $request['group_id'];
                $data['numbers'] = $recipients;
                $phonegroupmodel->updateGroup($data);
            }
        }
        if ($request["message_source"] == "write_new") {
            $message = $request['message'];
        } elseif ($request["message_source"] == "from_draft") {
            $message = $draftmodel->find($request["draft_id"])->body;
        }
        if (isset($request["show_save_draft"])) {
            if ($request["draft_source"] == "new_draft") {
                $draftmodel->save([
                    "title"=>$request['new_draft_name'],
                    "body"=>$message
                ]);
            } elseif ($request["draft_source"] == "existing_draft") {
                $draftmodel->save([
                    "id"=>$request['save_draft_id'],
                    "body"=>$message
                ]);
            }
        }
        $query = http_build_query([
            "username"=>env('goshen.username')??get_settings('goshen_username'),
            "password"=>env('goshen.password')??get_settings('goshen_password'),
            "sender"=>env('goshen.sender_id')??get_settings('sender_id'),
            "recipient"=>implode(",", $recipients),
            "message"=>$message.get_settings('sms_signature')
        ]);
        $api_call = "http://goshensms.com/components/com_spc/smsapi.php?".$query;

        $res = @file_get_contents($api_call);
        $sent = stristr($res, "OK");
        model("smshistorymodel")->save([
            "response"=>$res,
            "gateway"=>"Goshen SMS",
            "phone"=>serialize($recipients),
            "status"=>$sent ? "OK": "FAILED",
            "api_call"=>$api_call
        ]);
        if ($sent) {
            set_message('success', 'Success', 'Message Sent to '.count($recipients).' numbers');
        } else {
            set_message('danger', 'Failed', 'Failed to send message. '.goshen_errors($res));
        }
        return redirect()->back() ;
    }
    public function sendEmailCompose()
    {
        $emailgroupmodel = model("emailgroupmodel");
        $emaildraftmodel = model("emaildraftmodel");
        $request = $this->request->getPost();
        $recipients = [];
        $subject = "";
        $message 	= "";
        if ($request['source'] == "manual") {
            $recipients =  $request['recipients'];
        } elseif ($request['source'] == "upload") {
            $file = $_FILES['csv_file'];
            if (pathinfo($file['name'], PATHINFO_EXTENSION) != "csv") {
                set_message('warning', 'Invalid File', 'Only csv files are allowed');
                return redirect()->back() ;
            }
            $recipients = csv2Array($file['tmp_name']);
        } elseif ($request['source'] == "group") {
            $recipients = unserialize($emailgroupmodel->find($request['group_id'])->address);
        }
        if (isset($request['group'])) {
            if ($request["group"] == "new") {
                $data['name'] =  $request['new_group_name'];
                $data['address'] = $recipients;
                $emailgroupmodel->saveGroup($data);
            } else {
                $data['id'] =  $request['group_id'];
                $data['address'] = $recipients;
                $emailgroupmodel->updateGroup($data);
            }
        }
        if ($request["message_source"] == "write_new") {
            $message = $request['message'];
            $subject = $request['subject'];
        } elseif ($request["message_source"] == "from_draft") {
            $draft = $emaildraftmodel->find($request["draft_id"]);
            $subject = $draft->title;
            $message = $draft->body;
        }
        if (isset($request["show_save_draft"])) {
            if ($request["draft_source"] == "new_draft") {
                $emaildraftmodel->save([
                    "title"=>$request['new_draft_name'],
                    "body"=>$message
                ]);
            } elseif ($request["draft_source"] == "existing_draft") {
                $emaildraftmodel->save([
                    "id"=>$request['save_draft_id'],
                    "title"=>$request['subject'],
                    "body"=>$message
                ]);
            }
        }
        $message.="<p>".get_settings('email_signature')."</p>";
        $mail_data  = [
            'subject' =>$subject,
            'message'  =>$message
            ];
        $status = '';
        foreach ($recipients as $email) {
            $status = do_email($email, $mail_data["subject"], $mail_data, 'default');
        }
        if ($status === true) {
            set_message('success', 'Success', 'Mail Sent to '.count($recipients).' email(s)');
        }
        model("emailhistorymodel")->save([
            "address"=>serialize($recipients),
            "status"=>(string)$status,
            'subject' =>$subject,
            'message'  =>$message,
            "meta"=>serialize([
                "mailer_type"=>env('email.mailer_type')?? get_settings('mailer_type'),
                "host"=>env('email.host')??get_settings('host'),
                "port"=>env('email.port')??get_settings('port')
            ])
        ]);

        return redirect()->back() ;
    }

    public function draft()
    {
        $draftmodel = model("draftmodel");
        $emaildraftmodel = model("emaildraftmodel");

        if ($id = $this->request->getGet("id")) {
            if ($this->request->getGet("type") == "email") {
                $data["edite"] = $emaildraftmodel->find($id);
            } else {
                $data["edit"] = $draftmodel->find($id);
            }
        }

        $data['title'] = "Draft";
        $data["drafts"] =  $draftmodel->orderBy("id", "desc")->findall();
        $data["emaildrafts"] =  $emaildraftmodel->orderBy("id", "desc")->findall();

        return view('sms/draft', $data);
    }
    public function saveDraft()
    {
        $rules = [
            'title'  	    => 'required|min_length[5]|max_length[15]|is_unique[draft.title]',
            'body'  	    => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        model('draftmodel')->save($this->request->getPost())?set_message('success', 'Draft', 'Draft created/updated successfully'):set_message('danger', 'Draft', 'Error while saving draft');
        return redirect()->back() ;
    }
    public function saveEmailDraft()
    {
        $rules = [
            'title'  	    => 'required|is_unique[draft.title]',
            'body'  	    => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email')->withInput()->with('errors', $this->validator->getErrors());
        }
        
        model('emaildraftmodel')->save($this->request->getPost())?set_message('success', 'Email Draft', 'Draft created successfully'):set_message('danger', 'Draft', 'Error while saving draft');
        return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email') ;
    }

    public function deleteDraft()
    {
        if (! $this->validate(['checkbox'  	=> 'required'])) {
            set_message("warning", "Warning", $this->validator->getError());
            return redirect()->back()->withInput();
        }
        model('draftmodel')->delete($this->request->getPost("checkbox"));
        return redirect()->back() ;
    }
    public function deleteEmailDraft()
    {
        if (! $this->validate(['checkbox'  	=> 'required'])) {
            set_message("warning", "Warning", $this->validator->getError());
            return redirect()->back()->withInput();
        }
        model('emaildraftmodel')->delete($this->request->getPost("checkbox"));
        return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email') ;
    }
    public function history()
    {
        $smshistorymodel = model("smshistorymodel");
        $emailhistorymodel = model("emailhistorymodel");

        if ($id = $this->request->getGet("id")) {
            if ($this->request->getGet("type") == "email") {
                $data["moree"] = $emailhistorymodel->find($id);
            } else {
                $data["more"] = $smshistorymodel->find($id);
            }
        }

        $data['title'] = "History";
        $data["history"] =  $smshistorymodel->orderBy("id", "desc")->findall();
        $data["historye"] =  $emailhistorymodel->orderBy("id", "desc")->findall();

        return view('sms/history', $data);
    }
    public function deleteHistory()
    {
        if (! $this->validate(['checkbox'  	=> 'required'])) {
            set_message("warning", "Warning", $this->validator->getError());
            return redirect()->back()->withInput();
        }
        model('smshistorymodel')->delete($this->request->getPost("checkbox"));
        return redirect()->back() ;
    }
    public function deleteEmailHistory()
    {
        if (! $this->validate(['checkbox'  	=> 'required'])) {
            set_message("warning", "Warning", $this->validator->getError());
            return redirect()->back()->withInput();
        }
        model('emailhistorymodel')->delete($this->request->getPost("checkbox"));
       return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email') ;

    }

    public function group()
    {
        $phonegroupmodel = model("phonegroupmodel");
        $emailgroupmodel = model("emailgroupmodel");


        if ($id = $this->request->getGet("id")) {
            if ($this->request->getGet("type") == "email") {
                $data["edite"] = $emailgroupmodel->find($id);
            } else {
                $data["edit"] = $phonegroupmodel->find($id);
            }
        }

        $data['title'] = "Group";
        $data["groups"] =  $phonegroupmodel->orderBy("id", "desc")->findall();
        $data["email_groups"] =  $emailgroupmodel->orderBy("id", "desc")->findall();
        return view('sms/group', $data);
    }
    public function createGroup()
    {
        $request = $this->request->getPost();
        if ($request['source'] == "upload") {
            $file = $_FILES['csv_file'];
            if (pathinfo($file['name'], PATHINFO_EXTENSION) != "csv") {
                set_message('warning', 'Invalid File', 'Only csv files are allowed');
                return redirect()->back() ;
            }
            $request['numbers'] = csv2Array($file['tmp_name']);
        }
        
        model("phonegroupmodel")->saveGroup($request)?set_message('success', 'Group', 'New group created successfully'):set_message('danger', 'Group', 'Error while creating group');
        return redirect()->back() ;
    }
    public function createEmailGroup()
    {
        $request = $this->request->getPost();
        if ($request['source'] == "upload") {
            $file = $_FILES['csv_file'];
            if (pathinfo($file['name'], PATHINFO_EXTENSION) != "csv") {
                set_message('warning', 'Invalid File', 'Only csv files are allowed');
                return redirect()->back() ;
            }
            $request['address'] = csv2Array($file['tmp_name']);
        }
        
        model("emailgroupmodel")->saveGroup($request)?set_message('success', 'Group', 'New group created successfully'):set_message('danger', 'Group', 'Error while creating group');
        return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email') ;
    }

    public function updateGroup()
    {
        model("phonegroupmodel")->updateGroup($this->request->getPost())?set_message('success', 'Group', 'Group updated successfully'):set_message('danger', 'Group', 'Error while updating group');
        return redirect()->back() ;
    }
    public function updateEmailGroup()
    {
        model("emailgroupmodel")->updateGroup($this->request->getPost())?set_message('success', 'Group', 'Group updated successfully'):set_message('danger', 'Group', 'Error while updating group');
        return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email') ;
    }
    public function deleteGroup()
    {
        model("phonegroupmodel")->delete($this->request->getPost("id"));
        return redirect()->back() ;
    }
    public function deleteEmailGroup()
    {
        model("emailgroupmodel")->delete($this->request->getPost("id"));
        return redirect()->to($_SERVER['HTTP_REFERER'].'#animated-underline-email') ;
    }
    public function settings()
    {
        $data['title'] = "Settings";
        $data['unit'] = @file_get_contents("http://www.goshensms.com/components/com_spc/smsapi.php?username=".get_settings('goshen_username')."&password=".get_settings('goshen_password')."&balance=true&");

        return view('sms/settings', $data);
    }
    public function saveSettings()
    {
        $request = $this->request->getPost();
        $db = db_connect()->table("settings");
        foreach ($request as $key => $value) {
            if ($db->getWhere(["type"=>$key])->getRow()) {
                $db->update(["description"=>$value], ["type"=>$key]);
            } else {
                $db->insert(["type"=>$key,"description"=>$value]);
            }
        }
        set_message("success", "Successful", "Your configuration has been saved");
        return redirect()->back();
    }
    public function passwordUpdate()
    {
        if (! $this->validate(['password' => 'required|min_length[6]|matches[confirm_password]'])) {
            set_message("warning", "Error", $this->validator->getError());
            return redirect()->back();
        }
        $request = $this->request->getPost();
        $db = db_connect()->table("settings");
        $oldpassword = get_settings("password");
        if ($oldpassword) {
            if ($oldpassword == sha1($request["current_password"])) {
                $db->update(["description"=>sha1($request["password"])], ["type"=>"password"])?set_message("success", "Successful", "Your password has been updated"):set_message("danger", "Error", "Your password was not updated");
            } else {
                set_message("danger", "Not Successful", "Incorrect Password. Check your current password again");
            }
        } else {
            $db->insert(["type"=>"password","description"=>sha1($request["password"])])?set_message("success", "Successful", "Your password has been saved"):set_message("danger", "Error", "Your password was not saved");
        }
        
        return redirect()->back();
    }

    //--------------------------------------------------------------------
}
