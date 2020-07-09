<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 *
 */

 if (! function_exists('set_message')) {
     function set_message($status, $title, $message)
     {
         $notification_body = "
        <div class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='15000' data-autohide='true' style='min-width:250px'>
            <div class='toast-header bg-{$status}'>
                <strong class='mr-auto'>$title</strong>
                <small>".date('H:ia')."</small>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'><span>&times;</span></button>
            </div>
            <div class='toast-body'>
                $message
            </div>
        </div>
        ";
         session()->setFlashdata('notification', $notification_body);
     }
 }
 if (! function_exists('csv2Array')) {
     function csv2Array($file, $skipHeader = true)
     {
         $csv = [];
         try {
            //  if(pathinfo($file,PATHINFO_EXTENSION) != "csv"){
            //      throw new Exception("Wrong Acceptable format", 1);
            //  }
             $handle = fopen($file, 'r');
             while ($data = fgetcsv($handle)) {
                 array_push($csv, $data[1]);
             }
             fclose($handle);

             return $skipHeader?array_slice(array_unique($csv), 1):array_unique($csv);
         } catch (\Throwable $th) {
             echo $th->getMessage();
             return false;
         }
     }
 }
 if (!function_exists("get_settings")) {
    function get_settings($name)
    {
        $db = db_connect()->table("settings");
        return $db->getWhere(["type"=>$name])->getRow("description");
    }
}

if (! function_exists('is_logged_in')) {
    function is_logged_in()
    {
        return session()->has("logged_in") && session("logged_in") == true;
    }
}

if (! function_exists('auth_attempt')) {
    function auth_attempt(array $credentials)
    {
        $valid_username = env('login_username')??get_settings('username');
        $valid_password = env('login_password')??get_settings('password');

        $user = sha1($credentials['password']) == $valid_password && $credentials['username'] == $valid_username;
        if (!$user) {
            set_message('danger', 'Login Failed', 'Unable to log you in. Please check your credentials.');
            return false;
        }
        session()->set(["logged_in"=>true]);
        return true;
    }
}
if (! function_exists('goshen_errors')) {
    function goshen_errors(int $error_code)
    {
        switch ($error_code) {
             case 2905:
                return "Invalid username/password combination";
                break;
             case 2906:
                return "Credit exhausted";
                break;
             case 2907:
                return "Gateway unavailable";
                break;
             case 2908:
                return "Invalid schedule date format";
                break;
             case 2909:
                return "Unable to schedule";
                break;
             case 2910:
                return "Username is empty";
                break;
             case 2911:
                return "Password is empty";
                break;
             case 2912:
                return "Recipient is empty";
                break;
             case 2913:
                return "Message is empty";
                break;
             case 2914:
                return "Sender is empty";
                break;
             case 2915:
                return "One or more required fields are empty";
                break;
             case 2916:
                return "SMS sending failed units(etc Use of banned key words)";
                break;
            
            default:
                 return "SMS Sending Failed";
                break;
        }
    }
}
if (! function_exists('do_email')) {
    function do_email(string $to, string $subject, array $view_data, string $template='default')
    {
        $mail = service("phpmailer",false);

        try {
            $site_name      = env('email.sender_name')?? get_settings('sender_name');
            $site_email     = env('email.smtp_username')?? get_settings('smtp_username');

            if (env('email.mailer_type')?? get_settings('mailer_type') == "isSMTP") {
                $mail->isSMTP();
            } else {
                $mail->isMail();
            }
        
            $mail->Host = env('email.host')??get_settings('host');
            $mail->SMTPAuth = env('email.smtp_auth')?? get_settings('smtp_auth');
            $mail->Username = env('email.smtp_username')?? get_settings('smtp_username');
            $mail->Password = env('email.smtp_password')?? get_settings('smtp_password');
            $mail->SMTPSecure = env('email.smtp_secure')?? get_settings('smtp_secure');
            $mail->Port = env('email.port')?? get_settings('port');
            $mail->setFrom($site_email, $site_name);
            $mail->addReplyTo($site_email, $site_name);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->isHTML(true);

            $mail->Body = view("email/$template", $view_data);
        
            $mail->send();
            return true;
        } catch (\Throwable $th) {
            set_message("danger", "Mailer Error", $th->getMessage());
            return $th->getMessage();
            return false;
        } finally {
            $mail->smtpClose();
        }
    }
}
