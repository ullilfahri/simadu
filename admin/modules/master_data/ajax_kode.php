<?php
include '../../../sysconfig.php';

if (isset($_GET['cari_kode'])) :
$input=$_GET['input'];
$data=$conn->query("select COUNT(id), kode_barang, nama_barang from stok_barang where kode_barang='$input'")->fetch_array();

if (strlen($input)<5) {
			echo " <i class='glyphicon glyphicon-remove'></i> Kode Minimal 5 Digit";
} else if (strlen($input)>10) {
			echo " <i class='glyphicon glyphicon-remove'></i> Kode Maksimal 10 Digit";
} else if ($data[0]>0) {	
			echo " <i class='glyphicon glyphicon-remove'></i> Kode $input Sudah Ada Yaitu : ".$data[2];		
} else {
			echo "<a href='javascript:autoInsert(".$input.");'><i class='fa fa-check fa-lg' style='color:green;'></i> Kode ".$input." belum ada di database, Klik Utntuk Validasi</a>";
}			

endif;

if (isset($_GET['jenis_barang'])) :
$jenis_barang=$_GET['jenis_barang'];
$query = $conn->query("SELECT jenis_barang FROM barang_jenis WHERE jenis_barang like '%$jenis_barang%' GROUP BY jenis_barang LIMIT 0 , 5"); //query mencari hasil search
while ($x=$query->fetch_array()) :
?>
<a href="javascript:autoInsert_jenis_barang('<?=htmlspecialchars($x[0])?>','1');"><?=$x[0]?></a><br>
<?php
endwhile;

endif;

if (isset($_GET['merek_barang'])) :
$merek_barang=$_GET['merek_barang'];
$query = $conn->query("SELECT merek_barang FROM barang_jenis WHERE merek_barang like '%$merek_barang%'  GROUP BY merek_barang LIMIT 0 , 5"); //query mencari hasil search
while ($x=$query->fetch_array()) :
?>
<a href="javascript:autoInsert_merek_barang('<?=htmlspecialchars($x[0])?>','1');"><?=$x[0]?></a><br>
<?php
endwhile;
endif;

if (isset($_GET['nama_barang'])) :
$nama_barang=$_GET['nama_barang'];
$query = $conn->query("SELECT nama_barang FROM kode_barang WHERE nama_barang like '%$nama_barang%' GROUP BY nama_barang LIMIT 0 , 5"); 
while ($x=$query->fetch_array()) :
?>
<a href="javascript:autoInsert_nama_barang('<?=htmlspecialchars($x[0])?>','1');"><?=$x[0]?></a><br>
<?php
endwhile;
endif;

if (isset($_GET['satuan'])) :
$satuan=$_GET['satuan'];
$query = $conn->query("SELECT satuan_barang, akronim FROM barang_satuan WHERE satuan_barang like '%$satuan%' GROUP BY satuan_barang LIMIT 0 , 5"); //query mencari hasil search
while ($x=$query->fetch_array()) :
?>
<a href="javascript:autoInsert_satuan('<?=$x[0]?>', '<?=htmlspecialchars($x[1])?>', '1');"><?=$x[0]?></a><br>
<?php
endwhile;

endif;

if (isset($_GET['cari_kode_bujur'])) :
$jenis_barang =$_POST['jenis_barang'];
$merek_barang =$_POST['merek_barang'];
$nama_barang =$_POST['nama_barang'];
$distributor =$_POST['distributor'];
$nama_lengkap=$jenis_barang.' '.$merek_barang.' '.$nama_barang;

$sudah=$conn->query(" SELECT COUNT(*), kode_barang FROM stok_barang WHERE nama_barang LIKE '%$nama_lengkap%' AND distributor='$distributor' ")->fetch_array();
if ($sudah[0] == 0) {
$kar_1=substr($jenis_barang,0,1);
$kar_2=substr($merek_barang,0,1);
$insial=$kar_1.$kar_2;
$cari=$conn->query(" SELECT * FROM kode_barang WHERE kode_barang LIKE '%$insial%' ")->num_rows;
$digit=$cari+1;
$digit = str_pad($digit, 4, '0', STR_PAD_LEFT);
$kode=$insial.$digit;
echo json_encode(array('status' =>true, 'kode' =>$kode, 'barang' =>'Kode Barang '.$nama_lengkap.' Berhasil '.$distributor.' Digenerate'));
} else {
$kode=$sudah[1];
echo json_encode(array('error' =>true, 'barang' =>'Kode Barang '.$nama_lengkap.' Sudah Ada <a href="../pembelian/index.php?input='.$nama_lengkap.'&kode='.$kode.'" target="_blank">Klik Disini</a> Untuk Pembelian'));
}

endif;


?>