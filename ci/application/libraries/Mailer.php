<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{

    var $mail;

    public function __construct()
    {
        $this->CI =& get_instance();

        // the true param means it will throw exceptions on errors, which we need to catch
        $this->mail = new PHPMailer(true);

        $this->mail->IsSMTP(); // telling the class to use SMTP

        $this->mail->CharSet = 'utf-8';                  // 一定要設定 CharSet 才能正確處理中文
        $this->mail->SMTPDebug = false;                     // enables SMTP debug information
        $this->mail->SMTPAuth = true;                  // enable SMTP authentication
        $this->mail->SMTPSecure = 'ssl';                 // sets the prefix to the servier
        $this->mail->Host = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
        $this->mail->Port = 465;                   // set the SMTP port for the GMAIL server
        $this->mail->Username = 'chimeinep3@gmail.com';                // GMAIL username
        $this->mail->Password = 'chimein!@#';       // GMAIL password
        $this->mail->IsHTML(true);
    }

    public function sendmail($to, $subject, $body, $dir = null, $filename = null)
    {
        try {
            $send_account = $this->getSenderemail();
            foreach ($to as $value) {
                $this->mail->AddAddress($value);
            }
            $send_email = explode(',', $send_account['email']);
            $this->mail->SetFrom($send_email[0], $send_account['name']);
            foreach ($send_email as $value) {
                $this->mail->AddReplyTo($value, $send_account['name']);
            }
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            if ($dir != null && $filename != null) {
                $this->mail->AddAttachment($dir, rtrim($filename));
            }
            if ($dir != null && $filename == null) {
                $this->mail->AddAttachment($dir);
            }
            $this->mail->Send();

            return '您的訊息已寄出。';
        } catch (phpmailerException $e) {
            return $e->errorMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //取得寄件者電子郵件
    function getSenderemail()
    {
        $e_mail = array();
        if ($this->CI->session->userdata('e_mail') == '') {
            $e_mail['email'] = 'system@chimeiep.gov.tw';
            $e_mail['name'] = '系統開發小組';
        } else {
            $e_mail['email'] = $this->CI->session->userdata('e_mail');
            $e_mail['name'] = $this->CI->session->userdata('name') . ' ' . $this->CI->session->userdata('identity_name');
        }

        return $e_mail;
    }
}

/* End of file mailer.php */
