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
$id_sj=implode(", ", $_GET['cek']);
$y=$conn->query("SELECT * FROM ambil_barang where id IN ($id_sj) ");
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

            
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY METODE METODE PENGAMBILAN BARANG
                            </h2>
                        </div>
                        <div class="body">
                            <form name="form_metode" method="post" action="form_crud.php">
                            <?php $cek=$_GET['cek']; $jumlah_dipilih = count($cek); for($x=0;$x<$jumlah_dipilih;$x++) { echo '<input type="hidden" name="id_sj[]" value="'.$cek[$x].'">'; }?>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">No Surat Jalan</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group demo-tagsinput-area">
                                            <div class="form-line">
                                                <input type="text" name="no_sj" id="no_sj" class="form-control" data-role="tagsinput" value="
												<?php 
												while ($x=$y->fetch_array()) :
												$fak=$conn->query("SELECT no_faktur FROM barang_keluar where id = '".$x['id_barang_keluar']."' ")->fetch_array();
													if ($x['partial'] > 0) { 
													echo $fak[0].'-'.surat_jalan($x['partial']).','; 
													} else {
													echo $fak[0].',';
													}
												endwhile;
												?>
                                                " disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="metode_ambil">Metode Pengambilan</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="demo-radio-button">
                                                <input name="metode" type="radio" id="ambil_sendiri" value="1" onclick="check(this.value)" checked />
                                                <label for="ambil_sendiri">Diambil Sendiri</label>
                                                <input name="metode" type="radio" id="diantar" value="2" onclick="check(this.value)" />
                                                <label for="diantar">Diantar</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                
<div id="form_antar" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="metode_ambil">Pilih Sopir</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                       <select name="sopir" id="sopir" class="form-control show-tick" data-live-search="true">
                                        <option value="">-- PILIH SOPIR --</option>
                                        <?php
                                        $sopir=$conn->query("SELECT * FROM tabel_karyawan WHERE id IN (SELECT id_karyawan FROM tabel_sopir) ORDER BY nama_karyawan ASC");
										while ($x=$sopir->fetch_array()) :
										?>
                                        <option value="<?=$x['id']?>"><?=$x['nama_karyawan']?></option>
                                        <?php endwhile;?>
                                    	</select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="metode_ambil">Pilih Plat Mobil</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                       <select name="plat_mobil" id="plat_mobil" class="form-control show-tick" data-live-search="true">
                                        <option value="">-- PILIH MOBIL --</option>
                                        <?php
                                        $mobil=$conn->query("SELECT * FROM tabel_mobil WHERE non_aktif=0 ORDER BY plat_mobil ASC");
										while ($x=$mobil->fetch_array()) :
										?>
                                        <option value="<?=$x['id']?>"><?=$x['plat_mobil'].' Jenis '.$x['jenis_mobil']?></option>
                                        <?php endwhile;?>
                                    	</select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="lokasi">Pilih Kriteria Lokasi</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                       <select name="lokasi" id="lokasi" class="form-control show-tick" data-live-search="true">
                                        <option value="">-- PILIH KRITERIA LOKASI --</option>
                                        <?php
                                        $lokasi=$conn->query("SELECT * FROM lokasi_antar WHERE non_aktif=0");
										while ($x=$lokasi->fetch_array()) :
										?>
                                        <option value="<?=$x['id'].'#'.$x['premi']?>">Jarak <?=$x['jarak'].' KM, Premi Rp. '.angka($x['premi'])?></option>
                                        <?php endwhile;?>
                                    	</select>
                                    </div>
                                </div>
</div>                                
                                                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" name="form_metode" class="btn btn-primary m-t-15 waves-effect">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->
            
            
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
    
    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="<?=PLG?>bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
                
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    

<script>
function check(metode) {
var form_antar = document.getElementById("form_antar");
  if (metode==2) {
  	form_antar.style.display = "block";
	document.getElementById('sopir').required = true;
	document.getElementById('plat_mobil').required = true;
	document.getElementById('lokasi').required = true;
	} else {
  	form_antar.style.display = "none";
	document.getElementById('sopir').required = false;
	document.getElementById('plat_mobil').required = false;
	document.getElementById('lokasi').required = false;
	}
}
</script>

</body>

</html>