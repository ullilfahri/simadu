<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");

$mpdf = new mPDF('utf-8', array(215.9,139), 10 ,'Courier New', 5, 1, 1, 1, '', '');

$id_pengambilan=$_GET['id_pengambilan'];

if (isset($_GET['cetak_langsung'])) :
$data_keluar=$conn->query("select * from barang_keluar where id IN (select id_barang_keluar from ambil_barang where id_pengambilan='$id_pengambilan')")->fetch_array();
/* $update=$conn->query("UPDATE ambil_barang set is_final=1 where id_pengambilan='$id_pengambilan' ");
$partial=$conn->query("select SUM(jumlah), SUM(is_ambil) from barang_keluar where no_faktur='".$data_keluar['no_faktur']."' AND distributor='".$data_keluar['distributor']."'")->fetch_array();	
	$sisa=$partial[0]-$partial[1];
		if ($sisa > 0) {
		$ada=$conn->query("SELECT * FROM `ambil_barang` WHERE `id_barang_keluar` IN (SELECT id FROM barang_keluar WHERE no_faktur='".$data_keluar['no_faktur']."' AND distributor='".$data_keluar['distributor']."') GROUP BY id_pengambilan")->num_rows;
		$update_partial=$conn->query(" UPDATE ambil_barang SET partial = '$ada' where id_pengambilan='$id_pengambilan' AND distributor='".$data_keluar['distributor']."'");
		$pis='-';
		} else {
		$pis='';
		}
*/
$barcode=$_SERVER['DOCUMENT_ROOT']."/folder_upload/barcode/".$data_keluar['no_faktur'].'.jpg';

$cst=$conn->query("SELECT customer, cus_umum, id_toko FROM tabel_faktur where no_faktur = '".$data_keluar['no_faktur']."' ")->fetch_array();
	if ($cst[0] > 0) {
	$tetap=$conn->query("SELECT * FROM tabel_customer where id = '$cst[0]' ")->fetch_array();
	$nama_pelanggan=$tetap['nama'];
	$alamat_pelanggan=$tetap['alamat'];
	$kota_pelanggan=$tetap['kota'];
	$hp_pelanggan=$tetap['no_hp'];
	} else {
	$arr = json_decode($cst[1], true);
	$nama_pelanggan=$arr["umum"]["nama"];
	$alamat_pelanggan=$arr["umum"]["alamat"];
	$kota_pelanggan=$arr["umum"]["kota"];
	$hp_pelanggan=$arr["umum"]["hp"];
}
$outlet_sql=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$cst[2]."'")->fetch_array();
$outlet=$outlet_sql[0];		

$loop=$conn->query("select distributor, id_barang_keluar, jumlah_ambil, remark, id_user, jumlah_ambil, partial, id_gudang, pintu_gudang from ambil_barang where id_pengambilan='$id_pengambilan' GROUP BY distributor  DESC");
$nnn=1;
while ($ulang=$loop->fetch_array()) :

$update=$conn->query("UPDATE barang_keluar set remark='".$ulang[3]."' where id='".$ulang[1]."' ");

$gudang=$conn->query("select b.nama, a.pintu_gudang from barang_keluar as a left join lokasi as b ON a.id_gudang = b.id_lokasi where a.id='".$ulang[1]."' ")->fetch_array();
$staf=$conn->query("select nama from user where id='".$ulang[4]."'")->fetch_array();
$asal=$conn->query("select nama from lokasi where id_lokasi='".$ulang[7]."'")->fetch_array();
$asal_barang=$asal[0];

if ($ulang[0]=='TSNB') {
	$head = "PT. TRI SUKSES NIAGA BERSAMA";
	} else if ($ulang[0]=='SRYA'){
	$head = "CV. SURYA";
	} else if ($ulang[0]=='PCPK'){
	$head = "PT. CAHAYA PUTRA KREASI";
	} else {
	$head='';
	}
	
	
$string = '
<table width="100%" border="0">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="40%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td align="center">SURAT JALAN<br>      
      Nomor : '.$data_keluar["no_faktur"].$pis.surat_jalan($ulang[6]).'</td>
    <td rowspan="2" align="left" valign="middle"><img src='.$barcode.' width="180" height="20"></td>
  </tr>
  <tr>
    <td align="center">'.$head.'</td>
  </tr>
</table>
';	

$string.= '
<table width="100%" border="0">
  <tr>
    <td width="20%">Kepada Yth.</td>
    <td width="1%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
    <td width="20%">Tanggal</td>
    <td width="1%">:</td>
    <td width="29%">'.tanggal_indo(date("Y-m-d",$id_pengambilan)).'</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td>'.$nama_pelanggan.'</td>
    <td>Asal Barang</td>
    <td>:</td>
    <td>'.$asal_barang.'</td>
  </tr>
  <tr>
    <td>No. Hp/Telp/Fax</td>
    <td>:</td>
    <td>'.$hp_pelanggan.'</td>
    <td>Outlet Penjualan</td>
    <td>:</td>
    <td>'.$outlet.'</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:</td>
    <td colspan="4" rowspan="2" valign="top">'.$alamat_pelanggan.', '.$kota_pelanggan.'</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
';

ob_start();
$tbl = "";
$data=$conn->query(" SELECT b.kode_barang, b.nama_barang, b.satuan, SUM(a.jumlah_ambil), a.pintu_gudang FROM ambil_barang AS a LEFT JOIN barang_keluar AS b ON a.id_barang_keluar = b.id WHERE  a.distributor = '".$ulang[0]."' AND a.id_pengambilan = '$id_pengambilan' AND b.no_faktur='".$data_keluar['no_faktur']."' GROUP BY a.pintu_gudang, a.id_barang_keluar");

$tbl .='
<table  width="100%">
<tr>
    <td colspan="4" style="border-bottom:#000000  solid thin;"></td>
</tr>
  <tr>
    <th align="left" style="border-bottom:thin" width="10%">#NO</th>
    <th scope="col" width="15%">#KODE</th>
    <th scope="col" width="50%">#NAMA BARANG</th>
    <th scope="col" width="25%">#QTY</th>
  </tr>
<tr>
    <td colspan="4" style="border-bottom:#000000  solid thin;"></td>
</tr>
';
$no=1;
while ($x=$data->fetch_array()) :
$tbl .='  
  <tr>
    <td align="center">'.$no++.'</td>
	<td align="left">'.$x[0].'</td>
    <td align="center">'.$x[1].'</td>
    <td align="center">'.angka($x[3]).' '.$x[2].' ['.$x[4].']</td>
  </tr>
';

endwhile;


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
        <td colspan="4" style="border-top:#000000 solid thin;"></td>
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
        <td colspan="4" style="border-top:#000000 solid thin;"></td>
    </tr>
</table>  
';
} else  {
$tbl .= '
<tr>
        <td colspan="4" style="border-top:#000000 solid thin;"></td>
    </tr>
</table>  
';
}

echo $tbl;

$string .= ob_get_contents();
ob_end_clean();

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
$file_pdf=$id_pengambilan.'.pdf';
 
$nnn++;
endwhile;	
$mpdf->Output($_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$id_pengambilan.'.pdf');	
echo "<script>window.location='../pdf_viewer/index.php?pengambilan&dir=surat_jalan&file=$file_pdf'</script>";

endif;
 
?>