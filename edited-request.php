<?php

/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
require_once("PaytmChecksum.php");

$paytmParams = array(
    "mid"             => "EAYZZm89707374490316",
    "linkType"        => "GENERIC",
    "linkDescription" => "Test Payment",
    "linkName"        => "Test",
    "amount"          => "1",
    "sendEmail"       => "1",
    "customerName"    => "selva",
    "customerEmail"   => "avles.personal@gmail.com"
);

//$paytmParams["body"] = array(
    
//);

/*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams, JSON_UNESCAPED_SLASHES), "s#9st2y#VTIPf2rD");

/*$paytmParams["head"] = array(
    "tokenType"	      => "AES",
    "signature"	      => $checksum
);*/

$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
$url = "https://securegw-stage.paytm.in/link/create";

/* for Production */
// $url = "https://securegw.paytm.in/link/create";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("tokenType : AES","signature:".$checksum)); 
$response = curl_exec($ch);
print_r($response);

?>
