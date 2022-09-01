<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
  $str_json = file_get_contents('php://input');
   $req_data = json_decode($str_json);
  $email = $req_data->email;
  $pdf_url = "test";


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.zoho.com';                //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'nick@eshopgenius.com';                     //SMTP username
    $mail->Password   = 'LouchoLove@eshopgenius123';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
$mail->SMTPDebug = 2;
    //Recipients
    $mail->setFrom('nick@eshopgenius.com', 'Minimum threshold');
    $mail->addAddress('priyamehrotra02@gmail.com', 'Olivier');  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Minimum quantity threshold';
    $mail->Body    = '<p><a href="'.$pdf_url.'">Download certificate</a></p>';
    $mail->AltBody = 'DIY School certificate';

    $mail->send();
        echo json_encode(["message"=>'Message has been sent',"success"=>"true"]);
    } catch (Exception $e) {
        echo json_encode(["success"=>"false", "message","Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }