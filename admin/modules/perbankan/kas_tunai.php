
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] !=2) :
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

$reservasi=strtotime(date('Y-m-d H:i:s'));
$ada=$conn->query("SELECT * FROM log_tunai WHERE reservasi='$reservasi'")->num_rows;
if ($ada > 0) {
echo '<script>
    setTimeout(function() {
        swal({
            title: "'.$reservasi.'",
            text: "Maaf, Database Sedang Digunakan, Harap Menunggu Beberapa Saat",
            type: "error",
			timer: 5000,
			showConfirmButton: false
        }, function() {
            window.location = "../dashboard/";
        });
    }, 1000);
</script>';

} else {
$masuk=$conn->query("INSERT INTO log_tunai(reservasi) VALUES ('$reservasi')");
}

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Summary Tunai</a></li>
			</ol>  


            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN TANGGAL
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form name="form_epen" class="form-input">
                            <input type="hidden" name="reservasi" value="<?=$reservasi?>" />
									<div class="col-md-4">
										<p><b>Outlet</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<select name="toko" id="toko" data-actions-box="true" class="selectpicker" multiple required>
                                        			<option value="0">Kas Non Outlet</option>
                                        		<?php 
												$toko_sql=$conn->query("SELECT * FROM lokasi");
												while ($t=$toko_sql->fetch_array()) :
												?>	
                                        			<option value="<?=$t['id_lokasi']?>"><?=$t['nama']?></option>
                                                <?php endwhile;?>    
												</select> 
                                                </div>
                                        	</div>
									</div>
                                    
									<div class="col-md-4">
										<p><b>Tanggal Awal</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<input type="text" name="awal" class="datepicker form-control" placeholder="Masukan Tanggal Awal" required>
                                                </div>
                                        	</div>
									</div>
                                    
									<div class="col-md-4">
										<p><b>Tanggal Akhir</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<input type="text" name="akhir" class="datepicker form-control" placeholder="Masukan Tanggal Akhir" required>
                                                </div>
                                        	</div>
									</div>
                            </div>
                            <button type="button" onclick="tampil();" class="btn btn-info waves-effect">Tampilkan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Advanced Select -->

     <div class="list-data"></div>

                 
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
    
    
<script type="text/javascript">
    $('.live_edit').editable({
           url: '../global/update.php?live_edit&tabel=konfirmasi_bank&jenis_id=id',
           type: 'textarea',
           pk: 1,
		   placement: 'top',
           name: 'name',
           title: 'Enter name'
    });	
	
	
	
</script>

<script>
function tampil() {
awal =document.form_epen.awal.value;
akhir =document.form_epen.akhir.value;
reservasi =document.form_epen.reservasi.value;
var toko = $('#toko').val();

if (akhir =='' || awal =='' || !toko) {
	swal("Perhatian!", "Harap Isi Filed", "error");
	} else {
    swal({
        title: "Generate Data Tunai",
        text: "Tekan OK untuk Generate Laporan Kas Tunai",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function () {
        var data=$(".form-input").serialize();
		$.ajax({
		url	     : 'data_tunai.php?generate',
		type     : 'POST',
		data:data,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			swal("Sukses!", response.pesan, "success");
			$(".list-data").load("data_tunai.php?tampilkan_data&reservasi="+reservasi+"&awal="+awal+"&akhir="+akhir+"&toko="+toko);
			} else if (response.error){
			swal("Gagal!", response.pesan, "error");
			} else {
			swal("Gagal!", response.pesan, "error");
			}
		},
	})
    });
	
	}


}
</script>    

    

</body>

</html>