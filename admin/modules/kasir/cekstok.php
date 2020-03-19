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


<table border='1'>
  <tr>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Stok Jual</th>
    <th>Stok Fisik</th>
    <th>Terjual</th>
    <th>Belum Final</th>
    <th>Open Stok</th>
    
    <th>Nama Gudang</th>
  </tr>

<?php
if(isset($_GET["fname"])) {
    $kode_barang = mysqli_real_escape_string($conn,$_GET["fname"]) ;
    $barang = $conn->query("SELECT * FROM `stok_barang` WHERE `kode_barang` LIKE '$kode_barang'")->fetch_array();
    //melihat gundag
    $nama_barang = $barang["nama_barang"] ;
  
    echo "<h2>".$kode_barang. " ". $barang["nama_barang"] . "</h2>" ;
    echo "Sisa Stok Global : ".$barang["sisa_stok"] ;
    echo "<hr>" ;
    $query = $conn->query("SELECT * FROM `lokasi`");
    while ($data = $query->fetch_array()) {
        $kode_gudang = $data["id_lokasi"] ;
        $nama_gudang = $data["nama"] ;

        $stok_jual = $conn->query("SELECT SUM(jumlah) as total FROM `alokasi_stok_jual` WHERE kode_barang = '$kode_barang' AND id_gudang = '$kode_gudang' GROUP BY id_gudang, kode_barang")->fetch_array();
        
        $stok_fisik=$conn->query(" SELECT SUM(jumlah) as total FROM alokasi_stok where kode_barang = '$kode_barang'  AND id_gudang = '$kode_gudang' ")->fetch_array();
        
        $belum_ambil=$conn->query(" SELECT SUM(`jumlah`)-SUM(`is_ambil`) as total FROM `barang_keluar` where kode_barang = '$kode_barang'  AND id_gudang = '$kode_gudang' ")->fetch_array();
       
        $belum_final=$conn->query("SELECT SUM(jumlah) as total FROM tabel_trx where kode_barang = '$kode_barang'  AND id_gudang = '$kode_gudang' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE total_trx=0) ")->fetch_array();
			
			
			$ada_jual=$data[6]-$stok_jual[0];
			$ada_jual=$stok_fisik[0]-$belum_ambil[0]-$belum_final[0];
      //$ada_jual = $stok_fisik["total"] - $stok_jual["total"] ;
?>




  <tr>
    <td><?php echo $kode_barang ?></td>
    <td><?php echo $nama_barang ?></td>
    <td><?php echo $stok_jual["total"] ?></td>
    <td><?php echo $stok_fisik["total"] ?></td>
    <td><?php echo $belum_ambil["total"] ?></td>
    <td><?php echo $belum_final["total"] ?></td>
    <td><?php echo $ada_jual ?></td>
  
    <td><?php echo $nama_gudang ?></td>
  </tr>
  




<?php 
      //  echo $nama_gudang." Tersedia ". $ada_jual   ."<br>" ;

    }

   echo '</table>' ;


}

?>