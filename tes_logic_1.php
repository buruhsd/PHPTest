<?php
$angka = 6;
$hasil = true;

if($angka != 1){
    for($i=2;$i<$angka; $i++){
        if ($angka % $i == 0)
        $hasil    =false;
    }
}

echo $hasil ? 'termasuk bilangan prima' : ' bukan bilangan prima';
?>