<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';


if (isset($_GET['action'])) :

$nama_baru=$_GET['id_pembelian']; 
$file = $_FILES['asprise_scans']['name'];
$nama_file=$nama_baru.$file;
$ukuran_file = $_FILES['asprise_scans']['size'];
$tipe_file = $_FILES['asprise_scans']['type'];
$tmp_file = $_FILES['asprise_scans']['tmp_name'];

$path = "upload/".$nama_file;

$terupload = move_uploaded_file($tmp_file, $path);


if ($terupload) {
//$sql = $conn->query("update tabel_pembelian set file='$nama_file' where id_pembelian='$nama_baru'");
$path_baru='upload/'.$nama_baru.'.pdf';
$real_path='../stok/upload/'.$nama_baru.'.pdf';
$conn->query("INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `file`, distributor) VALUES ('5', '$nama_baru', '$nama_baru', '$real_path', '".$_SESSION['distributor']."')");
rename($path, $path_baru);
echo "Upload berhasil!<br/>";
echo "Link: <a href='upload/tampil_file.php?file=".$nama_baru.".pdf' target='_blank'>".$nama_baru.".pdf</a>";
} else {
echo "Upload Gagal!";
}


endif;	
?>