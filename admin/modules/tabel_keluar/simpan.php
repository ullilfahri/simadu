<?php
include '../../../sysconfig.php';
$id_pembelian = $_POST['id_pembelian'];
$keterangan = $_POST['keterangan'];
$distributor = $_POST['distributor'];
$jumlah = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah']);
$jenis = $_POST['jenis'];
if ($_POST['kode']=='0') {
$cari=$conn->query(" SELECT * FROM jenis_pengeluaran ")->num_rows;
$digit=$cari+1;
$digit = str_pad($digit, 4, '0', STR_PAD_LEFT);
$kode_barang = 'OP'.$digit;
$masuk_kode=$conn->query(" INSERT INTO `jenis_pengeluaran`(`kode`, `jenis`) VALUES('$kode_barang', '$jenis') ");
} else {
$kode_barang=$_POST['kode'];
}
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$sub_total=$jumlah*$harga_barang;
if ($jumlah > 0 && $harga_barang > 0 && !empty($kode_barang) && !empty($jenis)) :
$query=$conn->query("INSERT INTO `pengeluaran_sementara`(`id_pembelian`, `jumlah`, `kode_barang`, `nama_barang`, `harga_barang`, `sub_total`, `distributor`, `keterangan`) VALUES( '$id_pembelian', '$jumlah', '$kode_barang', '$jenis', '$harga_barang', '$sub_total', '$distributor', '$keterangan') ");
endif;

?>