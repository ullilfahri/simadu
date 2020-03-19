<?php


$nama_dir = 'C://print_siako';

if(!is_dir($nama_dir)):
    mkdir($nama_dir, 0755);
	$file = 'http://'.$_SERVER['HTTP_HOST'].'/SIAKO\admin\modules\kasir\print\DOSPrinter.exe';
	$newfile = $nama_dir.'/DOSPrinter.exe';
	copy($file, $newfile);
	$file2 = 'http://'.$_SERVER['HTTP_HOST'].'/SIAKO\admin\modules\kasir\print\Language.ini';
	$newfile2 = $nama_dir.'/Language.ini';
	copy($file2, $newfile2);

endif;

include '../../../sysconfig.php';
$no_faktur=$_GET['no_faktur'];

$tengah='                                                                               ';
$setengah='                                       ';
$invoice='INVOICE';

/*if (isset($_GET['cetak_langsung'])) :
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
endif;*/

$faktur=$conn->query("select * from tabel_faktur where no_faktur='$no_faktur'")->fetch_array();
$jumlah_diskon=$faktur['total_trx']-$faktur['total'];
if ($faktur['jatuh_tempo'] != '0000-00-00') {
$tempo_bayar=tanggal_indo($faktur['jatuh_tempo']);
} else {
$tempo_bayar='Tunai';
}

if ($faktur['customer'] > 0) {
$customer=$conn->query("select * from tabel_customer where id='".$faktur['customer']."'")->fetch_array();
$nama_customer=$customer['nama'];
$alamat_customer=$customer['alamat'];
$kota_customer=$customer['kota'];
$hp_customer=$customer['no_hp'];
} else if ($faktur['customer'] == 0 && $faktur['cus_umum'] !='' ) {
$arr = json_decode($faktur['cus_umum'], true);
$nama_customer=$arr["umum"]["nama"];
$alamat_customer=$arr["umum"]["alamat"];
$kota_customer=$arr["umum"]["kota"];
$hp_customer=$arr["umum"]["hp"];
} else {
$nama_customer='';
$alamat_customer='';
$kota_customer='';
$hp_customer='';
}

$kasir=$conn->query("select nama, id from user where id='".$faktur['kasir']."'")->fetch_array();

$nl=1;
if (isset($_GET['cetak_langsung'])) {
$loop=$conn->query("select distributor, SUM(jumlah), SUM(sub_total), SUM(potongan), kode_barang, satuan from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor");
} else {
$loop=$conn->query("select distributor, SUM(jumlah), SUM(sub_total), SUM(potongan), kode_barang, satuan from tabel_trx where no_faktur='$no_faktur' and distributor = '".$_GET['distributor']."'");
} 
while ($ulang=$loop->fetch_array()) : 

switch ($ulang[0]) {
	case 'TSNB':
	$atas='PT. TRI SUKSES NIAGA BERSAMA';
	$bawah='ALAMAT :';
	$npwp='NPWP :';
	break;
	case 'SRYA':
	$atas='CV. SURYA';
	$bawah='ALAMAT :';
	$npwp='NPWP :';
	break;
	default:
	$atas='';
	$bawah='';
	$npwp='';
	break;
}	


$namafile = $nama_dir."/cetak".$nl.".prn"; 
@unlink($nama_dir."/cetak".$nl.".prn");
$handle = fopen ($namafile, "w"); 

$string  = "".substr($tengah, 0, 40-round(strlen($invoice)/2)).$invoice."
";
$string  .= "".substr($tengah, 0, 40-round(strlen($atas)/2)).$atas."
";
$string .= "".substr($tengah, 0, 40-round(strlen($bawah)/2)).$bawah."
";
$string .= "-------------------------------------------------------------------------------
";
$string .= "Kasir       : ".$kasir[0]."  
";
$string .= "Invoice     : ".$no_faktur." 
";
$string .= "Tanggal     : ".tanggal_indo(date('Y-m-d', $no_faktur))."
";
$string .= "Jatuh Tempo : ".$tempo_bayar."
";
$string .= "Customer    : ".$nama_customer." Alamat, ".$alamat_customer." ".$kota_customer.", Phone/Fax/Hp. ".$hp_customer."
";
ob_start();
$tbl = "";
//$total = '0';

$tbl .= "-------------------------------------------------------------------------------
";
$tbl .= "#Nama Barang                #Vol           #Harga       #Potongan    #Sub Total
";
$tbl .= "-------------------------------------------------------------------------------
";

$data=$conn->query("select nama_barang, SUM(jumlah), satuan, harga_barang, potongan, SUM(sub_total), kode_barang  from tabel_trx where no_faktur='$no_faktur' and distributor='".$ulang[0]."' AND kode_barang='".$ulang[4]."'");
$baris1='                            ';
$baris2='            ';
$baris3='          ';
$baris4='             ';
$baris5='               ';

while ($x=$data->fetch_array()) :


$kata1=$x[0];
$kata2=$x[1].' '.$x[2];
$kata3=angka($x[3]);
$kata4=angka($x[4]);
$kata5=angka($x[5]);


$jml_1=strlen($kata1);
$jml_2=strlen($kata2);
$jml_3=strlen($kata3);
$jml_4=strlen($kata4);
$jml_5=strlen($kata5);


$potong1 = $kata1.substr($baris1, $jml_1);
$potong2 = $kata2.substr($baris2, $jml_2);
$potong3 = substr($baris3, $jml_3).$kata3;
$potong4 = substr($baris4, $jml_4).$kata4;
$potong5 = substr($baris5, $jml_5).$kata5;

$tbl .= " ".$potong1.$potong2.$potong3.$potong4.$potong5."
";

endwhile;

$jml_data=$data->num_rows;

if ($jml_data==1) {
$tbl .= "
";
$tbl .= "
";
$tbl .= "
";
$tbl .= "
";
} else if ($jml_data==2) {
$tbl .= "
";
$tbl .= "
";
$tbl .= "
";
} else if ($jml_data==3) {
$tbl .= "
";
$tbl .= "
";
} else  {
$tbl .= "
";
}
echo $tbl;

$string .= ob_get_contents();
ob_end_clean();
$kalimat = "                                                       ";

$bayar=$conn->query("select SUM(jumlah_transaksi), SUM(jumlah_bayar), kode_bayar from tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]' GROUP BY distributor")->fetch_array();

$string .= "-------------------------------------------------------------------------------
";
$string .= "Sub Total        : Rp.  ".substr($kalimat,strlen(angka($bayar[0]))).angka($bayar[0])."    
";
$string .= "Diskon Tambahan  : Rp.  ".substr($kalimat,strlen(angka($ulang[3]))).angka($ulang[3])."    
";
$string .= "Total            : Rp.  ".substr($kalimat,strlen(angka($bayar[0]-$ulang[3]))).angka($bayar[0]-$ulang[3])."
";
$string .= "Jumlah Dibayar   : Rp.  ".substr($kalimat,strlen(angka($bayar[1]))).angka($bayar[1])."
";
$string .= "Jumlah Terhutang : Rp.  ".substr($kalimat,strlen(angka($bayar[0]-$bayar[1]))).angka($bayar[0]-$bayar[1])."    
";

$hormat='Ketapang, '.tanggal_indo(date('Y-m-d', $no_faktur));
$string .= substr($tengah,strlen($hormat)).$hormat."    
";
$string  .= "        Penerima,                                    Kasir,
";
$string  .= "

";

$string  .= "      (..........)                                  ".$kasir[0]."
";

$string  .= "Keterangan :
";
$keterangan=$conn->query("select * from tabel_bayar where no_faktur='$no_faktur' AND distributor='".$ulang[0]."'");
while ($rem=$keterangan->fetch_array()):
ob_start();
switch ($rem['kode_bayar']) {
	case '1':
	$pola='Pembayaran Tunai Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	break;
	case '2':
	$pola='Pembayaran Transfer Ke Rekening 1 Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	break;
	case '3':
	$pola='Pembayaran Transfer Ke Rekening 2 Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	break;
	default:
	$pola='';
	break;
}	
echo $pola;
endwhile;
$string .= ob_get_contents();
ob_end_clean();



fwrite ($handle, $string); 
fclose($handle); 

	@unlink($nama_dir."/cetak".$nl.".bat");
	$run = fopen($nama_dir."/cetak".$nl.".bat", "w");
	$oke = 'CD '.$nama_dir.'
	';
	$oke .= 'start DOSPrinter.exe /LINES /F\'Lucida Console\' /LEFT0.5 "cetak'.$nl.'.prn"
	';
	$path=$nama_dir.'/DOSPrinter.exe';
	$dir=$nama_dir.'/';
	fwrite($run, $oke);
	fclose($run);
	
	
	shell_exec($dir.'cetak'.$nl.'.bat');   

$nl++;
endwhile; //END LOOP Tabel_trx

if (isset($_GET['dari_transaksi'])) {
 
echo "<script>window.alert('Transaksi Dicetak') 
		window.close()</script>"; 
 
} else { 

echo "<script>window.alert('Transaksi Dicetak') 
		window.location='http://127.0.0.1:9999/siako/admin/modules/kasir/index.php?Jnjhg'</script>";
		
}		
?>


