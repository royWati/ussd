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
            //   $test_user="mutai";
			            $response="CON Welcome ".Data::get_user_name($MSISDN) ." to AirtimeZone digital payment and referral marketing services. Please enter your PIN:\n 0. Forgot Pin";
		       }
    }elseif (sizeof($input_array)==2) {
        $level_two=$input_array[sizeof($input_array)-1];
        if(Data::check_pin($MSISDN,$level_two)==1){
          $response="CON Welcome to AirtimeZone Service \n 1. Buy Airtime \n 2. Refer Member\n 3. My Account \n 4. Pay Utility bills \n 5. Help \n 6.Feedback \n 7.Reset Pin \n 0. Back";
        }else {
            $response="CON Wrong pin. Try Again \n 0. Forgot Pin";
        }

    }else if(sizeof($input_array)==3){
  		$level_three=$input_array[sizeof($input_array)-1];
  		if ($level_three=="1") {
  			# 04*1
  		//	$response="CON Buy Airtime From \n 1. Direct Top up \n 2. Wallet \n 3. Earning";
        $response="CON Buy Airtime For \n 1. Self \n 2. Other \n 0. Back";
  		}elseif($level_three=="2"){

  			# 04*2
  			$response="CON Enter the name of the person you are referring \n ";
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
  		}elseif ($level_three=="7") {
          $response="CON Enter your Current PIN";
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
                $response="CON Enter phone number \n ";
              }
            }elseif ($level_three=="3") {
                if($level_four=="1"){
                      $response="CON Airtime bought KSH: X.00 \n Your Todays Earnings KSH: X.00 \n Amount Loaded to wallet KSH: X.00";
                }elseif ($level_four=="2") {
                    $response="CON Total In Wallet is KSH.".Data::checkWallet($MSISDN)." Enter Amount to load from your mpesa";
                }elseif ($level_four=="3") {
                    $response="CON Actual Amount: KSH. ".Data::checkEarnings($MSISDN)." \n Supposed Amount KSH. X.00";
                }elseif ($level_four=="4") {
                    $response="CON Total Earnings KSH.".Data::checkEarnings($MSISDN)." \nEnter Amount";
                }elseif ($level_four=="5") {
                    $response="CON 1. Send via Email \n 2. Send via SMS";
                }elseif ($level_four=="6") {
                    $response="CON 1. Direct Members \n 3. All Members";
                }elseif ($level_four=="7") {
                    $response="1. Create mobile and USSD PIN \n2. RESET PIN";
                }
            }elseif ($level_three=="2") {
                  $response="CON Enter the phone number of the person you are referring";
            }elseif ($level_three=="7") {
                  if(Data::check_pin($MSISDN,$level_four)==1){
                      $response="CON Enter your new PIN";
                  }else{
                        $response="CON WRONG PIN. 2 Attempts Left. Enter your Current PIN";
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
                $response="CON Your Wallet Balance is KSH ".Data::checkWallet($MSISDN)." \n Enter Amount";
            }else if($level_four=="1" && $level_five=="3"){
                $response="CON Your Earning Amount is KSH ".Data::checkEarnings($MSISDN)." \n Enter Amount";
            }elseif ($level_three=="2" && strlen($level_five)==12) {
                $response="A notification has been send to the person you have reffered";
            }elseif ($level_three=="7" && strlen($level_five)==4 && $level_two==$level_four) {
              if(Data::reset_pin($MSISDN,$level_five)==1){
                  $response="END PIN has been reset successfully";
              }else{
                $response="END Failed to reset the PIN";
              }
            }
            elseif (strlen($level_five)==12 || strlen($level_five)==10) {
                    $response="CON Select Option \n 1. Direct Top up \n 2. Wallet\n 3. Earnings";
            }elseif (strlen($level_five) !=12 || strlen($level_five) !=10) {

            }
        }elseif ($level_three=="7" && strlen($level_five)==4) {

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
           if(strlen($level_five)==10 || strlen($level_five)==12) {
             if($level_six=="1"){
                 $response="CON Enter Amount";
             }else if($level_six=="2"){
                $response="CON Your Wallet Balance is KSH ".Data::checkWallet($MSISDN)." \n Enter Amount";
            }else if($level_six=="3"){
                $response="CON Your Earning Amount is KSH ".Data::checkEarnings($MSISDN)." \n Enter Amount";
            }

          }elseif ($level_three=="1" && $level_four=="1" && $level_five=="2") {
              if(Data::wallet_buy_airtime($MSISDN,$MSISDN,$level_six)->{'status'}==1){
                  $response="END You have successfully purchased airtime worth KSH ".$level_six;
              }else{
                  $response="END ".Data::wallet_buy_airtime($MSISDN,$MSISDN,$level_six)->{'Reason'};
              }
          }


        }else{
           $response="END Implementation in progress. Try Again Later";
        }

  	}elseif(sizeof($input_array)==7) {
      $level_two=$input_array[sizeof($input_array)-6];
      $level_three=$input_array[sizeof($input_array)-5];
      $level_four=$input_array[sizeof($input_array)-4];
      $level_five=$input_array[sizeof($input_array)-3];
      $level_six=$input_array[sizeof($input_array)-2];
      $level_seven=$input_array[sizeof($input_array)-1];

      if($level_three=="1" && $level_four=="2" && strlen($level_five) > 9) {
        if(Data::wallet_buy_airtime($MSISDN,$level_six,$level_seven)->{'status'}==1){
            $response="END You have successfully purchased airtime worth KSH ".$level_six;
        }else{
            $response="END ".Data::wallet_buy_airtime($MSISDN,$level_six,$level_seven)->{'Reason'};
        }
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

      $response="CON Welcome to AirtimeZone Services \n 1. Buy Airtime \n 2. Register";
    }
  }elseif (sizeof($input_array)==2) {

    $level_two=$input_array[sizeof($input_array)-1];

    if ($level_two=="1") {

      # 04*1

      $response="CON \n 1. Buy For Self \n 2. Buy for Other";
    }elseif ($level_two=="2") {
      # 04*2
      $response="CON Welcome to AirtimeZone services.\n 1. Enter the number of the person who has referred you \n 2. Enter Secret key from Your Referrer";
    }else{
      $response="END Implementation in progress. Try Again Later";
    }
  }elseif (sizeof($input_array)==3) {

		$level_two=$input_array[sizeof($input_array)-2];
		$level_three=$input_array[sizeof($input_array)-1];

		if($level_two=="1"){

			if($level_three=="1"){
          $response="CON \n  Buy Enter Amount you would like to purchase";
      }elseif ($level_three=="2") {
          $response="CON \n Enter the phone number";
      }

		}else if($level_two=="2"){

			# 04*2*chris
			$response="CON Enter the phone number of the person who has referred you";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}

	}elseif (sizeof($input_array)==4) {
    $level_two=$input_array[sizeof($input_array)-3];
    $level_three=$input_array[sizeof($input_array)-2];
    $level_four=$input_array[sizeof($input_array)-1];


    if($level_two=="1"){
        if($level_three=="1"){
             $response="END \n currently implementing";
        }elseif ($level_three=="2") {
              $response="CON \n  Buy Enter Amount you would like to purchase";
        }else{
          $response="CON wrong selection \n 0. Back";
        }
    }elseif ($level_two=="2") {
      if($level_three=="1"){
         $response="CON Enter Your Name";
          if(Data::number_exists($MSISDN)=="1"){
              $response="CON Enter Your Name";
          }else{
              $response="CON Sorry but we have no record of the phonenumber you inputed \n 0. Back";
          }
      }
    }


  }elseif(sizeof($input_array)==5) {
			$level_two=$input_array[sizeof($input_array)-4];
			$level_three=$input_array[sizeof($input_array)-3];
			$level_four=$input_array[sizeof($input_array)-2];
			$level_five=$input_array[sizeof($input_array)-1];

      if($level_two=="2"){
          $response="CON Enter your new PIN";
      }else {
          $response="END Implementation in progress. Try Again Later";
      }


	}elseif (sizeof($input_array)==6) {
    $level_two=$input_array[sizeof($input_array)-5];
    $level_three=$input_array[sizeof($input_array)-4];
    $level_four=$input_array[sizeof($input_array)-3];
    $level_five=$input_array[sizeof($input_array)-2];
    $level_six=$input_array[sizeof($input_array)-1];

    if($level_two=="2"){
        $response="CON Confirm your PIN";
    }else {
        $response="END Implementation in progress. Try Again Later";
    }
  }elseif (sizeof($input_array)==7) {
    $level_two=$input_array[sizeof($input_array)-6];
    $level_three=$input_array[sizeof($input_array)-5];
    $level_four=$input_array[sizeof($input_array)-4];
    $level_five=$input_array[sizeof($input_array)-3];
    $level_six=$input_array[sizeof($input_array)-2];
    $level_seven=$input_array[sizeof($input_array)-1];

    if($level_two=="2"){
        if($level_six==$level_seven){
              if(Data::register_user($level_four,$MSISDN,$level_five,$level_six)==1){
                  $response="END You have registerd successfully on AirtimeZone platform. Kindly enter the secret key send by your referrer";
              }
        }else{
            $response="CON Confirm your PIN \n ). Back";
        }
    }else {
        $response="END Implementation in progress. Try Again Later";
    }
  }else {
    $response="END Implementation in progress. Try Again Later";
  }
}

header('Content-type:text/plain');
echo $response;

?>
