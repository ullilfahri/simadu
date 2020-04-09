
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']>2) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-edit fa-lg"></i> Stok</a></li>
			</ol>  


            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                GENERATE LAPORAN BUKU PIUTANG
                                <small>Buku Piutang dalam Format PDF</small>
                            </h2>
                        </div>
                        <div class="body">
                        	<form name="form_awal">
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">Pilih Kriteria Sortir</h2>
                                        <input name="kriteria_sortir" type="radio" id="radio_1" value="1" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_1">Sortir Data By Customer</label>
                                        <br>
                                    	<input name="kriteria_sortir" type="radio" id="radio_2" value="0" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_2">Sortir Data By Tanggal Transaksi, Status Piutang Atau Tanggal Jatuh Tempo</label>
                                    </div>    
                                </div>
                             </form>   
                        
						  <div id="sortir_pelanggan" style="display:none"> 
							  <div class="row clearfix">
								<form method="post" action="buku_piutang_pdf.php" target="_blank" name="form_sortir_customer">
								<input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
									<div class="col-md-12">
										<p><b>Pilih Customer, Pencarian Cepat dengan mengetikan Nama</b></p>
										<select name="customer" class="form-control show-tick" data-live-search="true" required>
											<option value="">--PILIH CUSTOMER--</option>
											<?php
											$cust_sql=$conn->query(" SELECT a.customer, b.nama FROM tabel_bayar as a LEFT JOIN tabel_customer as b ON a.customer = b.id WHERE a.metode_bayar = 1  AND a.distributor = '".$_SESSION['distributor']."' GROUP BY a.customer ORDER BY b.nama ASC");
											while ($y=$cust_sql->fetch_array()) :
											?>
											<option value="<?=$y[0]?>"><?=$y[1]?></option>
											<?php endwhile;?>
										</select>
									</div>
								</div>
								<button type="submit" name="generate_pdf" onclick="return generate_sortir_customer();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-pdf-o fa-1.5x"></i>
								<span>Generate PDF</span>
								</button>
								</form>   
							</div>
                    
						  <div id="sortir_tanggal" style="display:none"> 
							  <div class="row clearfix">
								<form method="post" action="tanggal_piutang_pdf.php" target="_blank" name="form_sortir_tanggal">
								<input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
									<div class="col-md-3">
										<p><b>Pilih Status Piutang</b></p>
										<select name="status_piutang" class="form-control show-tick" required>
											<option value="">--STATUS PIUTANG--</option>
											<option value="0">BELUM LUNAS</option>
											<option value="1">LUNAS</option>
										</select>
									</div>
									<div class="col-md-3">
										<p><b>Sortir Kriteria Tanggal</b></p>
										<select name="kriteria_tanggal"  class="form-control show-tick" required>
											<option value="">--KRITERIA TANGGAL--</option>
											<option value="tanggal_transaksi">TANGGAL TRANSAKSI</option>
											<option value="tanggal_jatuh_tempo">TANGGAL JATUH TEMPO</option>
										</select>
									</div>
                                    
									<div class="col-md-3">
										<p><b>Tanggal Awal</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<input type="text" name="awal" class="datepicker form-control" placeholder="Masukan Tanggal Awal" required>
                                                </div>
                                        	</div>
									</div>
                                    
									<div class="col-md-3">
										<p><b>Tanggal Akhir</b></p>
                                        	<div class="form-group">
                                            	<div class="form-line">
												<input type="text" name="akhir" class="datepicker form-control" placeholder="Masukan Tanggal Akhir" required>
                                                </div>
                                        	</div>
									</div>
                                    
                                    
                                    
								</div>
								<button type="submit" name="laporan_pdf" onclick="return generate_sortir_tanggal();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-pdf-o fa-1.5x"></i>
								<span>Laporan PDF</span>
								</button>
								</form>   
							</div>
                   </div> 
				</div>
			</div>
          </div>  
            <!-- #END# Advanced Select -->
            <!-- #Starr# paginasit -->
            <div class="data_paginasi"></div>
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
    

<script>
function check(kriteria_sortir) {
kriteria_sortir = document.form_awal.kriteria_sortir.value;
var sortir_pelanggan = document.getElementById("sortir_pelanggan");
var sortir_tanggal = document.getElementById("sortir_tanggal");
  if (kriteria_sortir==0) {
  	sortir_tanggal.style.display = "block";
  	sortir_pelanggan.style.display = "none";
	} else {
  	sortir_pelanggan.style.display = "block";
	sortir_tanggal.style.display = "none";
	}
}

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
function generate_sortir_tanggal() {
awal =document.form_sortir_tanggal.awal.value;
akhir =document.form_sortir_tanggal.akhir.value;
kriteria_tanggal =document.form_sortir_tanggal.kriteria_tanggal.value;
status_piutang =document.form_sortir_tanggal.status_piutang.value;
if (awal =='' || akhir =='' || kriteria_tanggal=='' || status_piutang=='') {
	swal("Perhatian!", "Harap Isi Semua Filed", "error");
	return false;
	} else {
	$('.data_paginasi').load('paginasi_piutang.php?sortir_tanggal&awal='+awal+'&akhir='+akhir+'&kriteria_tanggal='+kriteria_tanggal+'&status_piutang='+status_piutang);
	}

}
</script>   
 
<script>
function generate_sortir_customer() {
customer =document.form_sortir_customer.customer.value;
if (customer =='') {
	swal("Perhatian!", "Harap Isi Semua Filed", "error");
	return false;
	} else {
	$('.data_paginasi').load('paginasi_piutang.php?sortir_customer&customer='+customer);
	}

}
</script>    

    
    <!-- Custom Js -->
</body>

</html>