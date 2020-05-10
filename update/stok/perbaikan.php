<?php
include '../../sysconfig.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Perbaikan Stok Awal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</head>
<body>
<h1>Perbaikan Stok Awal</h1>
<a href="../../../stok3.php">Download Laporan</a>

<hr>

<form method="get" action="">
   <label>Tanggal : </label>
    <input type="date" name="tanggal" required>
   


    <label>Nama Barang</label>
    <select class="js-example-basic-single" name="kode_barang">
   
   <?php 
        $qbarang = mysqli_query($conn,"SELECT DISTINCT(kode_barang), nama_barang FROM `alokasi_stok` ORDER BY `alokasi_stok`.`nama_barang` ASC ") ;
        while ($tbarang = mysqli_fetch_array($qbarang)) {
   ?>
    <option value="<?php echo $tbarang["kode_barang"] ?>"><?php echo $tbarang["kode_barang"] ?> -- <?php echo $tbarang["nama_barang"] ?></option>
        <?php 
        }
        ?>
    </select>


        <label>Nama Gudang</label>
    <select class="js-example-basic-single" name="gudang">
  <?php
    $qlokasi = mysqli_query($conn,"SELECT * FROM `lokasi` ORDER BY `lokasi`.`nama` DESC ") ;
    while ($tlokasi = mysqli_fetch_array($qlokasi)) {
  ?>
    <option value="<?php echo $tlokasi["id_lokasi"] ?>"><?php echo $tlokasi["nama"] ?></option>
    <?php 
    }
    ?>
        </select>
<br>
<input class="btn btn-info" type="submit" name="cari" value="lihat Stok">

</form>


</body>


<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>

<?php
if(isset($_GET["tanggal"])) {
    $tanggal = mysqli_real_escape_string($conn,$_GET["tanggal"]) ;
    $kode_barang = mysqli_real_escape_string($conn,$_GET["kode_barang"]) ;
    $gudang = mysqli_real_escape_string($conn,$_GET["gudang"]) ;


  $qstok = mysqli_query($conn,"SELECT * FROM `stok_awal` INNER JOIN lokasi on stok_awal.id_gudang = lokasi.id_lokasi WHERE tanggal = '$tanggal' and kode_barang = '$kode_barang' and id_gudang = '$gudang' ")  ;


  $ts = mysqli_fetch_array($qstok) ;
  $stok = $ts["stok"] ;

  $row = mysqli_num_rows($qstok) ;

  if($row > 0 )
  {
      
    include "updatestok.php" ;
  }
  else
    {
        include "tambahstok.php" ;
    }


} //pet

?>
