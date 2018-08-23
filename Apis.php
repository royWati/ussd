<?php

Class Apis{
  public static function Db($method,$phone_number,$state){
    $params="254708691402";
    $url="https://airtimezone.com/azapi.php?method=".$method."&msisdn=".$phone_number."&token=e95ea6797f160d2e9a16dde9b20b3afe";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {

      $obj=json_decode($response);

      if($state==1){
          return $obj->{'status'};
      }else if($state==0){

          return $obj->{'User Details'}[0]->first_name;
      }else if($state==3){
          return $obj->{'Wallet'};
      }elseif ($state==4) {
          return $obj->{'Actual Earnings'};
      }elseif ($state==5) {
          return $obj->{'User Details'}[0]->USSD_PIN;
      }elseif ($state==6) {
            return $obj->{'Supposed Earnings:'};
      }elseif ($state==7) {
            return $obj->{'Direct Referrals'};
      }elseif ($state==8) {
            return $obj->{'Referrals'};
      }elseif ($state==9) {
          return $obj->{'Airtime Today'};
      }elseif ($state==10) {
          return $obj->{'Today Wallet'};
      }elseif ($state==11) {
          if($obj->{'Direct Referrals Today'}==null){
            return 0;
          }else{
              return $obj->{'Direct Referrals Today'};
          }

      }elseif ($state==12) {
          return $obj->{'Total Referrals Today'};
      }elseif ($state==13) {
          return $obj->{'Earnings Today'};
      }elseif ($state==14) {
            return $obj->{'User Details'}[0]->promotionCode;
      }

    }
  }

  public static function reset_pin($phone_number,$pin,$old_pin){

    $url="https://airtimezone.com/resetUSSD.php?token=e95ea6797f160d2e9a16dde9b20b3afe&newPIN=".$pin."&msisdn=".$phone_number."&oldPIN=".$old_pin;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }else {
        $obj=json_decode($response);
        return $obj->{'status'};
    }
  }
  public static function register_user($referrer,$referee,$first_name,$PIN){


    $password=Apis::password_generator(8);
    $promoCode=Apis::new_user_promocode(5,$first_name);

    $url="https://airtimezone.com/user_register_USSD.php?token=e95ea6797f160d2e9a16dde9b20b3afe&referrer=".$referrer."&referree=".$referee."&first_name=".$first_name."&PIN=".$PIN."&password=".$password."&promoCode=".$promoCode;

    //return $url;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }else {
        $obj=json_decode($response);
        return $obj->{'status'};
      //return var_dump($obj) ;
    }

}
  public static function buy_airtime($buyer,$recipient,$amount,$method){
    if($method=="DirectTopUp"){
      $url="https://airtimezone.com/loadAirtime.php?token=e95ea6797f160d2e9a16dde9b20b3afe&msisdn=".$recipient."&amount=".$amount;
    }
    $url="https://airtimezone.com/buyAirtimeAZAPI.php?token=e95ea6797f160d2e9a16dde9b20b3afe&method=".$method."&buyer=".$buyer."&recipient=".$recipient."&amount=".$amount;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }else {

        $obj=json_decode($response,true);
        return $obj;
        //this object is the one failing to decode. i have decided to work on the app logics to cover the bug

    }
  }

  public static function load_wallet_online($phone_number,$amount){
      $url="https://airtimezone.com/loadWallet.php?token=e95ea6797f160d2e9a16dde9b20b3afe&msisdn=".$phone_number."&amount=".$amount;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }else {

        $obj=json_decode($response,true);
        return $obj;
        //this object is the one failing to decode. i have decided to work on the app logics to cover the bug

    }
  }

  public static function send_sms(){
    $username = "test_account";
    $password = "f934ac120abba45c1430ed23e13b3635";
    $shortcode = "AIRTIMEZONE";

    $mobile = "254708691402";
    $message = "bamboocha!!";

    $finalURL = "https://197.248.7.118:1112/sendsms.php?username=" . urlencode($username) . "&password=" . urlencode($password) . "&message=" . urlencode($message) . "&shortcode=".$shortcode."&mobile=".$mobile;

      $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $finalURL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }else {

      $response;

    }
  }

  public static function withdraw_earnings($MSISDN,$amount){
    $url="http://airtimezone.com/AZpay.php?token=e95ea6797f160d2e9a16dde9b20b3afe&msisdn=".$MSISDN."&amount=".$amount;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",

      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }else {
        $obj=json_decode($response);
        return $obj->{'ResponseCode'};
    }

  }

  public static function password_generator($length){
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $clen   = strlen( $chars )-1;
            $id  = '';

            for ($i = 0; $i < $length; $i++) {
                    $id .= $chars[mt_rand(0,$clen)];
            }
            return ($id);
  }

  public static function encrypt_password($password){
  		return hash('sha256',$password);
  }

  public static function promocode($length,$MSISDN){
  	$substring_name=substr(Data::get_user_name($MSISDN),0,3);
  	$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  	$clen   = strlen( $chars )-1;
  	$id  = '';

  	for ($i = 0; $i < $length; $i++) {
  					$id .= $chars[mt_rand(0,$clen)];
  	}
  	return ($substring_name."".$id);
  }
  public static function new_user_promocode($length,$username){
    $substring_name=substr($username,0,3);
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $clen   = strlen( $chars )-1;
    $id  = '';

    for ($i = 0; $i < $length; $i++) {
            $id .= $chars[mt_rand(0,$clen)];
    }
    return ($substring_name."".$id);
  }

}
?>
