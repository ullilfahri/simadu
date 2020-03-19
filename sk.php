<head>
<meta http-equiv="refresh" content="3" />
<title>Sinkronisasi Stok Barang </title>
</head>

<h1>Proses Sinkronisasi Stok</h1>

<?php
include 'sysconfig.php';

//hitung total data

$total = mysqli_query($conn,"SELECT COUNT(id)  as total FROM `stok_new2`") ;
$tt = mysqli_fetch_array($total) ;
$data_total = $tt["total"] ;


//if tidak ada barang untuk di sinkron

if($data_total > 0 ) { // KODE A

echo "Data Antrian Sinkron : ".$data_total ." Barang" ;

echo '
<br>
Perkiraan Waktu Sinkron :
' ; 
$waktu = $data_total * 3 ;
echo number_format($waktu / 60 / 60 , 2 ) ;

echo " Jam <br>" ;




//query antrian descending

$xx = mysqli_query($conn,"SELECT * FROM `stok_new2` ORDER BY `stok_new2`.`id` ASC") ;
$tc = mysqli_fetch_array($xx) ;

//mulai proses sinkron berdasarakan antrian
/////////////////////////////////////////////////////////////////////


?>



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

    $kode_barang = $tc["kode_barang"] ;
   // echo $kode_barang ;
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

//masukan ke database stok new
//DELETE STOK LAMA
//mysqli_query($conn,"DELETE FROM `stok_new` WHERE `kode_barang` LIKE '$kode_barang' ") ;
//Tambahkan stok baru

$stok_jual2 = $stok_jual["total"] ;
    $stok_fisik2 = $stok_fisik["total"] ;
    $belum_ambil2 = $belum_ambil["total"] ;
    $belum_final2 = $belum_final["total"] ;
    $sisa_stok = $barang["sisa_stok"] ;

mysqli_query($conn,"INSERT INTO `stok_new` (`id`, `kode_barang`, `nama_barang`, `stok_jual`, `stok_fisik`, `terjual`, `belum_final`, `open_stok`, `nama_gudang` , `sisa_stok` ) VALUES (NULL, '$kode_barang', '$nama_barang', '$stok_jual2', '$stok_fisik2', '$belum_ambil2', '$belum_final2', '$ada_jual', '$nama_gudang' , '$sisa_stok' );") ;



    }

   echo '</table>' ;





// delete antrian atas
mysqli_query($conn,"DELETE FROM `stok_new2` WHERE kode_barang = '$kode_barang' ") ;

} ///kode a

else
{
    echo "<script>window.location='stok.php'</script>" ;
}



?>