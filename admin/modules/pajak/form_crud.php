<?php
include '../../../sysconfig.php';

if (isset($_GET['editable'])) :

$tabel=$_GET['editable'];
$jenis_id=$_GET['jenis_id'];
$value = $_POST['value'];
$id = $_POST['pk'];
$kolom = $_POST['name'];

$conn->query("UPDATE $tabel SET $kolom = '$value' where $jenis_id = '$id' ");


endif;

if (isset($_POST['kirim_pesan'])) :
$jenis_arsip=implode(', ', $_POST['jenis_arsip']);
$tujuan = $_POST['tujuan'];
$pengirim = $_POST['pengirim'];
$isi_pesan = $_POST['isi_pesan'].' Yaitu : '.$jenis_arsip;
$jumlah_dipilih = count($tujuan);
$url = $_POST['url'];

for($x=0;$x<$jumlah_dipilih;$x++){
$conn->query("INSERT INTO `kirim_pesan` VALUES ('', '$tujuan[$x]', '$pengirim', '$isi_pesan', '".date('Y-m-d H:i:s')."', '0')");
}

        echo "<script>window.alert('Pesan Terkirim') 
		window.location='index.php?$url'</script>";		


endif;


?>
