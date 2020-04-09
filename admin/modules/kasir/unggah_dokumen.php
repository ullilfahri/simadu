<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
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
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Summary Penjualan</a></li>
			</ol>
            
            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN TRANSAKSI PENJUALAN BERDASARKAN NOMOR FAKTUR
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form name="form_faktur">
                                <div class="col-sm-12">
                                <b>No Faktur</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_faktur" class="form-control" placeholder="Masukan No Faktur" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
								<button type="button" onclick="return generate_faktur();" name="sukses_upload" value="ungh_dokumen" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
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
                                PENCARIAN TRANSAKSI PENJUALAN BERDASARKAN TANGGAL
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form name="form_tanggal">
                                <div class="col-sm-6">
                                <b>Tanggal Awal</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="awal" class="tanggal_picker form-control" placeholder="Masukan Tanggal Awal" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                <b>Tanggal Akhir</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="akhir" class="tanggal_picker form-control" placeholder="Masukan Tanggal Akhir" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
								<button type="button" name="cari_tanggal" onclick="return generate_tanggal();" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
                                </div>

                            </form>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->
            
            <!-- Exportable Table -->
			<div class="data_paginasi"></div>
            <!-- #END# Exportable Table -->   
                                         
            </div>
    </section>
<!--MODAL EDIT-->        
<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">RINCIAN DAFTAR TRANSAKSI</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-data"></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                        	<i class="fa fa-times"></i><span>Tutup</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT--> 

<!--MODAL EDIT-->        
<div class="modal fade upload" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Upload Dokumen Penjualan</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-upload"></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                        	<i class="fa fa-times"></i><span>Tutup</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT--> 

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
    
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    
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
    
<script type="text/javascript">
<?php if (!empty($_GET['paginasi']) && $_GET['paginasi']=='cari_tanggal') {?>
$(".data_paginasi").load("data_paginasi.php?cari_tanggal&date_1=<?=$_GET['date_1']?>&date_2=<?=$_GET['date_2']?>");
<?php $url = 'paginasi=cari_tanggal&date_1='.$_GET['date_1'].'&date_2='.$_GET['date_2'];?>
<?php } else if (!empty($_GET['paginasi']) && $_GET['paginasi']=='sukses_upload') {?>
$(".data_paginasi").load("data_paginasi.php?sukses_upload&no_faktur=<?=$_GET['no_faktur']?>");
<?php $url = 'paginasi=sukses_upload&no_faktur='.$_GET['no_faktur'];?>
<?php } else {?>
$(".data_paginasi").load("data_paginasi.php?hari_ini");
<?php $url = 'hari_ini';?>
<?php }?>
function generate_faktur() {
no_faktur =document.form_faktur.no_faktur.value;
if (no_faktur =='') {
	swal("Perhatian!", "Harap Isi Semua Filed", "error");
	return false;
	} else {
	$('.data_paginasi').load('data_paginasi.php?sukses_upload&no_faktur='+no_faktur);
	}
}
function generate_tanggal() {
awal =document.form_tanggal.awal.value;
akhir =document.form_tanggal.akhir.value;
if (awal =='' || akhir == '') {
	swal("Perhatian!", "Harap Isi Filed Tanggal", "error");
	return false;
	} else {
	swal({
        title: "Harap Tunggu Sesaat",
		type: "info",
		imageUrl: "loader.gif",
        timer: 3000,
        showConfirmButton: false
    });
	$('.data_paginasi').load('data_paginasi.php?cari_tanggal&date_1='+awal+'&date_2='+akhir);
	}
}
</script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.edit').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?transaksi',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
 

<script type="application/javascript">
$(function () {
    //Datetimepicker plugin
    $('.tanggal_picker').bootstrapMaterialDatePicker({
        format: 'DD-MM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

});
</script>  


</body>

</html>