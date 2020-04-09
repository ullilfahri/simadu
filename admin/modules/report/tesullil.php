<?php

include '../../../sysconfig.php';
//$no_faktur=strtotime(date('Y-m-d H:i:s'));


//$tanggal = "Y-m-d" ;
echo strtotime(date('Y-m-d 00:00:00')) ;
echo "<br>" ;
echo strtotime(date('Y-m-d 23:59:59')) ;
echo "<br>" ;

echo "<hr>" ;
$nilai = strtotime(date('Y-m-d 00:00:00')) ;  ;
$asli = date('Y-m-d 00:00:00') ;
echo $nilai ."<br>" ;
echo $asli ;
echo "<hr>" ;
$ok = "1586049738" ;

echo date("Y-m-d",$ok)




//SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN '1586019600' and '1586105999' and total_trx != 0


?>