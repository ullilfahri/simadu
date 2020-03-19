
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2 && $_SESSION['level'] != 6) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-user fa-lg"></i> Karyawan</a></li>
			</ol>  
 
<?php
if (isset($_GET['main'])) :
$karyawan=$conn->query("select * from tabel_karyawan ORDER BY nama_karyawan ASC");
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA KARYAWAN<br><br>
                                <a href="<?=$_SERVER['PHP_SELF']?>?tambah_karyawan"><button type="button" class="btn bg-light-blue waves-effect">Tambah Karyawan</button></a>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis</th>
                                            <th>Tanggal Lahir, Umur</th>
                                            <th>Tanggal Mulai Kerja, Lama Bekerja</th>
                                            <th>Status</th>
                                            <th>AKSI</th>
                                            <th>Make Driver</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$karyawan->fetch_array()) :
									if ($x['non_aktif']==0) {
									$status = 'Aktif';
									} else {
									$status = 'Non Aktif';
									}
									$driver=$conn->query("SELECT * FROM tabel_sopir where id_karyawan='".$x['id']."'")->num_rows;
									if ($driver==0) {
									$btn='<a href="form_crud_supplier.php?sopir&ket=aktif&id='.$x['id'].'" class="aktif-link"><button type="button" class="btn bg-green waves-effect">Jadikan Sopir</button></a>';
									} else {
									$btn='<a href="form_crud_supplier.php?sopir&ket=non_aktif&id='.$x['id'].'" class="inaktif-link"><button type="button" class="btn bg-red waves-effect">Hapus Sebagai Sopir</button></a>';
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_karyawan']?></td>
                                            <td><?=$x['jenis_karyawan']?></td>
                                            <td><?=tanggal_indo($x['tanggal_lahir'])?>, <?=umur($x['tanggal_lahir'])?> Tahun</td>
                                            <td><?=tanggal_indo($x['mulai_kerja'])?>, <?=lama_kerja(date_format(date_create($x['mulai_kerja']),"d-m-Y"))?></td>  
                                            <td><?=$status?></td>
                                            <td>
                                            <a href="<?=$_SERVER['PHP_SELF']?>?ubah_karyawan&id=<?=$x['id']?>">
                                            <button type="button" class="btn bg-light-blue waves-effect">Ubah</button>
                                            </a>
                                            </td>
                                            <td><?=$btn?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
<?php endif;
if (isset($_GET['tambah_karyawan'])):
?>            
            
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               TAMBAH KARYAWAN
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-horizontal" method="post" action="form_crud_supplier.php">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Nama</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" onkeyup="myFunction()" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Jenis Karyawan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                    		<select class="form-control show-tick" name="jenis_karyawan" required>
                                        	<option value="">-- PILIH JENIS KARYAWAN --</option>
                                        	<option value="HARIAN">HARIAN</option>
                                        	<option value="BULANAN">BULANAN</option>
                                    		</select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Tanggal Lahir</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="tanggal_lahir" class="datepicker form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Tanggal Mulai Kerja</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="mulai_kerja" class="datepicker form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                         <div class="modal-footer">
                            <button type="submit" name="tambah_karyawan" class="btn btn-info waves-effect">SIMPAN</button>
                            <button type="reset" class="btn btn-danger waves-effect" data-dismiss="modal">RESET</button>
                        </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
<?php endif;

if (isset($_GET['ubah_karyawan'])):
$data=$conn->query("SELECT * FROM tabel_karyawan where id = '".$_GET['id']."'")->fetch_array();
if ($data['non_aktif']==0) {
	$status = 'checked';
	} else {
	$status = 'unchecked';
}

?>            
            
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               UBAH DATA KARYAWAN
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-horizontal" method="post" action="form_crud_supplier.php">
                            <input type="hidden" name="id" value="<?=$data['id']?>" />
                            
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Status</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                            	<div class="switch">
                                                <label>NON AKTIF<input type="checkbox" name="non_aktif" <?=$status?>><span class="lever"></span>AKTIF</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Nama</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="nama_karyawan" class="form-control" value="<?=$data['nama_karyawan']?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Jenis Karyawan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                    		<select class="form-control show-tick" name="jenis_karyawan" required>
                                        	<option value="<?=$data['jenis_karyawan']?>"><?=$data['jenis_karyawan']?></option>
                                        	<option value="HARIAN">HARIAN</option>
                                        	<option value="BULANAN">BULANAN</option>
                                    		</select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Tanggal Lahir</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="tanggal_lahir" class="datepicker form-control" value="<?=date_format(date_create_from_format('Y-m-d', $data['tanggal_lahir']), 'l d F Y')?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Tanggal Mulai Kerja</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="mulai_kerja" class="datepicker form-control" value="<?=date_format(date_create_from_format('Y-m-d', $data['mulai_kerja']), 'l d F Y')?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                         <div class="modal-footer">
                            <button type="submit" name="ubah_karyawan" class="btn btn-info waves-effect">SIMPAN</button>
                        </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
                        
<?php endif;?>   
         
                 
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
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
function saveToDatabase(editableObj,column,id) {
	$(editableObj).css("background","#FFF url(../stok/img/loader.gif) no-repeat right");
	$.ajax({
		url: "form_crud_supplier.php?live_edit=tabel_customer",
		type: "POST",
		data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
		success: function(data){
			$(editableObj).css("background","#FDFDFD");
		}        
   });
}
</script>


<script>
function myFunction() {
    var a = document.getElementById("nama_karyawan");
    a.value = a.value.toUpperCase();

}
</script>

<script>
        jQuery(document).ready(function($){
            $('.aktif-link').on('click',function(){
                var getLink = $(this).attr('href');
                swal({
                        title: 'Alert',
                        text: 'Jadikan Sopir..?',
                        html: true,
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,
						imageUrl: "../../../images/thumbs-up.png"
                        },function(){
                        window.location.href = getLink
                    });
                return false;
            });
        });
</script>

<script>
        jQuery(document).ready(function($){
            $('.inaktif-link').on('click',function(){
                var getLink = $(this).attr('href');
                swal({
                        title: 'Alert',
                        text: 'Hapus Sebagai Sopir..?',
                        html: true,
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,
						imageUrl: "../../../images/thumbs-down.png"
                        },function(){
                        window.location.href = getLink
                    });
                return false;
            });
        });
</script>


</body>

</html>