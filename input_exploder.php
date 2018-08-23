<?php

$input=$_REQUEST['input'];

$input_array_raw=explode("*",$input);

// $final_position=0;
// for ($i=0; $i < sizeof($input_array_raw); $i++) {
//     if($input_array_raw[$i]=="00"){
//         $final_position=$i;
//     }
// }
//
// $final_position += 1;
// for($final_position; $final_position<sizeof($input_array_raw);$final_position++){
//     echo $input_array_raw[$final_position]."\n";
// }

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


var_dump($input_array);
 ?>
