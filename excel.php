<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporanstok.xls");
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
    <th>Sisa Stok</th>
  </tr>

<?php
include 'sysconfig.php';


$query = mysqli_query($conn,"SELECT * FROM `stok_new` ORDER BY `stok_new`.`id` ASC") ;

while ( $t = mysqli_fetch_array($query)) {



?>

<tr>
    <td><?php echo $t["kode_barang"] ?></td>
    <td><?php echo $t["nama_barang"] ?></td>
    <td><?php echo $t["stok_jual"] ?></td>
    <td><?php echo $t["stok_fisik"] ?></td>
    <td><?php echo $t["terjual"] ?></td>
    <td><?php echo $t["belum_final"] ?></td>
    <td><?php echo $t["open_stok"] ?></td>
  
    <td><?php echo $t["nama_gudang"] ?></td>
    <td><?php echo $t["sisa_stok"] ?></td>
</tr>


<?php 
}
echo '</table>' ;
?>

