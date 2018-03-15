<?php

Class Apis{
  public static function Db($method,$phone_number,$state){
    $params="254708691402";
    $url="https://meppcommunications.com/mpesa/airtimezone/azapi.php?method=".$method."&msisdn=".$phone_number."&token=e95ea6797f160d2e9a16dde9b20b3afe";

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
          return $obj->{'Earnings'};
      }elseif ($state==5) {
          return $obj->{'User Details'}[0]->USSD_PIN;
      }

    }
  }

  public static function reset_pin($phone_number,$pin){
    $url="https://meppcommunications.com/mpesa/airtimezone/resetPIN.php?token=e95ea6797f160d2e9a16dde9b20b3afe&PIN=".$pin."&msisdn=".$phone_number;

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
    $url="https://meppcommunications.com/mpesa/airtimezone/user_register_USSD.php?token=e95ea6797f160d2e9a16dde9b20b3afe&referrer=".$referrer."&referree=".$referee."&first_name=".$first_name."&PIN=".$PIN;

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
  public static function wallet_buy_airtime($buyer,$recipient,$amount){
    $url="https://meppcommunications.com/mpesa/airtimezone/buyAirtimeAZAPI.php?token=e95ea6797f160d2e9a16dde9b20b3afe&buyer=".$buyer."&recipient=".$recipient."&amount=".$amount;

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
        return $obj;
    }
  }

}
?>
