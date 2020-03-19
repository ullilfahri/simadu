<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['tambah_transfer'])) :

$jumlah_barang = $_POST['jumlah_barang'];
$id_user = $_POST['id_user'];
$id_gudang = $_POST['id_gudang'];
$pintu_gudang = $_POST['pintu_gudang'];
$kode_barang = $_POST['kode_barang'];



	if ($_POST['jenis_form']=='alokasi') {
		
		$id = $_POST['id_retur'];
		$kode=$conn->query(" SELECT * FROM tabel_retur WHERE `id` = '$id' AND kode=1 ")->num_rows;
		$ada=$conn->query("SELECT * FROM alokasi_stok where id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND kode_barang='$kode_barang'")->num_rows;
		if ($ada > 0) {
		$update_alokasi_stok=$conn->query(" UPDATE alokasi_stok SET jumlah=jumlah+$jumlah_barang where id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND kode_barang='$kode_barang' ");
		} else {
		$update_alokasi_stok=$conn->query(" INSERT INTO alokasi_stok(jumlah, kode_barang, id_gudang, pintu_gudang, nama_barang, distributor) SELECT '$jumlah_barang', kode_barang, '$id_gudang', '$pintu_gudang', nama_barang, distributor FROM tabel_retur WHERE id= '$id' ");
		}
		$update_retur=$conn->query(" UPDATE tabel_retur set is_alokasi=is_alokasi+$jumlah_barang, gudang_tujuan='$id_gudang', pintu_tujuan='$pintu_gudang' where id='$id' ");
		/*if ($kode > 0) :
		$update_stok_barang=$conn->query(" UPDATE stok_barang SET sisa_stok=sisa_stok+$jumlah_barang where kode_barang='$kode_barang' ");
		endif;*/
        echo json_encode(array('url' =>true, 'direct' => 'summary_data.php?data=data_retur', 'pesan' => 'Alokasi Tersimpan'));
		
		
	} else {
		$gudang_tujuan = $_POST['gudang_tujuan'];
		$pintu_tujuan = $_POST['pintu_tujuan'];
		$id = $_POST['id_asal'];
		$update=$conn->query(" UPDATE alokasi_stok SET jumlah=jumlah-$jumlah_barang WHERE id = '$id' ");
		$update=$conn->query(" UPDATE stok_barang SET sisa_stok=sisa_stok+$jumlah_barang where kode_barang='$kode_barang' ");
		$id_trx = $_POST['id_trx'];
			if ($gudang_tujuan==$id_gudang) {
				if ($pintu_tujuan=='') {
				echo json_encode(array('error' =>true, 'pesan' => 'Harap Isi Pintu Tujuan'));
				} else {
				$ada=$conn->query("SELECT * FROM alokasi_stok WHERE id_gudang = '$gudang_tujuan' AND pintu_gudang='$pintu_tujuan' AND kode_barang = '$kode_barang'")->num_rows;
				if ($ada > 0) {
					$update=$conn->query(" UPDATE alokasi_stok SET jumlah=jumlah+$jumlah_barang WHERE id_gudang = '$gudang_tujuan' AND pintu_gudang='$pintu_tujuan' AND kode_barang = '$kode_barang' ");
					} else {
					$update=$conn->query(" INSERT INTO alokasi_stok(jumlah, kode_barang, id_gudang, pintu_gudang, nama_barang, distributor) SELECT '$jumlah_barang', kode_barang, '$gudang_tujuan', '$pintu_tujuan', nama_barang, distributor FROM alokasi_stok WHERE id = '$id' ");
					}
				echo json_encode(array('url' =>true, 'direct' => 'entry_alokasi.php?JmnJUHS', 'pesan' => 'Transfer Antar Pintu Dalam Gudang Tersimpan' ));
				}	
				} else {
				$ada=$conn->query("SELECT * FROM tabel_retur WHERE id_trx='$id_trx' AND kode='2' AND kode_barang='$kode_barang' AND id_gudang='$id_gudang' AND gudang_tujuan='$gudang_tujuan'")->num_rows;
				if ($ada > 0) {
				$masuk=$conn->query(" UPDATE `tabel_retur` SET jumlah_barang=jumlah_barang+$jumlah_barang WHERE id_trx='$id_trx' AND kode='2' AND kode_barang='$kode_barang' AND id_gudang='$id_gudang' AND gudang_tujuan='$gudang_tujuan'");
				echo json_encode(array('status' =>true, 'pesan' => 'Update Tersimpan', 'gudang_tujuan' => $gudang_tujuan ));
				} else {
				$masuk=$conn->query(" INSERT INTO `tabel_retur`(`tanggal`, `user_approve`, `kode_barang`, `jumlah_barang`, `nama_barang`, `satuan`, `id_gudang`, `kode`, `gudang_tujuan`, `distributor`, id_trx, pintu_gudang) SELECT '".date('Y-m-d H:i:s')."', '$id_user', kode_barang, '$jumlah_barang', nama_barang, satuan, '$id_gudang', '2', '$gudang_tujuan', distributor, '$id_trx', '$pintu_gudang' FROM stok_barang where kode_barang =  '$kode_barang' ");
				echo json_encode(array('status' =>true, 'pesan' => 'Data Tersimpan', 'gudang_tujuan' => $gudang_tujuan));
				}
			}	
		
	} 	

endif;

if (isset($_GET['simpan_booking'])) :

$jumlah = $_POST['jumlah'];
$sisa = $_POST['totstok'];
$id_gudang = $_POST['id_gudang'];
$kode_barang = $_POST['kode_barang'];
$pintu_gudang = $_POST['pintu_gudang'];
$nama_barang = $_POST['nama_barang'];

$cek=$conn->query("SELECT * FROM alokasi_booking WHERE id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND kode_barang='$kode_barang'")->num_rows;
if ($cek == 0) {
	$masuk=$conn->query("INSERT INTO `alokasi_booking`(`id_gudang`, `nama_barang`, `kode_barang`, `jumlah`, `pintu_gudang`) VALUES('$id_gudang', '$nama_barang', '$kode_barang', '$jumlah', '$pintu_gudang')");
	} else {
	$masuk=$conn->query("UPDATE alokasi_booking SET jumlah=jumlah+$jumlah WHERE id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND kode_barang='$kode_barang'");
	}

if ($sisa==0) {
echo json_encode(array('habis' =>true, 'data' => $sisa, 'url' =>'entry_alokasi.php?JmnJUHS' ));
} else {
echo json_encode(array('sisa' =>true, 'data' => $sisa, 'url' =>'booking.php?jumlah='.$sisa.'&kode_barang='.$kode_barang.'&id_gudang='.$id_gudang.'&nama_barang='.$nama_barang));
}
endif;

if (isset($_GET['hapus_transfer'])) :
$id=$_POST['id'];
$id_gudang = $_POST['id_gudang'];
$kode_barang = $_POST['kode_barang'];
$pintu_gudang = $_POST['pintu_gudang'];
$jumlah_barang = $_POST['jumlah_barang'];
//$update=$conn->query(" UPDATE alokasi_stok SET jumlah=jumlah+$jumlah_barang WHERE id = '$id' ");
echo json_encode(array('status' =>true, 'pesan'=>$jumlah_barang ));
endif;

?>
