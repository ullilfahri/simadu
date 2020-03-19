<?php
include '../../../sysconfig.php';
if (isset($_GET['input'])) {

	$input = $_GET['input'];
		

	$query = $conn->query("SELECT `id`, `id_gudang`, `id_gudang`, `nama_barang`, `kode_barang`, `distributor`, SUM(jumlah) FROM `alokasi_stok` WHERE kode_barang LIKE '%$input%' AND jumlah > 0 OR nama_barang LIKE '%$input%' AND jumlah > 0 GROUP BY kode_barang,id_gudang "); //query mencari hasil search
	
	$hasil = $query->num_rows;
		
		if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Tidak Ada Barang ".$input;
			} else  {
					//ini jika barang tersedia
				//echo $input." Tersedia ".$hasil ;	
					//mengulang barang tersedia
					while ($data = $query->fetch_array()) {
						echo "a" ;	
					}
					


			}
} // penutup atas
		
	
?>