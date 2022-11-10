<?php
    $size =5;
    for($i = 1; $i < $size; $i++) {
        $k = $i;
        for($j = 0; $j < $size -2; $j++) {
          echo $k. " ";
          $k = $k + $size - $j;
        }
        echo "\n";
    }
?>