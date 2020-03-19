<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");

$mpdf = new mPDF('utf-8', array(215.9,139), 11 ,'Times New Roman', 5, 1, 1, 1, '', '');

$id_trx=$_POST['id_trx'];

$kode = $_POST['kode'];

$data_retur=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx' AND kode='$kode'")->fetch_array();

    if (!empty($_POST['biaya_administrasi'])) {
		$tabel_biaya_administrasi=$_POST['tabel_biaya_administrasi'];
		$jumlah_bayar_administrasi=preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_biaya_administrasi']);
		if ($tabel_biaya_administrasi=='konfirmasi_tunai') {
			$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT `user_approve`, `tanggal`, `id_trx`, `no_faktur`, '$jumlah_bayar_administrasi', 'Biaya Administrasi Retur Barang', `distributor`, `id_toko`, '1' FROM tabel_retur where id='".$data_retur['id']."' ");
			} else {
			$pecah=explode('#',$_POST['tabel_biaya_administrasi']);
			$tabel=$pecah[0];
			$id_bank=$pecah[1];
			$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`, id_bank) SELECT `user_approve`, `tanggal`, `id_trx`, `no_faktur`, '$jumlah_bayar_administrasi', 'Biaya Administrasi Retur Barang', `distributor`, `id_toko`, '1', '$id_bank' FROM tabel_retur where id='".$data_retur['id']."' ");
			}
	} else {
	$jumlah_bayar_administrasi=0;
	}

	
	if (!empty($_POST['biaya_kembali'])) {
		$tabel_biaya_kembali=$_POST['tabel_biaya_kembali'];
		$jumlah_bayar_retur=preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_biaya_kembali']);
		$jumlah_bayar_retur='-'.$jumlah_bayar_retur;
		$jumlah_bayar_retur_cetak=$jumlah_bayar_retur;
		if ($tabel_biaya_kembali=='konfirmasi_tunai') {
			$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`) SELECT `user_approve`, `tanggal`, `id_trx`, `no_faktur`, '$jumlah_bayar_retur', 'Biaya Pengembalian Atas Retur Barang', `distributor`, `id_toko`, '1' FROM tabel_retur where id='".$data_retur['id']."' ");
			} else {
			$pecah=explode('#',$_POST['tabel_biaya_kembali']);
			$tabel=$pecah[0];
			$id_bank=$pecah[1];
			$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `id_toko`, `jenis`, id_bank) SELECT `user_approve`, `tanggal`, `id_trx`, `no_faktur`, '$jumlah_bayar_retur', 'Biaya Pengembalian Atas Retur Barang', `distributor`, `id_toko`, '1', '$id_bank' FROM tabel_retur where id='".$data_retur['id']."' ");
			
			}
	} else {
	$jumlah_bayar_retur=0;
	}



$cst=$conn->query("SELECT customer, cus_umum from tabel_faktur where no_faktur = '".$data_retur['no_faktur']."' ")->fetch_array();
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
		
$kasir=$conn->query("SELECT nama from user where id = '".$data_retur['user_approve']."'")->fetch_array();

if ($data_retur['distributor']=='TSNB') {
	$head = "PT. TRI SUKSES NIAGA BERSAMA";
	} else if ($data_retur['distributor']=='SRYA'){
	$head = "CV. SURYA";
	} else {
	$head='';
	}
	
	
$string = "<br><p align='center'>RETUR BARANG<br>".$head."</p>";	

$string.= '
<table width="100%" border="0">
  <tr>
    <td width="14%">No. Faktur</td>
    <td width="1%">:</td>
    <td width="32%">'.$data_retur['no_faktur'].'</td>
    <td width="21%">Customer</td>
    <td width="0%">:</td>
    <td width="32%">'.$nama_pelanggan.'</td>
  </tr>
  <tr>
    <td>Tanggal Faktur</td>
    <td>:</td>
    <td>'.tanggal_indo(date('Y-m-d',$data_retur['no_faktur'])).'</td>
    <td>No, Hp./Telp/Fax</td>
    <td>:</td>
    <td>'.$hp_pelanggan.'</td>
  </tr>
  <tr>
    <td>No. Bukti Retur</td>
    <td>:</td>
    <td>'.$data_retur["id_trx"].'</td>
    <td>Alamat</td>
    <td>:</td>
    <td rowspan="3" valign="top">'.$alamat_pelanggan.', '.$kota_pelanggan.'</td>
  </tr>
  <tr>
    <td>Tanggal Retur</td>
    <td>:</td>
    <td>'.tanggal_indo(date("Y-m-d",$id_trx)).'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Admin</td>
    <td>:</td>
    <td>'.$kasir[0].'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
';

ob_start();
$tbl = "";
$data=$conn->query(" SELECT * FROM tabel_retur where id_trx = '$id_trx' ");

$tbl .='
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
$no=1;
while ($x=$data->fetch_array()) :
$tbl .='  
  <tr>
    <td align="center">'.$no++.'</td>
	<td align="left">'.$x['kode_barang'].'</td>
    <td align="center">'.$x['nama_barang'].'</td>
    <td align="center">'.angka($x['jumlah_barang']).' '.$x['satuan'].'</td>
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

$string.= "<p align='left'>Catatan : <br>Biaya Administrasi ".rupiah($jumlah_bayar_administrasi)."<br>Biaya Pengembalian ".rupiah($jumlah_bayar_retur_cetak)."</p>";	
$string.='
<table width="100%" border="0">
  <tr>
    <td align="center">Customer,</td>
    <td  align="center">Admin Toko,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  align="center">'.$nama_pelanggan.'</td>
    <td  align="center">'.$kasir[0].'</td>
  </tr>
</table>
';


$mpdf->AddPage();
$mpdf->WriteHTML($string);
$mpdf->Output($_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/bukti_ambil/".$id_trx.'.pdf');
$file_pdf=$id_trx.'.pdf';
 
echo "<script>window.location='../pdf_viewer/index.php?retur_barang&dir=bukti_ambil&file=$file_pdf'</script>";

 
?>