<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include '../include/db/Store.php';
include '../include/utils/Shopify.php';

$Shopify = new Shopify();
$Stores = new Stores();

$shop = null;
if(isset($_REQUEST['shop'])){
	$shop = $_REQUEST['shop'];
}

$code = isset($_GET["code"]) ? $_GET["code"] : false;

if($shop && !$code){
	if(!$Shopify->validateMyShopifyName($shop)){
		echo "Invalid shop url";
	}

	// $is_installation_from_shopify = $Shopify->validateRequestOriginIsShopify($code,$shop,$timestamp,$signature);
	// echo "$is_installation_from_shopify";
	// if(!$is_installation_from_shopify){
		$redirect_url = $Shopify->getAuthUrl($shop);
		header("Location: $redirect_url");
	// }else{
		// $Shopify->getAuthUrl($shop);
	// }	
}

if($code){

	$exchange_token_response = $Shopify->exchangeTempTokenForPermanentToken($shop, $code);
	// print_r($exchange_token_response);
	// die;
	if(!isset($exchange_token_response->access_token) && isset($exchange_token_response->errors)) {
	// access token is not valid, redirect user to error page
	// echo "<pre>";
	// print_r($exchange_token_response->errors);
	// echo "</pre>";
	}

	// echo "<pre>";
	print_r($exchange_token_response['access_token']);
	// echo "</pre>";

	$access_token = $exchange_token_response['access_token'];
	$shop_info = $Stores->isShopExists($shop);
	
	if(empty($shop_info)){		
		$Stores->addData(array(
		"store_url" => $shop,
		"access_key" => SHOPIFY_API_KEY,
		"access_token" => $access_token
		// "created_at" => date("Y-m-d")
		));		

	}else{
		$Stores->updateData(array(
		"access_key" => SHOPIFY_API_KEY,
		"access_token" => $access_token,
		// "modified_at" => date("Y-m-d")
		), "store_url = '$shop'");
	}
	header("Location:" . APP_URL . "?shop=$shop");
}

?>

<form action="" method="post">
	<input type="text" name="shop" value="" placeholder="Your store name">
	<input type="submit" name="submit">
	
</form>