<?php
//tes mencari rentang tanggal pembelian
include '../../sysconfig.php';
$tanggal = date("Y-m-d") ;


echo $tanggal ." : "; 
$convertanggal =  strtotime(date($tanggal))  ;
echo $convertanggal ;

echo "<hr> Mengurangi 1 Hari <br>" ;

$hmin1 = date("Y-m-d",strtotime('-1 days',strtotime($tanggal))) ;

echo $hmin1 ." : ";
$th1 = strtotime(date($hmin1)) ;
echo $th1 ;

echo "<hr> Menambah 1 hari <br>";
$hplus1 = date("Y-m-d",strtotime('1 days',strtotime($tanggal))) ;

echo $hplus1 ." : ";
$tp = strtotime(date($hplus1)) ;
echo $tp ;



echo "<hr>" ;
$kd = '1585835942' ;
echo date("Y-m-d",$kd) ;

?>