
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] !=2) :
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
$kas=$conn->query("SELECT * FROM `konfirmasi_bank` WHERE `distributor` = '".$_SESSION['distributor']."'");
$tot_masuk=$conn->query("select SUM(jumlah_bayar) FROM `konfirmasi_bank` WHERE `distributor` = '".$_SESSION['distributor']."' and jenis=1")->fetch_array();
$tot_keluar=$conn->query("select SUM(jumlah_bayar) FROM `konfirmasi_bank` WHERE `distributor` = '".$_SESSION['distributor']."' and jenis=2")->fetch_array();
$total_pemasukan=$tot_masuk[0];
$total_pengeluaran=$tot_keluar[0];
$saldo=$total_pemasukan-$total_pengeluaran;
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                KAS PADA BANK
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User Approve</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal Approve</th>
                                            <th>Pemasukan</th>
                                            <th>Pengeluaran</th>
                                            <th>Keterangan</th>
                                            <th>Sumber</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th colspan="1"><?=rupiah($total_pemasukan)?></th>
                                            <th colspan="3"><?=rupiah($total_pengeluaran)?></th>
                                        </tr> 
                                        <tr>
                                            <th colspan="3">SALDO :</th>
                                            <th><?=rupiah($saldo)?></th>
                                            <th colspan="4"><?=ucwords(Terbilang($saldo))?> Rupiah</th>
                                        </tr>    
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$kas->fetch_array()) :
									$user=$conn->query("select nama from user where id='".$x['user_approve']."'")->fetch_array();
									$pecah=explode(' ',$x['tgl_approve']);
									$tgl=tanggal_indo($pecah[0]).', Jam '.$pecah[1];
									if ($x['id_toko']>0) {
									$toko_sql=$conn->query("select nama from lokasi where id_lokasi='".$x['id_toko']."'")->fetch_array();
									$toko=$toko_sql[0];
									} else {
									$toko='manual';
									}
									if ($x['jenis']==1) {
									$pemasukan=angka($x['jumlah_bayar']);
									$pengeluaran='-';
									} else {
									$pemasukan='-';
									$pengeluaran=angka($x['jumlah_bayar']);
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$user[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$pemasukan?></td>
                                            <td><?=$pengeluaran?></td>
                                            <td><?=ucwords($x['keterangan'])?></td>
                                            <td><?=strtoupper($toko)?></td>
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
            
<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Hapus ?</h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal Delete-->
                 
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
<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
<!--Akhir Javasrip Modal Delete-->  

</body>

</html>