<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include '../../../sysconfig.php';
include_once "css_print/headjs.php";
$no_faktur=$_GET['no_faktur'];
$id_gudang=$_GET['id_gudang'];
$data=$conn->query("select a.total, b.nama, a.customer from tabel_faktur as a left join user as b on a.kasir=b.id where a.no_faktur='$no_faktur'")->fetch_array();
$customer=$conn->query("select * from tabel_customer where id='".$data[2]."'")->fetch_array();
$sql=$conn->query("select * from tabel_trx where no_faktur='$no_faktur' and id_gudang='$id_gudang' GROUP by kode_barang");
$gudang=$conn->query("select nama from lokasi where id_lokasi='$id_gudang'")->fetch_array();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CETAK SURAT JALAN</title>
</head>

<body>
<div id="content" class="container_12 clearfix">
<div id="content-main" class="grid_7">

<link href="css_print/surat.css" rel="stylesheet" type="text/css" />
</div>
</div>


<table width="100%" border="0" align="center">
  <tr>
    <th align="left" width="50%">Kepada Yth.</th>
    <th align="left">Ketapang, <?=tanggal_indo(date("Y-m-d", $no_faktur))?></th>
  </tr>
  <tr>
    <td align="left"><?=$customer['nama']?><br><?=$customer['alamat']?><br><?=$customer['kota']?><br>Telp.Faks <?=$customer['no_hp']?></td>
    <td align="left"><br>
    <p>
    No. Surat Jalan&nbsp;: <?=$no_faktur?><br>
    Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=date("d-m-Y", $no_faktur)?><br>
    No. PO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <br>
    Dibuat oleh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=$data[1]?>
    </p>
    </td>
  </tr>
</table>

<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><b><u>SURAT JALAN</u></b></td>
  </tr>
</table>

<table border="1" width="100%" cellspacing="0" cellpadding="10px" align="center">
  <tr>
    <th align="left">NO</th>
    <th align="left">KODE</th>
    <th align="left">NAMA BARANG</th>
    <th align="left">QTY</th>
    <th align="left">KETERANGAN ASAL GUDANG</th>
  </tr>
    <?php 
	$no=1;
	while ($x=$sql->fetch_array()):?>
  <tr>
    <td style="border:1px solid white;"><?=$no++?><br><br><br><br><br><br></td>
    <td style="border:5px solid white;"><?=$x['kode_barang']?><br><br><br><br><br><br></td>
    <td style="border:5px solid white;"><?=$x['nama_barang']?><br><br><br><br><br><br></td>
    <td style="border:5px solid white;"><?=$x['jumlah']?><br><br><br><br><br><br></td>
    <td style="border:5px solid white;"><?=$gudang[0]?><br><br><br><br><br><br></td>
    <?php endwhile;?>
  </tr>
</table>


<!--ENDING-->
<div id="aside">
</div>
</body>
</html>
<!--AKHIR ENDING-->
