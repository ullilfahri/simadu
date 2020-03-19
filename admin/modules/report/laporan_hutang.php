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
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Hutang</a></li>
			</ol>  
            
            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                GENERATE LAPORAN BUKU HUTANG
                                <small>Buku Piutang dalam Format PDF</small>
                            </h2>
                        </div>
                        <div class="body">
                        
                        	<form name="form_awal" id="form_awal"  style="display:block">
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">Pilih Kriteria Sortir</h2>
                                        <input name="kriteria_sortir" type="radio" id="radio_1" value="1" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_1">Sortir Data By Supplier</label>
                                        <br>
                                    	<input name="kriteria_sortir" type="radio" id="radio_2" value="0" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_2">Sortir Data By Tanggal Transaksi, Status Piutang Atau Tanggal Jatuh Tempo</label>
                                    </div>    
                                </div>
                                
                             </form>   
                        
                        
								<form name="form_sortir"  id="form_sortir" style="display:none">
								<input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
							  <div class="row clearfix">
									<div class="col-md-12">
										<p><b>Pilih Supplier, Pencarian Cepat dengan mengetikan Nama, dan Multiple Choice </b></p>
										<select name="supplier"  id="supplier" class="form-control show-tick" data-live-search="true" multiple required>
											<?php
											$cust_sql=$conn->query(" SELECT a.supplier, b.nama FROM tabel_pembelian as a LEFT JOIN tabel_supplier as b ON a.supplier = b.id WHERE a.metode_bayar = 1  AND a.distributor = '".$_SESSION['distributor']."' GROUP BY a.supplier ORDER BY b.nama ASC");
											while ($y=$cust_sql->fetch_array()) :
											?>
											<option value="<?=$y[0]?>"><?=$y[1]?></option>
											<?php endwhile;?>
										</select>
									</div>
								</div>
							  <div class="row clearfix">
									<div class="col-md-3">
										<p><b>Pilih Status Piutang</b></p>
										<select name="status_hutang" class="form-control show-tick" required>
											<option value="">--STATUS HUTANG--</option>
											<option value="0">LUNAS</option>
											<option value="1">BELUM LUNAS</option>
										</select>
									</div>
									<div class="col-md-3">
										<p><b>Sortir Kriteria Tanggal</b></p>
										<select name="kriteria_tanggal"  class="form-control show-tick" required>
											<option value="">--KRITERIA TANGGAL--</option>
											<option value="tanggal_transaksi">TANGGAL NOTA PEMBELIAN</option>
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
								<button type="button" name="laporan_pdf" onclick="return generate();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-pdf-o fa-1.5x"></i>
								<span>Laporan PDF</span>
								</button>
								</form>   
                  
                        	  <form name="form_supplier" id="form_supplier" style="display:none">
							  <div class="row clearfix">
									<div class="col-md-12">
										<p><b>Pilih Supplier, Pencarian Cepat dengan mengetikan Nama</b></p>
										<select name="supplier"  id="supplier" class="form-control show-tick" data-live-search="true" required>
											<option value="">--PILIH SUPPLIER--</option>
											<?php
											$cust_sql=$conn->query(" SELECT a.supplier, b.nama FROM tabel_pembelian as a LEFT JOIN tabel_supplier as b ON a.supplier = b.id WHERE a.metode_bayar = 1  AND a.distributor = '".$_SESSION['distributor']."' GROUP BY a.supplier ORDER BY b.nama ASC");
											while ($y=$cust_sql->fetch_array()) :
											?>
											<option value="<?=$y[0]?>"><?=$y[1]?></option>
											<?php endwhile;?>
										</select>
									</div>
								</div>
								<button type="button" name="laporan_pdf" onclick="return generate_supplier();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-pdf-o fa-1.5x"></i>
								<span>Laporan PDF</span>
								</button>
                             </form>   
                  
                   </div> 
				</div>
			</div>
          </div>  
            <!-- #END# Advanced Select -->            

            
     <div class="data_paginasi"></div>

            
<!-- Default Size -->
            <div class="modal fade biaya" id="ModalBiaya" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">RINCIAN PEMBAYARAN</h4>
                        </div>
                        <div class="modal-body">
                            <div class="ambil-biaya"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-teal waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            
            


                 
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
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.biaya').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../global/modal_detail.php?rincian_bayar=laporan',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.ambil-biaya').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
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
function check(kriteria_sortir) {
var form_awal = document.getElementById("form_awal");
var form_sortir = document.getElementById("form_sortir");
var form_supplier = document.getElementById("form_supplier");
kriteria_sortir = document.form_awal.kriteria_sortir.value;
  if (kriteria_sortir==0) {
  	form_sortir.style.display = "block";
  	form_supplier.style.display = "none";
	} else {
  	form_supplier.style.display = "block";
	form_sortir.style.display = "none";
	}
}

</script>    

<script>
function generate() {
var supplier = $('#supplier').val();
status_hutang =document.form_sortir.status_hutang.value;
kriteria_tanggal =document.form_sortir.kriteria_tanggal.value;
awal =document.form_sortir.awal.value;
akhir =document.form_sortir.akhir.value;
if (supplier =='' || status_hutang =='' || kriteria_tanggal =='' || awal =='' || akhir =='' ) {
	swal("Perhatian!", "Harap Isi Semua Filed", "error");
	return false;
	} else {
	$('.data_paginasi').load('paginasi_hutang.php?tampil_data&supplier='+supplier+'&status_hutang='+status_hutang+'&kriteria_tanggal='+kriteria_tanggal+'&awal='+awal+'&akhir='+akhir);
	window.open('buku_hutang_pdf.php?supplier='+supplier+'&status_hutang='+status_hutang+'&kriteria_tanggal='+kriteria_tanggal+'&awal='+awal+'&akhir='+akhir);
	}
}
</script>  

<script>
function generate_supplier() {
supplier =document.form_supplier.supplier.value;
if (supplier =='') {
	swal("Perhatian!", "Harap Isi Filed", "error");
	return false;
	} else {
	$('.data_paginasi').load('paginasi_hutang.php?tampil_supplier&supplier='+supplier);
	window.open('buku_hutang_supplier.php?supplier='+supplier);
	}

}
</script>    
  
    
</body>

</html>