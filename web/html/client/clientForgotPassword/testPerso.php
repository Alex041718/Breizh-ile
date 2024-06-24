<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

//Load Composer's autoloader
//require 'vendor/autoload.php';

function sendmail(String $email, $token)
{
//Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.laposte.net';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'crepe-tech@laposte.net';                     //SMTP username
        $mail->Password = 'hR7cv^EV?29m=3';                               //SMTP password
        $mail->SMTPSecure = 'SSL'; //PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('crepe-tech@laposte.net', 'Breizh-Ile');
        $mail->addAddress($email);     //Add a recipient

//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Modification de votre mot de passe';
//        $mail->Body = 'Change you password right <a href="http://localhost:5555/client/clientForgotPassword/reset-password-page.php?token='. $token .'">here</a>';
        $mail->Body = 'Changer votre mot de passe en cliquant <a href="https://crepetech.ventsdouest.dev/client/clientForgotPassword/reset-password-page.php?token='. $token .'">juste ici</a>.';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        header("Location: /client/forgot-password?success=true");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
