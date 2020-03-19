
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['sub_level']!=4) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
?>
<?php include DOT.'partial/theme.php';?>
    <!-- Page Loader -->
<?php include DOT.'partial/preloader.php';?>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
<?php include DOT.'partial/overlay.php';?>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
<?php include DOT.'partial/top_bar.php';?>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include DOT.'partial/left_sidebar.php';
if (isset($_GET['hari_ini'])) {
$awal=strtotime(date('Y-m-d 00:00:00'));
$akhir=strtotime(date('Y-m-d 23:59:59'));
$gudang=$conn->query("SELECT * from ambil_barang where id_pengambilan BETWEEN $awal and $akhir AND id_barang_keluar IN (SELECT id FROM barang_keluar WHERE no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE id_toko='".$_SESSION['toko']."'))  order by id_barang_keluar, id ASC");
$ket='HARI INI';
} else if (isset($_GET['cari_tanggal'])) {
$awal = date_create_from_format('l d F Y', $_GET['awal']);
$awal=strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$akhir = date_create_from_format('l d F Y', $_GET['akhir']);
$akhir=strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$gudang=$conn->query("SELECT * from ambil_barang where id_pengambilan BETWEEN $awal and $akhir AND id_barang_keluar IN (SELECT id FROM barang_keluar WHERE no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE id_toko='".$_SESSION['toko']."'))  order by id_barang_keluar, id ASC");
$ket='PERIODE '.tanggal_indo(date('Y-m-d', $awal)).' s.d '.tanggal_indo(date('Y-m-d', $akhir));

} else {
$gudang=$conn->query("SELECT * FROM ambil_barang WHERE id_barang_keluar IN (SELECT id FROM barang_keluar WHERE no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur = '".$_GET['no_faktur']."' AND id_toko='".$_SESSION['toko']."')) order by id_pengambilan ASC");
$ket='No Faktur Penjualan '.$_GET['no_faktur'];
}


?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Transaksi</a></li>
			</ol>


            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CARI DATA PENGAMBILAN BARANG BERDASARKAN NOMOR FAKTUR PENJUALAN
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_faktur" class="form-control" placeholder="Masukan Nomor Faktur" required>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-12">
                                            <button type="submit" name="cari_faktur" class="btn btn-info waves-effect">
                                    		<i class="fa fa-search"></i>
                                			Tampilkan</button>
                                </div>
                                
                             </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->
            
            
            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CARI DATA PENGAMBILAN BARANG BERDASARKAN TANGGAL
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="awal" class="datepicker form-control" placeholder="Tanggal dsn Waktu Awal" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="akhir" class="datepicker form-control" placeholder="Tanggal dan Waktu Akhir" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                            <button type="submit" name="cari_tanggal" class="btn btn-info waves-effect">
                                    		<i class="fa fa-search"></i>
                                			Tampilkan</button>
                                </div>
                                
                             </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->


            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR PENGAMBILAN BARANG
                                <small><?=$ket?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-tes">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NO FAKTUR</th>
                                            <th>QTY BELI</th>
                                            <th>SATUAN</th>
                                            <th>TGL PEMBELIAN</th>
                                            <th>HARGA SATUAN</th>
                                            <th>DISKON</th>
                                            <th>SPESIAL DISKON</th>
                                            <th>TOTAL</th>
                                            <th>QTY RETUR</th>
                                            <th>CUSTOMER</th>
                                            <th>CETAK</th>
                                            <th>NO SURAT JALAN</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY AMBIL</th>
                                            <th>SATUAN</th>
                                            <th>QTY Retur / SJ</th>
                                            <th>QTY Realisasi</th>
                                            <th>Harga Per Item</th>
                                            <th>TGL AMBIL</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>OUTLET</th>
                                            <th>GUDANG</th>
                                            <th>PINTU/RAK/RUANG</th>
                                            <th>KASIR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$gudang->fetch_array()):
									$kasir=$conn->query("SELECT a.id_kasir, b.nama FROM barang_keluar AS a LEFT JOIN user AS b ON a.id_kasir = b.id WHERE a.id ='".$x['id_barang_keluar']."'")->fetch_array();
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									
									$gudang_sql=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();

									$fak=$conn->query("SELECT no_faktur, kode_barang, nama_barang, satuan FROM barang_keluar where id = '".$x['id_barang_keluar']."' ")->fetch_array();
									
									$cst=$conn->query("SELECT customer, cus_umum, id_toko from tabel_faktur where no_faktur = '".$fak[0]."' ")->fetch_array();
									if ($cst[0] > 0) {
									$tetap=$conn->query("SELECT nama FROM tabel_customer where id = '$cst[0]' ")->fetch_array();
									$pelanggan=$tetap[0];
									} else {
									$arr = json_decode($cst[1], true);
									$pelanggan=$arr["umum"]["nama"];
									}
									
									if ($x['partial'] > 0) {
										$srt_jalan=$fak[0].'-'.surat_jalan($x['partial']);
										} else {
										$srt_jalan=$fak[0];
										}
									$file=$x['id_pengambilan'].'.pdf';	
									
									$harga=$conn->query("SELECT * FROM tabel_trx WHERE no_faktur='".$fak[0]."' AND kode_barang='".$fak[1]."' ")->fetch_array();
									$retur=$conn->query("SELECT SUM(jumlah_barang) FROM tabel_retur WHERE no_faktur='".$fak[0]."' AND kode_barang='".$fak[1]."' ")->fetch_array();
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi='".$cst[2]."'")->fetch_array();
										
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$fak[0]?></td>
                                            <td><?=$harga['jumlah']?></td>
                                            <td><?=$harga['satuan']?></td>
                                            <td><?=tanggal_indo(date('Y-m-d',$fak[0]))?></td>
                                            <td><?=angka($harga['harga_barang'])?></td>
                                            <td><?=angka($harga['potongan']/$harga['jumlah'])?></td>
                                            <td><?=angka($harga['spc_diskon'])?></td>
                                            <td><?=angka($harga['sub_total'])?></td>
                                            <td><?=$retur[0]?></td>
                                            <td><?=$pelanggan?></td>
                                            <td><a href="../pdf_viewer/index.php?dir=surat_jalan&file=<?=$file?>" target="_blank">
											<button type="button" class="btn bg-deep-purple waves-effect"><i class="fa fa-print"></i><span></span></button>
											</a></td>
                                            <td><?=$srt_jalan?></td>
                                            <td><?=$fak[1]?></td>
                                            <td><?=$fak[2]?></td>
                                            <td><?=$x['jumlah_ambil']?></td>
                                            <td><?=$fak[3]?></td>
                                            <td><?=$x['jumlah_ambil']-$retur[0]?></td>
                                            <td><?=$x['jumlah_ambil']-$retur[0]?></td>
                                            <td><?=$harga['harga_barang']-($harga['potongan']/$harga['jumlah'])?></td>
                                            <td><?=tanggal_indo(date('Y-m-d',$x['id_pengambilan']))?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=$gudang_sql[0]?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$kasir[1]?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->

                    
            </div>
    </section>
    <!-- Jquery Core Js -->
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?=PLG?>bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
    <!-- Autosize Plugin Js -->
    <script src="<?=PLG?>autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?=PLG?>jquery-countto/jquery.countTo.js"></script>
    
    <!-- Sparkline Chart Plugin Js -->
    <script src="<?=PLG?>jquery-sparkline/jquery.sparkline.js"></script>
            
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?=PLG?>jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?=PLG?>jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
<script type="application/javascript">

$(function () {
			
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 || column === 6 || column === 7 || column === 8 || column === 18  ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.js-tes').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24 ]
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]

    });
	
	
});

</script>    
    
</body>

</html>