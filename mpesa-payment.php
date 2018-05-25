<?php

$response_data=file_get_contents("php://input");

$obj=json_decode($response_data);

$data=array();

$service_name=$obj->{"service_name"};
$business_number=$obj->{"business_number"};
$transaction_reference=$obj->{"transaction_reference"};
$transaction_timestamp=$obj->{"transaction_timestamp"};
$transaction_type=$obj->{"transaction_type"};
$account_number=$obj->{"account_number"};
$sender_phone=$obj->{"sender_phone"};
$amount=$obj->{"amount"};
$currency=$obj->{"currency"};
$signature=$obj->{"signature"};

if($business_number=="941499"){
	// the phone number is $sender_phone
	// airtime amount is $amount
	//use the api here
}
?>