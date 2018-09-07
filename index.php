<?php

include("./class.php");


$SESSIONID = $_GET["SESSIONID"];
$USSDCODE = rawurldecode($_GET["USSDCODE"]);
$MSISDN = $_GET["MSISDN"];
$INPUT = rawurldecode($_GET["INPUT"]);

$input_array=array();


$input_array_raw=explode("*",$INPUT);

$input_array=Data::array_validator($input_array_raw);

//var_dump($input_array);

$obj = json_decode(Data::number_exists($MSISDN));
if($obj != null){

  if(sizeof($input_array)==1){
		# user exists
		$level_one=$input_array[sizeof($input_array)-1];
		      if($level_one=="04" || $level_one=="8"){
			         # 04
            //   $test_user="mutai";
			            $response="CON Welcome ".$obj->{'first_name'} ." to AirtimeZone services. Please enter your PIN:\n 000. Forgot Pin";
		       }
    }elseif (sizeof($input_array)==2) {
        $level_two=$input_array[sizeof($input_array)-1];
        if($obj->{'USSD_PIN'}==sha1($level_two.sha1(md5($MSISDN)))){
          $response="CON Refferal Code; ".$obj->{'promotionCode'}."\n Select a Service \n 1. Buy Airtime \n 2. Refer Member\n 3. My Account \n 4. Pay Bills/Services \n 5. Help \n 6. Feedback \n 7.Reset Pin \n 0.Back";
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
  			$response="CON Enter the name of the person you are referring \n 0. Back";
  		}elseif($level_three=="3"){

  			# 04*3
  				$response="CON My Account \n 1. Today \n 2. Load Wallet \n 3. Income \n 4. Withdraw \n 5. Mini Statement\n 6. Members \n 7. Mobile App \n 0. Back";
  		}elseif($level_three=="4"){
  			# 04*4
  				$response="CON Pay Utility Bills \n 1. Kenya Power \n 2. Nairobi Water \n 3. NHIF \n 4. Pay TV \n 0. Back";
  		}elseif($level_three=="5"){
  			# 04*5
  				$response="CON Help \n 1. Wallet Top up \n 2. Check Income \n 3. Paybills \n 4. Members \n 5. Support \n 0. Back";
  		}elseif($level_three=="6"){
  			# 04*6
  				$response="CON Customer Feedback \n Enter your feedback below \n 0. Back";
  		}elseif ($level_three=="7") {
          $response="CON Enter your Current PIN \n 0. Back";
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
                  $response="CON Select Option \n 1. Direct Top up \n 2. Wallet\n 3. Earnings \n 0. Back";
              }else{
                $response="CON Enter phone number \n 0. Back";
              }
            }elseif ($level_three=="3") {
                if($level_four=="1"){
                      $response="CON Airtime bought Kshs: ".Data::checkAirtimeToday($MSISDN)." \n Earnings Kshs: ".Data::checkEarningsToday($MSISDN)." \n Amount Loaded to wallet Kshs: ".Data::checkWalletToday($MSISDN)."\n Direct Refferals: ".Data::checkDirectReferralsToday($MSISDN)."\n All referrals: ".Data::checkReferralsToday($MSISDN)."\n 0. Back";
                }elseif ($level_four=="2") {
                    $response="CON Wallet balance Kshs.".Data::checkWallet($MSISDN)."\n Enter Amount \n 0. Back";
                }elseif ($level_four=="3") {
                    $response="CON Actual Earnings: Kshs. ".Data::actualEarnings($MSISDN)." \n Supposed Earnings: Kshs. ".Data::supposedEarnings($MSISDN)." \n 0. Back";
                }elseif ($level_four=="4") {
                    $response="CON Earnings Kshs.".Data::actualEarnings($MSISDN)." \n Enter Amount \n 0. Back";
                }elseif ($level_four=="5") {
                    $response="CON 1. Send via Email \n 2. Send via SMS \n 0. Back";
                }elseif ($level_four=="6") {
                    $response="CON  Direct Members: ".Data::directMembers($MSISDN)." \n All Members: ".Data::referrals($MSISDN)."\n 0. Back";
                }elseif ($level_four=="7") {
                    $response="1. Create mobile and USSD PIN \n 2. RESET PIN \n 0. Back";
                }
            }elseif ($level_three=="2") {
                  $response="CON Enter the phone number of the person you are referring \n 0. Back";
            }elseif ($level_three=="7") {
                  if($obj->{'USSD_PIN'}==sha1($level_two.sha1(md5($MSISDN)))){
                      $response="CON Enter your new PIN \n 0. Back";
                  }else{
                        $response="CON WRONG PIN. 2 Attempts Left. Enter your Current PIN \n 0. Back";
                  }
            }elseif ($level_three=="5") {
                  if($level_four=="1"){
                      $response="CON Go to USSD menu My Account\n Load Wallet \n Enter Amount (The amount is debited from your Mpesa) \n Enter your Mpesa PIN and send \n 0. Back";
                  }elseif ($level_four=="2") {
                      $response="CON Go to USSD menu My Account\n Income \n 0.Back";
                  }elseif ($level_four=="3") {
                      $response="CON Go to USSD menu Pay bills/Services \n Select the bill you want to pay \n 0.Back";
                  }elseif ($level_four=="4") {
                        $response="CON Go to USSD menu My Account \n Members \n 0.Back";
                  }elseif ($level_four=="5") {
                      $response="CON Support  \n Call, Text or WhatsApp 0796769787 \n 0.Back";
                  }
            }elseif ($level_four=="6") {
                      $response="CON Write to us an email to us via info@airtimezone.com for an quiries \n 0. Back";
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
                $response="CON Enter Amount \n 0. Back";
            }else if($level_four=="1" && $level_five=="2"){
                // $response="CON Wallet Balance is KSH ".Data::checkWallet($MSISDN)." \n Enter Amount \n 0. Back";
                $response="Enter Amount \n 0. Back";
            }else if($level_four=="1" && $level_five=="3"){
                // $response="CON Earnings Kshs. ".Data::actualEarnings($MSISDN)." \n Enter Amount \n 0. Back";

                 $response="Enter Amount \n 0. Back";
            }elseif ($level_three=="2") {
                  if(Data::register_user($MSISDN,$level_five,$level_four,Data::pin_generator())=="1"){
                      $response="CON A notification has been sent to the person you have reffered \n 00. Homepage";
                  }else{
                      $response="CON The phone number already exists in the system. \n 00. Homepage";
                  }

            }elseif ($level_three=="3" && $level_four=="4") {
                if(Data::withdraw_earnings($MSISDN,$level_five)=="0"){
                    $response="CON You have successfully withdrawn KSH. ".$level_five." from your earnings account \n 0. Back \n 00. Homepage";
                }else{
                      $response="CON Insufficient Earnings to Withdraw. Your actual Earnings is Ksh ".Data::actualEarnings($MSISDN)." \n 00. Homepage";
                }
            }elseif ($level_three=="3" && $level_four=="2") {
                  Data::load_wallet_online($MSISDN,$level_five);
                  $response="END Your Mpesa pin window will pop up to complete this transcation";
            }elseif($level_three=="7" && strlen($level_five)==4 && $level_two==$level_four) {
              if(Data::reset_pin($MSISDN,$level_five,$level_two)==1){
                  $response="CON PIN has been reset successfully \n 00. Homepage";
              }else{
                $response="CON Failed to reset the PIN \n 00. Homepage";
              }
            }
            elseif (strlen($level_five)==12 || strlen($level_five)==10) {
                    $response="CON Select Option \n 2. Wallet\n 3. Earnings \n 0. Back";
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
                 $response="CON Enter Amount \n 0. Back";
             }else if($level_six=="2"){
                $response="CON Your Wallet Balance is KSH ".Data::checkWallet($MSISDN)." \n Enter Amount \n 0. Back";
            }else if($level_six=="3"){
                $response="CON Your Earning Amount is KSH ".Data::actualEarnings($MSISDN)." \n Enter Amount \n 0. Back";
            }

          }elseif ($level_three=="1" && $level_four=="1" && $level_five=="2") {
              if((int)Data::checkWallet($MSISDN) >= (int)$level_six){
                  Data::buy_airtime($MSISDN,$MSISDN,$level_six,"wallet");
                   $response="CON You successfully bought airtime worth KSH  ".$level_six."\n 00. Homepage";
              }else{
                $response="CON Insufficient funds. Your Wallet balance is ".Data::checkWallet($MSISDN)." amount ".$level_six."\n 00. Homepage";
              }
          }elseif($level_three=="1" && $level_four=="1" && $level_five=="3"){
                if((int)Data::actualEarnings($MSISDN) >= (int)$level_six){
                  Data::buy_airtime($MSISDN,$MSISDN,$level_six,"earnings");
                   $response="CON You successfully bought airtime worth KSH  ".$level_six."\n 00. Homepage";
                }else{

                    $response="CON Insufficient funds. Your Wallet balance is ".Data::checkWallet($MSISDN)." amount ".$level_six."\n 00. Homepage";
                }
          }elseif ($level_three=="1" && $level_four=="1" && $level_five=="1") {
            Data::buy_airtime($MSISDN,$MSISDN,$level_six,"DirectTopUp");
            $response="END Your Mpesa pin window will pop up to complete this transcation";
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

      if($level_three=="1" && $level_four=="2"){

        if((int)Data::checkWallet($MSISDN) >= (int)$level_seven && (int)$level_seven >=10){
            Data::buy_airtime($MSISDN,$level_five,$level_seven,"wallet");
             $response="CON You successfully bought airtime worth KSH ".$level_seven." for ".$level_five."\n 00. Homepage";
        }else{
          $response="CON Insufficient funds. Your balance is ".Data::checkWallet($MSISDN)." and amount is".$level_seven."\n 00. Homepage";
        }


      }
    }else{
      	$response="END Implementation in progress. Try Again Later";
    }
}else {
  if(sizeof($input_array)==1){
    #new user
    $level_one=$input_array[sizeof($input_array)-1];
    if($level_one=="04" || $level_one=="8"){
      # 04

      $response="CON Welcome to AirtimeZone Services \n 1. Buy Airtime \n 2. Register ";
    }
  }elseif (sizeof($input_array)==2) {

    $level_two=$input_array[sizeof($input_array)-1];

    if ($level_two=="1") {

      # 04*1

      $response="CON \n 1. Buy For Self \n 2. Buy for Other \n 0. Back";
    }elseif ($level_two=="2") {
      # 04*2
      $response="CON Welcome to AirtimeZone services.\n Enter the number of the person who has referred you \n  0. Back";
    }else{
      $response="END Implementation in progress. Try Again Later";
    }
  }elseif (sizeof($input_array)==3) {

		$level_two=$input_array[sizeof($input_array)-2];
		$level_three=$input_array[sizeof($input_array)-1];

		if($level_two=="1"){

			if($level_three=="1"){
          $response="CON \n Enter Amount \n 0. Back";
      }elseif ($level_three=="2") {
          $response="CON \n Enter the phone number \n 0. Back";
      }

		}else if($level_two=="2"){

			# 04*2*chris
			$response="CON Enter the referral code of the person who has referred you \n 0. Back";
		}else{
			$response="END Implementation in progress. Try Again Later";
		}

	}elseif (sizeof($input_array)==4) {
    $level_two=$input_array[sizeof($input_array)-3];
    $level_three=$input_array[sizeof($input_array)-2];
    $level_four=$input_array[sizeof($input_array)-1];


    if($level_two=="1"){
        if($level_three=="1"){
              Data::buy_airtime($MSISDN,$MSISDN,$level_four,"DirectTopUp");
              $response="END Your Mpesa pin window will pop up to complete this transcation";
        }elseif ($level_three=="2") {
              $response="CON \n  Enter Amount \n 0. Back";
        }else{
          $response="CON wrong selection \n 0. Back";
        }
    }elseif ($level_two=="2") {
          Data::checkpromotioncode($level_three);

        //MaurNJPL
      //   $response="CON Enter Your Name";
    //  $response=$level_three;
          if(Data::checkpromotioncode($level_three)==$level_four){
              $response="CON Enter Your Name \n 0. Back";

          }else{
              $response=" CON Sorry the promotion code doesn't exist \n 0. Back";
          }

    }


  }elseif(sizeof($input_array)==5) {
			$level_two=$input_array[sizeof($input_array)-4];
			$level_three=$input_array[sizeof($input_array)-3];
			$level_four=$input_array[sizeof($input_array)-2];
			$level_five=$input_array[sizeof($input_array)-1];

      if($level_two=="2"){
          $response="CON Create your 4 digit PIN \n 0. Back";
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
        $response="CON Confirm your PIN \n 0. Back";
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
          
              $response ="Your pin has been set successfully. Please select your membership \n 1. Gold (KSH 1000)\n 2. Silver (KSH 500)\n 3. Bronze (KSH 500)";
           /*   if(Data::register_user($level_three,$MSISDN,Data::string_creator($level_five,'merge'),$level_six)=="1"){
                  $response="END You have registerd successfully on AirtimeZone platform.";
              }else{
                  $response="END Your Number already exists";
               } */
        }else{
            $response="CON Unsuccessful registration \n 0. Back";
         }
    }else {
        $response="END Implementation in progress. Try Again Later";
    }
  }else if(sizeof($input_array)==8){
        $response = "What your would you like to be? \n 1. Digital Entreprenuer \n 2. Digital User";
  }else if(sizeof($input_array)==9){
        if(Data::register_user($level_three,$MSISDN,Data::string_creator($level_five,'merge'),$level_six)=="1"){
                  $response="END You have registerd successfully on AirtimeZone platform.";
              }else{
                  $response="END Your Number already exists";
               } 
  }else {
    $response="END Implementation in progress. Try Again Later";
  }
}

header('Content-type:text/plain');
echo $response;

?>
