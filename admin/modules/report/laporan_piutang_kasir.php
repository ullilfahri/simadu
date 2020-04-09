<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']==1 || $_SESSION['level']>3) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-area-money fa-lg"></i> Transaksi</a></li>
			</ol>  


            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LAPORAN PIUTANG
                            </h2>
                        </div>
                        <div class="body">
                        
                        	<form name="form_awal">
                            <input type="hidden" name="id_toko" id="id_toko" value="<?=$_SESSION['toko']?>" />
                            
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">Sortir Kriteria Tanggal</h2>
                                        <input name="kriteria_sortir" type="radio" id="radio_1" value="1" class="radio-col-indigo" checked />
                                		<label for="radio_1">Tanggal Jatuh Tempo</label>
                                        <br>
                                    	<input name="kriteria_sortir" type="radio" id="radio_2" value="0" class="radio-col-indigo"/>
                                		<label for="radio_2">Tanggal Transaksi</label>
                                    </div>    
                                </div>
                               

                                <div class="row clearfix"> 
                                	<div class="col-md-12">
                                		<div class="col-sm-6">
                                		<b>Tanggal Awal</b>
                                    		<div class="form-group">
                                        		<div class="form-line">
                                            	<input type="text" name="awal" id="awal" class="tanggal_picker form-control" placeholder="Masukan Tanggal Awal" required>
                                        		</div>
                                    		</div>
                                		</div>
                                		<div class="col-sm-6">
                                		<b>Tanggal Akhir</b>
                                    		<div class="form-group">
                                        		<div class="form-line">
                                            	<input type="text" name="akhir" id="akhir" class="tanggal_picker form-control" placeholder="Masukan Tanggal Akhir" required>
                                        		</div>
                                    		</div>
                                		</div>
                                    </div>    
                                </div>

                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">DISTRIBUTOR</h2>
                                        <select name="distributor" id="distributor" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0">--PILIH DISTRIBUTOR--</option>
                                        <option value="%%">SEMUA DISTRIBUTOR</option>
                                        <?php 
										$distributor=$conn->query("SELECT * FROM mst_hak_akses WHERE id_akses=2 ORDER BY kode DESC");
										while ($x=$distributor->fetch_array()) :
										?>
                                        <option value="<?=$x['kode']?>"><?=$x['pengguna']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>    
                                </div>

                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">CUSTOMER</h2>
                                        <select name="customer" id="customer" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0">--PILIH CUSTOMER--</option>
                                        <option value="%%">SEMUA CUSTOMER</option>
                                        <?php 
										$customer=$conn->query("SELECT * FROM tabel_customer WHERE id IN (SELECT customer FROM tabel_faktur WHERE id_toko='".$_SESSION['toko']."' AND metode_bayar=1) GROUP BY nama ASC");
										while ($y=$customer->fetch_array()) :
										?>
                                        <option value="<?=$y['id']?>"><?=$y['nama']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>    
                                </div>

                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">STATUS PIUTANG</h2>
                                        <select name="status_piutang" id="status_piutang" class="form-control show-tick">
                                        <option value="0">--PILIH STATUS PIUTANG--</option>
                                        <option value="semua">SEMUA STATUS</option>
                                        <option value="lunas">LUNAS</option>
                                        <option value="belum_lunas">BELUM LUNAS</option>
                                        </select>
                                    </div>    
                                </div>
                            
								<button type="button" onclick="tampil_data();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-o fa-1.5x"></i>
								<span>Tampilkan Data</span>
								</button>

                             </form> 
                         </div>      
                   </div> 
				</div>
			</div>
            <!-- #END# Advanced Select -->
            <!-- #Starr# paginasit -->
            <div class="paginasi_transaksi"></div>
            <!-- #END# paginasit -->

            <!-- Large Size -->
            <div class="modal fade modal_rincian" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Transaksi</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-modal"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Large Size -->

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
    $('.tanggal_picker').bootstrapMaterialDatePicker({
        format: 'DD-MM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

});
</script>  

    
<script>
function check(kriteria_sortir) {
kriteria_sortir = document.form_tanggal.kriteria_sortir.value;
awal = document.form_awal.awal.value;
akhir = document.form_awal.akhir.value;
var sortir_tanggal = document.getElementById("sortir_tanggal");
var jatuh_tempo = document.getElementById("jatuh_tempo");
  if (kriteria_sortir==1) {
  	sortir_tanggal.style.display = "none";
  	jatuh_tempo.style.display = "block";
	} else {
  	sortir_tanggal.style.display = "block";
  	jatuh_tempo.style.display = "none";
	}
}

</script>     
    
<script>
function tampil_data() {
kriteria_sortir = document.form_awal.kriteria_sortir.value;
id_toko = document.form_awal.id_toko.value;
distributor = document.form_awal.distributor.value;
status_piutang = document.form_awal.status_piutang.value;
customer = document.form_awal.customer.value;
awal = document.form_awal.awal.value;
akhir = document.form_awal.akhir.value;
if (distributor == '0') {
	swal("Perhatian!", "Harap Isi Filed Distributor", "error");
	} else if (customer == '0') {
	swal("Perhatian!", "Harap Isi Filed Customer", "error");
	} else if (status_piutang == '0') {
	swal("Perhatian!", "Harap Isi Filed Status Piutang", "error");
	} else if (awal =='' ) {
	swal("Perhatian!", 'Harap Isi Field Tanggal Awal', "error");
	} else if (akhir =='' ) {
	swal("Perhatian!", 'Harap Isi Field Tanggal Akhir', "error");
	} else {
	$('.paginasi_transaksi').load('paginasi_piutang_kasir.php?tampil_data&customer='+customer+'&distributor='+distributor+'&status_piutang='+status_piutang+'&awal='+awal+'&akhir='+akhir+'&kriteria_sortir='+kriteria_sortir+'&id_toko='+id_toko);
	}
}
</script>  

    
</body>

</html>