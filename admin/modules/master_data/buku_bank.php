
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] == 5 || $_SESSION['level'] == 4) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard/'</script>";
	endif; 
if ($_SESSION['level'] == 3 && $_SESSION['sub_level'] == 3) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard/'</script>";
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
				<li><a href="javascript:void(0);"><i class="fa fa-university fa-lg"></i> Buku Bank</a></li>
			</ol>  

<?php
if (isset($_GET['kasir'])) :
if ($_SESSION['level'] == 2) {
$bank=$conn->query("select * from rekening_bank WHERE distributor='".$_SESSION['distributor']."'");
} else if ($_SESSION['level'] == 3) {
$bank=$conn->query("select * from rekening_bank WHERE id_toko='".$_SESSION['toko']."'");
} else {
$bank=$conn->query("select * from rekening_bank");
}
?>
            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA BANK<br><br>
                                <?php if ($_SESSION['level']==2) :?>
                                <a href="<?=$_SERVER['PHP_SELF']?>?tambah_rekening"><button type="button" class="btn bg-light-blue waves-effect"  data-toggle="modal" data-target="#largeModal">Tambah Rekening</button></a>
                                <?php endif;?>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bank</th>
                                            <th>No Rekening</th>
                                            <th>Nama Akun Rekening</th>
                                            <th>Kepemilikan</th>
                                            <th>Status Rekening, Klik Untuk Perubahan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$bank->fetch_array()) :
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['id_toko']."' ")->fetch_array();
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode= '".$x['distributor']."' ")->fetch_array();
									if ($x['stts'] == 1) {
									$stts='Kepemilikan '.$toko[0].' Untuk Distributor '.$dis[0];
									} else {
									$stts='Kepemilikan '.$dis[0].' Untuk Transaksi Pembelian Barang';
									}
									if ($x['is_aktif']==0) {
									$act='<a href="form_crud_supplier.php?aktif_rekening&ket=aktif&is_aktif=1&id='.$x['id'].'" class="aktif-link"><button type="button" class="btn bg-red waves-effect">Rekening Non Aktif, Klik Untuk Aktifkan</button></a>';
									} else {
									$act='<a href="form_crud_supplier.php?aktif_rekening&ket=nonaktif&is_aktif=0&id='.$x['id'].'" class="inaktif-link"><button type="button" class="btn bg-green waves-effect">Rekening Aktif, Klik Untuk Non Aktifkan</button></a>';
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['bank']?></td>
                                            <td><?=$x['no_rek']?></td>
                                            <td><?=$x['nama_akun']?></td>
                                            <td><?=$stts?></td>
                                            <td><?=$act?></td>
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

if (isset($_GET['tambah_rekening'])) :
?>
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TAMBAH REKENING BANK
                            </h2>
                        </div>
                        <div class="body">
                            <form action="form_crud_supplier.php" method="post">
                            <input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
                            <input type="hidden" name="is_aktif" value="1" />
                                <label for="bank">Bank</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="bank" class="form-control" placeholder="Masukan Detail Nama Bank, misal : Bank Mandiri Cabang Ketapang" required>
                                    </div>
                                </div>
                                
                                
                                <label for="no_rek">Nomor Rekening</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="no_rek" class="form-control" placeholder="Masukan Nomor Rekening" required>
                                    </div>
                                </div>
                                
                                
                                <label for="nama_akun">Nama Akun Bank</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="nama_akun" class="form-control" placeholder="Masukan Nama Akun Rekening Bank" required>
                                    </div>
                                </div>
                                
                                
                                <label for="nama_akun">Status Kepemilikan Rekening Untuk Transaksi Pembelian Barang (Rekening Milik Distributor)</label>
                                <div class="form-group">
                            		<div class="demo-radio-button">
                                		<input type="checkbox" id="radio_umum" onclick="untuk_umum();" name="stts" value="1"/>
                                		<label for="radio_umum">Beri Tanda Centang (&#10004;) Jika Rekening Untuk Transaksi Penjualan di Toko, Hilangkan Tanda (&#10004;) Jika Rekening Diperuntukankan sebagai Transaksi Pembelian</label>
                            		</div>
                                </div>
                                
    <div id="pel_umum" style="display:none">
                                
                                <label for="id_toko">Toko/Outlet (Jika Rekening Sebagai Transaksi Penjualan)</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="id_toko" name="id_toko" class="form-control" onchange="javascript:rubah(this)">
                                                <option value="">-- PILIH TOKO/OUTLET --</option>
                                     <?php
                                     $out=$conn->query("select * from lokasi order by nama ASC");
									 while ($o=$out->fetch_array()) :
									 ?>           
                                                <option value="<?=$o['id_lokasi']?>"><?=$o['nama']?></option>
                                     <?php endwhile;?>           
                                       </select>
                                    </div>
                                </div>
                                
    </div>

                                <button type="submit" name="tambah_rekening_bank" class="btn btn-primary m-t-15 waves-effect">Simpan</button>
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
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
function saveToDatabase(editableObj,column,id) {
	$(editableObj).css("background","#FFF url(../stok/img/loader.gif) no-repeat right");
	$.ajax({
		url: "form_crud_supplier.php?live_edit=tabel_supplier",
		type: "POST",
		data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
		success: function(data){
			$(editableObj).css("background","#FDFDFD");
		}        
   });
}
</script>

<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
<!--Akhir Javasrip Modal Delete-->  

<script>
function untuk_umum() {
    var x = document.getElementById("radio_umum");
    var y = document.getElementById("pel_umum");
	if (x.checked == true){
        y.style.display = "block";
    } else {
       y.style.display = "none";
    }
}
</script>


<script>
        jQuery(document).ready(function($){
            $('.aktif-link').on('click',function(){
                var getLink = $(this).attr('href');
                swal({
                        title: 'Alert',
                        text: 'Aktifkan Rekening..?',
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
                        text: 'Non Aktifkan Rekening..?',
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