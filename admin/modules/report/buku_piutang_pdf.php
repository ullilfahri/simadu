<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");

$mpdf = new mPDF('utf-8', array(215.9,139), 8 ,'Times New Roman', 5, 1, 1, 1, '', '');

$customer=$_POST['customer'];
$distributor=$_POST['distributor'];
$cust=$conn->query(" SELECT nama from tabel_customer where id = '".$customer."' ")->fetch_array();
$dis=$conn->query(" SELECT pengguna from mst_hak_akses where kode = '$distributor' ")->fetch_array();

$string = '
<table width="100%" border="0">
  <tr>
    <td colspan="3" align="center"><br>'.$dis[0].'<br>LAPORAN BUKU PIUTANG</td>
  </tr>
  <tr>
    <td width="20%">No. Pelanggan</td>
    <td width="1%">:</td>
    <td width="79%">'.$customer.'</td>
  </tr>
  <tr>
    <td>Nama Pelanggan</td>
    <td>:</td>
    <td>'.$cust[0].'</td>
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

$induk=$conn->query(" SELECT * FROM tabel_bayar WHERE customer = '$customer' AND distributor = '$distributor' AND metode_bayar = 1 ");
while ($x=$induk->fetch_array()) :
$jt=$conn->query(" SELECT jatuh_tempo FROM tabel_faktur where no_faktur = '".$x['no_faktur']."' ")->fetch_array();
$string.= '
  <tr>
    <td align="center">'.$x['no_faktur'].'</td>
    <td align="center">'.tanggal_indo(date('Y-m-d', $x['no_faktur'])).'</td>
    <td align="center">'.tanggal_indo($jt[0]).'</td>
    <td align="right">'.angka($x['jumlah_transaksi']).'</td>
	<td></td>
	<td></td>
	<td align="center">'.angka($x['jumlah_transaksi']-$x['jumlah_bayar']).'</td>
  </tr>		
';
$sub=$conn->query(" SELECT * FROM bayar_hutang where id_hutang = '".$x['id']."' ORDER by id ASC");
while ($y=$sub->fetch_array()) :
$pecah_tgl=explode(' ', $y['tgl_transaksi']);
$tgl_bayar=tanggal_indo($pecah_tgl[0]);
$string.='
  <tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
    <td align="center">'.$tgl_bayar.'</td>
    <td align="center">'.angka($y['jumlah_bayar']).'</td>
    <td align="center"></td>
  </tr>
';
endwhile;
$string.='  
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
';
endwhile;
$string.= '  
</table>
';

$total=$conn->query(" SELECT SUM(jumlah_transaksi), SUM(jumlah_bayar) FROM tabel_bayar WHERE customer = '$customer' AND distributor = '$distributor' AND metode_bayar = 1 ")->fetch_array();

$kode_jumlah_trx=angka($total[0]);
$kode_jumlah_bayar=angka($total[1]);
$kode_sisa_piutang=angka($total[0]-$total[1]);

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
$mpdf->Output();
