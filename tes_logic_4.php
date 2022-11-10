<?php
$bilangan = array(99, 2, 64, 8, 111, 33, 65, 11, 102, 50);
do {
    $swapped = false;
    for($i = 0, $c = count($bilangan ) - 1; $i < $c; $i++){
        if($bilangan[$i] > $bilangan[$i + 1]){
            list($bilangan[$i + 1], $bilangan[$i]) =
                array($bilangan[$i], $bilangan[$i + 1]);
            $swapped = true;
        }
    }
} while( $swapped );

echo implode(', ',$bilangan);
?>
