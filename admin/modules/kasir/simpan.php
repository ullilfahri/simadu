<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
$no_faktur = $_POST['no_faktur'];
$jumlah = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah']);
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$satuan = $_POST['satuan'];
$potongan = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['potongan']);
$id_gudang = $_POST['id_gudang'];
$stok_gudang = $_POST['stok_gudang'];
$distributor = $_POST['distributor'];
$sisa = $_POST['sisa_stok'];
$keterangan = $_POST['keterangan'];
$id_toko = $_SESSION['toko'];
$potongan_total=$potongan*$jumlah;

//$jumlah_stok_gudang = $_POST['stok_gudang']-$jumlah;

if ($potongan > 0) {
  $harga_dasar = $harga_barang-$potongan; 
  $sub_total = $jumlah*$harga_dasar;
  $harga_barang = $harga_barang;
  } else {
  $harga_barang = $harga_barang; 
  $sub_total = $jumlah*$harga_barang;
  }

if ($stok_gudang >= 0 && !empty($id_gudang) && !empty($kode_barang) && $jumlah > 0)  :
$ada=$conn->query("select COUNT(*), jumlah, sub_total, potongan, id from tabel_trx where id_gudang='$id_gudang' and no_faktur='$no_faktur' and kode_barang='$kode_barang' and id_toko='$id_toko'")->fetch_array();

$update=$conn->query("UPDATE `stok_barang` SET `sisa_stok` = '$sisa'  WHERE kode_barang='$kode_barang'");
		$stok_jual=$conn->query("SELECT * FROM alokasi_stok_jual WHERE id_gudang='$id_gudang' AND kode_barang='$kode_barang' AND no_faktur='$no_faktur'")->num_rows;
		if ($stok_jual > 0) {
		$update_stok_jual=$conn->query("UPDATE `alokasi_stok_jual` SET `jumlah` = jumlah+$jumlah  WHERE id_gudang='$id_gudang' AND kode_barang='$kode_barang' AND no_faktur='$no_faktur'");
		} else {
		$update_stok_jual=$conn->query("INSERT INTO `alokasi_stok_jual`(`id_gudang`, `nama_barang`, `kode_barang`, `jumlah`, `distributor`, no_faktur) VALUES ('$id_gudang', '$nama_barang', '$kode_barang', '$jumlah', '$distributor', '$no_faktur')");
		}
if ($ada[0]==0) {
$query=$conn->query("INSERT INTO `tabel_trx`(`no_faktur`, `jumlah`, `kode_barang`, `nama_barang`, `harga_barang`, `sub_total`, `satuan`, `potongan`, `id_gudang`, `distributor`,  `id_toko`, keterangan) VALUES('$no_faktur', '$jumlah', '$kode_barang', '$nama_barang', '$harga_barang', '$sub_total', '$satuan', '$potongan_total', '$id_gudang', '$distributor', '$id_toko', '$keterangan')");
} else {
$jml = $ada[1]+$jumlah;
$sb_ttl = $ada[2]+$sub_total;
$ptg = $potongan_total+$ada[3];
$query=$conn->query("UPDATE tabel_trx set jumlah='$jml', sub_total='$sb_ttl', potongan='$ptg' where id='".$ada[4]."'");
}

endif;

?>

