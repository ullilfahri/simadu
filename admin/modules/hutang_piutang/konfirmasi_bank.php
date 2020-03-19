
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
if (isset($_GET['approve'])) {
$bank=$conn->query("SELECT * FROM tabel_bayar where id IN (select id_bayar from konfirmasi_bank) and kode_bayar > 1 ORDER BY no_faktur DESC");
$ket='SUDAH';
$jumlah=$bank->num_rows;
$tombol='<a href="konfirmasi_bank.php?not_approve"><button type="button" class="btn btn-warning waves-effect"><i class="fa fa-exclamation fa-lg"></i><span>Tampilkan Data Belum Dikonfirmasi</span></button></a>';
$is_confirm='Do Cancelled';
$tipe='danger';
  echo '<script type="text/javascript">';
  echo 'setTimeout(function () { swal("Perhatian..!","Terdapat '.$jumlah.' Data Yang Sudah Dikonfirmasi","success");';
  echo '}, 1000);</script>';
} else {
$bank=$conn->query("SELECT * FROM tabel_bayar where id NOT IN (select id_bayar from konfirmasi_bank) and kode_bayar > 1 ORDER BY no_faktur DESC");
$ket='BELUM';
$jumlah=$bank->num_rows;
$tombol='<a href="konfirmasi_bank.php?approve"><button type="button" class="btn btn-bg btn-info waves-effect"><i class="fa fa-check-square fa-lg"></i><span>Tampilkan Data Sudah Dikonfirmasi</span></button></a>';
$is_confirm='Do Confirm..!';
$tipe='success';
  echo '<script type="text/javascript">';
  echo 'setTimeout(function () { swal("Perhatian..!","Terdapat '.$jumlah.' Data Yang Belum Dikonfirmasi","error");';
  echo '}, 1000);</script>';
}
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PEMBAYARAN VIA TRANSFER BANK 
                            </h2>
                            <small><?=$ket?> DILAKUKAN KONFIRMASI</small>
                            <br><br>
                            <?=$tombol?>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Customer</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Penjualan</th>
                                            <th>Terbayar</th>
                                            <th>Is Confirm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$bank->fetch_array()) :
									$customer=$conn->query("select nama from tabel_customer where id='".$x['customer']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$customer[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo(date('Y-m-d'), $x['no_faktur'])?></td>
                                            <td><?=angka($x['jumlah_transaksi'])?></td>
                                            <td><?=angka($x['jumlah_bayar'])?></td>
                                            <td><button type="button" class="btn btn-<?=$tipe?> btn-sm" onClick="confirm_modal('form_crud.php?konfirmasi=<?=$tipe?>&modal_id=<?=$x['id']?>');"><?=$is_confirm?></button></td>
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
        <h4 class="modal-title" style="text-align:center;"><?=$is_confirm?></h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-warning" id="delete_link"><?=$is_confirm?></a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Exit</button>
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