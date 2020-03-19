<?php
include '../../../sysconfig.php';

if (isset($_GET['live_edit'])) :
$tabel=$_GET['tabel'];
$jenis_id=$_GET['jenis_id'];
$value = $_POST['value'];
$id = $_POST['pk'];
$kolom = $_POST['name'];
$conn->query("UPDATE $tabel SET $kolom = '$value' where $jenis_id = '$id' ");

endif;


if (isset($_GET['tutup_kunci'])) :

$tabel=$_GET['tabel'];
$jenis_id=$_GET['jenis_id'];
$url=$_GET['url'];
$id=$_POST['id'];

$aksi=$conn->query("UPDATE $tabel SET kunci = 1 where $jenis_id = '$id' ");

echo json_encode(array('status' =>true, 'url' =>$url.'&id='.$id));

endif;

if (isset($_GET['buka_kunci'])) :

$tabel=$_GET['tabel'];
$jenis_id=$_GET['jenis_id'];
$id=$_POST['id'];
$url=$_GET['url'];
$aksi=$conn->query("UPDATE $tabel SET kunci = 0 where $jenis_id = '$id' ");
echo json_encode(array('status' =>true, 'url' =>$url.'&id='.$id));

endif;
?>