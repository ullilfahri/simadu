<?php
include("./mpdf54/mpdf.php");

$mpdf = new mPDF('utf-8', array(215.9,139), 10 ,'Courier New', 5, 1, 1, 1, '', '');

include '../../../sysconfig.php';

$barcode=$_SERVER['DOCUMENT_ROOT']."/folder_upload/barcode/".$_GET['no_faktur'].'.jpg';
$nama_dir = 'C://print_siako';


$no_faktur=$_GET['no_faktur'];

$tengah='                                                                               ';
$setengah='                                       ';
$invoice='INVOICE';
if (isset($_GET['cetak_langsung'])) :
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
endif;

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

$kasir=$conn->query("select nama, id, id_toko from user where id='".$faktur['kasir']."'")->fetch_array();

$nl=1;
$loop=$conn->query("select distributor from tabel_trx where no_faktur='$no_faktur' ORDER BY distributor DESC");
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

$string  = "<p align='center'>INVOICE<br>".$atas."<br>".$bawah."</p>";
/*$string  .= "".substr($tengah, 0, 40-round(strlen($atas)/2)).$atas."
";
$string .= "".substr($tengah, 0, 40-round(strlen($bawah)/2)).$bawah."
";*/
$string .= '<hr width="100%" align="center">';

$string .='
<table width="100%" border="0">
  <tr>
    <td width="13%">Kasir</td>
    <td width="3%">:</td>
    <td width="84%">'.$kasir[0].'</td>
  </tr>
  <tr>
    <td>Invoice</td>
    <td>:</td>
    <td>'.$no_faktur.'</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>:</td>
    <td>'.tanggal_indo(date('Y-m-d', $no_faktur)).'</td>
  </tr>
  <tr>
    <td>Jatuh Tempo</td>
    <td>:</td>
    <td>'.$tempo_bayar.'</td>
  </tr>
  <tr>
    <td>Customer</td>
    <td>:</td>
    <td>'.$nama_customer.' Alamat, '.$alamat_customer.' '.$kota_customer.', Phone/Fax/Hp. '.$hp_customer.'</td>
  </tr>
</table>
';

$data=$conn->query("select nama_barang, jumlah, satuan, harga_barang, potongan, sub_total, kode_barang  from tabel_trx where no_faktur='$no_faktur' and distributor='".$ulang[0]."'");
ob_start();
$tbl = "";
$tbl .='
<table  width="100%">
<tr>
    <td colspan="5" style="border-bottom:#000000  solid thin;"></td>
</tr>
  <tr>
    <th align="left" style="border-bottom:thin">#Nama Barang</th>
    <th scope="col">#Vol</th>
    <th scope="col">#Harga</th>
    <th scope="col">#Potongan</th>
    <th scope="col">#Sub Total</th>
  </tr>
<tr>
    <td colspan="5" style="border-bottom:#000000  solid thin;"></td>
</tr>
';
while ($x=$data->fetch_array()) { //Star ambila data

$tbl .='  
  <tr>
    <td align="left">'.$x[0].'</td>
    <td align="center">'.$x[1].' '.$x[2].'</td>
    <td align="center">'.angka($x[3]).'</td>
    <td align="center">'.angka($x[4]).'</td>
    <td align="center">'.angka($x[5]).'</td>
  </tr>
';
} //End ambila data


$jml_data=$data->num_rows;

if ($jml_data==1) {
$tbl .='  
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<tr>
        <td colspan="5" style="border-top:#000000 solid thin;"></td>
    </tr>
  
</table>  
';

} else if ($jml_data==2) {
$tbl .= '
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<tr>
        <td colspan="5" style="border-top:#000000 solid thin;"></td>
    </tr>
</table>  
';
} else  {
$tbl .= '
<tr>
        <td colspan="5" style="border-top:#000000 solid thin;"></td>
    </tr>
</table>  
';
}

echo $tbl;

$string .= ob_get_contents();
ob_end_clean();
$kalimat = "                                                       ";

$bayar=$conn->query("select SUM(jumlah_transaksi), SUM(jumlah_bayar), kode_bayar from tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]' GROUP BY distributor")->fetch_array();

$string .='
<table width="100%" border="0">
  <tr>
    <td width="37%">Sub Total</td>
    <td width="2%">:</td>
    <td width="3%">Rp.</td>
    <td align="left">'.angka($bayar[0]).'</td>
  </tr>
  <tr>
    <td>Diskon Tambahan</td>
    <td>:</td>
    <td>Rp.</td>
     <td align="left">'.angka($ulang[3]).'</td>
  </tr>
  <tr>
    <td>Total</td>
    <td>:</td>
    <td>Rp.</td>
     <td align="left">'.angka($bayar[0]-$ulang[3]).'</td>
  </tr>
  <tr>
    <td>Jumlah Dibayar</td>
    <td>:</td>
    <td>Rp.</td>
     <td align="left">'.angka($bayar[1]).'</td>
  </tr>
  <tr>
    <td align="left"><div>Jumlah Terhutang</td>
    <td align="center">:</td>
    <td align="center">Rp.</td>
    <td align="left">'.angka($bayar[0]-$bayar[1]).'</td>
  </tr>
</table>
';
$string .='
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">Ketapang, '.tanggal_indo(date('Y-m-d', $no_faktur)).'</td>
  </tr>
  <tr>
    <td align="center">Penerima,</td>
    <td align="center"><img src='.$barcode.' height="15"/></td>
    <td align="center">Kasir,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">(...............................)</td>
    <td>&nbsp;</td>
    <td align="center">(...............................)</td>
  </tr>
</table>

';
$string  .= "Keterangan :
";
$keterangan=$conn->query("select * from tabel_bayar where no_faktur='$no_faktur' AND distributor='".$ulang[0]."'");
while ($rem=$keterangan->fetch_array()){ //ambil data bayar
$bank=$conn->query("SELECT `bank`, `no_rek`, `nama_akun` FROM `rekening_bank` WHERE `stts`=1 and `is_aktif`=1 and `distributor`='".$ulang[0]."' and `id_toko` = '".$kasir[2]."'")->fetch_array();
$rek_bank=$bank[0].' No. Rek '.$bank[1].' A.N '.$bank[2];
ob_start();
switch ($rem['kode_bayar']) {
	case '1':
	$pola='Pembayaran Tunai Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	break;
	case '2':
	$pola='Pembayaran Transfer Ke '.$rek_bank.' Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	break;
	case '3':
	$pola='Pembayaran Transfer Ke '.$$rek_bank.' Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	break;
	default:
	$pola='';
	break;
}	
echo $pola;
} // END ambil data bayar
$string .= ob_get_contents();
ob_end_clean();
$mpdf->AddPage();
$mpdf->WriteHTML($string);
$nl++;
endwhile; //END LOOP Tabel_trx

$mpdf->Output($_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/tes_cetak/".$_GET['no_faktur'].'-'.$ulang[0].'.pdf');
//$file_pdf=$_GET['no_faktur'].'-'.$ulang[0].'.pdf';


//header ("location: ../pdf_viewer/index.php?dir=no_faktur&file=$file_pdf&no_faktur=$no_faktur&jumlah_file=$nl"); 

?>


