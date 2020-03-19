
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']==3 || $_SESSION['level']==5 ) :
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
$id_gudang=$_GET['id_gudang'];
$kode_barang=$_GET['kode_barang'];
$gudang=$conn->query("SELECT nama FROM lokasi where id_lokasi='$_GET[id_gudang]'")->fetch_array();
$stok=$conn->query("SELECT * FROM alokasi_stok  WHERE kode_barang = '$kode_barang' AND id_gudang='$id_gudang' ORDER by jumlah DESC");
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
            

            
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                FORM BOOKING BARANG
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" id="booking" name="booking" class="form-input" autocomplete="off">
                            <input type="hidden" id="id_gudang" name="id_gudang" value="<?=$_GET['id_gudang']?>"/>
                            <input type="hidden" name="kode_barang" id="kode_barang" value="<?=$_GET['kode_barang']?>"/>


                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="nama_barang">Nama Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?=$_GET['nama_barang']?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="jumlah_ambil">QTY Belum Diambil</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="qty_ambil" id="qty_ambil" class="form-control" value="<?=$_GET['jumlah']?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="jumlah_beli">Jumlah Booking</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="jumlah" id="jumlah"  onFocus="startCalc();" onBlur="stopCalc();"  autofocus required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="satuan">Dari Pintu/Ruang/Sekat (*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <select class="form-control show-tick" name="pintu_gudang" data-show-subtext="true" required>
                                            <option value="">--PILIH PINTU/RUANG/SEKAT--</option>
                                            <?php
                                            while ($s=$stok->fetch_array()) :
											?>
                                                <option value="<?=$s['jumlah'].'#'.$s['pintu_gudang']?>"><?=$s['pintu_gudang'].' Jumlah Stok '.$s['jumlah']?></option>
                                            <?php
											endwhile;
                                            ?>  
                                            </select>  
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="totstok">Sisa Stok</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="totstok" id="totstok" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="button" class="btn btn-primary m-t-15 waves-effect" onclick="return validasi();">Simpan</button>
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

    <!-- Select Plugin Js -->
    <script src="<?=PLG?>bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Multi Select Plugin Js -->
    <script src="<?=PLG?>multi-select/js/jquery.multi-select.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?=PLG?>bootstrap-notify/bootstrap-notify.js"></script>    
    
    <!-- Jquery Spinner Plugin Js -->
    <script src="<?=PLG?>jquery-spinner/js/jquery.spinner.js"></script>


    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    
    <!-- Light Gallery Plugin Js -->
    <script src="<?=PLG?>light-gallery/js/lightgallery-all.js"></script>


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
    
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
<script>
    function startCalc(){
    		interval = setInterval("calc()",1);
    }
    function calc(){
	    jumlah = document.booking.jumlah.value;
	    qty_ambil = document.booking.qty_ambil.value;
		totstok=qty_ambil-jumlah;

		document.booking.totstok.value = totstok;
	}
    function stopCalc(){
    	clearInterval(interval);
    }
</script> <!-- Menghitung otomatis -->

<script type="text/javascript">
    function validasi() {
		var error="";
		var jumlah = document.booking.jumlah.value;
		var totstok = document.booking.totstok.value;
		var id_gudang = document.booking.id_gudang.value;
		var kode_barang = document.booking.kode_barang.value;
		var nama_barang = document.booking.nama_barang.value;
		var mentah = document.booking.pintu_gudang.value;
		var pecah = mentah.split('#');
		var stok = pecah[0];
		var pintu_gudang = pecah[1];
		var stok_fisik = stok-jumlah;
		
		if( jumlah ==  '' || jumlah==0)	{
    		swal("Gagal!", "Jumlah Booking Harus Terisi", "error");
			return false;
			
			} else if( mentah == '' )	{
    		swal("Gagal!", "Field Pintu/Ruang/Sekat Harus Diisi", "error");
			return false; 

			} else if( isNaN(totstok) )	{
    		swal("Gagal!", "Mohon Masukan Hanya Angka Pada Jumlah Booking", "error");
			return false; 

			} else if( stok_fisik < 0 )	{
    		swal("Gagal!", "Jumlah Yang Dientry melebihi Jumlah Stok Fisik Pintu/ruang/sekat "+pintu_gudang, "error");
			return false; 

			} else if( totstok < 0 )	{
    		swal("Gagal!", "Jumlah Booking melebihi QTY yang belum diambil", "error");
			return false; 
			} else {
			$.ajax({
				type:'POST',
				url:'form_crud.php?simpan_booking',
				data :  'jumlah='+jumlah+'&totstok='+totstok+'&id_gudang='+id_gudang+'&kode_barang='+kode_barang+'&pintu_gudang='+pintu_gudang+'&nama_barang='+nama_barang,
				success: function(result){
				var response = JSON.parse(result);
				if (response.sisa){
					alert(nama_barang+' Masih Ada Stok '+response.data+' yang belum dibooking, Lakukan Entry..!');
					location.href = response.url;
					} else if (response.habis){
					alert(nama_barang+' Telah Diboking, Silahkan lakukan Transfer Barang tersebut');
					location.href = response.url;
					}
				}
			});
			}
    }
</script>


</body>

</html>