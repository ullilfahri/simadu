<?php
include '../../../sysconfig.php';
include("../kasir/mpdf54/mpdf.php");

$mpdf = new mPDF('en-GB-x', 'A4-L', 10 ,'Times New Roman', 3, 3, 3, 3);


$status_piutang=$_POST['status_piutang'];
if ($status_piutang==0) {
$stts_piutang='BELUM LUNAS';
} else {
$stts_piutang='LUNAS';
}
$distributor=$_POST['distributor'];
$kriteria_tanggal=ucwords(str_replace('_',' ',$_POST['kriteria_tanggal']));
$awal = date_create_from_format('d-m-Y', $_POST['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d',$awal);
$akhir = date_create_from_format('d-m-Y', $_POST['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d',$akhir);
$dis=$conn->query(" SELECT pengguna from mst_hak_akses where kode = '$distributor' ")->fetch_array();


	if ($status_piutang==1 && $_POST['kriteria_tanggal']=="tanggal_transaksi") {
		$data=$conn->query("SELECT a.customer, a.no_faktur, a.jatuh_tempo, b.nama, a.total_trx-a.jumlah_diskon FROM tabel_faktur AS a LEFT JOIN tabel_customer AS b ON a.customer=b.id WHERE a.no_faktur BETWEEN $awal and $akhir AND a.metode_bayar=1 AND a.no_faktur IN (SELECT no_faktur FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar = 0 AND distributor='$distributor') ORDER BY b.nama ASC");
		$data_akhir=$conn->query("SELECT SUM(jumlah_transaksi), SUM(jumlah_bayar) FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar = 0 AND distributor='$distributor' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE metode_bayar=1 AND no_faktur BETWEEN '$awal' and '$akhir') ")->fetch_array();
		
		} else if ($status_piutang==1 && $_POST['kriteria_tanggal']=="tanggal_jatuh_tempo") {
		$data=$conn->query("SELECT a.customer, a.no_faktur, a.jatuh_tempo, b.nama, a.total_trx-a.jumlah_diskon FROM tabel_faktur AS a LEFT JOIN tabel_customer AS b ON a.customer=b.id WHERE a.jatuh_tempo BETWEEN '".date('Y-m-d',$awal)."' and '".date('Y-m-d',$akhir)."' AND a.metode_bayar=1 AND a.no_faktur IN (SELECT no_faktur FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar = 0 AND distributor='$distributor') ORDER BY b.nama ASC");
		$data_akhir=$conn->query("SELECT SUM(jumlah_transaksi), SUM(jumlah_bayar) FROM tabel_bayar WHERE  jumlah_transaksi-jumlah_bayar = 0 AND distributor='$distributor' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE metode_bayar=1 AND jatuh_tempo BETWEEN '$tgl_awal' and '$tgl_akhir')")->fetch_array();
		
		} else if ($status_piutang==0 && $_POST['kriteria_tanggal']=="tanggal_transaksi") {
		$data=$conn->query("SELECT a.customer, a.no_faktur, a.jatuh_tempo, b.nama, a.total_trx-a.jumlah_diskon FROM tabel_faktur AS a LEFT JOIN tabel_customer AS b ON a.customer=b.id WHERE a.no_faktur BETWEEN $awal and $akhir AND a.metode_bayar=1 AND a.no_faktur IN (SELECT no_faktur FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar > 0 AND distributor='$distributor') ORDER BY b.nama ASC");
		$data_akhir=$conn->query("SELECT SUM(jumlah_transaksi), SUM(jumlah_bayar) FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar > 0 AND distributor='$distributor' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE metode_bayar=1 AND no_faktur BETWEEN '$awal' and '$akhir') ")->fetch_array();

		} else if ($status_piutang==0 && $_POST['kriteria_tanggal']=="tanggal_jatuh_tempo") {
		$data=$conn->query("SELECT a.customer, a.no_faktur, a.jatuh_tempo, b.nama, a.total_trx-a.jumlah_diskon FROM tabel_faktur AS a LEFT JOIN tabel_customer AS b ON a.customer=b.id WHERE a.jatuh_tempo BETWEEN '$tgl_awal' and '$tgl_akhir' AND a.metode_bayar=1 AND a.no_faktur IN (SELECT no_faktur FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar > 0 AND distributor='$distributor') ORDER BY b.nama ASC");
		$data_akhir=$conn->query("SELECT SUM(jumlah_transaksi), SUM(jumlah_bayar) FROM tabel_bayar WHERE jumlah_transaksi-jumlah_bayar > 0 AND distributor='$distributor' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE metode_bayar=1 AND jatuh_tempo BETWEEN '$tgl_awal' and '$tgl_akhir')")->fetch_array();
		
		} else {
		echo "<script>window.alert('Tidak Ada Kriteria $status_piutang DAN $kriteria_tanggal') 
		window.close()</script>";
		}


$string='
<table width="100%" border="0">
  <tr>
    <td colspan="3" align="center"><br>'.$dis[0].'<br>LAPORAN BUKU PIUTANG</td>
  </tr>
  <tr>
    <td width="20%">Status</td>
    <td width="1%">:</td>
    <td width="79%">'.$stts_piutang.'</td>
  </tr>
  <tr>
    <td>Kriteria</td>
    <td>:</td>
    <td>'.$kriteria_tanggal.'</td>
  </tr>
  <tr>
    <td>Periode</td>
    <td>:</td>
    <td>Dari Tanggal '.tanggal_indo(date('Y-m-d',$awal)).' Sampai Dengan '.tanggal_indo(date('Y-m-d',$akhir)).'</td>
  </tr>
</table>
<table width="100%" border="0">
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
  <tr>
    <th width="26%" scope="col">Customer</th>
    <th width="7%" scope="col">No. Ivoice</th>
    <th width="12%" scope="col">Tgl Transaksi</th>
    <th width="12%" scope="col">Tgl Jatuh Tempo</th>
    <th width="12%" scope="col">Tgl Bayar</th>
    <th width="10%" scope="col">Jumlah Transaksi</th>
    <th width="10%" scope="col">Jumlah Bayar</th>
    <th width="11%" scope="col">Sisa Piutang/Keterangan</th>
  </tr>
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
';
while ($x=$data->fetch_array()) :
$sisa_bayar=$conn->query("SELECT jumlah_transaksi-jumlah_bayar, id FROM tabel_bayar WHERE no_faktur='".$x[1]."' AND distributor='$distributor' ")->fetch_array();
$string.='
  <tr>
    <td>'.$x[3].'</td>
    <td>'.$x[1].'</td>
    <td align="center">'.tanggal_indo(date('Y-m-d',$x[1])).'</td>
    <td align="center">'.tanggal_indo($x[2]).'</td>
    <td>&nbsp;</td>
    <td align="right">'.angka($x[4]).'</td>
    <td>&nbsp;</td>
    <td align="right">'.angka($sisa_bayar[0]).'</td>
  </tr>
';
$data_bayar=$conn->query("SELECT tgl_transaksi, jumlah_bayar, via_bayar FROM bayar_hutang where id_hutang='".$sisa_bayar[1]."'");
$ada=$data_bayar->num_rows;
if ($ada==0) {
$string.='
';
} else {
while ($y=$data_bayar->fetch_array()):
$pecah=explode(' ',$y[0]);
$tgl=tanggal_indo($pecah[0]);
$string.='
  <tr>
    <td></td>
    <td></td>
    <td align="center"></td>
    <td align="center"></td>
    <td>'.$tgl.'</td>
    <td align="right"></td>
    <td align="right">'.angka($y[1]).'</td>
    <td align="center">'.ucwords($y[2]).'</td>
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
    <th align="right">'.angka($data_akhir[1]).'</th>
    <th align="right">'.angka($data_akhir[0]-$data_akhir[1]).'</th>
  </tr>
';

$string.='
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
<tr><td colspan="8" style="border-top:#000000 solid thin;"></td></tr>
</table>
';

$mpdf->AddPage();
$mpdf->WriteHTML(utf8_encode($string));
$mpdf->Output("Laporan Piutang.pdf" ,'I');

