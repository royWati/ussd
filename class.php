<?php

include('controllers/db.php');

global $db;

Class Data{

	public static function number_exists($phone_number){
		global $db;

		$get_row=$db->GetRow("SELECT * FROM tb_users where phone_number='".$phone_number."'");

		if($get_row){
		  	return 1;
		}else{
			return 0;
		}
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



}

?>
