<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");
include MDL.'login/session.php';
$mpdf = new mPDF('utf-8', array(215.9,139), 8 ,'Times New Roman', 5, 1, 1, 1, '', '');

$supplier=$_GET['supplier'];
$distributor=$_SESSION['distributor'];
$sup=$conn->query(" SELECT nama from tabel_supplier where id = '".$supplier."' ")->fetch_array();
$dis=$conn->query(" SELECT pengguna from mst_hak_akses where kode = '$distributor' ")->fetch_array();
$loop=$conn->query("SELECT * from tabel_pembelian where supplier  = '$supplier' AND metode_bayar=1 AND distributor = '$distributor' ");

$string = '
<table width="100%" border="0">
  <tr>
    <td colspan="3" align="center"><br>'.$dis[0].'<br>LAPORAN BUKU HUTANG</td>
  </tr>
  <tr>
    <td width="20%">No. Supplier</td>
    <td width="1%">:</td>
    <td width="79%">'.$supplier.'</td>
  </tr>
  <tr>
    <td>Nama Supplier</td>
    <td>:</td>
    <td>'.$sup[0].'</td>
  </tr>
</table>
<table width="100%" border="0">
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
  <tr>
    <th scope="col">No. Ivoice</th>
    <th scope="col">Tanggal Transaksi</th>
    <th scope="col">Tanggal Jatuh Tempo</th>
    <th scope="col">Jumlah Transaksi</th>
    <th scope="col">Tgl Bayar</th>
    <th scope="col">Jumlah Bayar</th>
    <th scope="col">Sisa Piutang</th>
  </tr>
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
';
$induk=$conn->query("SELECT * from tabel_pembelian where supplier  = '$supplier' AND metode_bayar=1 AND distributor = '$distributor' ");
while ($x=$induk->fetch_array()) :
$string.= '
  <tr>
    <td align="center">'.$x['no_faktur'].'</td>
    <td align="center">'.tanggal_indo($x['tgl_nota']).'</td>
    <td align="center">'.tanggal_indo($x['jatuh_tempo']).'</td>
    <td align="right">'.angka($x['total']).'</td>
	<td></td>
	<td></td>
    <td align="right">'.angka($x['jumlah_hutang']).'</td>
  </tr>		
';
$data_tunai=$conn->query("SELECT tgl_approve, jumlah_bayar  FROM konfirmasi_tunai where id_bayar='".$x['id_pembelian']."' AND distributor='$distributor' AND no_faktur='".$x['no_faktur']."' ");
$ada_tunai=$data_tunai->num_rows;
if ($ada_tunai==0) {
$string.='
';
} else {
while ($y=$data_tunai->fetch_array()):
$pecah_tunai=explode(' ',$y[0]);
$tgl_tunai=tanggal_indo($pecah_tunai[0]);
$string.='
  <tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
    <td align="center">'.$tgl_tunai.'</td>
    <td align="center">'.angka($y['jumlah_bayar']).'</td>
    <td align="center">TUNAI</td>
  </tr>
';
endwhile;
}

$data_bank=$conn->query("SELECT tgl_approve, jumlah_bayar  FROM konfirmasi_bank where id_bayar='".$x['id_pembelian']."' AND distributor='$distributor' AND no_faktur='".$x['no_faktur']."' ");
$ada_bank=$data_bank->num_rows;
if ($ada_bank==0) {
$string.='
';
} else {
while ($y=$data_bank->fetch_array()):
$pecah_bank=explode(' ',$y[0]);
$tgl_bank=tanggal_indo($pecah_bank[0]);
$string.='
  <tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
    <td align="center">'.$tgl_bank.'</td>
    <td align="center">'.angka($y['jumlah_bayar']).'</td>
    <td align="center">TRANSFER BANK</td>
  </tr>
';
endwhile;
}
$string.='  
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
';
endwhile;
$string.= '  
</table>
';

$total=$conn->query(" SELECT SUM(total), SUM(jumlah_hutang) from tabel_pembelian where supplier = '$supplier' AND metode_bayar=1 ")->fetch_array();

$kode_jumlah_trx=angka($total[0]);
$kode_jumlah_bayar=angka($total[0]-$total[1]);
$kode_sisa_piutang=angka($total[1]);

$string.='
<table width="100%" border="0">
  <tr>
    <td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="38%" align="right">Jumlah Transaksi</td>
    <td width="1%">:</td>
    <td width="26%" align="right">'.$kode_jumlah_trx.'</td>
    <td width="18%" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Jumlah Bayar</td>
    <td>:</td>
    <td align="right">'.$kode_jumlah_bayar.'</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">Sisa Piutang</td>
    <td>:</td>
    <td align="right">'.$kode_sisa_piutang.'</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
';

$mpdf->AddPage();
$mpdf->WriteHTML($string);
$mpdf->Output("Lap_Hutang_".$sup[0].".pdf" ,'I');
