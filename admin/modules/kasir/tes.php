<?php

$kata='Semen';
$spasi='1234567891123456789212345678931345678941|';
$cek=strlen($kata) % 2;

if ($cek==0) {
$jumlah=(40/2)-(strlen($kata)/2);
$sisip=substr($spasi, 0 , $jumlah);
$kalimat = $sisip.$kata.$sisip;
} else {
$ganjil=(strlen($kata)/2)+0.5;
$jumlah=(40/2)-($ganjil);
$sisip=substr($spasi, 0 , $jumlah);
$kalimat = $sisip.$kata.$sisip.'a';
}

echo $kalimat;

?>