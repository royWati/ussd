<?php


include('controllers/db.php');
global $db;
class Query{
	
	public static function check_session($session_id){
		global $db;

		$get_session=$db->GetRow("SELECT * FROM tb_sessions where session='$session_id'");
		if($get_session){
			 return true;
		}
	}

	public static function add_session($session_id,$customer_id){
		global $db;

		$data=array();
		$data["session"]=$session_id;
		$data["customer_id"]=$customer_id;
		$data["transcation_time"]=$db->GetOne("select now();");

		$db->AutoExecute('tb_sessions',$data, 'INSERT');
	}

	public static function checkUser($phone_number){
			global $db;
			$getUser = $db->GetRow("SELECT * FROM tb_users where phone_number='$phone_number'");

			if($getUser){
				return json_encode($getUser);
			}
	}

	public static function addUser($obj){
		global $db;
		$data=array();
		$user = json_decode($obj);

		$phone_number=$user->{'User Details'}[0]->phone_number;
		$mepp_id=$user->{'User Details'}[0]->id;
		$first_name=$user->{'User Details'}[0]->first_name;
		$surname=$user->{'User Details'}[0]->surname;
		$last_name=$user->{'User Details'}[0]->last_name;
		$email=$user->{'User Details'}[0]->email;
		$USSD_PIN=$user->{'User Details'}[0]->USSD_PIN;
		$promotionCode=$user->{'User Details'}[0]->promotionCode;
		$password=$user->{'User Details'}[0]->password;

		$data['phone_number']=$phone_number;
	    $data["mepp_id"]=$mepp_id;
		$data["first_name"]=$first_name;
		//$data["surname"]=$surname;
		// $data["last_name"]=$last_name;
		// $data["email"]=$email;
		$pepper=sha1(md5($phone_number));
		$data["USSD_PIN"]=sha1($USSD_PIN.$pepper);
		$data["promotionCode"]=$promotionCode;

		$db->AutoExecute('tb_users',$data, 'INSERT');

		return Query::checkUser($phone_number);

	}
}
?>