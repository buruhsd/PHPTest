<?php
$bilangan = array(11, 6, 31, 201, 99, 861, 1, 7, 14, 79);
$terbesar = $bilangan[0];

foreach($bilangan as $number){
    if($number > $max){  
        $max=$d;  
    }   
}  
echo $max;
?>