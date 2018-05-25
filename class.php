<?php

include('Apis.php');

global $db;

Class Data{

	public static function number_exists($phone_number){
		global $db;

		return Apis::Db('checkUser',$phone_number,1);

	}



	public static function get_user_name($phone_number){
		return Apis::Db('checkUser',$phone_number,0);

	}


public static function checkWallet($MSISDN){
		return Apis::Db('checkWallet',$MSISDN,3);
}
public static function actualEarnings($MSISDN){
		return Apis::Db('actualEarnings',$MSISDN,4);
}

public static function supposedEarnings($MSISDN){
		return Apis::Db('supposedEarnings',$MSISDN,6);
}

public static function directMembers($MSISDN){
		return Apis::Db('checkDirectReferrals',$MSISDN,7);
}
public static function referrals($MSISDN){
		return Apis::Db('checkReferrals',$MSISDN,8);
}

public static function add_referrer($MSISDN,$USER_NAME,$PHONE_NUMBER){
		return Apis::Db($MSISDN,$USER_NAME,$PHONE_NUMBER);
}
public static function check_pin($MSISDN,$PIN){
		if(Apis::Db('checkUser',$MSISDN,5)==$PIN){
				return 1;
		}else{
			return 0;
		}
}

public static function reset_pin($MSISDN,$PIN,$old_pin){
		return Apis::reset_pin($MSISDN,$PIN,$old_pin);
}

public static function register_user($referrer,$referee,$first_name,$PIN){
		return Apis::register_user($referrer,$referee,$first_name,$PIN);
}

public static function buy_airtime($buyer,$recipient,$amount,$method){
		return Apis::buy_airtime($buyer,$recipient,$amount,$method);
}

public static function pin_generator(){
	return mt_rand(1000,9999);
}

public static function get_todays_earnings(){

}



public static function withdraw_earnings($MSISDN,$amount){
		return Apis::withdraw_earnings($MSISDN,$amount);
}

public static function array_validator($input_array_raw){
	$input_array=array();
	if(in_array("0",$input_array_raw)){


			foreach (array_keys($input_array_raw,"0") as $key =>$index_of_0) {
					$index_before=$index_of_0-1;
					array_push($input_array,$index_before,$index_of_0);


			}

			$offset_pos=0;
			for($x=0; $x< sizeof($input_array); $x++){

				$element=$input_array[$x]-$offset_pos;
				array_splice($input_array_raw,$element,1);

				$offset_pos++;
			}

	}

	return $input_array_raw;
}

public static function checkAirtimeToday($MSISDN){
			return Apis::Db('checkAirtimeToday',$MSISDN,9);
}



public static function checkWalletToday($MSISDN){
		return Apis::Db('checkWalletToday',$MSISDN,10);
}

public static function checkDirectReferralsToday($MSISDN){
		return Apis::Db('checkDirectReferralsToday',$MSISDN,11);
}
public static function checkReferralsToday($MSISDN){
		return Apis::Db('checkReferralsToday',$MSISDN,12);
}

public static function checkpromotioncode($MSISDN){
		return Apis::Db('checkUser',$MSISDN,14);
}

public static function checkEarningsToday($MSISDN){
			return number_format(Apis::Db('checkEarningsToday',$MSISDN,13));
}

public static function load_wallet_online($MSISDN,$amount){
		return Apis::load_wallet_online($MSISDN,$amount);

}



}

?>
