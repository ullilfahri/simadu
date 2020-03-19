<?php
include '../../../sysconfig.php';
?>

<h1>Cek Stok Manual</h1>
<hr>

<form action="">
  <label for="fname">Kode Barang:</label><br>
  
  <input type="text" id="fname" name="fname" placeholder="Kode Barang"><br>
  
  <input type="submit" value="Submit">
</form> 

<?php
if(isset($_GET["fname"])) {
    $kode_barang = mysqli_real_escape_string($conn,$_GET["fname"]) ;
    $barang = $conn->query("SELECT * FROM `stok_barang` WHERE `kode_barang` LIKE '$kode_barang'")->fetch_array();
    //melihat gundag
  
    echo "<h2>".$kode_barang. " ". $barang["nama_barang"] . "</h2>" ;
    echo "<hr>" ;
    $query = $conn->query("SELECT * FROM `lokasi`");
    while ($data = $query->fetch_array()) {
        $kode_gudang = $data["id_lokasi"] ;
        $nama_gudang = $data["nama"] ;

        $stok_jual = $conn->query("SELECT SUM(jumlah) as total FROM `alokasi_stok_jual` WHERE kode_barang = '$kode_barang' AND id_gudang = '$kode_gudang' GROUP BY id_gudang, kode_barang")->fetch_array();
        
        $stok_fisik=$conn->query(" SELECT SUM(jumlah) FROM alokasi_stok where kode_barang = '$kode_barang'  AND id_gudang = '$kode_gudang' ")->fetch_array();
        
        $belum_ambil=$conn->query(" SELECT SUM(`jumlah`)-SUM(`is_ambil`) FROM `barang_keluar` where kode_barang = '$kode_barang'  AND id_gudang = '$kode_gudang' ")->fetch_array();
       
        $belum_final=$conn->query("SELECT SUM(jumlah) FROM tabel_trx where kode_barang = '$kode_barang'  AND id_gudang = '$kode_gudang' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE total_trx=0) ")->fetch_array();
			
			
			$ada_jual=$data[6]-$stok_jual[0];
			$ada_jual=$stok_fisik[0]-$belum_ambil[0]-$belum_final[0];

        echo $nama_gudang." Tersedia ". $ada_jual   ."<br>" ;

    }


}

?>