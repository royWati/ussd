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
}

?>