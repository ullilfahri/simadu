<?php
include 'sysconfig.php';


mysqli_query($conn,"TRUNCATE `stok_new2`") ;

mysqli_query($conn,"TRUNCATE `stok_new`") ;

$query = $conn->query("SELECT DISTINCT(kode_barang) FROM `stok_barang` WHERE `sisa_stok` > 0 limit 0,10"); 
while ($data = $query->fetch_array()) {
$kode_barang =  $data["kode_barang"] ;

        mysqli_query($conn,"INSERT INTO `stok_new2` (`id`, `kode_barang`) VALUES (NULL, '$kode_barang');") ;


}





?>
<script>window.location='sk.php'</script>