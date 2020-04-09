<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_POST['kirim_pesan'])) :
$tujuan = $_POST['tujuan'];
$pengirim = $_POST['pengirim'];
$isi_pesan = $_POST['isi_pesan'];
$jumlah_dipilih = count($tujuan);

for($x=0;$x<$jumlah_dipilih;$x++){
$conn->query("INSERT INTO `kirim_pesan` VALUES ('', '$tujuan[$x]', '$pengirim', '$isi_pesan', '".date('Y-m-d H:i:s')."', '0')");
}

        echo "<script>window.alert('Pesan Terkirim') 
		window.location='pesan.php'</script>";		


endif;

if (isset($_GET['ambil_pesan'])) :

$jml_pesan = $conn->query("SELECT * FROM `kirim_pesan` WHERE `tujuan`='".$_SESSION['id']."' AND is_read=0")->num_rows;

//echo json_encode($jml_pesan);

echo json_encode(array('animasi' =>'', 'pesan' => $jml_pesan));

endif;


?>