<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] != 3) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
	
if ($_SESSION['sub_level'] != 3) :
	echo "<script>window.alert('Hanya Kasir yang memiliki Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
	
$ambil=$conn->query("SELECT no_faktur FROM tabel_faktur WHERE total_trx=0 and kasir='".$_SESSION['id']."'");
while ($a=$ambil->fetch_array()) :
	$retur=$conn->query("select * from tabel_trx where no_faktur='".$a[0]."'");
	while ($b=$retur->fetch_array()) :
	$sisa_stok=$conn->query("select sisa_stok from stok_barang where kode_barang='".$b['kode_barang']."'")->fetch_array();
	$stok=$b['jumlah']+$sisa_stok[0];
	$update=$conn->query("update stok_barang set sisa_stok='$stok' where kode_barang='".$b['kode_barang']."'");
	endwhile;
	$hapus_trx=$conn->query("delete from tabel_trx where no_faktur='".$a[0]."'");
	$hapus_alokasi_jual=$conn->query("delete from alokasi_stok_jual where no_faktur='".$a[0]."'");
endwhile;
$hapus_faktur=$conn->query("delete FROM tabel_faktur WHERE total_trx=0 and kasir='".$_SESSION['id']."'");

$no_faktur=strtotime(date('Y-m-d H:i:s'));
$ada=$conn->query("SELECT * FROM tabel_faktur where no_faktur='$no_faktur'")->num_rows;
if ($ada > 0) {
echo '<script>
    setTimeout(function() {
        swal({
            title: "'.$no_faktur.'",
            text: "No Transaksi sedang diakses User Lain, Harap Tunggu Sesaat, Sedang Menyiapkan No Transaksi",
            type: "error",
			timer: 5000,
			showConfirmButton: false
        }, function() {
            window.location = "index.php?Jnjhg=YMLjhyt";
        });
    }, 1000);
</script>';

} else {

$masuk=$conn->query("INSERT INTO tabel_faktur(no_faktur, kasir, total_trx, id_toko) VALUES ('$no_faktur', '".$_SESSION['id']."', '0', '".$_SESSION['toko']."')");

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
				<li><a href="javascript:void(0);"><i class="fa fa-cart-arrow-down fa-lg"></i> Penjualan</a></li>
			</ol>  
            
           
            <!-- Horizontal Layout -->
          <div id="form_pelanggan" style="display:block">  
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA CUSTOMER
                            </h2>
                        <div class="body">
                            <form class="form-horizontal FrmEntry" name="epen_1">
                            <input type="hidden" name="no_faktur" value="<?=$no_faktur?>" />
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="tipe_pelanggan">Pilih Tipe Pelanggan Terlebih Dahulu</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <input name="tipe_pelanggan" type="radio" id="radio_1" value="1" onclick="check(this.value)" class="with-gap radio-col-indigo"/>
                                		<label for="radio_1">Pelanggan Tetap</label>
                                    	<input name="tipe_pelanggan" type="radio" id="radio_2" value="0" onclick="check(this.value)" class="with-gap radio-col-blue"/>
                                		<label for="radio_2">Pelanggan Umum</label>
                                    </div>
                                </div>
                                                            
                            <div id="pel_umum" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="nama_umum">Nama Customer</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="nama_umum" name="nama_umum" class="form-control" placeholder="Masukan Nama Customer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="alamat_umum">Alamat</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="alamat_umum" name="alamat_umum" class="form-control" placeholder="Masukan Alamat Customer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="kota_umum">Kota</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="kota_umum" name="kota_umum" class="form-control" value="Ketapang">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="hp_umum">No Telp/Fax/HP</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="hp_umum" name="hp_umum" class="form-control" placeholder="Masukan HP Customer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--DIV Pel_umum-->
                            
                            <div id="pel_tetap" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="customer">Pilih Pelanggan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="customer"  id="customer" class="form-control show-tick" data-live-search="true" data-show-subtext="true">
                                                <option value="">--PILIH PELANGGAN TETAP--</option>
                                                <?php
                                                $sct_sql=$conn->query(" SELECT id, nama, level_diskon, limit_kredit from tabel_customer ORDER BY nama ASC ");
												while ($x=$sct_sql->fetch_array()) :
												$limit_kredit=$conn->query("SELECT SUM(jumlah_transaksi)-SUM(jumlah_bayar) FROM tabel_bayar where customer='$x[0]' AND metode_bayar=1")->fetch_array();
												?>
                                                <option value="<?=$x[0]?>" data-subtext="Limit Piutang <?=angka($x[3]-$limit_kredit[0])?>"><?=$x[1]?></option>
                                                <?php endwhile;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--DIV Pel_tetap-->
                            
                            <div id="tombol_pelanggan" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="button" onclick="return data_customer();" class="btn btn-primary m-t-15 waves-effect">Lanjutkan</button>
                                    </div>
                                </div>
                           </div>     
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
         </div>   
            <!-- #END# Horizontal Layout -->           
           
			
            <div class="from_entry"></div>
                             
            </div>
    </section>


<!-- Modal Small Size -->
            <div class="modal fade" id="smallModal" role="dialog"  style="overflow:hidden;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">Cetak Struk</h4>
                        </div>
                        <div class="modal-body" style="max-height: 800px">
						<div class="fetched-data"></div>
                        
                    </div>
                </div>
            </div>
<!--MODAL-->


    <!-- Jquery Core Js -->
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>
    
    <!-- Input Mask Plugin Js -->
    <script src="<?=JS?>my.js"></script>

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
<script type="text/javascript" src="<?=JS?>jquery.shortcuts.min.js"></script>
    <!-- Custom Js -->
 

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('#smallModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?modal',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->


<script>
function check(tipe_pelanggan) {
document.getElementById("tombol_pelanggan").style.display = "block";
var pel_umum = document.getElementById("pel_umum");
var pel_tetap = document.getElementById("pel_tetap");
  if (tipe_pelanggan==0) {
  	pel_umum.style.display = "block";
  	pel_tetap.style.display = "none";
	} else {
  	pel_tetap.style.display = "block";
	pel_umum.style.display = "none";
	}
}
</script>

<script type="text/javascript">

function data_customer() {
tipe_pelanggan = document.epen_1.tipe_pelanggan.value;
customer =document.epen_1.customer.value;
nama_umum =document.epen_1.nama_umum.value;
alamat_umum =document.epen_1.alamat_umum.value;
kota_umum =document.epen_1.kota_umum.value;
if (tipe_pelanggan==1 && customer=="") {
    		swal("Gagal!", "Isi Data Pelanggan!", "error");
			return false;
} else if (tipe_pelanggan==0 && nama_umum=="") {
    		swal("Gagal!", "Isi Data Pelanggan Umum!", "error");
			return false;
} else {
	var data=$(".FrmEntry").serialize();
		$.ajax({
		type:'POST',
		url:'form_unggah.php?update_customer',
		data:data,
		success:function(){
		$(".from_entry").load("form_entry.php?no_faktur=<?=$no_faktur?>");
		document.getElementById("form_pelanggan").style.display = "none";
		} 
	});
}


}
</script>


</body>

</html>