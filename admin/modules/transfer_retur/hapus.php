<?php
include '../../../sysconfig.php';
$id=$_POST['id'];
$jumlah_barang=$_POST['jumlah_barang'];
$kode_barang=$_POST['kode_barang'];
$query=$conn->query("delete from tabel_retur where id='$id'");
$query=$conn->query(" UPDATE stok_barang SET sisa_stok=sisa_stok-$jumlah_barang where kode_barang='$kode_barang' ");
if ($query){
	echo json_encode(array('status' =>true));
}
else
{
	echo json_encode(array('status' =>false));
}
?>