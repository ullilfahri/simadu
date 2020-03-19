<?php
include '../../../sysconfig.php';

if (isset($_GET['live_edit'])) :
$tabel=$_GET['live_edit'];
$kolom=$_POST['column'];
$id=$_POST['id'];
if ($kolom=='limit_kredit') {
$value=preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['editval']);
$value = preg_replace("/[^0-9.]/", '', $value);
} else if ($kolom=='no_hp'){
$value=$_POST['editval'];
$value = str_replace(" ","",$value);
$value = str_replace(".","",$value);
$value = preg_replace("/^((\+?)0)/", "+62", $value);
} else {
$value=$_POST['editval'];
}

$update=$conn->query("update $tabel SET $kolom = '$value' where id = '$id'");

endif;


if (isset($_POST['tambah_supplier'])) :

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$no_hp = $_POST['no_hp'];
$no_hp = str_replace(" ","",$no_hp);
$no_hp = str_replace(".","",$no_hp);
$no_hp = preg_replace("/^((\+?)0)/", "+62", $no_hp);
	if (!empty($_POST['jenis_1'])) {
		$jenis_1=$_POST['jenis_1'];
		} else {
		$jenis_1=0;
		}
	if (!empty($_POST['jenis_2'])) {
		$jenis_2=$_POST['jenis_2'];
		} else {
		$jenis_2=0;
		}
		
		
$jenis_supplier = $jenis_1+$jenis_2;
$no_identitas = $_POST['no_identitas'];
$email = $_POST['email'];
$contact_person = $_POST['contact_person'];

if ($_POST['tambah_supplier']=='tambah') {

$masuk=$conn->query("INSERT INTO `tabel_supplier`(`nama`, `alamat`, `no_hp`, `kota`, `jenis_supplier`, `no_identitas`, `email`, `contact_person`) VALUES('$nama', '$alamat', '$no_hp', '$kota', '$jenis_supplier', '$no_identitas', '$email', '$contact_person') ");

} else {
$id=$_POST['id'];
	if (!empty($_POST['non_aktif'])) {
	$non_aktif= '0';
	} else {
	$non_aktif= '1';
	} 
$masuk=$conn->query("UPDATE `tabel_supplier` SET `nama`='$nama', `alamat`='$alamat', `no_hp`='$no_hp', `kota`='$kota', `jenis_supplier`='$jenis_supplier', `no_identitas`='$no_identitas', `email`='$email', `contact_person`='$contact_person' , `non_aktif`='$non_aktif'  where id = '$id'");
}

echo "<script>window.alert('Dtaa Supplier Disimpan') 
	window.location='supplier.php?main'</script>";


endif;

if (isset($_GET['hapus'])) :

$id=$_GET['modal_id'];
$tabel=$_GET['tabel'];
$ket=$_GET['ket'];


$hapus=$conn->query("DELETE FROM $tabel WHERE id='$id'");

echo "<script>window.alert('$ket Terhapus') 
	window.location='$ket.php?main'</script>";


endif;

if (isset($_POST['tambah_customer'])) :

$nama = $_POST['nama'];
$level_diskon = $_POST['level_diskon'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$contact_person = $_POST['contact_person'];
$no_identitas = $_POST['no_identitas'];
$kota = $_POST['kota'];
$no_hp = $_POST['no_hp'];
$no_hp = str_replace(" ","",$no_hp);
$no_hp = str_replace(".","",$no_hp);
$no_hp = preg_replace("/^((\+?)0)/", "+62", $no_hp);
$limit_kredit = $_POST['limit_kredit'];
$limit_kredit=preg_replace('/[^A-Za-z0-9\  ]/', '', $limit_kredit);
$limit_kredit = preg_replace("/[^0-9.]/", '', $limit_kredit);

if ($_POST['tambah_customer']=='ubah') {
$id=$_POST['id'];
	if (!empty($_POST['non_aktif'])) {
	$non_aktif= '0';
	} else {
	$non_aktif= '1';
	} 

$masuk=$conn->query("UPDATE `tabel_customer` SET `nama`='$nama', `alamat`='$alamat', `no_hp`='$no_hp', `kota`='$kota', `limit_kredit`='$limit_kredit', `no_identitas`='$no_identitas', `email`='$email', `contact_person`='$contact_person' , `non_aktif`='$non_aktif'  , `level_diskon`='$level_diskon'  where id = '$id'");

} else {
$masuk=$conn->query("INSERT INTO `tabel_customer`(`nama`, `alamat`, `no_hp`, `kota`, `limit_kredit`, `no_identitas`, `email`, `contact_person`, `level_diskon`) VALUES('$nama', '$alamat', '$no_hp', '$kota', '$limit_kredit', '$no_identitas', '$email', '$contact_person', '$level_diskon') ");
}

echo "<script>window.alert('Data Customer Disimpan') 
	window.location='customer.php?main'</script>";


endif;



if (isset($_POST['tambah_rekening_bank'])) :

$bank = $_POST['bank'];
$no_rek = $_POST['no_rek'];
$nama_akun = $_POST['nama_akun'];
$distributor = $_POST['distributor'];
$is_aktif = $_POST['is_aktif'];
if (!empty($_POST['stts'])) {
$stts = $_POST['stts'];
$id_toko = $_POST['id_toko'];
} else {
$stts ='0';
$id_toko = '0';
}

$masuk=$conn->query("INSERT INTO `rekening_bank`(`bank`, `no_rek`, `nama_akun`, `id_toko`, `distributor`, `stts`, `is_aktif`) VALUES('$bank', '$no_rek', '$nama_akun', '$id_toko', '$distributor', '$stts', '$is_aktif')");

echo "<script>window.alert('Rekening Bank Ditambah') 
	window.location='buku_bank.php?kasir'</script>";

endif;

if (isset($_GET['aktif_rekening'])) :

$update=$conn->query("UPDATE rekening_bank set is_aktif='".$_GET['is_aktif']."' WHERE id = '".$_GET['id']."' ");
echo "<script>window.alert('REKENING BANK DI".strtoupper($_GET['ket'])."KAN') 
	window.location='buku_bank.php?kasir'</script>";


endif;

if (isset($_POST['tambah_karyawan'])) :

$nama_karyawan = $_POST['nama_karyawan'];
$jenis_karyawan = $_POST['jenis_karyawan'];
$tanggal_lahir = date_format(date_create_from_format('l d F Y', $_POST['tanggal_lahir']), 'Y-m-d');
$mulai_kerja = date_format(date_create_from_format('l d F Y', $_POST['mulai_kerja']), 'Y-m-d');



$masuk=$conn->query("INSERT INTO `tabel_karyawan`(`nama_karyawan`, `jenis_karyawan`, `tanggal_lahir`, `mulai_kerja`) VALUES('$nama_karyawan', '$jenis_karyawan', '$tanggal_lahir', '$mulai_kerja')");

echo "<script>window.alert('Karyawan Ditambah') 
	window.location='karyawan.php?main'</script>";


endif;

if (isset($_POST['ubah_karyawan'])) :

$id = $_POST['id'];
$nama_karyawan = $_POST['nama_karyawan'];
$jenis_karyawan = $_POST['jenis_karyawan'];
$tanggal_lahir = date_format(date_create_from_format('l d F Y', $_POST['tanggal_lahir']), 'Y-m-d');
$mulai_kerja = date_format(date_create_from_format('l d F Y', $_POST['mulai_kerja']), 'Y-m-d');
	if (!empty($_POST['non_aktif'])) {
	$non_aktif= '0';
	} else {
	$non_aktif= '1';
	} 

$masuk=$conn->query("UPDATE `tabel_karyawan` SET `nama_karyawan`='$nama_karyawan', `jenis_karyawan`='$jenis_karyawan', `tanggal_lahir`='$tanggal_lahir', `non_aktif`='$non_aktif', `mulai_kerja`='$mulai_kerja' WHERE id = '$id'");

echo "<script>window.alert('Data Karyawan Nama $nama_karyawan Diubah') 
	window.location='karyawan.php?main'</script>";


endif;



if (isset($_GET['sopir'])) :
$ket = $_GET['ket'];
$id = $_GET['id'];

	if ($ket=='aktif') {
	$ada=$conn->query("SELECT * FROM tabel_sopir WHERE id_karyawan='$id'")->num_rows;
		if ($ada==0) :
		$masuk=$conn->query("INSERT INTO `tabel_sopir`(`id_karyawan`) SELECT id FROM tabel_karyawan WHERE id='$id'");
		endif;
	echo "<script>window.alert('Data Sopir Ditambah') 
	window.location='karyawan.php?main'</script>";
	} else {
	$hapus=$conn->query("DELETE FROM `tabel_sopir` WHERE id_karyawan='$id'");
	echo "<script>window.alert('Data Sopir Dihapus') 
	window.location='karyawan.php?main'</script>";
	}

endif;

?>