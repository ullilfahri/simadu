<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['sub_level']!=4) :
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
$toko=$conn->query(" SELECT nama FROM lokasi where id_lokasi = '".$_SESSION['toko']."' ")->fetch_array();
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


            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN TRANSAKSI BERDASARKAN TANGGAL DAN KASIR DI OUTLET <?=$toko[0]?>
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-horizontal FrmEntry" name="epen">
                            <input type="hidden" name="id_toko" id="id_toko" value="<?=$_SESSION['toko']?>"/>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="awal" id="awal" class="form-control tanggal_picker" placeholder="Masukan Tanggal Awal...">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="akhir" id="akhir" class="tanggal_picker form-control" placeholder="Masukan Tanggal Akhir...">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="kasir" id="kasir" class="form-control show-tick" data-live-search="true">
                                            <option value="">--PILIH KASIR--</option>
                                            <?php
                                            $kasir_sql=$conn->query("SELECT id, nama FROM user where id_gudang = '".$_SESSION['toko']."' AND id_level=3 ");
											while ($k=$kasir_sql->fetch_array()) :
											?>
                                            <option value="<?=$k[0]?>"><?=$k[1]?></option>
                                            <?php endwhile;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                                <button type="button" onclick="cari_trx()" class="btn btn-primary m-t-15 waves-effect">Cari</button>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- Vertical Layout | With Floating Label -->

             <div id="paginasi_transaksi_kasir"></div>

                    
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

<script type="text/javascript">
function cari_trx() {
awal = document.epen.awal.value;
akhir =document.epen.akhir.value;
kasir =document.epen.kasir.value;
id_toko =document.epen.id_toko.value;
	if (awal=='' || akhir=='' || kasir=='') {
	swal("Gagal!", "Harap Isi Semua Field Tersedia..!", "error");
	} else {
	 $("#paginasi_transaksi_kasir").load("paginasi_transaksi_kasir.php?ambil_data&kasir="+kasir+"&awal="+awal+"&akhir="+akhir+"&id_toko="+id_toko);
	} 

}
</script>
    
    
</body>

</html>