<?php

Class promo{

  public static function register_user($referrer,$referee,$first_name,$PIN){

    $password=promo::password_generator(8);
    $promoCode=promo::new_user_promocode(8,$first_name);

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

  public static function password_generator($length){
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $clen   = strlen( $chars )-1;
            $id  = '';

            for ($i = 0; $i < $length; $i++) {
                    $id .= $chars[mt_rand(0,$clen)];
            }
            return ($id);
  }
}

 ?>
