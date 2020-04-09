<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");
include('../kasir/barcode/src/BarcodeGenerator.php');
include('../kasir/barcode/src/BarcodeGeneratorJPG.php');
$generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
file_put_contents($_SERVER['DOCUMENT_ROOT']."/folder_upload/barcode/".$_GET['id_trx'].'.jpg', $generatorJPG->getBarcode($_GET['id_trx'], $generatorJPG::TYPE_CODE_128));
$barcode=$_SERVER['DOCUMENT_ROOT']."/folder_upload/barcode/".$_GET['id_trx'].'.jpg';
$mpdf = new mPDF('utf-8', array(215.9,139), 11 ,'Times New Roman', 5, 1, 1, 1, '', '');

$id_trx=$_GET['id_trx'];

$sql=$conn->query(" SELECT * FROM tabel_retur where id_trx = '$id_trx' GROUP BY gudang_tujuan");
while ($x=$sql->fetch_array()) :
$asal=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['id_gudang']."' ")->fetch_array();
$tujuan=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['gudang_tujuan']."' ")->fetch_array();
$pecah=explode(' ',$x['tanggal']);
$tgl=tanggal_indo($pecah[0]);
$admin=$conn->query(" SELECT nama from user where id = '".$x['user_approve']."' ")->fetch_array();

if ($x['distributor']=='TSNB') {
	$head = "PT. TRI SUKSES NIAGA BERSAMA";
	} else if ($x['distributor']=='SRYA'){
	$head = "CV. SURYA";
	} else if ($x['distributor']=='PCPK'){
	$head = "PT. CAHAYA PUTRA KREASI";
	} else {
	$head='';
	}
	
	
$string = '
<table width="100%" border="0">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="40%">&nbsp;</td>
    <td width="30%" rowspan="3" align="center" valign="middle"><img src='.$barcode.' width="190" height="40"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">SURAT JALAN TRANSFER BARANG</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">'.$head.'</td>
  </tr>
</table>
';	

$string.= '
<table width="100%" border="0">
  <tr>
    <td width="17%">Asal Barang</td>
    <td width="1%">:</td>
    <td width="37%">'.$asal[0].'</td>
    <td width="16%">No. Surat</td>
    <td width="1%">:</td>
    <td width="28%">'.$x['id_trx'].'</td>
  </tr>
  <tr>
    <td>Tujuan Barang</td>
    <td>:</td>
    <td>'.$tujuan[0].'</td>
    <td>Tanggal Surat</td>
    <td>:</td>
    <td>'.$tgl.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Admin</td>
    <td>:</td>
    <td>'.$admin[0].'</td>
  </tr>
</table>
';


$string .='
<table  width="100%">
<tr>
    <td colspan="4" style="border-bottom:#000000  solid thin;"></td>
</tr>
  <tr>
    <th align="left" style="border-bottom:thin">#NO</th>
    <th scope="col">#KODE</th>
    <th scope="col">#NAMA BARANG</th>
    <th scope="col">#QTY</th>
  </tr>
<tr>
    <td colspan="4" style="border-bottom:#000000  solid thin;"></td>
</tr>
';
ob_start();
$tbl = "";
$data_barang=$conn->query("select kode_barang, nama_barang, jumlah_barang, satuan FROM tabel_retur where id_trx='".$x['id_trx']."' and gudang_tujuan='".$x['gudang_tujuan']."' ");
$no=1;
while ($y=$data_barang->fetch_array()) { //Star ambila data
$tbl .='  
  <tr>
    <td align="center">'.$no.'</td>
	<td align="left">'.$y[0].'</td>
    <td align="center">'.$y[1].'</td>
    <td align="center">'.angka($y[2]).' '.$y[3].'</td>
  </tr>
';
$no++;
} // END ambil data bayar
echo $tbl;

$string .= ob_get_contents();
ob_end_clean();



$string .='  
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
        <td colspan="4" style="border-top:#000000 solid thin;"></td>
    </tr>
  
</table>  
';


$string.= "<p align='left'>Catatan : <br><br></p>";	
$string.='
<table width="100%" border="0" align="center">
  <tr>
    <td align="center">Dibuat Oleh,</td>
    <td align="center">Menyetujui,</td>
    <td align="center">Dikeluarkan,</td>
    <td align="center">Diperiksa,</td>
    <td align="center">Pengirim,</td>
    <td align="center">Penerima,</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">(__________)</td>
    <td align="center">(__________)</td>
    <td align="center">(__________)</td>
    <td align="center">(__________)</td>
    <td align="center">(__________)</td>
    <td align="center">(__________)</td>
  </tr>
  <tr>
    <td align="center">Adm</td>
    <td align="center">GM/AM</td>
    <td align="center">Ka. Gudang</td>
    <td align="center">Ka. Opr</td>
    <td align="center">Sopir</td>
    <td align="center">Customer</td>
  </tr>
</table>
';


$mpdf->AddPage();
$mpdf->WriteHTML($string);

endwhile;

$mpdf->Output($_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/bukti_ambil/".$id_trx.'.pdf');
$file_pdf=$id_trx.'.pdf';
 
echo "<script>window.location='../pdf_viewer/index.php?transfer_barang&dir=bukti_ambil&file=$file_pdf'</script>";

 
?>