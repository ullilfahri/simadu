<?php
$tanggal   = date("Y-m-d")  ;
//$tanggal = "2020-04-02" ;
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
(function($){$("html").removeClass("v2");
$("#header").ready(function(){
$("#progress-bar").stop().animate({ width: "25%" },1500) });
$("#footer").ready(function(){
$("#progress-bar").stop().animate({ width: "75%" },1500) });
$(window).load(function(){
$("#progress-bar").stop().animate({ width: "100%" },600,function(){
$("#loading").fadeOut("fast",function(){
$(this).remove();
});
});
});
})(jQuery);
</script>

<style type="text/css" media="all">
#loading {
position: fixed;
z-index: 9999;
top: 0;
left: 0;
width: 100%;
height: 10px;
line-height: 350px;
text-align: center;
padding-top:70px;
font:bold 50px Calibri,Arial,Sans-Serif;
color: #0000ff;
}
.v2 #loading {
display: none
}
#progress-bar {
position: absolute;
top: 0;
left: 0;
z-index: 9999;
background-color:rgba(0,0,200,0.8);
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
filter: alpha(opacity=80);
opacity: 0.8;
width: 0;
height: 10px;
}

#loader {
top:0;
left:0;
width:100%;
height: 10px;
position:fixed;
display: block;
color:#FFCC66;
background: #ffffff;
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
filter: alpha(opacity=80);
opacity: 0.8;
}
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