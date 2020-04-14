<?php
$tgl1 = strtotime(date("2020-02-10")) ;
echo $tgl1 ;
echo "<hr>" ;
$tgl2 = strtotime(date("2019-04-11")) ;
echo $tgl2 ;

echo "<br>" ;
if($tgl1 > $tgl2) {
    echo "Tgl 1 Besar";
}
else{
    echo "tgl 2 Besar" ;
}

?>