<!DOCTYPE html>
<html lang="en">
<head>
  <title>Simadu Stock Recording</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>


  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</head>


<body>

<?php 
include "menu.php" ;

?>
<?php
include '../../../../sysconfig.php';


?>
<hr>

<h1> Barang Trending </h1>

<hr>


<form>

<select name="gudang">
<option value="">Semua Outlet</option>
    <?php 
      $qgd = mysqli_query($conn,"SELECT * FROM `lokasi` ") ;
      while ($tgd = mysqli_fetch_array($qgd)) { 
    ?>
    <option value="<?php echo $tgd["id_lokasi"] ?>"><?php echo $tgd["nama"] ?></option>
      <?php } ?>
    
</select>

<input type="submit" value="Lihat Trending Outlet" class="btn btn-info">

</form>


<hr>


<div class="container">



<?php
if(isset($_GET["gudang"])) {

echo '<table class="table table" border="1">

<tr>
<td>Kode Barang</td>
<td>Nama Barang</td>
<td>Total Terjual</td>
</tr>' ;

$id_gudang = mysqli_real_escape_string($conn,$_GET["gudang"]) ;


  if($id_gudang == "" ) {
    $qtrending = mysqli_query($conn,"SELECT DISTINCT(kode_barang) as kb , sum(jumlah) as total ,nama_barang FROM `alokasi_stok_jual` GROUP by kode_barang ORDER BY `total` DESC ") ;
  }
  else
  {
  $qtrending = mysqli_query($conn,"SELECT DISTINCT(kode_barang) as kb , sum(jumlah) as total ,nama_barang FROM `alokasi_stok_jual` WHERE id_gudang = '$id_gudang' GROUP by kode_barang ORDER BY `total` DESC") ;
  }
}

while ( $tt = mysqli_fetch_array($qtrending)) {
?>


<tr>
<td><?php echo $tt["kb"] ?></td>
<td><?php echo $tt["nama_barang"] ?></td>
<td><?php echo $tt["total"] ?></td>
</tr>

<?php 
}
?>

</table>


</div>




</body>


