<?php

$INPUT = rawurldecode($_GET["INPUT"]);
$input_array_raw=explode("*",$INPUT);

$input_array=array();


$level_one_one="welcome\n 1. My Account \n 2. Pay Bills \n 3. Buy Airtime";
$level_two_one="1. Earnings \n 2. Wallet \n 0. Back";
$level_two_two="1. Buy Electric Tokens \n 2. Pay Water Bill \n 0. Back";
$number_of_zeros=0;
if(in_array("0",$input_array_raw)){


    foreach (array_keys($input_array_raw,"0") as $key =>$index_of_0) {
        //  $index_of_0=$input_array_raw.indexOf("0");
        $index_before=$index_of_0-1;
        echo "0 position:".$index_of_0."\n"."pre value position:".$index_before."\n";

        array_push($input_array,$index_before,$index_of_0);


    }

    $offset_pos=0;
    for($x=0; $x< sizeof($input_array); $x++){
      echo "position:".$input_array[$x]."\n";
      $element=$input_array[$x]-$offset_pos;
    //  echo "element position:".$input_array_raw[$element]."\n";

      //array_push($temporary_array,$input_array_raw[$element]);
      array_splice($input_array_raw,$element,1);

      $offset_pos++;
    }

}


  var_dump($input_array_raw);

if(sizeof($input_array_raw)==2){

    $level_two=$input_array_raw [sizeof($input_array_raw)-1];
    if($level_two=="1"){
        $response=$level_two_one;
    }elseif ($level_two=="2") {
        $response=$level_two_two;
    }elseif ($level_two=="3") {
        $response="Enter Amount";
    }
}elseif (sizeof($input_array_raw)==3) {
    $level_two=$input_array_raw[sizeof($input_array_raw)-2];
    $level_three=$input_array_raw[sizeof($input_array_raw)-1];

    if($level_two=="1"){
        if($level_three=="0"){
            $response=$level_one_one;
        }
    }elseif ($level_two=="2") {
      if($level_three=="0"){
          $response=$level_one_one;
      }
    }
}elseif (sizeof($input_array_raw)==1) {
    $response=$level_one_one;
}
else{
    $response="Implementation in progress";
}

header('Content-type:text/plain');
echo $response;
 ?>
