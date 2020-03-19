<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']!=2) :
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
$cari=$conn->query(" SELECT * FROM jenis_pengeluaran ")->num_rows;
$digit=$cari+1;
$digit = str_pad($digit, 4, '0', STR_PAD_LEFT);
$kode='OP'.$digit;
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-wrench fa-lg"></i> Jenis Pengeluaran</a></li>
			</ol>  
            
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TAMBAH JENIS PENGELUARAN
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" name="frm_ajax" id="form" >
                            <input type="hidden" name="kode" id="kode" class="form-control" value="<?=$kode?>">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="jenis" id="jenis" class="form-control ubah_kapital" onkeyup="myFunction()">
                                        <label class="form-label">Jenis Pengeluaran</label>
                                    </div>
                                </div>

                                <br>
                                <button type="button" class="btn btn-primary m-t-15 waves-effect" onClick="kirim_form();" value="Kirim" name="kirim">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR JENIS PENGELUARAN
                            </h2>
                        </div>
                        <div class="body">
                        
							<div class="list-data">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->            
                 
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

<!-- Bootstrap Notify Plugin Js -->
    <script src="<?=PLG?>bootstrap-notify/bootstrap-notify.js"></script>
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

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
    
<script>
$(document).ready(function(){
        $(".list-data").load("crud_katalog_barang.php?data&tabel=jenis_pengeluaran&kolom1=kode&kolom2=jenis");
});
</script>

<script>
function myFunction() {
    var jenis = document.getElementById("jenis");
    jenis.value = jenis.value.toUpperCase();
}
</script>

<script>
function kirim_form(){
	var jenis   = $('#jenis').val();
	var kode   = $('#kode').val();

	if (jenis=="") {
	swal("Perhatian!", "Field Jenis Pengeluaran Harus Terisi", "error");
	return false;


	} else {			 
	$.ajax({
		url	     : 'crud_katalog_barang.php?kirim&tabel=jenis_pengeluaran&kolom1=kode&kolom2=jenis',
		type     : 'POST',
		dataType : 'html',
		data     : 'value='+kode+'&value2='+jenis,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			swal("Sukses!", response.pesan, "success");
			$(".list-data").load("crud_katalog_barang.php?data&tabel=jenis_pengeluaran&kolom1=kode&kolom2=jenis");
			document.getElementById("form").reset();
			} else {
			swal("Gagal!", response.pesan, "error");
			}
		},
	})
	} //akhir if
}		
</script>

 

</body>

</html>