<?php
include '../../../sysconfig.php';

if (isset($_GET['simpan_data'])) :
//$id_ambil_barang = $_POST['id_ambil_barang'];
$user_approve = $_POST['user_approve'];
$id_trx = $_POST['id_trx'];
$id_toko = $_POST['id_toko'];
$tanggal = $_POST['tanggal'];
$kode = $_POST['kode'];
$nama_barang = $_POST['nama_barang'];
$kode_barang = $_POST['kode_barang'];
$no_faktur = $_POST['no_faktur'];
$distributor = $_POST['distributor'];
$satuan = $_POST['satuan'];
$jumlah_barang = $_POST['jumlah_barang'];


$ada=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx' AND kode='$kode' AND kode_barang='$kode_barang' AND id_toko='$id_toko'")->num_rows;
$ada_dis=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx' AND distributor != '$distributor'")->num_rows;
$ada_fak=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx' AND no_faktur != '$no_faktur'")->num_rows;
$update_stok_barang=$conn->query(" UPDATE stok_barang SET sisa_stok=sisa_stok+$jumlah_barang where kode_barang='$kode_barang' ");

/*
		if ( $ada > 0 && $ada_dis > 0 && $ada_fak > 0 ) {
		$retur=$conn->query("UPDATE tabel_retur SET jumlah_barang = jumlah_barang+$jumlah_barang where id_trx='$id_trx' AND kode='$kode' AND kode_barang='$kode_barang' AND id_toko='$id_toko'");
		echo json_encode(array('status' =>true, 'error' =>true,  'pesan' => ' Data Ditambah..!'));
		} else if ( $ada > 0 && $ada_dis == 0  && $ada_fak > 0) {
		echo json_encode(array('error' =>false, 'pesan' => ' Harus Distributor Yang Sama..! Lakukan Finalisasi Terlebih Dahulu'));
		} else if ( $ada > 0 && $ada_fak == 0  ) {
		echo json_encode(array('error' =>false, 'pesan' => ' Harus Nomor Faktur Yang Sama..! Lakukan Finalisasi Terlebih Dahulu'));
		} else if ( $ada == 0 && $ada_dis == 0 && $ada_fak == 0 ) {
		$retur=$conn->query("INSERT INTO tabel_retur(tanggal, id_trx, no_faktur, user_approve, kode_barang, jumlah_barang, nama_barang, satuan, id_toko, kode, distributor) VALUES('$tanggal', '$id_trx', '$no_faktur', '$user_approve', '$kode_barang', '$jumlah_barang', '$nama_barang', '$satuan', '$id_toko', '$kode', '$distributor')");
		echo json_encode(array('status' =>true, 'error' =>true, 'pesan' => ' Data Tersimpan..!'));
		} else if ( $ada == 0 && $ada_dis > 0 && $ada_fak > 0 ) {
		$retur=$conn->query("INSERT INTO tabel_retur(tanggal, id_trx, no_faktur, user_approve, kode_barang, jumlah_barang, nama_barang, satuan, id_toko, kode, distributor) VALUES('$tanggal', '$id_trx', '$no_faktur', '$user_approve', '$kode_barang', '$jumlah_barang', '$nama_barang', '$satuan', '$id_toko', '$kode', '$distributor')");
		echo json_encode(array('status' =>true, 'error' =>true, 'pesan' => ' Data Tersimpan..!'));
		} else {
		echo json_encode(array('error' =>false, 'pesan' => ' Harus Distributor Yang Sama..!! Lakukan Finalisasi Terlebih Dahulu'));
		}

*/

if ($ada_fak > 0) {
	echo json_encode(array('error' =>true, 'pesan' => ' Harus Nomor Faktur Yang Sama..! Lakukan Finalisasi Terlebih Dahulu'));
	} else if ($ada_dis > 0) {
	echo json_encode(array('error' =>true, 'pesan' => ' Harus Distributor Yang Sama..! Lakukan Finalisasi Terlebih Dahulu'));
	} else if ($ada > 0) {
	$retur=$conn->query("UPDATE tabel_retur SET jumlah_barang = jumlah_barang+$jumlah_barang where id_trx='$id_trx' AND kode='$kode' AND kode_barang='$kode_barang' AND id_toko='$id_toko'");
	echo json_encode(array('status' =>true, 'pesan' => ' Data Tersimpan'));
	} else {
	$retur=$conn->query("INSERT INTO tabel_retur(tanggal, id_trx, no_faktur, user_approve, kode_barang, jumlah_barang, nama_barang, satuan, id_toko, kode, distributor) VALUES('$tanggal', '$id_trx', '$no_faktur', '$user_approve', '$kode_barang', '$jumlah_barang', '$nama_barang', '$satuan', '$id_toko', '$kode', '$distributor')");
	echo json_encode(array('status' =>true, 'pesan' => ' Data Tersimpan'));
	}

endif;



?>

