<?php

include('controllers/db.php');
include('Apis.php');

global $db;

Class Data{

	public static function number_exists($phone_number){
		global $db;

		return Apis::Db('checkUser',$phone_number,1);

	}

	public static function number_refer_exists($phone_number){
		global $db;

		$get_row=$db->GetRow("SELECT * FROM tb_referred_members where refer_no='".$phone_number."'");

		if($get_row){
			return 1;
		}else{
			return 0;
		}
	}

	public static function add_refer_member($phone_number,$name,$refer_no){
		global $db;

		$get_id=$db->GetOne("SELECT tb_user_id FROM tb_users where phone_number='".$phone_number."'");

		$data=array();

		$data['refer_no']=$refer_no;
		$data['name']=$name;
		$data['member_id']=$get_id;

		$db->AutoExecute('tb_referred_members',$data, 'INSERT');

		return Data::number_refer_exists($refer_no);
	}
	public static function add_new_member($phone_number,$pin){
		global $db;

		$name=$db->GetOne("SELECT name FROM tb_referred_members where refer_no='".$phone_number."'");

		$data=array();

		$data['phone_number']=$phone_number;
		$data['name']=$name;
		$data['tb_active_status']="1";
		$data['pin']= md5(sha1($pin));

		$db->AutoExecute('tb_users',$data, 'INSERT');

		return Data::number_exists($phone_number);
	}

	public static function get_user_name($phone_number){
		return Apis::Db('checkUser',$phone_number,0);

	}
public static function transcation($SESSIONID,$phone_number){
	global $db;

	$data=array();
	$data['session_id']=$SESSIONID;
	$data['phone_number']=$phone_number;
	$data['time_of_trans']=$db->GetOne("SELECT now()");


	$db->AutoExecute('tb_transcations',$data, 'INSERT');

}

public static function checkWallet($MSISDN){
		return Apis::Db('checkWallet',$MSISDN,3);
}
public static function checkEarnings($MSISDN){
		return Apis::Db('checkEarnings',$MSISDN,4);
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

public static function reset_pin($MSISDN,$PIN){
		return Apis::reset_pin($MSISDN,$PIN);
}

public static function register_user($referrer,$referee,$first_name,$PIN){
		return Apis::register_user($referrer,$referee,$first_name,$PIN);
}

public static function wallet_buy_airtime($buyer,$recipient,$amount){
		return Apis::wallet_buy_airtime($buyer,$recipient,$amount);
}

}

?>
