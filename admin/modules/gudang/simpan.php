<?php
include '../../../sysconfig.php';
$id_barang_keluar = $_POST['id_barang_keluar'];
$id_user = $_POST['id_user'];
$id_pengambilan = $_POST['id_pengambilan'];
$totstok = $_POST['totstok'];
$jumlah_ambil = $_POST['jumlah_ambil'];
$id_gudang = $_POST['id_gudang'];
$pecah = explode('#',$_POST['pintu_gudang']);
$pintu_gudang = $pecah[1];
$stok_pintu=$pecah[0];
$is_booking=$pecah[2];
$nama_barang = $_POST['nama_barang'];
$kode_barang = $_POST['kode_barang'];
$no_faktur = $_POST['no_faktur'];
$distributor = $_POST['dist'];
$remark = date('Y-m-d H:i:s');

if ($stok_pintu <= 0) {

echo json_encode(array('status' =>false, 'pesan' => ' '. $pintu_gudang.' Stok Tidak Mencukupi..!'));

} else if ($totstok < 0 || $id_barang_keluar=="" || $nama_barang=="" || $totstok=='NaN' || $totstok==''){
echo json_encode(array('status' =>false, 'pesan' => 'Entry Tidak Prosedural..!'));

} else  {

$sisa=$conn->query("select is_ambil from barang_keluar where id='$id_barang_keluar'")->fetch_array();
$is_ambil=$sisa[0]+$jumlah_ambil;

$update=$conn->query("UPDATE `barang_keluar` SET `is_ambil` = '$is_ambil'  WHERE id='$id_barang_keluar'");
if ($is_booking==1) :
$update=$conn->query("UPDATE `alokasi_booking` SET `jumlah` = jumlah-$jumlah_ambil  WHERE id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND kode_barang='$kode_barang'");
endif;

$ada=$conn->query("SELECT * FROM ambil_barang where id_pengambilan='$id_pengambilan' AND id_barang_keluar='$id_barang_keluar' AND id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND is_booking='$is_booking'")->num_rows;
if ($ada==0) {
$query=$conn->query("INSERT INTO `ambil_barang`(`id_pengambilan`, `id_user`, `id_barang_keluar`, `jumlah_ambil`, `remark`, `distributor`, pintu_gudang, id_gudang, is_booking) VALUES('$id_pengambilan', '$id_user', '$id_barang_keluar', '$jumlah_ambil', '$remark', '$distributor', '$pintu_gudang', '$id_gudang', '$is_booking') ");
} else {
$query=$conn->query("UPDATE `ambil_barang` SET `jumlah_ambil` = jumlah_ambil+$jumlah_ambil where id_pengambilan='$id_pengambilan' AND id_barang_keluar='$id_barang_keluar' AND id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND is_booking='$is_booking'");
}

$query=$conn->query("UPDATE alokasi_stok SET jumlah = jumlah-'$jumlah_ambil' where id_gudang='$id_gudang' AND kode_barang = '$kode_barang' AND pintu_gudang = '$pintu_gudang' AND distributor = '$distributor'");

$query=$conn->query("UPDATE alokasi_stok_jual SET jumlah = jumlah-'$jumlah_ambil' where id_gudang='$id_gudang' AND kode_barang = '$kode_barang' AND no_faktur='$no_faktur'");

echo json_encode(array('status' =>true, 'pesan' => 'Tersimpan'));

}

?>

