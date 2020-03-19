
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']==1 || $_SESSION['level']>3) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
	
if ($_SESSION['level']==2) {
	$umum_sql=$conn->query(" SELECT cus_umum FROM `tabel_faktur` WHERE `cus_umum` != '' AND no_faktur IN (select no_faktur FROM tabel_trx WHERE distributor='".$_SESSION['distributor']."') GROUP BY cus_umum ASC");
	} else {
	$umum_sql=$conn->query(" SELECT cus_umum FROM `tabel_faktur` WHERE `cus_umum` != '' AND no_faktur IN (select no_faktur FROM tabel_trx WHERE id_toko='".$_SESSION['toko']."') GROUP BY cus_umum ASC");
	} 	
	
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
				<li><a href="javascript:void(0);"><i class="fa fa-area-chart fa-lg"></i> Stok</a></li>
			</ol>  


            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LAPORAN PERUBAHAN HARGA
                            </h2>
                        </div>
                        <div class="body">
                        	<form name="form_awal">
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">Pilih Kriteria Sortir</h2>
                                        <input name="kriteria_sortir" type="radio" id="radio_1" value="1" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_1">Perubahan Harga Per Customer</label>
                                        <br>
                                    	<input name="kriteria_sortir" type="radio" id="radio_2" value="0" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_2">Perubahan Harga Per Barang</label>
                                    </div>    
                                </div>
                             </form>   
                        
						  <div id="sortir_pelanggan" style="display:none"> 
							  <div class="row clearfix">
								<form name="form_sortir_customer">                                
									<div class="col-md-12"> 
										<p><b>Pilih Pelanggan Tetap, Pencarian Cepat dengan mengetikan Nama</b></p>
										<select name="customer" id="tetap" class="form-control show-tick" data-live-search="true" required>
											<option value="">-- PILIH CUSTOMER --</option>
											<?php
											$cust_sql=$conn->query(" SELECT * FROM tabel_customer ORDER BY nama ASC");
											while ($y=$cust_sql->fetch_array()) :
											?>
											<option value="<?=$y['id'].';tetap'?>"><?=$y['nama']?> (Pelanggan Tetap)</option>
											<?php endwhile;?>
											<?php
											while ($y=$umum_sql->fetch_array()) :
											$arr = json_decode($y[0], true);
											?>
											<option value="<?=$arr["umum"]["nama"].';umum'?>"><?=$arr["umum"]["nama"].' Alamat '.$arr["umum"]["alamat"]?> (Pelanggan Umum)</option>
											<?php endwhile;?>
										</select>
									</div>
                                    
								</div>
								<button type="button" name="generate_pdf" onclick="return generate_sortir_customer();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-o fa-1.5x"></i>
								<span>Tampilkan Data</span>
								</button>
								</form>   
							</div>
                    
						  <div id="sortir_barang" style="display:none"> 
							  <div class="row clearfix">
								<form name="form_sortir 	_barang">
								<input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
									<div class="col-md-12">
										<p><b>Pilih Nama Barang</b></p>
										<select name="kode_barang" class="form-control show-tick" data-live-search="true" required>
											<option value="">--NAMA BARANG--</option>
											<?php
											$barang=$conn->query(" SELECT * FROM stok_barang WHERE distributor LIKE '%".$_SESSION['distributor']."%' ORDER BY kode_barang ASC");
											while ($y=$barang->fetch_array()) :
											?>
											<option value="<?=$y['kode_barang']?>"><?='['.$y['kode_barang'].'] : '.$y['nama_barang']?></option>
											<?php endwhile;?>
										</select>
									</div>
								</div>
								<button type="button" name="laporan_pdf" onclick="return generate_barang();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-o fa-1.5x"></i>
								<span>Tampilkan Data</span>
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
var sortir_barang = document.getElementById("sortir_barang");
  if (kriteria_sortir==0) {
  	sortir_barang.style.display = "block";
  	sortir_pelanggan.style.display = "none";
	} else {
  	sortir_pelanggan.style.display = "block";
	sortir_barang.style.display = "none";
	}
}

</script>    
      
<script>
function generate_barang() {
kode_barang =document.form_sortir_barang.kode_barang.value;
if (kode_barang=='') {
	swal("Perhatian!", "Harap Isi Semua Filed", "error");
	return false;
	} else {
	$('.data_paginasi').load('paginasi_harga_barang.php?sortir_barang&kode_barang='+kode_barang);
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
	$('.data_paginasi').load('paginasi_harga.php?sortir_customer&customer='+customer);
	}

}
</script>    

    
    <!-- Custom Js -->
</body>

</html>