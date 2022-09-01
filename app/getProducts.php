<?php 

  //header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Cache-Control");
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  // header('content-type: application/json; charset=utf-8');
 
  include '../include/utils/Shopify.php';
  include '../include/utils/Tools.php';


  $Shopify = new Shopify();
  $Stores = new Stores();
  $shop_url = "bobo-pops.myshopify.com";//Tools::getShopUrl()
  $access_token = "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"; 
  $coll_id = "";



  $getProducts =  $Shopify->getProducts($shop_url, $access_token,$coll_id);
  echo json_encode($getProducts);
  // print_r($getProducts)

  

?>