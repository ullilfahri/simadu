<?php
include '../../../sysconfig.php';

if (isset($_POST['tambah_pintu_gudang'])) :

$id_gudang = $_POST['id_gudang'];
$nama_pintu = $_POST['nama_pintu'];


$tambah=$conn->query("INSERT INTO `pintu_gudang`(`id_gudang`, `nama_pintu`) VALUES('$id_gudang', '$nama_pintu')   ");

        echo "<script>window.alert('Detail Gudang Tersimpan..!') 
		window.location='index.php'</script>";


endif;



if (isset($_POST['simpan_koordinat'])) :

$nama = $_POST['nama'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$alamat = $_POST['alamat'];
$id_level = $_POST['id_level'];

$masuk=$conn->query("INSERT INTO lokasi(nama,lat,lng,alamat, id_level) VALUES('$nama','$lat','$lng','$alamat','$id_level')");

echo "<script>window.alert('Lokasi $nama Tersimpan') 
		window.location='index.php'</script>";


endif;

if (isset($_POST['buka_peta'])) :

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server

// Select all the rows in the markers table
$result = $conn->query("SELECT * FROM lokasi");

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = $result->fetch_array()){
  // Add to XML document node
  echo '<marker ';
  echo 'id="' . $row['id_lokasi'] . '" ';
  echo 'name="' . parseToXML($row['nama']) . '" ';
  echo 'address="' . parseToXML($row['alamat']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'type="' . $row['id_level'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';

endif;


if (isset($_GET['rincian_stok'])) :

endif;


?>