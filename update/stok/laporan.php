<?php
$tanggal   = date("Y-m-d")  ;
//$tanggal = "2020-04-02" ;

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Laporan_".$tanggal.".xls"); 


session_start() ;
include '../../sysconfig.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php flush() ?>
  <title>Laporan Stok Barang</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>


<script>
document.onreadystatechange = function () {
if (document.readyState === "complete") {
console.log(document.readyState);
document.getElementById("PreLoaderBar").style.display = "none";
}
}
</script>

<style type="text/css">
  .progress {
  position: relative;
  height: 2px;
  display: block;
  width: 100%;
  background-color: white;
  border-radius: 2px;
  background-clip: padding-box;
  /*margin: 0.5rem 0 1rem 0;*/
overflow: hidden;


 }
  .progress .indeterminate {
  background-color:black; }
  .progress .indeterminate:before {
  content: '';
  position: absolute;
  background-color: #2C67B1;
  top: 0;
  left: 0;
  bottom: 0;
  will-change: left, right;
  -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
  animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite; }
  .progress .indeterminate:after {
  content: '';
  position: absolute;
  background-color: #2C67B1;
  top: 0;
  left: 0;
  bottom: 0;
  will-change: left, right;
  -webkit-animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
  animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
  -webkit-animation-delay: 1.15s;
animation-delay: 1.15s; }

 @-webkit-keyframes indeterminate {
  0% {
  left: -35%;
  right: 100%; }
  60% {
  left: 100%;
  right: -90%; }
  100% {
  left: 100%;
  right: -90%; } }
  @keyframes indeterminate {
  0% {
  left: -35%;
  right: 100%; }
  60% {
  left: 100%;
  right: -90%; }
  100% {
  left: 100%;
  right: -90%; } }
  @-webkit-keyframes indeterminate-short {
  0% {
  left: -200%;
  right: 100%; }
  60% {
  left: 107%;
  right: -8%; }
  100% {
  left: 107%;
  right: -8%; } }
  @keyframes indeterminate-short {
  0% {
  left: -200%;
  right: 100%; }
  60% {
  left: 107%;
  right: -8%; }
  100% {
  left: 107%;
  right: -8%; } }
</style>




</head>

<body>

<h1>Laporan Stok Barang</h1>
<h2>Tanggal : <?php 



echo $tanggal ;


$hmin1 = date("Y-m-d",strtotime('-1 days',strtotime($tanggal))) ;
$th1 = strtotime(date($hmin1)) ;

$hplus1 = date("Y-m-d",strtotime('1 days',strtotime($tanggal))) ;   
$tp = strtotime(date($hplus1)) ;

?>
</h2>
<div class="progress" id="PreLoaderBar">
Sedang Download Data
<div class="indeterminate"></div>
</div>
<hr>
<div class="container">
    
    <table class="table table-bordered table-hover" id="table_id">
        <thead>
            <tr>
             
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Dist. Code</th>
                <th>Satuan</th>
                
                <th>Stok Awal (<?php echo $hmin1 ?>)</th>
                <th>Pembelian Stok Masuk</th>
                <th>Pembelian Stok Masuk Alokasi</th>
                <th>Retur Stok Masuk</th>
                <th>Retur Stok Masuk Alokasi</th>
                <th>Penjualan Stok Keluar Booking ( Kasir )</th>
                <th>Penjualan Stok Keluar Surat Jalan</th>
                <th>Stok Akhir <?php echo $tanggal  ?></th>
                
                <th>Nama Gudang</th>
                
            </tr>
        </thead>
        <tbody>

        <?php 

            /*
            $qstok = mysqli_query($conn,"SELECT DISTINCT(id_gudang), SUM(jumlah) as total ,kode_barang ,nama_barang ,distributor FROM `alokasi_stok` GROUP BY kode_barang ,id_gudang HAVING SUM(jumlah) != 0 ORDER BY `alokasi_stok`.`kode_barang` ASC") ;

YANG DIPAKAI
             $qstok = mysqli_query($conn,"SELECT DISTINCT(id_gudang) ,kode_barang ,nama_barang ,distributor FROM `alokasi_stok` GROUP BY kode_barang ,id_gudang ORDER BY `alokasi_stok`.`kode_barang` ASC ") ;
        */
            $qstok = mysqli_query($conn,"SELECT DISTINCT(id_gudang) ,kode_barang ,nama_barang ,distributor FROM `alokasi_stok` GROUP BY kode_barang ,id_gudang ORDER BY `alokasi_stok`.`kode_barang` ASC  ") ;

            $totaldata = mysqli_num_rows($qstok) ;
            echo "Total Data : ".$totaldata ."<br>";
            //echo $datake ;
            $timerrr = $totaldata / 17 / 60 ;
            echo " ( Perkiraan Download Data : ". number_format($timerrr,0)." Menit ) " ; 
            echo "<hr>" ;
            $no = $totaldata ;

            while ( $ts = mysqli_fetch_array($qstok)) {
                $id_gudang = $ts["id_gudang"] ;
                //$_SESSION['nomor'] = $no++ ;
                //$datake = $no-- ;
                //echo substr($datake,-4 ) ;
               // echo "." ;
        ?>      
            <tr>
               
                <td><?php echo $ts["kode_barang"] ?></td>
                <td><?php echo $ts["nama_barang"] ?></td>
                <td><?php echo $ts["distributor"] ?></td>
                <td><?php 
                //mengambil satuan barang
                $kode_barang = $ts["kode_barang"] ;
                $qsb = mysqli_query($conn,"SELECT * FROM `stok_barang` WHERE `kode_barang` LIKE '$kode_barang' ") ;
                $tsb = mysqli_fetch_array($qsb) ;
                echo $tsb["satuan"] ;
                
                ?></td>
               
                <td></td>
                <td><?php
                //mengambil stok barag
                
                 
                $qpembelian = mysqli_query($conn,"SELECT sum(jumlah) as jumlah FROM `tabel_pembelian` INNER JOIN pembelian_sementara on tabel_pembelian.id_pembelian = pembelian_sementara.id_pembelian WHERE kode_barang = '$kode_barang' and tgl_nota = '$tanggal' ORDER BY `tabel_pembelian`.`tgl_nota` ASC ") ;
                

                    /*
                $qpembelian = mysqli_query($conn,"SELECT sum(jumlah) as jumlah FROM `tabel_pembelian` INNER JOIN pembelian_sementara on tabel_pembelian.id_pembelian = pembelian_sementara.id_pembelian WHERE kode_barang = '$kode_barang'  ORDER BY `tabel_pembelian`.`tgl_nota` ASC ") ;
                    */
                $tpembelian = mysqli_fetch_array($qpembelian) ;
                echo $tpembelian["jumlah"] ;


                ?></td>
                <td>
                    <?php
            //pembelian stok masuk alokasi
            
            $qbarangmasuk = mysqli_query($conn,"SELECT sum(jumlah) as totalbarangmasuk FROM `barang_masuk` WHERE `tgl_nota` = '$tanggal' and kode_barang = '$kode_barang' and id_gudang = '$id_gudang' ORDER BY `tgl_nota` DESC ") ;
            
            $tbarangmasuk = mysqli_fetch_array($qbarangmasuk) ;
            echo $tbarangmasuk["totalbarangmasuk"] ;



                    ?>

                </td>
                <td><?php
                //retur stok masuk
                    
                    $qreturmasuk = mysqli_query($conn,"SELECT sum(jumlah_barang) as jumlah_barang FROM `tabel_retur` WHERE `kode_barang` LIKE '$kode_barang' and tanggal like '%$tanggal%' and gudang_tujuan = '$id_gudang' ORDER BY `tabel_retur`.`id` DESC ") ;
                    $tretusmasuk = mysqli_fetch_array($qreturmasuk) ;
                    echo $tretusmasuk["jumlah_barang"] ;
                    
                ?></td>
                <td>

                        <?php
                   //retur alokasi
                   $qreturmasuk = mysqli_query($conn,"SELECT sum(is_alokasi) as jumlah_barang_alokasi FROM `tabel_retur` WHERE `kode_barang` LIKE '$kode_barang' and tanggal like '%$tanggal%' and gudang_tujuan = '$id_gudang' ORDER BY `tabel_retur`.`id` DESC ") ;
                   $tretusmasuk = mysqli_fetch_array($qreturmasuk) ;
                   echo $tretusmasuk["jumlah_barang_alokasi"] ;
                        ?>

                </td>
                <td><?php
                //penjualan booking dari kasir

               
                    
                $qkasir = mysqli_query($conn,"SELECT SUM(jumlah) AS totalpenjualan FROM `tabel_trx` WHERE kode_barang = '$kode_barang' AND id_gudang = '$id_gudang' and `no_faktur` BETWEEN '$th1' and '$tp' ") ;


                $tkasir = mysqli_fetch_array($qkasir) ;
                echo $tkasir["totalpenjualan"] ;
                
                ?></td>
                <td>
                    <?php
                    //barang keluar alokasi
                    $qbarangkeluar = mysqli_query($conn,"SELECT sum(is_ambil) as barangkeluar FROM `barang_keluar` WHERE `kode_barang` LIKE '$kode_barang' and id_gudang = '$id_gudang' and no_faktur BETWEEN '$th1' and '$tp' ") ;
                    $tbarangkeluar = mysqli_fetch_array($qbarangkeluar) ;
                    echo $tbarangkeluar["barangkeluar"] ;


                ?></td>
                <td>
                    <?php
                //echo total stok
                   //stok awal beulum dibuat 

                   $pembelianstokmasuk = $tbarangmasuk["totalbarangmasuk"] ;
                   $returalokasi = $tretusmasuk["jumlah_barang_alokasi"] ;
                   
                    $pejualanalokasi = $tbarangkeluar["barangkeluar"] ; 

                    $totalstok = $pembelianstokmasuk + $returalokasi + $pejualanalokasi ;
                    echo $totalstok ;

                    ?>
                </td>
                
                <td><?php 
                //idgudang
               
                $qs = mysqli_query($conn,"SELECT * FROM `lokasi` WHERE `id_lokasi` = '$id_gudang' ") ;
                $ts = mysqli_fetch_array($qs) ;
                echo $ts["nama"] ;
                ?></td>
                
            </tr>

            <?php
            //flush();
            //ob_flush();
           // sleep(1);
            }
            ?>

            
        </tbody>
    </table>
    
</div>
</body>


<script>
    $(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>