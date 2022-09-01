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
  $order_id = '4437820932174';

  $mail_products = '';
  $bundled_products = '';

  $orderById =  $Shopify->getOrderById($shop_url, $access_token,$order_id);
 
   
   //echo "<pre>";
  //print_r($orderById);
  //print_r($orderById->order->line_items);

  ?>
  <center><b>Order Number- </b><?php echo $orderById->order->name; ?></center>
  
  <br>
  <center><b>Total products ordered - </b><?php echo sizeof($orderById->order->line_items); ?></center>
  <br>
  <b><u>Products ordered detail</u></b> <br>
  <?php 
  $count_line_items = sizeof($orderById->order->line_items);
  for($i=0;$i<$count_line_items;$i++){
    $prod_id = $orderById->order->line_items[$i]->product_id; 

    $var_id = $orderById->order->line_items[$i]->variant_id;
    $productById =  $Shopify->getProductById($shop_url, $access_token,$prod_id,$var_id);
    $productDetail =  $Shopify->getProductDetail($shop_url, $access_token,$prod_id);
    //echo "<pre>"; 
    //print_r($productDetail);
    $productTags = $productDetail->product->tags;
    if (str_contains($productTags, 'Inventory')) { 
        // db insert and update
    $product_info = $Stores->getProductData($prod_id);
    $qty_stored = $product_info[0]['qty_ordered'];
     
    if(!empty($product_info)){
      $updateProductData = $Stores->updateProductData($prod_id, array(
            "qty_ordered" => $orderById->order->line_items[$i]->quantity + $qty_stored
     ));
    } 
  else {
    $Stores->add(array(
     "product_handle" => $orderById->order->line_items[$i]->name,
     "product_id" => $prod_id,
     "qty_ordered" => $orderById->order->line_items[$i]->quantity,
     "created_at" => $orderById->order->created_at
    ));
    //echo "data inserted";
  }
       $str_tag = explode (",", $productTags);
       $tag_count = sizeof($str_tag);
       for($j=0;$j<$tag_count;$j++){
           if(str_contains($str_tag[$j],'product_handle')){
            $qty ="-".$orderById->order->line_items[$i]->quantity;
            $prod_hand = explode('product_handle:',$str_tag[$j]);
            $product_handle = $prod_hand[1];
            $productInventory = $Shopify->getInventory($shop_url,$access_token,$product_handle);
            //print_r($productInventory);

            $inventory_id = $productInventory->products[0]->variants[0]->inventory_item_id;
            $getProductInventoryDetails = $Shopify->getProductInventoryDetails($shop_url,$access_token,$inventory_id);
            //print_r($getProductInventoryDetails);
            $inv_id = $getProductInventoryDetails->inventory_levels[0]->inventory_item_id;
            $location_id = $getProductInventoryDetails->inventory_levels[0]->location_id;
            //$updateInventory = $Shopify->updateInventory($shop_url,$access_token,$inv_id,$location_id,$qty);
            //echo "Inventory updated";
            //print_r($updateInventory);
         }
       }
    }
?>
  <b>Product-<?php echo $i+1; ?> name : </b><?php echo $orderById->order->line_items[$i]->name; ?><br>
  <b>Bundled products : </b><br> 
  <?php $str_tag = explode (",", $productTags);
       $tag_count = sizeof($str_tag);
       for($j=0;$j<$tag_count;$j++){
           if(str_contains($str_tag[$j],'product_handle')){
            $prod_hand = explode('product_handle:',$str_tag[$j]);
            $product_handle = $prod_hand[1];
            echo $product_handle."<br>";
           }
        }

    if(str_contains($productTags,'Minimum')){
        $min_qty = explode('Minimum_',$productTags);
        //echo "min qty ".$min_qty[1];
        $mqty = explode(',',$min_qty[1]);
        $inventory = $productDetail->product->variants[0]->old_inventory_quantity;
        //echo "inventory ".$inventory;
        //echo $mqty[0]."<".$inventory;
        if($mqty[0] >= $inventory){
          $mail_products .= 'Product '.$productDetail->product->title." has reached to Minimum quantity"."<br>";
        }
    }
  ?>
  <b>Quantity ordered : </b><?php echo $orderById->order->line_items[$i]->quantity; ?><br>
  <b>Product Inventory : </b><?php echo $productById->variant->old_inventory_quantity; ?><br>
  
  <hr>
 <?php  }

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
    $mail->addAddress('priya@acmeintech.in', 'Olivier');  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Alert !! Minimum quantity';
    $mail->Body    = $mail_products;
    $mail->AltBody = 'Minimum quantity threshold';

    $mail->send();
        echo json_encode(["message"=>'Message has been sent',"success"=>"true"]);
    } catch (Exception $e) {
        echo json_encode(["success"=>"false", "message","Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
 echo $mail_products;
 exit;
?>