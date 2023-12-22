<?php

namespace App\Controller\Support;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail
{
    private   $para_email;
    private  $para_nome;
    private  $error;


    public function __construct()
    {
        $this->para_email = "parceiro@soenu.com";
        $this->para_nome = "OLÁ SMS";
    }

    public function sendEmail($paraOndem, $nomeDoParaOnde, $QuemEstaEnviar, $nomeDeQuemEnvia, $assunto, $corpo)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(false);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = USERNAME;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = USERNAME;                     //SMTP username
            $mail->Password   = SENHA_EMAIL;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;
            $mail->CharSet = PHPMailer::CHARSET_UTF8;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($QuemEstaEnviar, $nomeDeQuemEnvia);
            $mail->addAddress($paraOndem, $nomeDoParaOnde);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            /* $mail->addBCC('admin@qlerius.com'); */

            //Attachments
            /*  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   */  //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $assunto;
            $mail->Body    = $corpo;
            $mail->AltBody = 'OLASMS';
            //$mail->msgHTML(file_get_contents('email.html'), __DIR__);
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            };
        } catch (Exception $e) {
            //echo "erro no envio: {$mail->ErrorInfo}";
            return false;
        }
    }


    public function sendEmailRecupracao($paraOndem, $nomeDoParaOnde, $QuemEstaEnviar, $nomeDeQuemEnvia, $assunto, $corpo)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(false);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.seu.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'seunome';                     //SMTP username
            $mail->Password   = 'suasenah';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;
            $mail->CharSet = PHPMailer::CHARSET_UTF8;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($QuemEstaEnviar, $nomeDeQuemEnvia);
            $mail->addAddress($paraOndem, $nomeDoParaOnde);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            $mail->addBCC('admin@soenu.com',);


            //Attachments
            /*  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   */  //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $assunto;
            $mail->Body    = $corpo;
            $mail->AltBody = 'Michak Canive';
            //$mail->msgHTML(file_get_contents('email.html'), __DIR__);
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            };
        } catch (Exception $e) {
            //echo "erro no envio: {$mail->ErrorInfo}";
            return false;
        }
    }
}
