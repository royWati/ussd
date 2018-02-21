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

			$response="CON Welcome to AirtimeZone Service \n 1. Buy Airtime \n 2. Refer Member \n 3. My Account \n 4. Help \n 5. Feedback";
		}
	}else if(sizeof($input_array)==2){
		$level_two=$input_array[sizeof($input_array)-1];
		if ($level_two=="1") {
			# 04*1
			$response="CON Buy Airtime From \n 1. Direct Top up \n 2. Wallet \n 3. Earning";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==3) {

		$level_two=$input_array[sizeof($input_array)-2];
		$level_three=$input_array[sizeof($input_array)-1];

		if($level_two=="1"){

			# 04*1*1
			$response="CON \n 1. Buy For Self \n 2. Buy for Other";
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
			}else{
			$response="END Implementation in progress. Try Again Later";
		}
	}elseif (sizeof($input_array)==5) {
			$level_three=$input_array[sizeof($input_array)-3];
			$level_four=$input_array[sizeof($input_array)-2];

			if($level_four=="2"){
				# 04*1*1*2*amount
				$response="CON ENTER AMOUNT";
			}else{
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

