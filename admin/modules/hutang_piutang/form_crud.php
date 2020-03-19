<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['konfirmasi'])) :

$id=$_GET['modal_id'];
$konfirmasi=$_GET['konfirmasi'];

if ($konfirmasi=='success') {
$masuk=$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `id_bayar`, `jumlah_bayar`, `no_faktur`, `keterangan`, `distributor`) SELECT '".$_SESSION['id']."', id, jumlah_bayar, no_faktur, 'Konfirmasi Transfer', distributor FROM tabel_bayar where id='$id'");
$alert='approve';
} else {
$masuk=$conn->query("DELETE FROM `konfirmasi_bank` WHERE id_bayar='$id'");
$alert='not_approve';
}
        echo "<script>window.alert('Berhasil..!') 
		window.location='konfirmasi_bank.php?$alert'</script>";
endif;


if (isset($_GET['hapus_kas'])) :

$id=$_GET['modal_id'];

echo $id;

endif;

if (isset($_POST['tambah_pengeluaran'])) :
$tabel = $_POST['tabel'];
$jenis = $_POST['jenis'];
$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);
$keterangan = $_POST['keterangan'];
$user_approve = $_POST['user_approve'];
$id_toko = $_POST['id_toko'];
$distributor = $_POST['distributor'];

if (!empty($_POST['id_bank'])) {
	$id_bank = $_POST['id_bank'];
	$masuk=$conn->query("INSERT INTO $tabel (jenis, jumlah_bayar, keterangan, id_bank, user_approve, id_toko, distributor) VALUES ('$jenis', '$jumlah_bayar', '$keterangan', '$id_bank', '$user_approve', '$id_toko', '$distributor')"); 
	} else {
	$masuk=$conn->query("INSERT INTO $tabel (jenis, jumlah_bayar, keterangan, user_approve, id_toko, distributor) VALUES ('$jenis', '$jumlah_bayar', '$keterangan', '$user_approve', '$id_toko', '$distributor')"); 
	}


        echo "<script>window.alert('Berhasil..!') 
		window.location='pengeluaran.php?main'</script>";

endif;

if (isset($_POST['tambah_pembukaan_kas'])) :

$jenis = $_POST['jenis'];
$user_approve = $_POST['user_approve'];
$id_toko = $_POST['id_toko'];
$keterangan = $_POST['keterangan'];
$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);

$kas=$conn->query(" INSERT INTO `konfirmasi_tunai`(`user_approve`, `jumlah_bayar`, `keterangan`, `id_toko`, `jenis`) VALUES('$user_approve', '$jumlah_bayar', '$keterangan', '$id_toko', '$jenis') ");

if ($kas) {
	    echo "<script>window.alert('Berhasil..!') 
		window.location='menu_kasir.php?hari_ini'</script>";
	} else {
	    echo "<script>window.alert('Gagal..!') 
		window.location='menu_kasir.php?hari_ini'</script>";
	}	


endif;

if (isset($_POST['entry_pengeluaran'])) :

$jenis = $_POST['jenis'];
$user_approve = $_POST['user_approve'];
$id_toko = $_POST['id_toko'];
$keterangan = $_POST['keterangan'];
$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);

$kas=$conn->query(" INSERT INTO `konfirmasi_tunai`(`user_approve`, `jumlah_bayar`, `keterangan`, `id_toko`, `jenis`) VALUES('$user_approve', '$jumlah_bayar', '$keterangan', '$id_toko', '$jenis') ");

if ($kas) {
	    echo "<script>window.alert('Berhasil..!') 
		window.location='menu_kasir.php?hari_ini'</script>";
	} else {
	    echo "<script>window.alert('Gagal..!') 
		window.location='menu_kasir.php?hari_ini'</script>";
	}	


endif;

if (isset($_POST['entry_penyetoran'])) :

$jenis = $_POST['jenis'];
$distributor = $_POST['distributor'];
$dis=$conn->query("SELECT pengguna FROM mst_hak_akses WHERE kode='$distributor'")->fetch_array();
$user_approve = $_POST['user_approve'];
$id_toko = $_POST['id_toko'];
$toko=$conn->query("SELECT nama from lokasi where id_lokasi = '$id_toko'")->fetch_array();
$keterangan_toko = $_POST['keterangan'].' '.$dis[0];
$keterangan_distributor = 'Setoran Pendapatan Dari '.$toko[0];
$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);
$tabel =   $_POST['via_bayar'];
if (!empty($_POST['id_bank'])) {
	$field_bank=', id_bank';
	$id_bank=$_POST['id_bank'];
	$id_bank=", '$id_bank'";
	} else {
	$field_bank='';
	$id_bank="";
   }




$kas=$conn->query(" INSERT INTO konfirmasi_tunai(`user_approve`, `jumlah_bayar`, `keterangan`, `id_toko`, `jenis`) VALUES('$user_approve', '$jumlah_bayar', '$keterangan_toko', '$id_toko', '$jenis') ");

$masuk=$conn->query(" INSERT INTO $tabel(`user_approve`, `jumlah_bayar`, `keterangan`, `distributor`, `jenis` $field_bank) VALUES('$user_approve', '$jumlah_bayar', '$keterangan_distributor', '$distributor', '3' $id_bank) ");

	    echo "<script>window.alert('Berhasil..!') 
		window.location='menu_kasir.php?hari_ini'</script>";
endif;

?>