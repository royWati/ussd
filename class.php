<?php

include('Apis.php');
include('internalDB.php');
global $db;

Class Data{

	public static function number_exists($phone_number){
		global $db;

		$obj=Query::checkUser($phone_number);
		if($obj != null){
			return $obj;
		}else{
			$obj=Apis::Db('checkUser',$phone_number,1);
			$dec_obj = json_decode($obj);

			if((int)$dec_obj->{'status'}==1){
				
				return Query::addUser($obj);;
			}else{
				return null;
			}
		}
		

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

public static function string_creator($string_value,$descriptor){
		if($descriptor=="merge"){
				$new_string_value=str_replace(' ','/',$string_value);
		}else if($descriptor=="original"){
				$new_string_value=str_replace('/',' ',$string_value);
		}

		return $new_string_value;
}

public static function homepage($input_array_raw){

	$maximum_size=sizeof($input_array_raw)-1;
	$flag_status=0;

	while($maximum_size>0){
	  if($input_array_raw[$maximum_size]=="00"){
	      if(sizeof($input_array_raw)-1==$maximum_size){
	          $flag_status=1;
	      }
	      break;
	  }
	  $maximum_size -=1;
	}
	$input_array=array();
	if($flag_status==1){
	  array_push($input_array,"8");
	}else{
	  $maximum_size =0;
	  do {
	      array_push($input_array,$input_array_raw[$maximum_size]);
	      $maximum_size++;
	  } while ($maximum_size < sizeof($input_array_raw));

	}

	return $input_array;

}



}

?>
