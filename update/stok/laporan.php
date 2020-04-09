<?php
include '../../sysconfig.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
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
$tanggal   = date("Y-m-d")  ;
//$tanggal = "2020-02-14" ;

echo $tanggal ;

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
                
                <th>Stok Awal (H-1)</th>
                <th>Pembelian Stok Masuk</th>
                <th>Pembelian Stok Masuk Alokasi</th>
                <th>Retur Stok Masuk</th>
                <th>Retur Stok Masuk Alokasi</th>
                <th>Penjualan Stok Keluar Booking</th>
                <th>Penjualan Stok Keluar Surat Jalan</th>
                <th>Stok Akhir Manual</th>
                <th>Stok By Sistem</th>
                <th>Nama Gudang</th>
                
            </tr>
        </thead>
        <tbody>

        <?php 
            $qstok = mysqli_query($conn,"SELECT DISTINCT(id_gudang), SUM(jumlah) as total ,kode_barang ,nama_barang ,distributor FROM `alokasi_stok` GROUP BY kode_barang ,id_gudang ORDER BY `alokasi_stok`.`kode_barang` ASC ") ;
            while ( $ts = mysqli_fetch_array($qstok)) {
                $id_gudang = $ts["id_gudang"] ;
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $ts["total"] ?></td>
                <td><?php 
                //idgudang
               
                $qs = mysqli_query($conn,"SELECT * FROM `lokasi` WHERE `id_lokasi` = '$id_gudang' ") ;
                $ts = mysqli_fetch_array($qs) ;
                echo $ts["nama"] ;
                ?></td>
                
            </tr>

            <?php
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