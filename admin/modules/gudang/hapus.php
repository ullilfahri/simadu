<?php
include '../../../sysconfig.php';
$id=$_POST['id'];
$awal=$conn->query("SELECT `jumlah_ambil`, `id_barang_keluar`, pintu_gudang, id_gudang, is_booking FROM `ambil_barang` WHERE id='$id'")->fetch_array();
$sisa=$conn->query("SELECT `is_ambil`, id_gudang, `pintu_gudang`, kode_barang, `distributor`, `no_faktur` FROM barang_keluar where id = '$awal[1]'")->fetch_array();
$stok=$sisa[0]-$awal[0];

$update=$conn->query("UPDATE `barang_keluar` SET `is_ambil` = '$stok' WHERE id='".$awal[1]."'");

$update=$conn->query("UPDATE alokasi_stok SET jumlah = jumlah+$awal[0] where id_gudang='$awal[3]' AND kode_barang = '$sisa[3]' AND pintu_gudang = '$awal[2]' AND distributor = '$sisa[4]'");
$update=$conn->query("UPDATE alokasi_stok_jual SET jumlah = jumlah+$awal[0] where id_gudang='$awal[3]' AND kode_barang = '$sisa[3]' AND no_faktur='$sisa[5]'");
if ($awal[4]==1) :
$update=$conn->query("UPDATE `alokasi_booking` SET `jumlah` = jumlah+$awal[0]  WHERE id_gudang='$awal[3]' AND pintu_gudang='$awal[2]' AND kode_barang='$sisa[3]'");
endif;


$query=$conn->query("delete from ambil_barang where id='$id'");
if ($query){
	echo json_encode(array('status' =>true));
}
else
{
	echo json_encode(array('status' =>false));
}
?>