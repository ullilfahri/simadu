<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';
include('barcode/src/BarcodeGenerator.php');
include('barcode/src/BarcodeGeneratorJPG.php');
$generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();

file_put_contents($_SERVER['DOCUMENT_ROOT']."/folder_upload/barcode/".$_GET['no_faktur'].'.jpg', $generatorJPG->getBarcode($_GET['no_faktur'], $generatorJPG::TYPE_CODE_128));
$no_faktur=$_GET['no_faktur'];
$id_toko=$_SESSION['toko'];
if (isset($_GET['cetak_langsung'])) {
$total_awal=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['total_awal']);
$customer = $_GET['customer'];
if (empty($_GET['jumlah_diskon'])) {
	$diskon='0';
	$jumlah_diskon='0';
	} else {
	$diskon=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['diskon']);
	$jumlah_diskon=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['jumlah_diskon']);
	$id_diskon=$_GET['id_diskon'];
	$distributor_diskon=$_GET['distributor_diskon'];
	$sub_total=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['sub_total']);
	$spc_diskon=$_GET['spc_diskon'];
	$id_trx=$_GET['id_trx'];
	$update=$conn->query("update kode_voucher SET is_pakai='1', customer='$customer', user='".$_GET['kasir']."' where id='$id_diskon'");
	$update=$conn->query("update tabel_trx SET spc_diskon='$jumlah_diskon', sub_total='$sub_total' where id='$id_trx'");
	}
$total_akhir=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['total_akhir']);
$tot=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['tot']);
if (!empty($_GET['tunai'])) {
	$uang_muka=preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['tunai']);
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
	$jatuh_tempo = strtotime($_GET['jatuh_tempo'], $no_faktur);
	$jatuh_tempo = date('Y-m-d', $jatuh_tempo);
	$tempo_bayar=tanggal_indo($jatuh_tempo);
	}

if (!empty($_GET['antar_bank'])) {
	$antar_bank= preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['antar_bank']);
	$is_antar='1';
	} else {
	$antar_bank='0';
	$is_antar='0';
	}

if (!empty($_GET['dalam_bank'])) {
	$dalam_bank = preg_replace('/[^A-Za-z0-9\  ]/', '', $_GET['dalam_bank']);
	$is_dalam = '1';
	$is_confirm='1';
	} else {
	$dalam_bank = '0';
	$is_dalam = '0';
	$is_confirm='0';
	}


$kasir=$conn->query("select nama, id from user where id='".$_GET['kasir']."'")->fetch_array();
$id_gudang    = $_GET['id_gudang'];
$pintu_gudang = $_GET['pintu_gudang'];

$update=$conn->query("UPDATE `tabel_faktur` SET `total_trx`='$total_awal', `total`='".$_GET['tot']."', `diskon`='".$diskon."', `metode_bayar`='".$metode_bayar."', `jatuh_tempo`='".$jatuh_tempo."', hutang='$hutang', uang_muka='$uang_muka', jumlah_diskon='$jumlah_diskon', antar_bank='$antar_bank', dalam_bank='$dalam_bank', is_confirm='$is_confirm' where no_faktur='$no_faktur'");

$loop=$conn->query("select distributor, SUM(sub_total), SUM(sub_total), id_gudang from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor DESC");
$jumlah_distributor=$loop->num_rows;
$tgl_transaksi=date('Y-m-d H:i:s', $no_faktur);

/* TANPA LOOP */

if ($metode_bayar==0 && $uang_muka > 0 && $uang_muka != $total_awal && $jumlah_distributor != 3 && $is_dalam==1) :
	$jatah_tunai=$uang_muka/$jumlah_distributor;
	$jatah_bank = $dalam_bank/$jumlah_distributor;
	$total_jatah=$jatah_tunai+$jatah_bank;
	$jatah_awal=$uang_muka;

	$cari=$conn->query("SELECT COUNT(*), `no_faktur`, distributor, SUM(`sub_total`) FROM tabel_trx where no_faktur='$no_faktur' GROUP BY `distributor` HAVING SUM(`sub_total`) <= '$jatah_awal'")->fetch_array();
	
	if ($cari[0] > 0) {
		$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), SUM(sub_total), '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko', '10' from tabel_trx where no_faktur='$no_faktur' and distributor = '$cari[2]' GROUP BY distributor");
		$sisa_tunai=$uang_muka-$cari[3];
		$sisa_bank=$dalam_bank-$cari[3];
			if($sisa_tunai >= 0) {
				$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), '$sisa_tunai', '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko', '11' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE '$cari[2]' GROUP BY distributor");
				$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), '$dalam_bank', '".$tgl_transaksi."', '".$customer."', '0', '2', '$id_toko', '12' from tabel_trx where no_faktur='$no_faktur' and distributor  NOT LIKE'$cari[2]' GROUP BY distributor");
				} else {
				$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), '$sisa_bank', '".$tgl_transaksi."', '".$customer."', '0', '2', '$id_toko', '13' from tabel_trx where no_faktur='$no_faktur' and distributor  NOT LIKE '$cari[2]' GROUP BY distributor");
				$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), '$uang_muka', '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko', '14' from tabel_trx where no_faktur='$no_faktur' and distributor  NOT LIKE '$cari[2]' GROUP BY distributor");
				} 
		

		} else {
		$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), '$jatah_tunai', '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko', '11' from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor");
		$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, metode_bayar, `kode_bayar`, id_toko, remark) SELECT distributor, no_faktur, SUM(sub_total), SUM(sub_total)-$jatah_tunai, '".$tgl_transaksi."', '".$customer."', '0', '2', '$id_toko', '12' from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor");

		}
	
endif;

if ($metode_bayar==0 && $uang_muka == 0) :
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '0', '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor");
endif;

if ($metode_bayar==0 && $is_dalam==0) :
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), SUM(sub_total), '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor");
endif;

/* AKHIR TANPA LOOP */

while ($ulang=$loop->fetch_array()) { //start while ulang

if ($metode_bayar==1) :
	if ($uang_muka > 0 && $jumlah_distributor == 3 && $ulang[0]=='TSNB' && $ulang[1]==$uang_muka && $dalam_bank==0 && $antar_bank==0) { 
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '$uang_muka', '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor = 'TSNB' GROUP BY distributor");
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`) SELECT distributor, no_faktur, SUM(sub_total), '0', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor NOT LIKE 'TSNB' AND distributor = '".$ulang[0]."' GROUP BY distributor");
	} else if ($uang_muka > 0 && $jumlah_distributor == 3 && $ulang[0]=='TSNB' && $ulang[1] < $uang_muka && $dalam_bank==0 && $antar_bank==0) {
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '$uang_muka', '".$tgl_transaksi."', '".$customer."', '1', '0', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor = 'TSNB' GROUP BY distributor");
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '0', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor NOT LIKE 'TSNB' AND distributor = '".$ulang[0]."' GROUP BY distributor");
	} else if ($uang_muka > 0 && $jumlah_distributor == 3 && $ulang[0]=='TSNB' && $ulang[1] > $uang_muka && $dalam_bank==0 && $antar_bank==0) {
	$sisa=($ulang[1]-$uang_muka)/2;
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), '$uang_muka', '".$tgl_transaksi."', '".$customer."', '0', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor = 'TSNB' GROUP BY distributor");
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, SUM(sub_total), SUM(sub_total)-$sisa, '".$tgl_transaksi."', '".$customer."', '1', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' AND distributor NOT LIKE 'TSNB' AND distributor = '".$ulang[0]."' GROUP BY distributor");
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
	} else {
		$masuk_bayar=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko) VALUES('".$ulang[0]."', '".$no_faktur."', '".$ulang[1]."', '0', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko')");
	}
endif;


if ($metode_bayar==0 && $uang_muka > 0 && $uang_muka != $total_awal && $jumlah_distributor==3) :
	if ($ulang[0]=='TSNB' && $ulang[1] == $uang_muka) { // START Jika ada TSNB dan jumlah bayar TSNB = uang Muka
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	if ($dalam_bank > 0) :
	//$bank_dalam=$dalam_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;
	
	} else if ($ulang[0]=='TSNB' && $ulang[1] > $uang_muka) {
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$uang_muka', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	$sisa=$ulang[1]-$uang_muka;
	if ($dalam_bank > 0) :
	//$bank_dalam=$dalam_bank/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$sisa', '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '2', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
	endif;

	} else if ($ulang[0]=='TSNB' && $ulang[1] < $uang_muka){
	$sisa=($uang_muka-$ulang[1])/2;
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, sub_total, '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor='TSNB'");
	$masuk=$conn->query("INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `kode_bayar`, id_toko) SELECT distributor, no_faktur, sub_total, '$sisa', '".$tgl_transaksi."', '".$customer."', '1', '$id_toko' from tabel_trx where no_faktur='$no_faktur' and distributor NOT LIKE 'TSNB' GROUP BY distributor");
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







$data=$conn->query("select nama_barang, SUM(jumlah), satuan, harga_barang, potongan, SUM(sub_total), kode_barang, id_gudang  from tabel_trx where no_faktur='$no_faktur' and distributor='".$ulang[0]."' group by kode_barang");
while ($x=$data->fetch_array()) :
$masuk=$conn->query("INSERT INTO `barang_keluar`(`id_gudang`, `pintu_gudang`, `kode_barang`, `nama_barang`, `distributor`, `tanggal`, `no_faktur`, `jumlah`, `satuan`, `id_kasir`) VALUES ('$x[7]', '$pintu_gudang', '".$x[6]."', '".$x[0]."', '".$ulang[0]."', '".date('Y-m-d H:i:s', $no_faktur)."', '$no_faktur', '".$x[1]."', '".$x[2]."', '".$kasir[1]."') ");
endwhile;
}//akhir  while ulang


$tampil = $conn->query("SELECT * FROM  `tabel_bayar` WHERE  `no_faktur` = '$no_faktur' AND  `jumlah_bayar` -  `jumlah_transaksi` > 0 ");
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

endwhile;
	
//header ("location: index.php?Jnjhg"); 
header ("location: cetak_penjualan.php?cetak_langsung&no_faktur=$no_faktur"); 
//header ("location: tes.php?no_faktur=$no_faktur");
} else {
$dis=$_GET['distributor'];
header ("location: cetak_penjualan.php?dari_transaksi&no_faktur=$no_faktur&distributor=$dis"); 
}
