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
include '../../../../sysconfig.php';


?>

<?php
include "menu.php" ; 

?>

<hr>
<h1>Simadu Stock Recording</h1>
<hr>

<form>

<select class="js-example-basic-single" name="kode_barang">
      <?php 
          $qsb = mysqli_query($conn,"SELECT DISTINCT(kode_barang),nama_barang FROM `alokasi_stok` ") ;
          while ($tsb = mysqli_fetch_array($qsb)) {
      ?>
      <option value="<?php echo $tsb["kode_barang"] ?>"><?php echo $tsb["kode_barang"] ?> - <?php echo $tsb["nama_barang"] ?></option>
            <?php 
          }
          ?>
</select>
<br>
<!--
<input type="text" name="kode_barang" placeholder="Kode Barang" class="form-control" required>
-->

<label>Tanggal Awal</label>
<input type="date" name="awal">
<label>Tanggal Akhir </label>
<input type="date" name="akhir">
<label>Outlet </label>
<select name="gudang">
    
    <?php 
      $qgd = mysqli_query($conn,"SELECT * FROM `lokasi` ") ;
      while ($tgd = mysqli_fetch_array($qgd)) { 
    ?>
    <option value="<?php echo $tgd["id_lokasi"] ?>"><?php echo $tgd["nama"] ?></option>
      <?php } ?>
    
</select>
<br>
<br>*Jika Ingin Semua Data Stock, Tanggal Awal dan Akhir jangan di isi .<br>

<input type="submit" value="Lihat Story" class="btn btn-info">

</form>


<hr>
<?php
if(isset($_GET["kode_barang"])) {
//echo "<h2>Output</h2>" ;

$kode_barang  = mysqli_real_escape_string($conn,$_GET["kode_barang"]) ;
$awal = mysqli_real_escape_string($conn,$_GET["awal"]) ;
$akhir = mysqli_real_escape_string($conn,$_GET["akhir"]) ;
$id_gudang = mysqli_real_escape_string($conn,$_GET["gudang"]) ;


//querynamabarang

$qbarang = mysqli_query($conn,"SELECT * FROM `alokasi_stok_jual` INNER JOIN lokasi on alokasi_stok_jual.id_gudang = lokasi.id_lokasi WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' ORDER BY `alokasi_stok_jual`.`id` DESC ") ;

$tx = mysqli_fetch_array($qbarang) ;


if($akhir == "" ) {
$qbx = mysqli_query($conn,"SELECT * FROM `alokasi_stok_jual` INNER JOIN lokasi on alokasi_stok_jual.id_gudang = lokasi.id_lokasi WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' and jumlah != 0 ORDER BY `alokasi_stok_jual`.`id` ASC ") ;

$jumlah = mysqli_query($conn,"SELECT sum(jumlah) as jumlah FROM `alokasi_stok_jual` INNER JOIN lokasi on alokasi_stok_jual.id_gudang = lokasi.id_lokasi WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' and jumlah != 0 ORDER BY `alokasi_stok_jual`.`id` ASC ") ;
}
else
{
  
  if($awal == "") {
      //mencari tanggal awal
      $qtawal = mysqli_query($conn,"SELECT * FROM `alokasi_stok_jual` WHERE `id_gudang` = 5 AND `kode_barang` LIKE 'sg0002' ORDER BY `alokasi_stok_jual`.`id` ASC ") ;
      $tawal = mysqli_fetch_array($qtawal) ;
      //echo $tawal["no_faktur"]
      $awalx = strtotime(date($tawal["no_faktur"])) ;
  }
  else
  {
  $awalx = strtotime(date($awal)) ;
  }
  
  $akhirx = strtotime(date($akhir)) ;

 //echo $awalx ."<br>" ;
 //echo $akhirx . "<br>" ;

  



  $qbx = mysqli_query($conn,"SELECT * FROM `alokasi_stok_jual` INNER JOIN lokasi on alokasi_stok_jual.id_gudang = lokasi.id_lokasi WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' and jumlah != 0 and no_faktur BETWEEN '$awalx' and '$akhirx' ORDER BY `alokasi_stok_jual`.`id` ASC ") ;

  $jumlah = mysqli_query($conn,"SELECT sum(jumlah) as jumlah FROM `alokasi_stok_jual` INNER JOIN lokasi on alokasi_stok_jual.id_gudang = lokasi.id_lokasi WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' and jumlah != 0 and no_faktur BETWEEN '$awalx' and '$akhirx' ORDER BY `alokasi_stok_jual`.`id` ASC ") ;
}




$jumlahx = mysqli_fetch_array($jumlah) ;


if($jumlahx["jumlah"] == 0 ) {
  echo "<script>alert('Maaf , Data Tidak Ditemukan')</script>" ;
  echo "<script>window.location='storystok.php'</script>" ;
}



//$tx = mysqli_fetch_array($qbx) ;
$total = mysqli_num_rows($qbx) ;

?>

<div class="container">
  
  <h3>Alokasi Stok </h3>
  <div class="alert alert-info">
  <p>Kode Barang : <?php echo $tx["kode_barang"] ?></p>     
  <p>Nama  Barang : <?php echo $tx["nama_barang"] ?> </p>  
  <p>Lokasi  : <?php echo $tx["nama"] ?> </p>     
  
  <?php 
  if($akhir == "") {
   
    echo ' <p>Tanggal   : Semua Alokasi Stok </p>' ;
  }
  else
  {
    echo ' <p>Tanggal Mulai '.$awal .' Sampai Dengan  ' .$akhir  ;
  }
  ?>
 


  </div>

<div class="alert alert-warning">


Jumlah Alokasi Terjual = <?php echo $jumlahx["jumlah"]  ?>  <a href='' data-toggle='modal' data-target='#myModal2'>( Lihat Alokasi Stok Terjual )</a><br>
Jumlah Alokaasi Stok  = <?php 
//mengambi stok fisik dari database alokasi stok

$qalokasistok = mysqli_query($conn,"SELECT * FROM `alokasi_stok` WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' ORDER BY `alokasi_stok`.`id` ASC ") ;

while ( $tas = mysqli_fetch_array($qalokasistok)) {
  $total_stok_fisil += $tas["jumlah"] ;

}

echo $total_stok_fisil ." ( <a href='' data-toggle='modal' data-target='#myModal'>Lihat Alokasi Stok </a>  ) ";

?>
<br>
Open Stok = <?php
$sisak = $total_stok_fisil - $jumlahx["jumlah"] ;
echo $sisak ;
?>
</div>



<!-- Modal Alokasi Stok -->
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Alokasi Stok Terjual <?php echo $tx["kode_barang"] ?> <?php echo $tx["nama_barang"] ?></h4>
        </div>
        <div class="modal-body">

Total Alokasi Transaksi = <?php echo $total ?> <br>
  <table class="table table-bordered" id="table_id">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>No Faktur</th>
        <th>Distributor</th>
        
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      
    <?php 

    while ( $tampil = mysqli_fetch_array($qbx)) {
    ?>
      <tr>
        <td><?php 
        //tangal
        $nf = $tampil["no_faktur"] ;
        echo date("Y-m-d",$nf) ;
        
        ?></td>
        <td><?php echo $tampil["no_faktur"] ?></td>
        <td><?php echo $tampil["distributor"] ?></td>
       
        <td><?php echo $tampil["jumlah"] ?></td>
      </tr>
     
     <?php 
    }
    ?> 
<?php echo "Jumlah Alokasi Jual : ". $jumlahx["jumlah"]  ?> <br>
<hr>

    </tbody>
  </table>
</div>

</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>



<?php 


}  //penutf if induk


?>






</body>

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );</script>

<script>

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>


<!-- Modal content stok-->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Alokasi Stok <?php echo $tx["kode_barang"] ?> <?php echo $tx["nama_barang"] ?></h4>
        </div>
        <div class="modal-body">
          
        <table class="table table-striped">
    <thead>
      <tr>
        <th>Pintu Gudang</th>
        <th>Distributor</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
<?php
$qalokasistok2 = mysqli_query($conn,"SELECT * FROM `alokasi_stok` WHERE `id_gudang` = '$id_gudang' AND `kode_barang` LIKE '$kode_barang' ORDER BY `alokasi_stok`.`id` ASC ") ;
while ( $talokasi = mysqli_fetch_array($qalokasistok2)) {

?>
      <tr>
        <td><?php echo $talokasi["pintu_gudang"] ?></td>
        <td><?php echo $talokasi["distributor"] ?></td>
        <td><?php echo $talokasi["jumlah"] ?></td>
      </tr>

      <?php 
}
?>


    </tbody>
  </table>  

<?php
echo "Total Jumlah Stok : ".$total_stok_fisil ;
?>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>