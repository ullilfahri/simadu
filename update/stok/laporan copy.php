<?php
$tanggal   = date("Y-m-d")  ;
//$tanggal = "2020-02-09" ;
/*
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Laporan_".$tanggal.".xls"); 
*/

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
                <th>Stok Akhir Manual</th>
                
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
            $qstok = mysqli_query($conn,"SELECT DISTINCT(id_gudang) ,kode_barang ,nama_barang ,distributor FROM `alokasi_stok` where kode_barang = 'SA0003' GROUP BY kode_barang ,id_gudang ORDER BY `alokasi_stok`.`kode_barang` ASC ") ;

            $totaldata = mysqli_num_rows($qstok) ;
            echo "Total Data : ".$totaldata ."<br>";
            echo $datake ;
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
                    /*
                    $qreturmasuk = mysqli_query($conn,"SELECT sum(jumlah_barang) as jumlah_barang FROM `tabel_retur` WHERE `kode_barang` LIKE '$kode_barang' and tanggal like '%$tanggal%' and gudang_tujuan = '$id_gudang' ORDER BY `tabel_retur`.`id` DESC ") ;
                    $tretusmasuk = mysqli_fetch_array($qreturmasuk) ;
                    echo $tretusmasuk["jumlah_barang"] ;
                    */
                ?></td>
                <td></td>
                <td><?php
                //penjualan booking dari kasir

               
                    
                $qkasir = mysqli_query($conn,"SELECT SUM(jumlah) AS totalpenjualan FROM `tabel_trx` WHERE kode_barang = '$kode_barang' AND id_gudang = '$id_gudang' and `no_faktur` BETWEEN '$th1' and '$tp' ") ;


                $tkasir = mysqli_fetch_array($qkasir) ;
                echo $tkasir["totalpenjualan"] ;
                
                ?></td>
                <td>
                    <?php
                    //barang keluar
                    $qbarangkeluar = mysqli_query($conn,"SELECT sum(is_ambil) as barangkeluar FROM `barang_keluar` WHERE `kode_barang` LIKE '$kode_barang' and id_gudang = '$id_gudang' and no_faktur BETWEEN '$th1' and '$tp' ") ;
                    $tbarangkeluar = mysqli_fetch_array($qbarangkeluar) ;
                    echo $tbarangkeluar["barangkeluar"] ;


                ?></td>
                <td></td>
                
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