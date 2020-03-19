
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] !=3) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../kasir'</script>";
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
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-university fa-lg"></i> Konfirmasi Transfer Bank</a></li>
			</ol>  
<?php
$kasir=$_GET['id_kasir'];
$toko=$_GET['toko'];
$awal=strtotime(date('Y-m-d 00:00:00'));
$akhir=strtotime(date('Y-m-d 23:59:59'));
	switch ($_GET['klasifikasi']) {
	case 'jual_tunai':
	$qry="SELECT * FROM tabel_faktur where no_faktur BETWEEN $awal and $akhir AND id_toko = '$toko' AND kasir LIKE '%$kasir%' AND metode_bayar=0 AND uang_muka > 0";
	break;
	case 'jual_transfer':
	$qry="SELECT * FROM tabel_faktur where no_faktur BETWEEN $awal and $akhir AND id_toko = '$toko' AND kasir LIKE '%$kasir%' AND metode_bayar=0 AND dalam_bank > 0";
	break;
	case 'jual_hutang':
	$qry="SELECT * FROM tabel_faktur where no_faktur BETWEEN $awal and $akhir AND id_toko = '$toko' AND kasir LIKE '%$kasir%' AND metode_bayar=1 AND hutang > 0";
	break;
	default:
	$qry="SELECT * FROM tabel_faktur where no_faktur BETWEEN $awal and $akhir AND id_toko = '$toko' AND kasir LIKE '%$kasir%' AND total_trx > 0";
	break;
	}
$trx=$conn->query("$qry");	
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                RINCIAN LAPORAN TRANSAKSI HARI INI (<?=$hari[date("N")].', '.tanggal_indo(date('Y-m-d'))?>)
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kasir</th>
                                            <th>No Faktur</th>
                                            <th>Waktu Transaksi</th>
                                            <th>Customer</th>
                                            <th>Total Transaksi</th>
                                            <th>Tunai</th>
                                            <th>Transfer</th>
                                            <th>Hutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									
									$no=1;
									while ($x=$trx->fetch_array()) :
									$user=$conn->query("select nama from user where id='$x[kasir]'")->fetch_array();
									$pecah=date('H:i',$x['no_faktur']);
									$tgl=$pecah;
									if ($x['customer'] > 0) {
										$cst_sql=$conn->query(" SELECT nama from tabel_customer where id= '$x[customer]' ")->fetch_array();
										$cst=$cst_sql[0];
										} else {
										$arr = json_decode($x['cus_umum'], true);
										$cst='Umum, '.$arr["umum"]["nama"];
									}	 
									
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$user[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$cst?></td>
                                            <td><?=angka($x['total_trx']-$x['jumlah_diskon'])?></td>
                                            <td><?=angka(intval($x['uang_muka']))?></td>
                                            <td><?=angka(intval($x['dalam_bank']))?></td>
                                            <td><?=angka(intval($x['hutang']))?></td>
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

    <!-- Select Plugin Js -->
    <script src="<?=PLG?>bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Multi Select Plugin Js -->
    <script src="<?=PLG?>multi-select/js/jquery.multi-select.js"></script>
    <!-- Input Mask Plugin Js -->
    <script src="<?=JS?>my.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>
    
    <!-- Jquery Spinner Plugin Js -->
    <script src="<?=PLG?>jquery-spinner/js/jquery.spinner.js"></script>


    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    
    <!-- Light Gallery Plugin Js -->
    <script src="<?=PLG?>light-gallery/js/lightgallery-all.js"></script>


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
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
</body>

</html>