<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']!=2) :
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
$awal=date('d-m-Y');
$akhir=date('d-m-Y');
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Pengeluaran</a></li>
			</ol>  
            
            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SUMMARY PENGELUARAN
                            </h2>
                        </div>
                        <div class="body">
                        
								<form name="form_sortir"  id="form_sortir" name="form_sortir">
								<input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
                                    
									<div class="col-md-6">
										<p><b>Tanggal Awal</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<input type="text" name="awal" class="datepicker form-control" placeholder="Masukan Tanggal Awal" required>
                                                </div>
                                        	</div>
									</div>
                                    
									<div class="col-md-6">
										<p><b>Tanggal Akhir</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<input type="text" name="akhir" class="datepicker form-control" placeholder="Masukan Tanggal Akhir" required>
                                                </div>
                                        	</div>
									</div>
                                    
								<button type="button" onclick="return tampil();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-search fa-1.5x"></i>
								<span>Cari</span>
								</button>
								</form>   
								</div>
                  
                   </div> 
				</div>
			</div>
            <!-- #END# Advanced Select -->            

            
     <div class="data_paginasi"></div>

            
<!-- Default Size -->
            <div class="modal fade biaya" id="ModalBiaya" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">RINCIAN PENGELUARAN</h4>
                        </div>
                        <div class="modal-body">
                            <div class="ambil-biaya"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-teal waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
<!-- Default Size -->
            
<!-- Default Size -->
            <div class="modal fade upload" id="ModalUpload" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Upload File</h4>
                        </div>
                        <div class="modal-body">
                            <div class="ambil-upload"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-teal waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
<!-- Default Size -->
            


                 
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
    
    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>



    <!-- Jquery DataTable Plugin Js -->
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
	<script src="<?=PLG?>jsgrid/bootstrap-editable.min.js"></script>
    <script src="<?=PLG?>editable/bootstrap-editable.js"></script>
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
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.biaya').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?rinci_beli',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.ambil-biaya').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.upload').on('show.bs.modal', function (e) {
            var id_pembelian = $(e.relatedTarget).data('id');
            var distributor = $(e.relatedTarget).data('distributor');
            var awal = $(e.relatedTarget).data('awal');
            var akhir = $(e.relatedTarget).data('akhir');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?modal_upload',
                data :  'id_pembelian='+id_pembelian+'&distributor='+distributor+'&awal='+awal+'&akhir='+akhir,
                success : function(data){
                $('.ambil-upload').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>

<script type="application/javascript">
$(function () {
    //Datetimepicker plugin
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD-MM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

});
</script>  

<script>
$(".data_paginasi").load("paginasi_pengeluaran.php?metode=hari_ini&awal=<?=$awal?>&akhir=<?=$akhir?>");
function tampil() {
awal = document.form_sortir.awal.value;
akhir =document.form_sortir.akhir.value;
if (awal =='' || akhir =='' ) {
	swal("Perhatian!", "Harap Isi Semua Filed", "error");
	return false;
	} else {
	$(".data_paginasi").load("paginasi_pengeluaran.php?metode=sortir&awal="+awal+"&akhir="+akhir);
	}
}
</script>  
    
</body>

</html>