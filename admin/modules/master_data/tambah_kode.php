
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

if (isset($_GET['belum_kode'])) {
$jenis_barang=$_GET['jenis_barang'];
$merek_barang=$_GET['merek_barang'];
$metode=$_GET['dari_kode'];
$ada_jenis='1';
} else {
$merek_barang=strtoupper($_GET['input']);
$jenis_barang='';
$metode=$_GET['dari_input'];
}

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-wrench fa-lg"></i> Tambah Kode</a></li>
			</ol>  
            
            
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TAMBAH KODE BARANG
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="<?=$_SERVER['PHP_SELF']?>" id="myform" class="form-horizontal js-sweetalert" autocomplete="off">
                            <input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
                            <input type="hidden" name="metode" value="<?=$metode?>" />
                            <input type="hidden" name="ada_jenis" value="<?=$ada_jenis?>" />
                            
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="kode">Kode Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" onkeyup='autoComplete();' autofocus required>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="nama">Jenis Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="jenis_barang" id="jenis_barang" value="<?=$jenis_barang?>" <?php if (isset($_GET['belum_kode'])) { echo 'readonly'; } else { echo 'required';}?> onkeyup='autoComplete_jenis_barang();'>
                                            </div>
                                             <div id='hasil_jenis_barang'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="merk">Merek/Sebutan Lain</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control merek_barang" name="merek_barang" id="merek_barang" value="<?=$merek_barang?>" <?php if (isset($_GET['belum_kode'])) { echo 'readonly'; } else { echo 'required';}?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="full_satuan">Satuan</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="satuan" id="satuan" onkeyup='autoComplete_satuan();' required>
                                            </div>
                                            <div id="hasil_satuan"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="nama">Akronim Satuan, ex. bh untuk buah</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="akronim" id="akronim" required>
                                                <input type="hidden" class="form-control" name="ada_satuan" id="ada">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="jual">Harga Jual</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="harga_barang" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" id="tombol" name="tambah_kode" class="btn btn-success btn-lg m-l-15 waves-effect" disabled>&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>
                                        <button type="reset" onclick="reset_form()" class="btn btn-warning btn-lg m-l-15 waves-effect">Reset Form</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout --> 
            
            <!-- Blockquotes -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                KETERANGAN
                            </h2>
                        </div>
                        <div class="body">
                            <blockquote>
                                <p>Penggunaan Form Tambah Kode.</p>
                                <footer>Hasil Pencarian bersifat sugestif</footer>
                                <footer>Jika Elemen Jenis, Merek, Satuan dan Akronim Tidak Ada di database, maka elemen tersbut akan secara otomatis masuk dalam database Katalog Barang</footer>
                                <footer>Tombol simpan akan aktif jika user mengkilk validasi data pada field Kode</footer>
                                <footer>Gunakan Tombol Reset Form Jika ingin mengubah field</footer>
                                <footer>Jika Prosedural sudah benar dan masuk dalam database, laman ini akan tertutup otomatis, silahkan entry nama barang pada laman Entry Pembelian dengan memasukan nama barang yang sudah dientry.</footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Blockquotes -->                 
            
            </div>
    </section>

<?PHP
if (isset($_POST['tambah_kode'])) :

$akronim = $_POST['akronim'];
$satuan_barang = $_POST['satuan'];
$jenis_barang = $_POST['jenis_barang'];
$merek_barang = $_POST['merek_barang'];
$ada_jenis = $_POST['ada_jenis'];
$ada_satuan = $_POST['ada_satuan'];


if ($ada_jenis != 1) :
$conn->query("REPLACE INTO barang_jenis(jenis_barang, merek_barang) VALUES('$jenis_barang', '$merek_barang') ");
endif;

if ($ada_satuan != 1) :
$conn->query("REPLACE INTO barang_satuan(satuan_barang, akronim) VALUES('$satuan_barang', '$akronim') ");
endif;


$distributor = $_POST['distributor'];
$kode_barang = $_POST['tambah_kode'];
$nama_barang = $jenis_barang.' '.$merek_barang;
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$harga_barang = preg_replace("/[^0-9.]/", '', $harga_barang);
$masuk=$conn->query("insert into stok_barang(kode_barang, nama_barang, harga_barang, sisa_stok, satuan, distributor) VALUES('$kode_barang', '$nama_barang','$harga_barang','0', '$akronim', '$distributor')");


echo "<script>window.alert('Data Disimpan') 
		window.close()</script>"; 

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
            ajaxRequest.open("GET","ajax_kode.php?cari_kode&input="+input);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert(tombol) { //fungsi mengisi input text dengan hasil pencarian yang dipilih
        document.getElementById("tombol").value = tombol;
        document.getElementById("hasil").innerHTML = "";
        document.getElementById('tombol').disabled = false;
        document.getElementById('kode_barang').disabled = true;
    }
	
</script>
<!---AKHIR JS AUTOCOMPLE-->  

<script>
function reset_form() {
        document.getElementById('kode_barang').value = "";
        document.getElementById('kode_barang').disabled = false;
		
        document.getElementById('jenis_barang').value = "";
		<?php if (isset($_GET['input'])) {?>
        document.getElementById('jenis_barang').readOnly = false;
        document.getElementById('merek_barang').readOnly = false;
		<?php } else { ?>
		document.getElementById('jenis_barang').readOnly = true;
        document.getElementById('merek_barang').readOnly = true;
		<?php }?>
        document.getElementById('merek_barang').value = "";
		
        document.getElementById('satuan').value = "";
        document.getElementById('satuan').readOnly = false;
		
        document.getElementById('akronim').value = "";
        document.getElementById('akronim').readOnly = false;
		
        document.getElementById('tombol').disabled = true;
}
</script>

<script type="text/javascript">
    function autoComplete_jenis_barang() { 
        getAjax();
        jenis_barang = document.getElementById('jenis_barang').value;if (jenis_barang == "") {
            document.getElementById("hasil_jenis_barang").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","ajax_kode.php?jenis_barang="+jenis_barang);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil_jenis_barang").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert_jenis_barang(jenis_barang) { 
        document.getElementById("jenis_barang").value = jenis_barang;
		document.getElementById("jenis_barang").readOnly = true;
        document.getElementById("hasil_jenis_barang").innerHTML = "";
    }
</script>    

<script type="text/javascript">
    function autoComplete_satuan() { 
        getAjax();
        satuan = document.getElementById('satuan').value;if (satuan == "") {
            document.getElementById("hasil_satuan").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","ajax_kode.php?satuan="+satuan);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil_satuan").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert_satuan(satuan, akronim, ada) { 
        document.getElementById("ada").value = ada;
        document.getElementById("satuan").value = satuan;
		document.getElementById("satuan").readOnly = true;
        document.getElementById("akronim").value = akronim;
		document.getElementById("akronim").readOnly = true;
        document.getElementById("hasil_satuan").innerHTML = "";
    }
</script>   

<script>
document.getElementById("jenis_barang").addEventListener("change", myFunction);
document.getElementById("merek_barang").addEventListener("change", myFunction);
document.getElementById("satuan").addEventListener("change", myFunction);
document.getElementById("akronim").addEventListener("change", myFunction);

function myFunction() {
    var jenis_barang = document.getElementById("jenis_barang");
    jenis_barang.value = jenis_barang.value.toUpperCase();
	document.getElementById("jenis_barang").readOnly = true;
	
    var merek_barang = document.getElementById("merek_barang");
    merek_barang.value = merek_barang.value.toUpperCase();
	
    var satuan = document.getElementById("satuan");
    satuan.value = satuan.value.toUpperCase();
	
    var akronim = document.getElementById("akronim");
    akronim.value = akronim.value.toUpperCase();	
	
	
}
</script> 

</body>

</html>