<?php
include '../../../sysconfig.php';
include 'css_print/headjs.php';


$cek=$_POST['cek'];
$jumlah_dipilih = count($cek);

for($x=0;$x<$jumlah_dipilih;$x++){
	$y=$conn->query("SELECT * FROM stok_barang where kode_barang = '$cek[$x]'")->fetch_array();
	if ($y['harga_barang']=='') {
		$harga='Harga Belum Ditentukan';
		} else {
		$harga=rupiah($y['harga_barang']);
		}
	/*
	echo '<img alt="'.$cek[$x].'" src="'.PRT.'barcode.php?codetype=Code39&size=40&text='.$cek[$x].'&print=true" />'.$y['nama_barang'].'<br>';
	*/
echo '
<table width="32%" border="0">
  <tr>
    <th width="55%" scope="col"><img alt="'.$cek[$x].'" src="'.PRT.'barcode.php?codetype=Code39&size=40&text='.$cek[$x].'&print=true" /></th>
    <th width="35%" scope="col">'.$y['nama_barang'].'</th>
    <th width="10%" scope="col">'.$harga.'</th>
  </tr>
</table>
';	
}

?>