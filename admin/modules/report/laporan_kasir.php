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
                                LAPORAN TRANSAKSI
                            </h2>
                        </div>
                        <div class="body">
                        
                        	<form name="form_tanggal" style="display:block">
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">Kriteria Tanggal</h2>
                                        <input name="kriteria_sortir" type="radio" id="radio_1" value="1" onclick="check(this.value)" class="radio-col-indigo" checked />
                                		<label for="radio_1">Hari ini</label>
                                        <br>
                                    	<input name="kriteria_sortir" type="radio" id="radio_2" value="0" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_2">Sortir Tanggal</label>
                                    </div>    
                                </div>
                             </form>   
                        
                        	<form name="form_awal">
                            <input type="hidden" name="id_toko" id="id_toko" value="<?=$_SESSION['toko']?>" />
                               
                                <div class="row clearfix" id="sortir_tanggal" style="display:none"> 
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
                                        <option value="">SEMUA DISTRIBUTOR</option>
                                        <?php 
										$distributor=$conn->query("SELECT * FROM mst_hak_akses WHERE id_akses=2 ORDER BY kode DESC");
										while ($x=$distributor->fetch_array()) :
										?>
                                        <option value="<?=$x['kode']?>"><?=$x['pengguna']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>    
                                </div>

                             <?php
                             if ($_SESSION['sub_level']==4) {
							 ?>   
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">KASIR</h2>
                                        <select name="id_kasir" id="id_kasir" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0">--PILIH KASIR--</option>
                                        <option value="">SEMUA KASIR</option>
                                        <?php 
										$kasir=$conn->query("SELECT * FROM user WHERE id_level=3 AND id_gudang='".$_SESSION['toko']."' ORDER BY nama ASC");
										while ($y=$kasir->fetch_array()) :
										?>
                                        <option value="<?=$y['id']?>"><?=$y['nama']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>    
                                </div>
                            <?php
                            } else {
							?>
                            <input type="hidden" id="id_kasir"  name="id_kasir" value="<?=$_SESSION['id']?>" />
                            <?php
                            }
							?> 
                            
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
  if (kriteria_sortir==1) {
  	sortir_tanggal.style.display = "none";
	} else {
  	sortir_tanggal.style.display = "block";
	}
}

</script>     
    
<script>
function tampil_data() {
kriteria_sortir = document.form_tanggal.kriteria_sortir.value;
id_toko = document.form_awal.id_toko.value;
distributor = document.form_awal.distributor.value;
id_kasir = document.form_awal.id_kasir.value;
awal = document.form_awal.awal.value;
akhir = document.form_awal.akhir.value;
if (distributor == '0') {
	swal("Perhatian!", "Harap Isi Filed Distributor", "error");
	} else if (id_kasir == '0') {
	swal("Perhatian!", "Harap Isi Filed Kasir", "error");
	} else if (kriteria_sortir == 0 && awal =='' ) {
	swal("Perhatian!", 'Harap Isi Field Tanggal Awal', "error");
	} else if (kriteria_sortir == 0 && akhir =='' ) {
	swal("Perhatian!", 'Harap Isi Field Tanggal Akhir', "error");
	} else {
	$('.paginasi_transaksi').load('paginasi_transaksi.php?tampil_data&id_toko='+id_toko+'&distributor='+distributor+'&id_kasir='+id_kasir+'&awal='+awal+'&akhir='+akhir+'&kriteria_sortir='+kriteria_sortir);
	}
}
</script>  

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.modal_rincian').on('show.bs.modal', function (e) {
            var detail = $(e.relatedTarget).data('detail');
            var id_toko = $(e.relatedTarget).data('toko');
            var id_kasir = $(e.relatedTarget).data('kasir');
            var distributor = $(e.relatedTarget).data('distributor');
            var awal = $(e.relatedTarget).data('awal');
            var akhir = $(e.relatedTarget).data('akhir');
            $.ajax({
                type : 'post',
                url : 'paginasi_transaksi.php',
                data :  'detail='+detail+'&id_toko='+id_toko+'&id_kasir='+id_kasir+'&distributor='+distributor+'&awal='+awal+'&akhir='+akhir,
                success : function(data){
                $('.fetched-modal').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
  
    
</body>

</html>