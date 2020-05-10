<?php
include "sysconfig.php" ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</head>
<body>




<h1>Download Laporan Stok Simadu</h1>

<form method="get" action="update/stok/laporan.php">
Silahkan Pilih Tanggal Pelaporan : 
    <input  type="date" name="t">

    
<select class="js-example-basic-single" name="kode_barang">
 
<option value="">Semua Barang</option>
<?php 
        $qbarang = mysqli_query($conn,"SELECT DISTINCT(kode_barang), nama_barang FROM `alokasi_stok` ORDER BY `alokasi_stok`.`nama_barang` ASC ") ;
        while ($tbarang = mysqli_fetch_array($qbarang)) {
   ?>
    <option value="<?php echo $tbarang["kode_barang"] ?>"><?php echo $tbarang["kode_barang"] ?> -- <?php echo $tbarang["nama_barang"] ?></option>
        <?php 
        }
        ?>

</select>



    <input class="btn btn-info" type="submit" name="simpan" value="Lihat Laporan">
</form>

<a href='update/stok/perbaikan.php'>Perbakian Stok Awal</a>


</body>

<script>
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>