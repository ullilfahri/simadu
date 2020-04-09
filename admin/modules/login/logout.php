<?php
include "../../../sysconfig.php";
include MDL.'login/session.php';

$ambil=$conn->query("SELECT no_faktur FROM tabel_faktur WHERE total_trx=0 and kasir='".$_SESSION['id']."'");
while ($a=$ambil->fetch_array()) :
	$retur=$conn->query("select * from tabel_trx where no_faktur='".$a[0]."'");
	while ($b=$retur->fetch_array()) :
	$sisa_stok=$conn->query("select sisa_stok from stok_barang where kode_barang='".$b['kode_barang']."'")->fetch_array();
	$stok=$b['jumlah']+$sisa_stok[0];
	$update=$conn->query("update stok_barang set sisa_stok='$stok' where kode_barang='".$b['kode_barang']."'");
	endwhile;
	$hapus_trx=$conn->query("delete from tabel_trx where no_faktur='".$a[0]."'");
	$hapus_alokasi_jual=$conn->query("delete from alokasi_stok_jual where no_faktur='".$a[0]."'");
endwhile;
$hapus_faktur=$conn->query("delete FROM tabel_faktur WHERE total_trx=0 and kasir='".$_SESSION['id']."'");
$conn->query("update user set last_login=NOW(), limit_sesi=0 where id='".$_SESSION['id']."'  ");

//session_start();
session_destroy(); //sesi login dihancurkan
//header ("location: ./"); 

?>

<script>
		var ua = navigator.userAgent.toLowerCase();
		var isAndroid = ua.indexOf("android") > -1;
		if(isAndroid) {
		Website2APK.exitApp();
		} else {
		window.location.href = './';
		}

</script>