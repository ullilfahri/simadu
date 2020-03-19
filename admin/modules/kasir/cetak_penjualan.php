<?php
//dimana urutan parameternya adalah : mode, format kertas, font size, font, margin left, margin right, margin top, margin bottom, margin header, margin footer, orientasi kertas (bisa diisi dengan p / portrait atau l / landscape).


include("./mpdf54/mpdf.php");

$mpdf = new mPDF('utf-8', array(215.9,139), 10 ,'Courier New', 5, 1, 1, 1, '', '');

include '../../../sysconfig.php';

$barcode=$_SERVER['DOCUMENT_ROOT']."/folder_upload/barcode/".$_GET['no_faktur'].'.jpg';

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
	$update2=$conn->query("update tabel_bayar SET jumlah_bayar='$akhir', metode_bayar='$data_bayar' where id = '".$m['id']."' AND remark != 9");
	$update2=$conn->query(" INSERT INTO `tabel_bayar`(`distributor`, `no_faktur`, `jumlah_transaksi`, jumlah_bayar , `tgl_transaksi`, `customer`, `metode_bayar`, id_toko, kode_bayar) SELECT distributor, no_faktur, jumlah_transaksi, '$surplus'+is_dalam, tgl_transaksi, customer, '0', id_toko, '2' from tabel_bayar bayar where id='".$m['id']."' ");
	}

endwhile;
endif;




$faktur=$conn->query("select * from tabel_faktur where no_faktur='$no_faktur'")->fetch_array();


if ($faktur['jumlah_diskon'] == 0 ) {
	$jumlah_diskon=$faktur['total_trx']-$faktur['total'];
	} else {
	$jumlah_diskon=$faktur['jumlah_diskon'];
	}


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

$kasir=$conn->query("select nama, id, id_gudang from user where id='".$faktur['kasir']."'")->fetch_array();

$nl=1;
$loop=$conn->query("select distributor from tabel_trx where no_faktur='$no_faktur' GROUP BY distributor DESC");
$jml_distributor=$loop->num_rows;


while ($ulang=$loop->fetch_array()) : 

switch ($ulang[0]) {
	case 'TSNB':
	$atas='PT. TRI SUKSES NIAGA BERSAMA';
	$bawah='ALAMAT :';
	$npwp='NPWP :';
	$ppn=1.1;
	break;
	case 'SRYA':
	$atas='CV. SURYA';
	$bawah='Jl. R. SUPRAPTO NO. 9, KETAPANG - KALIMANTAN BARAT';
	$npwp='';
	$ppn=1.1;
	break;
	case 'PCPK':
	$atas='PT. CAHAYA PUTRA KREASI';
	$bawah='ALAMAT : JL. DI. PANJAITAN RT. 13 RW. 003, DELTA PAWAN, KETAPANG';
	$npwp='NPWP : 84.709.206.1-703.000';
	$ppn=1.1;
	break;
	default:
	$atas='';
	$bawah='';
	$npwp='';
	$ppn=1;
	break;
}	

$string = '

<table width="100%" border="0">
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="50%" align="center">INVOICE</td>
    <td width="25%" rowspan="3" align="center" valign="middle"><img src='.$barcode.' width="167" height="15"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">'.$atas.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">'.$bawah.'</td>
  </tr>
</table>

';
$string .= '<hr width="100%" align="center">';

$string .='
<table width="100%" border="0">
  <tr>
    <td width="12%">Jatuh Tempo</td>
    <td width="1%">:</td>
    <td width="54%">'.$tempo_bayar.'</td>
    <td width="8%">Tanggal</td>
    <td width="1%">:</td>
    <td width="24%">'.tanggal_indo(date('Y-m-d', $no_faktur)).'</td>
  </tr>
  <tr>
    <td>Customer</td>
    <td>:</td>
    <td rowspan="2" valign="top">'.$nama_customer.'<br>Alamat, '.$alamat_customer.' '.$kota_customer.', Phone/Fax/Hp. '.$hp_customer.'</td>
    <td>Invoice</td>
    <td>:</td>
    <td>'.$no_faktur.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Kasir</td>
    <td>:</td>
    <td>'.$kasir[0].'</td>
  </tr>
</table>
';

$data=$conn->query("select nama_barang, jumlah, satuan, harga_barang, potongan, sub_total, kode_barang, spc_diskon, keterangan  from tabel_trx where no_faktur='$no_faktur' and distributor='".$ulang[0]."' ");
ob_start();
$tbl = "";
$tbl .='
<table  width="100%">
<tr>
    <td colspan="6" style="border-bottom:#000000  solid thin;"></td>
</tr>
  <tr>
    <th align="left" style="border-bottom:thin">#Nama Barang</th>
    <th scope="col">#Vol</th>
    <th scope="col">#Harga</th>
    <th scope="col">#Potongan</th>
    <th scope="col">#Total</th>
    <th scope="col">#Keterangan</th>
  </tr>
<tr>
    <td colspan="6" style="border-bottom:#000000  solid thin;"></td>
</tr>
';
while ($x=$data->fetch_array()) { //Star ambila data
$sbt_total_pra=$x[5]+$x[7];
$sbt_total=angka( $sbt_total_pra - ($sbt_total_pra*$ppn) );
$tbl .='  
  <tr>
    <td align="left">'.$x[0].'</td>
    <td align="center">'.$x[1].' '.$x[2].'</td>
    <td align="center">'.angka($x[3]).'</td>
    <td align="center">'.angka($x[4]/$x[1]).'</td>
    <td align="center">'.angka($sbt_total_pra).'</td>
    <td align="center">'.$x[8].'</td>
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
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<tr>
        <td colspan="6" style="border-top:#000000 solid thin;"></td>
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
    <td></td>
  </tr>
<tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<tr>
        <td colspan="6" style="border-top:#000000 solid thin;"></td>
    </tr>
</table>  
';
} else  {
$tbl .= '
<tr>
        <td colspan="6" style="border-top:#000000 solid thin;"></td>
    </tr>
</table>  
';
}

echo $tbl;

$string .= ob_get_contents();
ob_end_clean();

$bayar=$conn->query("SELECT * FROM tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]'")->fetch_array();
if ($bayar['metode_bayar']==0) {
$bayar_tunai=$conn->query("select jumlah_transaksi, SUM(jumlah_bayar), kode_bayar from tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]' AND kode_bayar=1")->fetch_array();
$bayar_transfer=$conn->query("select jumlah_transaksi, SUM(jumlah_bayar), kode_bayar from tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]' AND kode_bayar = 2")->fetch_array();
$tunai=$bayar_tunai[1];
$transfer=$bayar_transfer[1];
} else {
$bayar_tunai=$conn->query("select jumlah_transaksi, SUM(jumlah_bayar), kode_bayar from tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]' AND kode_bayar BETWEEN 0 AND 1")->fetch_array();
$bayar_transfer=$conn->query("select jumlah_transaksi, SUM(jumlah_bayar), kode_bayar from tabel_bayar where no_faktur='$no_faktur' and distributor='$ulang[0]' ")->fetch_array();
$transfer=$bayar_transfer[0]-$bayar_transfer[1];
$tunai=$bayar_transfer[1];
}	

$ket_umum=$conn->query(" SELECT SUM(sub_total), SUM(potongan), spc_diskon FROM tabel_trx where distributor='$ulang[0]' and no_faktur='$no_faktur'")->fetch_array();

if ($ulang[0] != 'INDV' ) {
$pajak_bawah='
	  <tr>
    	<td>PPn</td>
    	<td>:</td>
    	<td>Rp.</td>
    	<td align="left">'.angka(($ket_umum[0]/$ppn)*0.1).'</td>
  	</tr>
';
} else {
$pajak_bawah='';
}

$string .='
<table width="100%" border="0">
  <tr>
    <td>Diskon Tambahan</td>
    <td>:</td>
    <td>Rp.</td>
     <td align="left">'.angka($ket_umum[2]).'</td>
  </tr>
  <tr>
    <td width="37%">Sub Total</td>
    <td width="2%">:</td>
    <td width="3%">Rp.</td>
    <td align="left">'.angka($ket_umum[0]/$ppn).'</td>
  </tr>
	'.$pajak_bawah.'
  <tr>
    <td>Total</td>
    <td>:</td>
    <td>Rp.</td>
     <td align="left">'.angka($ket_umum[0]).'</td>
  </tr>
  <tr>
    <td>Jumlah Dibayar</td>
    <td>:</td>
    <td>Rp.</td>
     <td align="left">'.angka($tunai).'</td>
  </tr>
  <tr>
    <td align="left"><div>Jumlah Terhutang</td>
    <td align="center">:</td>
    <td align="center">Rp.</td>
     <td align="left">'.angka($transfer).'</td>
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
    <td align="center"></td>
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
$keterangan=$conn->query("select * from tabel_bayar where no_faktur='$no_faktur' and `distributor`='".$ulang[0]."' AND metode_bayar='0' AND remark between 11 and 12");
$ada_transfer=$keterangan->num_rows;
if ($ada_transfer > 0) :
ob_start();
$pola='
<p align="left" style="font-size:5pt">
Keterangan : <br>
';
while ($rem=$keterangan->fetch_array()) : //ambil data bayar
$bank=$conn->query("SELECT `bank`, `no_rek`, `nama_akun` FROM `rekening_bank` WHERE `stts`=1 and `is_aktif`=1 and `distributor`='".$ulang[0]."' and `id_toko` = '".$kasir[2]."'")->fetch_array();
$rek_bank=$bank[0].' No. Rek '.$bank[1].' A.N '.$bank[2];
if ($rem['kode_bayar']==1) {
	$ket='Pembayaran Tunai Sebesar : Rp. '.angka($rem['jumlah_bayar']);
	} else { 
	$ket='Pembayaran Transfer Ke '.$rek_bank.' Sebesar : Rp. '.angka($rem['jumlah_bayar']);
}
$pola .='
-. '.$ket.'<br>
';
endwhile; // END ambil data bayar
$pola .='
</p>
';
echo $pola;
$string .= ob_get_contents();
ob_end_clean();
endif;


$keterangan2=$conn->query("select * from tabel_bayar where no_faktur='$no_faktur' and `distributor`='".$ulang[0]."' AND kode_bayar = 2 AND metode_bayar='0' AND remark=0");
$ada_transfer2=$keterangan2->num_rows;
if ($ada_transfer2 > 0) :
$rem2=$keterangan2->fetch_array();
$string .='
<p align="left" style="font-size:5pt">
Keterangan : <br>
-. Pembayaran Transfer Ke '.$rek_bank.' Sebesar : Rp. '.angka($rem2['jumlah_transaksi']).'
</p>
';
endif;

$mpdf->AddPage();
$mpdf->WriteHTML($string);
$nl++;
endwhile; //END LOOP Tabel_trx

$mpdf->Output($_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'.pdf');
$file_pdf=$_GET['no_faktur'].'.pdf';

$mpdf_nota = new mPDF('utf-8', array(215.9,139), 10 ,'Courier New', 5, 1, 1, 1, '', '');

$toko=$conn->query("SELECT nama from lokasi where id_lokasi = '".$faktur['id_toko']."' ")->fetch_array();
$nota_sql=$conn->query("SELECT * FROM tabel_trx WHERE no_faktur ='$no_faktur' GROUP BY id_gudang,distributor");
while ($nota=$nota_sql->fetch_array()) :

switch ($nota['distributor']) {
	case 'TSNB':
	$dtr='PT. TRI SUKSES NIAGA BERSAMA';
	break;
	case 'SRYA':
	$dtr='CV. SURYA';
	break;
	case 'PCPK':
	$dtr='PT. CAHAYA PUTRA KREASI';
	break;
	default:
	$dtr='';
	break;
}	


$string_nota ='
<table width="100%" border="0">
  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td align="center">NOTA PENGAMBILAN</td>
  </tr>
  <tr>
    <td align="center">'.$dtr.' - '.$toko[0].'</td>
  </tr>
  <tr>
    <td align="center"> </td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td width="27%">Tanggal Invoice</td>
    <td width="1%">:</td>
    <td width="72%">'.tanggal_indo(date('Y-m-d',$no_faktur)).'</td>
  </tr>
  <tr>
    <td>Nomor Invoice</td>
    <td>:</td>
    <td>'.$no_faktur.'</td>
  </tr>
  <tr>
    <td>Customer</td>
    <td>:</td>
    <td>'.$nama_customer.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$alamat_customer.' '.$kota_customer.', No. Telp/Fax/HP. '.$hp_customer.'</td>
  </tr>
</table>

<table  width="100%">
<tr>
    <td colspan="3" style="border-bottom:#000000  solid thin;"></td>
</tr>

  <tr>
    <th width="38%" align="left" style="border-bottom:thin">#Nama Barang</th>
    <th width="14%" scope="col">#Vol</th>
    <th width="48%" scope="col">#Gudang</th>
  </tr>
<tr>
    <td colspan="3" style="border-bottom:#000000  solid thin;"></td>
</tr>
';
$data_nota=$conn->query("SELECT nama_barang, jumlah, satuan, id_gudang FROM barang_keluar WHERE no_faktur ='$no_faktur' AND id_gudang='".$nota['id_gudang']."' AND distributor='".$nota['distributor']."'");
ob_start();
$tbl_nota = "";
while ($y=$data_nota->fetch_array()) :
$gudang=$conn->query("SELECT nama FROM lokasi where id_lokasi = '".$y[3]."' ")->fetch_array();
$tbl_nota .='
  <tr>
    <td align="left">'.$y[0].'</td>
    <td align="center">'.$y[1].' '.$y[2].'</td>
    <td align="center">'.$gudang[0].'</td>
  </tr>
';
endwhile;
echo $tbl_nota;
$string_nota .= ob_get_contents();
ob_end_clean();

$string_nota .='
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<tr>
    <td colspan="3" style="border-bottom:#000000  solid thin;"></td>
</tr>
</table>

<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">Ketapang, '.tanggal_indo(date('Y-m-d', $no_faktur)).'</td>
  </tr>
  <tr>
    <td align="center">Penerima,</td>
    <td align="center"></td>
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

$mpdf_nota->AddPage();
$mpdf_nota->WriteHTML($string_nota);

endwhile;

$mpdf_nota->Output($_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/bukti_ambil/nota_ambil-".$_GET['no_faktur'].'.pdf');
$file_ambil='nota_ambil-'.$_GET['no_faktur'].'.pdf';


header ("location: ../pdf_viewer/index.php?penjualan&dir=no_faktur&file=$file_pdf&file_ambil=$file_ambil"); 

?>


