<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']!=4) :
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
                            <form name="form_faktur">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_faktur" class="form-control" placeholder="Masukan Nomor Faktur">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-12">
                                            <button type="button" onclick="return cari_faktur();" class="btn btn-info waves-effect">
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
                            <form name="form_tanggal">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="awal" class="tanggal_picker form-control"  placeholder="Tanggal dsn Waktu Awal" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="akhir" class="tanggal_picker form-control" placeholder="Tanggal dan Waktu Akhir" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                            <button type="button"  onclick="return generate_tanggal();" name="cari_tanggal" class="btn btn-info waves-effect">
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

            <!-- #Starr# paginasit -->
            <div class="paginasi_metode"></div>
            <!-- #END# paginasit -->

                    
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
    
<script>
$('.paginasi_metode').load('paginasi_metode.php?hari_ini');
</script>

<script>
function cari_faktur() {
no_faktur =document.form_faktur.no_faktur.value;
if (no_faktur =='') {
	swal("Perhatian!", "Harap No Faktur", "error");
	return false;
	} else {
	$('.paginasi_metode').load('paginasi_metode.php?no_faktur='+no_faktur);
	}
}
</script>


<script>
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
		imageUrl: "../kasir/loader.gif",
        timer: 3000,
        showConfirmButton: false
    });
	$('.paginasi_metode').load('paginasi_metode.php?cari_tanggal&date_1='+awal+'&date_2='+akhir);
	}
}


</script>   
    
</body>

</html>