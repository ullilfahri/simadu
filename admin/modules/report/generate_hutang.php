<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");
include MDL.'login/session.php';
$distributor = $_SESSION['distributor'];
$id_pembelian = $_GET['id'];

$x=$conn->query("select * from tabel_pembelian where id_pembelian = '$id_pembelian' ")->fetch_array();
$sup=$conn->query("SELECT nama FROM tabel_supplier WHERE id='".$x['supplier']."' ")->fetch_array();

$mpdf = new mPDF('en-GB-x', 'A4-L', 10 ,'Times New Roman', 3, 3, 3, 3);

$string='
<table width="100%" border="0">
  <tr>
    <td colspan="3" align="center"><br>'.$dis[0].'<br>LAPORAN BUKU HUTANG</td>
  </tr>
  <tr>
    <td width="20%">No. Supplier</td>
    <td width="1%">:</td>
    <td width="79%">'.$x['supplier'].'</td>
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
    <th width="7%" scope="col">No. Ivoice</th>
    <th width="12%" scope="col">Tgl Transaksi</th>
    <th width="12%" scope="col">Tgl Jatuh Tempo</th>
    <th width="12%" scope="col">Tgl Bayar</th>
    <th width="10%" scope="col">Jumlah Transaksi</th>
    <th width="10%" scope="col">Jumlah Bayar</th>
    <th width="11%" scope="col">Sisa Hutang/Keterangan</th>
  </tr>
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
';
$string.='
  <tr>
    <td>'.$x['no_faktur'].'</td>
    <td align="center">'.tanggal_indo($x['tgl_nota']).'</td>
    <td align="center">'.tanggal_indo($x['jatuh_tempo']).'</td>
    <td>&nbsp;</td>
    <td align="right">'.angka($x['total']).'</td>
    <td>&nbsp;</td>
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
    <td align="center"></td>
    <td align="center"></td>
    <td>'.$tgl_tunai.'</td>
    <td align="right"></td>
    <td align="right">'.angka($y[1]).'</td>
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
    <td align="center"></td>
    <td align="center"></td>
    <td>'.$tgl_bank.'</td>
    <td align="right"></td>
    <td align="right">'.angka($y[1]).'</td>
    <td align="center">TRANSFER BANK</td>
  </tr>
';
endwhile;
}  

$string.='  
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
';

$string.='
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
  <tr>
    <th colspan="4">TOTAL</th>
    <th align="right">'.angka($x['total']).'</th>
    <th align="right">'.angka($x['total']-$x['jumlah_hutang']).'</th>
    <th align="right">'.angka($x['jumlah_hutang']).'</th>
  </tr>
';

$string.='
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
<tr><td colspan="7" style="border-top:#000000 solid thin;"></td></tr>
</table>
';


$mpdf->AddPage();
$mpdf->WriteHTML(utf8_encode($string));
$mpdf->Output("Lap_Hutang_".$sup[0].".pdf" ,'I');
