<?php namespace App\Controllers;

class Scrapper extends BaseController
{
    public function nairaland()
    {
        if ($this->request->getMethod() == "post") {
            $request = $this->request->getPost();
            helper("scrapper");
            try {
                 $payload = havester($request["category"], $request["pages"], $request["email_pattern"], $request["phone_pattern"], $request["email_pattern"], $request["phone_pattern"]);
                $data['emails'] = array_unique($payload['emails']);
                $data['phones'] = array_unique($payload['phones']);
                $data["category"] = $request["category"];
            } catch (\Throwable $th) { 
                set_message('danger', 'Unsuccessful', 'Something went wrong. Please check your internet connection');
                return redirect()->back() ;
            }
        }
        $data['title'] = "Nairaland";
        return view('scrapper/nairaland', $data);
    }
    public function saveContacts()
    {
        $phonegroupmodel = model("phonegroupmodel");
        $request = $this->request->getPost();
        
        if ($request['group'] == "existing_group") {
            $data['id'] =  $request['id'];
            $data['numbers'] = unserialize($request['entry']);
            $phonegroupmodel->updateGroup($data)?set_message('success', 'Group', 'Group updated successfully'):set_message('danger', 'Group', 'Error while updating group');
        } else {
            $data['name'] =  $request['new_group_name'];
            $data['numbers'] = unserialize($request['entry']);
            $phonegroupmodel->saveGroup($data)?set_message('success', 'Group', 'New group created successfully'):set_message('danger', 'Group', 'Error while creating group');
        }
        return redirect()->back() ;
    }
    public function saveEmailContacts()
    {
        $emailgroupmodel = model("emailgroupmodel");
        $request = $this->request->getPost();
        
        if ($request['group'] == "existing_group") {
            $data['id'] =  $request['id'];
            $data['address'] = unserialize($request['entry']);
            $emailgroupmodel->updateGroup($data)?set_message('success', 'Group', 'Group updated successfully'):set_message('danger', 'Group', 'Error while updating group');
        } else {
            $data['name'] =  $request['new_group_name'];
            $data['address'] = unserialize($request['entry']);
            $emailgroupmodel->saveGroup($data)?set_message('success', 'Group', 'New group created successfully'):set_message('danger', 'Group', 'Error while creating group');
        }
        return redirect()->back() ;
    }



    //--------------------------------------------------------------------
}
