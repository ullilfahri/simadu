<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");
include MDL.'login/session.php';
$distributor = $_SESSION['distributor'];
$dis=$conn->query(" SELECT pengguna from mst_hak_akses where kode = '$distributor' ")->fetch_array();
$supplier = $_GET['supplier'];
$status_hutang = $_GET['status_hutang'];
$kriteria_tanggal = $_GET['kriteria_tanggal'];
$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d',$awal);
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d',$akhir);

	if ($status_hutang==0) {
		$qry_status='jumlah_hutang = 0';
		$stts='LUNAS';
		} else {
		$qry_status='jumlah_hutang != 0';
		$stts='BELUM LUNAS';
		}

	if ($kriteria_tanggal=='tanggal_jatuh_tempo') {
		$qry_tanggal='jatuh_tempo';
		} else {
		$qry_tanggal='tgl_nota';
		} 
$hutang=$conn->query("select * from tabel_pembelian where distributor = '$distributor' and metode_bayar='1' AND supplier IN ($supplier) AND $qry_status AND $qry_tanggal BETWEEN '$tgl_awal' and '$tgl_akhir' order by tgl_nota ASC");

$data_akhir=$conn->query("select SUM(total), SUM(jumlah_hutang) from tabel_pembelian where distributor = '$distributor' and metode_bayar='1' AND supplier IN ($supplier) AND $qry_status AND $qry_tanggal BETWEEN '$tgl_awal' and '$tgl_akhir'")->fetch_array();

$mpdf = new mPDF('en-GB-x', 'A4-L', 10 ,'Times New Roman', 3, 3, 3, 3);

$string='
<table width="100%" border="0">
  <tr>
    <td colspan="3" align="center"><br>'.$dis[0].'<br>LAPORAN BUKU HUTANG</td>
  </tr>
  <tr>
    <td width="20%">Status</td>
    <td width="1%">:</td>
    <td width="79%">'.$stts.'</td>
  </tr>
  <tr>
    <td>Kriteria</td>
    <td>:</td>
    <td>'.strtoupper(str_replace('_',' ',$kriteria_tanggal)).'</td>
  </tr>
  <tr>
    <td>Periode</td>
    <td>:</td>
    <td>Dari Tanggal '.tanggal_indo($tgl_awal).' Sampai Dengan '.tanggal_indo($tgl_akhir).'</td>
  </tr>
</table>
<table width="100%" border="0">
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
  <tr>
    <th width="26%" scope="col">Supplier</th>
    <th width="7%" scope="col">No. Ivoice</th>
    <th width="12%" scope="col">Tgl Transaksi</th>
    <th width="12%" scope="col">Tgl Jatuh Tempo</th>
    <th width="12%" scope="col">Tgl Bayar</th>
    <th width="10%" scope="col">Jumlah Transaksi</th>
    <th width="10%" scope="col">Jumlah Bayar</th>
    <th width="11%" scope="col">Sisa Hutang/Keterangan</th>
  </tr>
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
';
while ($x=$hutang->fetch_array()) :
$sup=$conn->query("SELECT nama FROM tabel_supplier WHERE id='".$x['supplier']."' ")->fetch_array();
$string.='
  <tr>
    <td>'.$sup[0].'</td>
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
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
';


endwhile;

$string.='
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
  <tr>
    <th colspan="5">TOTAL</th>
    <th align="right">'.angka($data_akhir[0]).'</th>
    <th align="right">'.angka($data_akhir[0]-$data_akhir[1]).'</th>
    <th align="right">'.angka($data_akhir[1]).'</th>
  </tr>
';

$string.='
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
</table>
';


$mpdf->AddPage();
$mpdf->WriteHTML(utf8_encode($string));
$mpdf->Output("Laporan Hutang.pdf" ,'I');
