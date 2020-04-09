<?php 
include '../../../sysconfig.php';
$no_faktur = $_GET['no_faktur'];
$total_trx = $_GET['total_trx'];
$update=$conn->query("UPDATE `tabel_faktur` SET `total_trx`='$total_trx' where no_faktur='$no_faktur'");

header ("location: ../kasir"); 



?>
