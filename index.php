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
		}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==3) {

		$level_two=$input_array[sizeof($input_array)-2];
		$level_three=$input_array[sizeof($input_array)-1];

		if($level_two=="1"){

			# 04*1*1
			$response="CON \n 1. Buy For Self \n 2. Buy for Other";
		}else if($level_three !=null){

			# 04*2*chris
			$response="CON ENTER PHONE NUMBER OF THE REFER \n (e.g 254XXXXXXXX)";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}

	}elseif (sizeof($input_array)==4) {
			$level_two=$input_array[sizeof($input_array)-3];
			$level_three=$input_array[sizeof($input_array)-2];
			$level_four=$input_array[sizeof($input_array)-1];

			if ($level_three=="1" && $level_four=="1") {

				# 04*1*1*1
				$response="CON ENTER AMOUNT";
			}elseif ($level_three=="1" && $level_four=="2") {

				# 04*1*1*2
				$response="CON ENTER PHONE NUMBER";
			}elseif($level_two=="2"){

				# 04*2*chris*254708318523
				$response="REFER NAME: ".$level_three." \n Phone Number: ".$level_four."\n 1.Accept \n 2.Cancel";
			}
			else{
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
					if(Data::number_exists($level_three)==1){
							 $response="CON ENTER YOUR PIN";
					}else {
						$response="END Sorry but your refferers number does not exists";
					}
			}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==4) {
		$level_three=$input_array[sizeof($input_array)-2];
		$level_four=$input_array[sizeof($input_array)-1];

		if($level_three=="2" && $level_four !=null){

			$response="CON ENTER AMOUNT";
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
