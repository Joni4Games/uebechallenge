<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require 'passwords.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.strato.de';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $username;                              //SMTP username
    $mail->Password   = $password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->CharSet    = 'UTF-8';
    $mail->Encoding   = 'base64';

    //Recipients
    $mail->setFrom($sender, 'Jugendorchesterschule');
    $mail->addAddress($mailadress, $mailadress);                //Add a recipient
    //$mail->addAddress('ellen@example.com');                   //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Übezeit überprüfen';
    $mail->Body    = '<p>Bitte bestätige die Übezeit über ' . $time . ' Minuten. Klicke dafür auf diesen Link:</p><br><a href="https://jugendorchesterschule.de/actions/linkchecked.php?code=' . $code . '">Übezeit bestätigen</a>';
    //$mail->Body    = '<p>Du hast diese E-Mail bekommen, weil Du dein Passwort zurücksetzen möchtest.<br>Bitte klicke dafür auf diesen Link:</p><a href="https://jugendorchesterschule.de/passwordform.php?code=' . $ccode . '">Passwort zurücksetzen</a>';
    $mail->AltBody = 'Bitte bestätigt die Übezeit. Nutze dafür diesen Link: https://jugendorchesterschule.de/passwordform.php?code=' . $code;

    $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}