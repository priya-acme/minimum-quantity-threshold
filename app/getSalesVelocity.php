<?php 
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
 
  include '../include/utils/Shopify.php';
  include '../include/utils/Tools.php';
  include "../include/db/Stores.php";


  $Shopify = new Shopify();
  $Stores = new Stores();
  $shop_url = "original-garage-moto.myshopify.com";//Tools::getShopUrl()
  $access_token = "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"; 

  $str_json = file_get_contents('php://input');
  $data = json_decode($str_json, true);
  $getAllData = $Stores->getAllData();
  $data = sizeof($getAllData);
  
  $sales = '<h2>Sales velocity data</h2>';
  $sales .= '<table border="1"><tr><th>S.No.</th><th>Product Title</th><th>Product Id</th><th>Sales velocity</th></tr>';
    for($i=0;$i<$data;$i++){ 
      $ii = $i + 1;
    $sales .= '<tr><td>'.$ii.'</td>';
    $sales .= '<td>'.$getAllData[$i]['product_handle'].'</td>';
    $sales .= '<td>'.$getAllData[$i]['product_id'].'</td>';
    $sales .= '<td>'.$getAllData[$i]['qty_ordered'].'</td>';
    $sales .= '</tr>'; 
    }
    $sales .='</table>';

 echo $sales;
// mail function


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$str_json = file_get_contents('php://input');
$req_data = json_decode($str_json);


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
    $mail->setFrom('nick@eshopgenius.com', 'Sales Velocity');
    $mail->addAddress('priya@acmeintech.in', 'Olivier');  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Alert !! Sales velocity';
    $mail->Body    = $sales;
    $mail->AltBody = 'Minimum quantity threshold';

    $mail->send();
        echo json_encode(["message"=>'Message has been sent',"success"=>"true"]);
    } catch (Exception $e) {
        echo json_encode(["success"=>"false", "message","Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
  ?>