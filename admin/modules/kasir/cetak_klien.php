<?php 
include '../../../sysconfig.php';
//include MDL.'login/session.php';
$no_faktur=$_GET['no_faktur'];
$id_toko=$_GET['toko'];
if (isset($_GET['cetak_langsung'])) {
$total_awal=$_GET['total_awal'];
$customer = $_GET['customer'];
if (empty($_GET['jumlah_diskon'])) {
	$diskon='0';
	$jumlah_diskon='0';
	} else {
	$diskon=$_GET['diskon'];
	$jumlah_diskon=$_GET['jumlah_diskon'];
	$id_diskon=$_GET['id_diskon'];
	$distributor_diskon=$_GET['distributor_diskon'];
	$sub_total=$_GET['sub_total'];
	$potongan=$_GET['potongan'];
	$id_trx=$_GET['id_trx'];
	$update=$conn->query("update kode_voucher SET is_pakai='1', customer='$customer', user='".$_GET['kasir']."' where id='$id_diskon'");
	$update=$conn->query("update tabel_trx SET potongan='$potongan', sub_total='$sub_total' where id='$id_trx'");
	}
$total_akhir=$_GET['total_akhir'];
$tot=$_GET['tot'];
if (!empty($_GET['tunai'])) {
	$uang_muka=$_GET['tunai'];
	} else {
	$uang_muka='0';
	}


if ($_GET['total_akhir']>0) {
	$metode_bayar='1';
	$hutang=$total_akhir;
	} else {
	$metode_bayar='0';
	$hutang='0';
	}


if (empty($_GET['jatuh_tempo'])) {
	$jatuh_tempo='0000-00-00';
	$tempo_bayar='-';
	} else if ($_GET['jatuh_tempo']=='0000-00-00') {
	$jatuh_tempo=$_GET['jatuh_tempo'];
	$tempo_bayar='-';
	} else {
	$jatuh_tempo=$_GET['jatuh_tempo'];
	$tempo_bayar=tanggal_indo($_GET['jatuh_tempo']);
	}

if (!empty($_GET['antar_bank'])) {
	$antar_bank= $_GET['antar_bank'];
	$is_antar='1';
	} else {
	$antar_bank='0';
	$is_antar='0';
	}

if (!empty($_GET['dalam_bank'])) {
	$dalam_bank = $_GET['dalam_bank'];
	$is_dalam = '1';
	$is_confirm='1';
	} else {
	$dalam_bank = '0';
	$is_dalam = '0';
	$is_confirm='0';
	}

if (empty($_GET['radio_umum'])) {
		$array = Array (
				"umum" => Array (
        		"nama" => $_GET['nama_umum'],
        		"alamat" =>  $_GET['alamat_umum'],
        		"kota" =>  $_GET['kota_umum'],
				"hp" =>  $_GET['hp_umum'],
				));
$cus_umum = json_encode($array);
} else {
$cus_umum = '';
}	


$kasir=$conn->query("select nama, id from user where id='".$_GET['kasir']."'")->fetch_array();
$id_gudang    = $_GET['id_gudang'];
$pintu_gudang = $_GET['pintu_gudang'];

$update=$conn->query("UPDATE `tabel_faktur` SET `total_trx`='$total_awal', `total`='".$_GET['tot']."', `diskon`='".$diskon."', `metode_bayar`='".$metode_bayar."', `jatuh_tempo`='".$jatuh_tempo."', `customer`='".$_GET['customer']."', hutang='$hutang', uang_muka='$uang_muka', jumlah_diskon='$jumlah_diskon', antar_bank='$antar_bank', dalam_bank='$dalam_bank', cus_umum = '$cus_umum', is_confirm='$is_confirm' where no_faktur='$no_faktur'");

$loop=$conn->query("select distributor, SUM(sub_total), SUM(sub_total), id_gudang from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor DESC");
$jumlah_distributor=$loop->num_rows;
while ($ulang=$loop->fetch_array()) { //start while ulang

$tgl_transaksi=date('Y-m-d H:i:s', $no_faktur);

if ($metode_bayar==0 && $uang_muka == $total_awal) :
$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `is_dalam`, `is_antar`, id_toko) VALUES('".$ulang[0]."', '".$no_faktur."', '".$ulang[1]."', '$ulang[2]', '".$tgl_transaksi."', '".$customer."', '".$is_dalam."', '".$is_antar."', '$id_toko')");

$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Tunai', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = '".$ulang[0]."' ");

endif;

if ($metode_bayar==0 && $uang_muka > 0 && $uang_muka != $total_awal && $jumlah_distributor==3) :
	if ($ulang[0]=='TSNB' && $ulang[1] == $uang_muka) { // START Jika ada TSNB dan jumlah bayar TSNB = uang Muka
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Tunai', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = 'TSNB' ");
	
	if ($dalam_bank > 0) :
	//$bank_dalam=$dalam_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;
	if ($antar_bank > 0) :
	$bank_antar=$antar_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '3', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;
	
	} else if ($ulang[0]=='TSNB' && $ulang[1] > $uang_muka) {
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$uang_muka', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = 'TSNB' ");
	
	$sisa=$ulang[1]-$uang_muka;
	if ($dalam_bank > 0) :
	//$bank_dalam=$dalam_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$sisa', '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;
	if ($antar_bank > 0) :
	//$bank_antar=$antar_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '3', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$sisa', '".$tgl_transaksi."', '".$customer."', '3', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	endif;
	
	} else if ($ulang[0]=='TSNB' && $ulang[1] < $uang_muka){
	$sisa_tsnb=$uang_muka-$ulang[1];
	$sisa=$sisa_tsnb/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = 'TSNB' ");

	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$sisa', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor NOT LIKE 'TSNB' ");

	if ($dalam_bank > 0) :
	$bank_dalam=$dalam_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total-'$sisa', '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;
	if ($antar_bank > 0) :
	$bank_antar=$antar_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total-'$sisa', '".$tgl_transaksi."', '".$customer."', '3', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;
	}
endif;


if ($metode_bayar==0 && $uang_muka > 0 && $uang_muka != $total_awal && $jumlah_distributor < 3) :
	$sisa=$uang_muka/$jumlah_distributor;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$sisa', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor='".$ulang[0]."' GROUP BY distributor");
	
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor='".$ulang[0]."' ");
	
	if ($dalam_bank > 0) :
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total-'$sisa', '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor='".$ulang[0]."'  GROUP BY distributor");
	endif;
	if ($antar_bank > 0) :
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total-'$sisa', '".$tgl_transaksi."', '".$customer."', '3', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor='".$ulang[0]."'  GROUP BY distributor");
	endif;
endif;


if ($metode_bayar==0 && $uang_muka == 0) :
	if ($dalam_bank > 0) :
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor='".$ulang[0]."' GROUP BY distributor");
	endif;
	if ($antar_bank > 0) :
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '3', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor='".$ulang[0]."'  GROUP BY distributor");
	endif;
endif;

if ($metode_bayar==1) :
	if ($uang_muka > 0 && $jumlah_distributor == 3 && $ulang[0]=='TSNB' && $ulang[1]==$uang_muka && $dalam_bank==0 && $antar_bank==0) { 
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '$uang_muka', '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor = 'TSNB' GROUP BY distributor");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = 'TSNB' ");
		
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `id_toko`) SELECT distributor, no_faktur, SUM(sub_total), '0', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor NOT LIKE 'TSNB' AND distributor = '".$ulang[0]."' GROUP BY distributor");
	} else if ($uang_muka > 0 && $jumlah_distributor == 3 && $ulang[0]=='TSNB' && $ulang[1] < $uang_muka && $dalam_bank==0 && $antar_bank==0) {
				$sisa=$uang_muka-$ulang[1];
				$sisa_sql=$conn->query("SELECT sub_total, distributor, no_faktur, COUNT(*) from tabel_trx where distributor NOT LIKE 'TSNB' and no_faktur = '$no_faktur' and sub_total < $sisa ORDER BY distributor DESC")->fetch_array();
				$sisa_sql2=$conn->query("SELECT sub_total, distributor, no_faktur, COUNT(*) from tabel_trx where distributor NOT LIKE 'TSNB' and no_faktur = '$no_faktur' and sub_total >= $sisa ORDER BY distributor DESC")->fetch_array();

		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), SUM(sub_total), '".$tgl_transaksi."', '".$customer."', '0', '0', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor = 'TSNB' GROUP BY distributor");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Tunai', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = 'TSNB' ");
		
				if ($sisa_sql[3] > 0) :
				
				$sisa_habis = $sisa - $sisa_sql[0];
				
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko, is_antar) SELECT distributor, no_faktur, SUM(sub_total),  SUM(sub_total), '".$tgl_transaksi."', '".$customer."', '0', '$id_toko', '1' from tabel_trx where no_faktur='".$sisa_sql[2]."' AND distributor = '".$sisa_sql[1]."' AND distributor NOT LIKE 'TSNB'");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Tunai', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='".$sisa_sql[2]."' AND distributor = '".$sisa_sql[1]."' AND distributor NOT LIKE 'TSNB'");
				
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko, is_antar) SELECT distributor, no_faktur, SUM(sub_total),  '$sisa_habis', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko', '1' from tabel_trx where no_faktur='".$sisa_sql[2]."' AND distributor NOT LIKE '".$sisa_sql[1]."' AND distributor NOT LIKE 'TSNB'");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='".$sisa_sql[2]."' AND distributor NOT LIKE '".$sisa_sql[1]."' AND distributor NOT LIKE 'TSNB'");
				
				
				endif;
				
				if ($sisa_sql2[3] > 0) :
				
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko, is_antar) SELECT distributor, no_faktur, SUM(sub_total), '$sisa', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko', '1' from tabel_trx where no_faktur='".$sisa_sql2[2]."' AND distributor = '".$sisa_sql2[1]."'  AND distributor NOT LIKE 'TSNB' GROUP BY distributor");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='".$sisa_sql2[2]."' AND distributor = '".$sisa_sql2[1]."'  AND distributor NOT LIKE 'TSNB'");
				
				endif;
		
		
	} else if ($uang_muka > 0 && $jumlah_distributor == 3 && $ulang[0]=='TSNB' && $ulang[1] > $uang_muka && $dalam_bank==0 && $antar_bank==0) {
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '$uang_muka', '".$tgl_transaksi."', '".$customer."', '1', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor = 'TSNB' GROUP BY distributor");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Tunai', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND distributor = 'TSNB' ");
		
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '0', '".$tgl_transaksi."', '".$customer."', '1', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor NOT LIKE 'TSNB' AND distributor = '".$ulang[0]."' GROUP BY distributor");
		
		
	} else if ($jumlah_distributor < 3) {
		if ($uang_muka > 0) {	
		$jatah=$uang_muka/$jumlah_distributor;
		$kode=1;
		} else if ($dalam_bank > 0) {
		$jatah=$dalam_bank/$jumlah_distributor;
		$kode=2;
		} else {
		$jatah=$antar_bank/$jumlah_distributor;
		$kode=3;
		}
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) VALUES('".$ulang[0]."', '".$no_faktur."', '".$ulang[1]."', '$jatah', '".$tgl_transaksi."', '".$customer."', '1', '$kode', '$id_toko')");
		
	$masuk_tunai=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT '".$kasir[1]."', '".date('Y-m-d H:i:s')."', id, '".$no_faktur."', jumlah_bayar, 'Pembayaran Uang Muka', distributor, '$id_toko', '1' FROM tabel_bayar where no_faktur='$no_faktur' AND  distributor = '".$ulang[0]."' ");
		
	} else {
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko) VALUES('".$ulang[0]."', '".$no_faktur."', '".$ulang[1]."', '0', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko')");
	}
endif;




$data=$conn->query("select nama_barang, SUM(jumlah), satuan, harga_barang, potongan, SUM(sub_total), kode_barang  from tabel_trx where no_faktur='$no_faktur' and distributor='".$ulang[0]."' group by kode_barang");
while ($x=$data->fetch_array()) :
$masuk=$conn->query("INSERT INTO `barang_keluar`(`id_gudang`, `pintu_gudang`, `kode_barang`, `nama_barang`, `distributor`, `tanggal`, `no_faktur`, `jumlah`, `satuan`, `id_kasir`) VALUES ('$id_gudang', '$pintu_gudang', '".$x[6]."', '".$x[0]."', '".$ulang[0]."', '".date('Y-m-d H:i:s', $no_faktur)."', '$no_faktur', '".$x[1]."', '".$x[2]."', '".$kasir[1]."') ");
endwhile;
}//akhir  while ulang


/*$tampil = $conn->query("SELECT * FROM  `tabel_bayar` WHERE  `no_faktur` = '$no_faktur' AND  `jumlah_bayar` -  `jumlah_transaksi` > 0 ");
$jumlah_kurang = $conn->query("SELECT * FROM  `tabel_bayar` WHERE  `no_faktur` = '$no_faktur' AND  `jumlah_bayar` -  `jumlah_transaksi` < 0 ")->num_rows;
while ($s=$tampil->fetch_array()) :
$surplus=($s['jumlah_bayar']-$s['jumlah_transaksi'])/$jumlah_kurang;
$update=$conn->query("UPDATE tabel_bayar set jumlah_bayar = '".$s['jumlah_transaksi']."', metode_bayar='0' where id='".$s['id']."'");
$minus = $conn->query("SELECT * FROM  `tabel_bayar` WHERE  `no_faktur` = '$no_faktur' AND  `jumlah_bayar` -  `jumlah_transaksi` < 0 ");
	while ($m=$minus->fetch_array()) {
	$akhir=$m['jumlah_bayar']+$surplus;
	if ($akhir==$m['jumlah_transaksi']) {
		$data_bayar='0';
		} else {
		$data_bayar='1'; 
		}
	$update2=$conn->query("update tabel_bayar SET jumlah_bayar='$akhir', metode_bayar='$data_bayar' where id = '".$m['id']."'");
	}

endwhile;*/

$dua_sql=$conn->query("SELECT DISTINCT `distributor`, COUNT(*) , `jumlah_bayar` FROM tabel_bayar where `no_faktur` = '$no_faktur' GROUP BY distributor HAVING COUNT(*) > 1 ORDER BY distributor DESC");
while ($dua=$dua_sql->fetch_array()) :
$satu=$conn->query("UPDATE tabel_bayar SET jumlah_bayar='$dua[2]' where no_faktur='$no_faktur' AND distributor='$dua[0]' and is_antar=1");
$hapus=$conn->query("delete from tabel_bayar where no_faktur='$no_faktur' AND is_antar=0 and distributor='$dua[0]'");
endwhile;
$metode=$conn->query("UPDATE tabel_bayar SET metode_bayar = 0 where no_faktur='$no_faktur' AND jumlah_transaksi = jumlah_bayar");
$metode2=$conn->query("UPDATE tabel_bayar SET is_antar = 0 where no_faktur='$no_faktur' AND is_antar = 1");
//header ("location: index.php?Jnjhg"); 
header ("location: cetak_penjualan_klien.php?cetak_langsung&no_faktur=$no_faktur"); 
//header ("location: tes.php?no_faktur=$no_faktur");
} else {
$dis=$_GET['distributor'];
header ("location: cetak_penjualan_klien.php?dari_transaksi&no_faktur=$no_faktur&distributor=$dis"); 
}
