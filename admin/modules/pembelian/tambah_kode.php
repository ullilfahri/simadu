
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
				<li><a href="javascript:void(0);"><i class="fa fa-edit fa-lg"></i> Stok</a></li>
			</ol>  
            
            <!-- Inline Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TAMBAH KODE BARANG
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
                            <input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
                                <div class="row clearfix js-sweetalert">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" autofocus required>
                                                <label class="form-label">Kode Barang</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect" name="cek" onclick='autoComplete();' data-type="with-custom-icon">Cek</button>
                                    </div>
                                                                        
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="nama_barang" <?php if (isset($_GET['input'])):?> value="<?=$_GET['input']?>" <?php endif;?> required>
                                                <label class="form-label">Nama Barang</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="satuan" required>
                                                <label class="form-label">Satuan</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="harga_barang" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                                <label class="form-label">Harga Jual</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="submit" name="tambah_kode" class="btn btn-primary btn-lg m-l-15 waves-effect">Simpan</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                      <div class="body">
                      <div id='hasil'></div>
                      </div>
                    </div>
                </div>
            </div>
            <!-- #END# Inline Layout | With Floating Label -->
            
                 
            </div>
    </section>

<?PHP
if (isset($_POST['tambah_kode'])) :

$kode_barang = $_POST['kode_barang'];
$distributor = $_POST['distributor'];
$satuan = $_POST['satuan'];
$nama_barang = $_POST['nama_barang'];
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$harga_barang = preg_replace("/[^0-9.]/", '', $harga_barang);
$ada=$conn->query("select * from stok_barang where kode_barang='$kode_barang'")->num_rows;

if ($ada > 0) {
echo "<script>window.alert('Barang dengan kode $kode_barang sudah ada, silahkan ganti dengan kode baru') 
		window.location='tambah_kode.php'</script>";
} else {
$masuk=$conn->query("insert into stok_barang(kode_barang, nama_barang, harga_barang, sisa_stok, satuan, distributor) VALUES('$kode_barang', '$nama_barang','$harga_barang','0', '$satuan', '$distributor')");
/*echo "<script>window.alert('Tambah Data Kode Barang Tersimpan') 
		window.location='index.php?OKhghh&input=$nama_barang&kode=$kode_barang'</script>";*/

//index.php?OKhghh&input='.$nama_barang.'&kode='.$kode_barang.'

echo '<script>
    setTimeout(function() {
        swal({
            title: "Tambah Data Kode Barang Tersimpan!",
			imageUrl: "../../../images/thumbs-up.png",
            type: "success"
        }, function() {
            window.location = "index.php?OKhghh&input='.$nama_barang.'&kode='.$kode_barang.'";
        });
    }, 1000);
</script>';		
}

endif;
?>

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

<!-- Bootstrap Notify Plugin Js -->
    <script src="<?=PLG?>bootstrap-notify/bootstrap-notify.js"></script>
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
<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
    
<!---JS AUTOCOMPLE-->   
<script language="JavaScript">
    var ajaxRequest;
    function getAjax() { //fungsi untuk mengecek AJAX pada browser
        try {
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
    }
    function autoComplete() { //fungsi menangkap input search dan menampilkan hasil search
        getAjax();
        input = document.getElementById('kode_barang').value;if (input == "") {
            document.getElementById("hasil").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","form_crud.php?cari_kode&input="+input);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
	
</script>
<!---AKHIR JS AUTOCOMPLE-->   

</body>

</html>