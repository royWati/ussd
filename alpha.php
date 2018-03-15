<?php

include("./class.php");


$SESSIONID = $_GET["SESSIONID"];
$USSDCODE = rawurldecode($_GET["USSDCODE"]);
$MSISDN = $_GET["MSISDN"];
$INPUT = rawurldecode($_GET["INPUT"]);

$input_array=explode("*",$INPUT);

Data::transcation($SESSIONID,$MSISDN);

if(Data::number_exists($MSISDN)==1){

  if(sizeof($input_array)==1){
		# user exists
		$level_one=$input_array[sizeof($input_array)-1];
		      if($level_one=="04"){
			         # 04
			            $response="CON Welcome ". Data::get_user_name($MSISDN)." to AirtimeZone digital payment and referral marketing services. Please enter your PIN:\n 0. Forgot Pin";
		       }
    }elseif (sizeof($input_array)==2) {
        $level_two=$input_array[sizeof($input_array)-1];
        if(Data::check_pin($MSISDN,$level_two)==1){
          $response="CON Welcome to AirtimeZone Service \n 1. Buy Airtime \n 2. Refer Member\n 3. My Account \n 4. Pay Utility bills \n 5. Help \n 6.Feedback";
        }else {
            $response="CON Wrong pin. Try Again \n 0. Forgot Pin";
        }

    }else if(sizeof($input_array)==3){
  		$level_three=$input_array[sizeof($input_array)-1];
  		if ($level_three=="1") {
  			# 04*1
  		//	$response="CON Buy Airtime From \n 1. Direct Top up \n 2. Wallet \n 3. Earning";
        $response="CON Buy Airtime For \n 1. Self \n 2. Other";
  		}elseif($level_three=="2"){

  			# 04*2
  			$response="CON ENTER NAME OF THE REFER \n ";
  		}elseif($level_three=="3"){

  			# 04*3
  				$response="CON My Account \n 1. Today \n 2. Load Wallet \n 3. Income \n 4. Withdraw \n 5. Mini Statement\n 6. Members \n 7. Mobile App";
  		}elseif($level_three=="4"){
  			# 04*4
  				$response="CON Pay Utility Bills \n 1. Kenya Power \n 2. Nairobi Water \n 3. NHIF \n 4. Pay TV";
  		}elseif($level_three=="5"){
  			# 04*5
  				$response="CON Help \n 1. Wallet Top up \n 2. Check Income \n 3. Paybills ";
  		}elseif($level_three=="6"){
  			# 04*6
  				$response="CON Customer Feedback \n Enter your feedback below";
  		}else{
  			$response="END Implementation in progress. Try Again Later";
  		}
  	}elseif (sizeof($input_array)==4) {
  			$level_two=$input_array[sizeof($input_array)-3];
  			$level_three=$input_array[sizeof($input_array)-2];
  			$level_four=$input_array[sizeof($input_array)-1];

        if(strlen($level_two)==4){

            if($level_three=="1"){
              if($level_four=="1"){
                  $response="CON Select Option \n 1. Direct Top up \n 2. Wallet\n 3. Earnings";
              }else{
                $response="CON Enter phone number(e.g 2547XXXXXXXX) \n ";
              }
            }elseif ($level_three=="3") {
                if($level_four=="1"){
                      $response="CON Airtime bought KSH: X.00 \n Your Todays Earnings KSH: X.00 \n Amount Loaded to wallet KSH: X.00";
                }elseif ($level_four=="2") {
                    $response="CON Enter Amount to load from your mpesa";
                }elseif ($level_four=="3") {
                    $response="CON Actual Amount: KSH. X.00 \n Supposed Amount KSH. X.00";
                }elseif ($level_four=="4") {
                    $response="CON Total Earnings KSH. X.00 \nEnter Amount";
                }elseif ($level_four=="5") {
                    $response="CON 1. Send via Email \n 2. Send via SMS";
                }elseif ($level_four=="6") {
                    $response="CON 1. Direct Members \n 3. All Members";
                }elseif ($level_four=="7") {
                    $response="1. Create mobile and USSD PIN \n2. RESET PIN";
                }
            }else{
                $response="END Implementation in progress. Try Again Later";
            }

        }


  	}elseif (sizeof($input_array)==5) {
  			$level_two=$input_array[sizeof($input_array)-4];
  			$level_three=$input_array[sizeof($input_array)-3];
  			$level_four=$input_array[sizeof($input_array)-2];
  			$level_five=$input_array[sizeof($input_array)-1];


  			if(strlen($level_two)==4){
            if($level_four=="1" && $level_five=="1"){
                $response="CON Enter Amount";
            }else if($level_four=="1" && $level_five=="2"){
                $response="CON Your Wallet Balance is X amount \n Enter Amount";
            }else if($level_four=="1" && $level_five=="3"){
                $response="CON Your Earning Amount is X amount \n Enter Amount";
            }elseif (strlen($level_five)==12) {
                  $response="CON Select Option \n 1. Direct Top up \n 2. Wallet\n 3. Earnings";
            }elseif (strlen($level_five)!=12) {
                  $response="CON Incomplete number. PLease enter the phone number";
            }
        }else{
            $response="END Implementation in progress. Try Again Later";
        }

  	}elseif (sizeof($input_array)==6) {
  			$level_two=$input_array[sizeof($input_array)-5];
  			$level_three=$input_array[sizeof($input_array)-4];
  			$level_four=$input_array[sizeof($input_array)-3];
  			$level_five=$input_array[sizeof($input_array)-2];
        $level_six=$input_array[sizeof($input_array)-1];


  			if(strlen($level_two)==4){
           if(strlen($level_five)==12) {
             if($level_six=="1"){
                 $response="CON Enter Amount";
             }else if($level_six=="2"){
                $response="CON Your Wallet Balance is X amount \n Enter Amount";
            }else if($level_six=="3"){
                $response="CON Your Earning Amount is X amount \n Enter Amount";
            }

          }


        }else{
           $response="END Implementation in progress. Try Again Later";
        }

  	}else{
      	$response="END Implementation in progress. Try Again Later";
    }
}else {
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
      $response="CON Welcome to AirtimeZone digital payment and referral marketing services.\n 1. Enter the number of the person who has referred you \n 2. Enter Secret key from Your Referrer";
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

	}elseif (sizeof($input_array)==5) {
			$level_two=$input_array[sizeof($input_array)-4];
			$level_three=$input_array[sizeof($input_array)-3];
			$level_four=$input_array[sizeof($input_array)-2];
			$level_five=$input_array[sizeof($input_array)-1];


			if(strlen($level_two)==4){
          if($level_four=="1" && $level_five=="1"){
              $response="CON Enter Amount";
          }else if($level_four=="1" && $level_five=="2"){
              $response="CON Your Wallet Balance is X amount \n Enter Amount";
          }else if($level_four=="1" && $level_five=="3"){
              $response="CON Your Earning Amount is X amount \n Enter Amount";
          }
      }else{
        $response="CON ".$level_two;
      //    $response="END Implementation in progress. Try Again Later";
      }

	}else {
    $response="END Implementation in progress. Try Again Later";
  }
}

header('Content-type:text/plain');
echo $response;

?>
