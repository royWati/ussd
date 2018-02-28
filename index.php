<?php

include("./class.php");


$SESSIONID = $_GET["SESSIONID"];
$USSDCODE = rawurldecode($_GET["USSDCODE"]);
$MSISDN = $_GET["MSISDN"];
$INPUT = rawurldecode($_GET["INPUT"]);

$input_array=explode("*",$INPUT);



if(Data::number_exists($MSISDN)==1){
	if(sizeof($input_array)==1){
		# user exists
		$level_one=$input_array[sizeof($input_array)-1];
		if($level_one=="04"){

			# 04

			$response="CON Welcome to AirtimeZone Service \n 1. Buy Airtime \n 2. Refer Member\n 3. My Account \n 4. Pay Utility bills \n 5. Help \n 6.Feedback";
		}
	}else if(sizeof($input_array)==2){
		$level_two=$input_array[sizeof($input_array)-1];
		if ($level_two=="1") {
			# 04*1
			$response="CON Buy Airtime From \n 1. Direct Top up \n 2. Wallet \n 3. Earning";
		}elseif($level_two=="2"){

			# 04*2
			$response="CON ENTER NAME OF THE REFER \n ";
		}elseif($level_two=="3"){

			# 04*3
				$response="CON My Account \n 1. Today \n 2. Load Wallet \n 3. Income \n 4. Withdraw \n 5. Mini Statement\n 6. Members \n 7. Reset Pin";
		}elseif($level_two=="4"){
			# 04*4
				$response="CON Pay Utility Bills \n 1. Kenya Power \n 2. Nairobi Water \n 3. NHIF \n 4. Pay TV";
		}elseif($level_two=="5"){
			# 04*5
				$response="CON Help \n 1. Wallet Top up \n 2. Check Income \n 3. Paybills ";
		}elseif($level_two=="6"){
			# 04*6
				$response="CON Customer Feedback \n Enter your feedback below";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==3) {

		$level_two=$input_array[sizeof($input_array)-2];
		$level_three=$input_array[sizeof($input_array)-1];

		if($level_two=="1"){

			# 04*1*1
			$response="CON \n 1. Buy For Self \n 2. Buy for Other";
		}else if($level_two=="2" && $level_three !=null){

			# 04*2*chris
			$response="CON ENTER PHONE NUMBER OF THE REFER \n (e.g 254XXXXXXXX)";
		}elseif ($level_two=="3" && $level_three=="1") {
				# 04*3*1
				$response="CON Today \n 1. Airtime \n 2. Earnings \n a. Actual \n b. Supposed \n 3. Members";
		}elseif ($level_two=="3" && $level_three=="2") {
				# 04*3*2
				$response="CON Enter Amount";
		}elseif ($level_two=="3" && $level_three=="3") {
				# 04*3*3
				$response="CON \n 1. Actual \n 2. Supposed";
		}elseif ($level_two=="3" && $level_three=="4") {
				# 04*3*4
				$response="CON Enter Amount";
		}elseif ($level_two=="3" && $level_three=="5") {
				# 04*3*5
				$response="CON \n Enter Your email Adress";
		}elseif ($level_two=="3" && $level_three=="6") {
				# 04*3*6
				$response="CON \n 1. Direct Members \n 2. All Members";
		}elseif ($level_two=="3" && $level_three=="7") {
				# 04*3*7
				$response="CON \n Current Pin";
		}elseif ($level_two=="4" && $level_three=="1") {
				# 04*4*1
				$response="CON \n Enter Your Meter Number";
		}elseif ($level_two=="4" && $level_three=="2") {
				# 04*4*2
				$response="CON \n Enter Your Meter Number";
		}elseif ($level_two=="4" && $level_three=="3") {
				# 04*4*1
				$response="CON \n Enter Your Membership Number";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}

	}elseif (sizeof($input_array)==4) {
			$level_two=$input_array[sizeof($input_array)-3];
			$level_three=$input_array[sizeof($input_array)-2];
			$level_four=$input_array[sizeof($input_array)-1];

			if($level_two=="1"){
				if ($level_three=="1" && $level_four=="1") {
					# 04*1*1*1
					$response="CON ENTER AMOUNT ";
				}elseif ($level_three=="1" && $level_four=="2") {
					# 04*1*1*2
					$response="CON ENTER PHONE NUMBER";
				}
			}elseif ($level_two=="2") {
					# 04*2*chris*254708318523
					$response="REFER NAME: ".$level_three." \n Phone Number: ".$level_four."\n 1.Accept \n 2.Cancel";

			}elseif ($level_two=="3") {
				# 04*3*1*1
				if($level_four=="1"){
						$response="CON Airtime Used: \n 0. Go Back";
				}

			}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==5) {
			$level_two=$input_array[sizeof($input_array)-4];
			$level_three=$input_array[sizeof($input_array)-3];
			$level_four=$input_array[sizeof($input_array)-2];
			$level_five=$input_array[sizeof($input_array)-1];

			if($level_four=="2"){
				# 04*1*1*2*amount
				$response="CON ENTER AMOUNT";
			}elseif ($level_two=="2" && $level_five=="1") {
					if(Data::add_refer_member($MSISDN,$level_three,$level_four)==1){
							$response="END Thank you for referring a member. We will contact them shortly";
					}else{
						$response="END Implementation in progress. Try Again Later";
					}
			}
			else{
			$response="END Implementation in progress. Try Again Later";
		}
	}else{
		$response="END Implementation in progress. Try Again Later";
	}
}else{
	if(sizeof($input_array)==1){
		#new user
		$level_one=$input_array[sizeof($input_array)-1];
		if($level_one=="04"){
			# 04

			$response="CON Welcome to AirtimeZone Service \n 1. Buy Airtime \n 2. Register";
		}
	}elseif (sizeof($input_array)==2) {

		$level_two=$input_array[sizeof($input_array)-1];

		if ($level_two=="1") {

			# 04*1

			$response="CON \n 1. Buy For Self \n 2. Buy for Other";
		}elseif ($level_two=="2") {
			# 04*2
				$response="CON Enter Referrers number \n (e.g 254XXXXXXXX)";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==3) {

			$level_two=$input_array[sizeof($input_array)-2];
			$level_three=$input_array[sizeof($input_array)-1];

			if ($level_two=="1" && $level_three=="1") {

				# 04*1*1

				$response="CON ENTER AMOUNT";
			}elseif ($level_two=="1" && $level_three=="2") {
				 # 04*1*2

				$response="CON ENTER PHONE NUMBER";
			}elseif ($level_two=="2") {

				# 04*2*phone_number of referrer
					if(Data::number_exists($level_three)==1){
							 $response="CON ENTER YOUR PIN";
					}else {
						$response="END Sorry but your refferers number does not exists";
					}
			}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==4) {
		$level_two=$input_array[sizeof($input_array)-3];
		$level_three=$input_array[sizeof($input_array)-2];
		$level_four=$input_array[sizeof($input_array)-1];

		if($level_three=="2" && $level_four !=null){

			$response="CON ENTER AMOUNT";
		}elseif ($level_two==2) {

			# 04*2*phone_number of referrer*PIN
				if(Data::add_new_member($MSISDN,$level_four)==1){
						$response="END Registration Successful";
		}else{
				$response="END Implementation in progress. Try Again Later";
		}
		}else{
			$response="END Implementation in progress. Try Again Later";
		}

	}else{
		$response="END Implementation in progress. Try Again Later";
	}
}

header('Content-type:text/plain');
echo $response;


?>
