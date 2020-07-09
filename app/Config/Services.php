<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

require_once SYSTEMPATH . 'Config/Services.php';
require_once(APPPATH."ThirdParty/PHPMailer/src/Exception.php");
require(APPPATH."ThirdParty/PHPMailer/src/PHPMailer.php");
require(APPPATH."ThirdParty/PHPMailer/src/SMTP.php");


class Services extends CoreServices
{
    public static function phpmailer($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('phpmailer');
        }
    
        return new \PHPMailer\PHPMailer\PHPMailer(true);
    }
}
