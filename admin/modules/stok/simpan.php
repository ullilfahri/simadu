<?php
include '../../../sysconfig.php';
$id_pembelian = $_POST['id_pembelian'];
$distributor = $_POST['distributor'];
$jumlah = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah']);
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$sub_total=$jumlah*$harga_barang;
if ($jumlah > 0 && $harga_barang > 0 && !empty($kode_barang) && !empty($nama_barang)) :
$ada=$conn->query("select COUNT(*), id_pembelian, jumlah, sub_total from pembelian_sementara where id_pembelian='$id_pembelian' AND kode_barang='$kode_barang' AND distributor='$distributor'")->fetch_array();
if ($ada[0]==0) {
$query=$conn->query("INSERT INTO `pembelian_sementara`(`id_pembelian`, `jumlah`, `kode_barang`, `nama_barang`, `harga_barang`, `sub_total`, `distributor`) VALUES('$id_pembelian', '$jumlah', '$kode_barang', '$nama_barang', '$harga_barang', '$sub_total', '$distributor') ");
} else {
$jml=$ada[2]+$jumlah;
$update_total=$ada[3]+$sub_total;
$query=$conn->query("UPDATE pembelian_sementara SET jumlah = '".$jml."', sub_total='$update_total' where id_pembelian='$id_pembelian' AND kode_barang='$kode_barang'");
}
endif;

?>