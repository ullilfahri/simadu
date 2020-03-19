<?php
include '../../../sysconfig.php';
$id=$_POST['id'];
$awal=$conn->query("SELECT `id`, `jumlah`, `kode_barang`, `id_gudang`, id_alokasi, no_faktur FROM `tabel_trx` WHERE id='$id'")->fetch_array();


$update=$conn->query("UPDATE `stok_barang` SET `sisa_stok` = sisa_stok + ".$awal[1]." WHERE kode_barang='".$awal[2]."'");
$update=$conn->query("UPDATE `alokasi_stok_jual` SET `jumlah` = jumlah - ".$awal[1]." WHERE id_gudang='".$awal[3]."' AND kode_barang='".$awal[2]."' AND no_faktur='".$awal[5]."' ");

$query=$conn->query("delete from tabel_trx where id='$id'");
if ($query){
	echo json_encode(array('status' =>true));
}
else
{
	echo json_encode(array('status' =>false));
}
?>