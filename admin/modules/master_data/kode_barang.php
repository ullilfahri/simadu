
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

$distributor=$conn->query(" SELECT pengguna from mst_hak_akses WHERE kode = '".$_SESSION['distributor']."' ")->fetch_array();

if ($_GET['katalog_barang']=='ubah_data') {
$id=$_GET['id'];
$val=$conn->query("SELECT a.kode_barang, b.jenis_barang, b.merek_barang, b.nama_barang, c.satuan_barang, c.akronim, a.harga_barang, a.level_1, a.level_2, a.level_3 FROM stok_barang as a LEFT JOIN kode_barang as b ON a.kode_barang=b.kode_barang LEFT JOIN barang_satuan as c ON a.satuan=c.akronim WHERE a.id = '$id' ")->fetch_array();
$tombol_validasi_kode='';
$kode_barang='value="'.$val[0].'" readonly';
$jenis_barang='value="'.$val[1].'" readonly';
$merek_barang='value="'.$val[2].'" readonly';
$nama_barang='value="'.$val[3].'" required';
$satuan='value="'.$val[4].'" onfocus="klik_fungsi(this)"';
$akronim='value="'.$val[5].'" readonly';
$harga_barang='value="'.angka($val[6]).'" required';
$level_1='value="'.angka($val[7]).'" autofocus';
$level_2='value="'.angka($val[8]).'" autofocus';
$level_3='value="'.angka($val[9]).'" autofocus';
$tombol_simpan='
<button type="submit" name="ubah_data" class="btn btn-warning btn-lg m-l-15 waves-effect">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>
';
$form='action="crud_katalog_barang.php"';
$input_id='<input type="hidden" name="id" value="'.$id.'">';
$judul='UBAH DATA';
} else {
$tombol_validasi_kode='
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<button type="button" id="tombol_validasi" class="btn btn-primary btn-sm waves-effect" onclick="validasi_kode();">Generate Kode</button>
</div>
';
$kode_barang='readonly';
$jenis_barang='autofocus';
$merek_barang='';
$nama_barang="onkeyup='autoComplete_nama_barang();' onchange='myFunction()'";
$satuan='';
$akronim='';
$harga_barang='';
$level_1='';
$level_2='';
$level_3='';
$tombol_simpan='
<button type="button" onclick="tambah_kode()" id="tombol" class="btn btn-success btn-lg m-l-15 waves-effect" disabled>&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>
<button type="button" onclick="reset_form();" class="btn btn-warning btn-lg m-l-15 waves-effect">Reset Form</button>
';
$form='';
$input_id='';
$judul='TAMBAH KODE';
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
                                <?=$judul?> BARANG
                            </h2>
                            <hr>
                            User login : <?=$_SESSION['adminUsername']?>
                        </div>
                        <div class="body">
                            <form method="post" id="myform" class="form-horizontal js-sweetalert" autocomplete="off" <?=$form?>>
                            <input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
                            <?=$input_id?>
                            
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="kode">Kode Barang</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" <?=$kode_barang?>>
                                            </div>
                                        </div>
                                    </div>
                                    <?=$tombol_validasi_kode?>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="nama">Jenis Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="jenis_barang" id="jenis_barang" onkeyup='autoComplete_jenis_barang();' onchange="myFunction()" <?=$jenis_barang?>>
                                                <input type="hidden" class="form-control" name="ada_jenis" id="ada_jenis">
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
                                                <input type="text" class="form-control" name="merek_barang" id="merek_barang"  onkeyup='autoComplete_merek_barang();' onchange="myFunction()" <?=$merek_barang?>>
                                                <input type="hidden" class="form-control" name="ada_merek" id="ada_merek">
                                            </div>
                                             <div id='hasil_merek_barang'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="nama_barang">Nama Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="nama_barang" id="nama_barang" <?=$nama_barang?>>
                                                <input type="hidden" class="form-control" name="ada_nama" id="ada_nama">
                                            </div>
                                             <div id='hasil_nama_barang'></div>
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
                                                <input type="text" class="form-control" name="satuan" id="satuan" onkeyup='autoComplete_satuan();' onchange="myFunction()" <?=$satuan?>>
                                                <input type="hidden" class="form-control" name="ada_satuan" id="ada_satuan">
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
                                                <input type="text" class="form-control" name="akronim" id="akronim" onchange="myFunction()" <?=$akronim?>>
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
                                                <input type="text" class="form-control" name="harga_barang" id="harga_barang" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required <?=$harga_barang?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="level_1">Diskon Level 1</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="level_1" id="level_1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" <?=$level_1?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="level_2">Diskon Level 2</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="level_2" id="level_2" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" <?=$level_2?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="level_3">Diskon Level 3</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="level_3" id="level_3" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" <?=$level_3?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-5">
                                        <?=$tombol_simpan?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout --> 
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR BARANG <?=$distributor[0]?>
                            </h2>
                        </div>
                        <div class="body">
                        
							<div class="list-data">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->            
            
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

<!-- Bootstrap Notify Plugin Js -->
    <script src="<?=PLG?>bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Jquery DataTable Plugin Js -->
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
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

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
$(document).ready(function(){
        $(".list-data").load("crud_katalog_barang.php?data_stok&tabel=stok_barang&distributor=<?=$_SESSION['distributor']?>");
});
</script>

<script>
function myFunction() {
    var a = document.getElementById("jenis_barang");
    var b = document.getElementById("nama_barang");
    var c = document.getElementById("merek_barang");
    var d = document.getElementById("satuan");
    var e = document.getElementById("akronim");
    a.value = a.value.toUpperCase();
    b.value = b.value.toUpperCase();
    c.value = c.value.toUpperCase();
    d.value = d.value.toUpperCase();
    e.value = e.value.toUpperCase();
}
</script>



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
    function autoInsert_jenis_barang(jenis_barang, ada_jenis) { 
        document.getElementById("jenis_barang").value = jenis_barang;
        document.getElementById("ada_jenis").value = ada_jenis;
		document.getElementById("jenis_barang").readOnly = true;
        document.getElementById("hasil_jenis_barang").innerHTML = "";
    }
	
    function autoComplete_merek_barang() { 
        getAjax();
        merek_barang = document.getElementById('merek_barang').value;if (merek_barang == "") {
            document.getElementById("hasil_merek_barang").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","ajax_kode.php?merek_barang="+merek_barang);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil_merek_barang").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert_merek_barang(merek_barang, ada_merek) { 
        document.getElementById("merek_barang").value = merek_barang;
        document.getElementById("ada_merek").value = ada_merek;
		document.getElementById("merek_barang").readOnly = true;
        document.getElementById("hasil_merek_barang").innerHTML = "";
    }
	
   
   
    function autoComplete_nama_barang() { 
        getAjax();
        nama_barang = document.getElementById('nama_barang').value;if (nama_barang == "") {
            document.getElementById("hasil_nama_barang").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","ajax_kode.php?nama_barang="+nama_barang);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil_nama_barang").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert_nama_barang(nama_barang, ada_nama) { 
        document.getElementById("nama_barang").value = nama_barang;
        document.getElementById("ada_nama").value = ada_nama;
		document.getElementById("nama_barang").readOnly = true;
        document.getElementById("hasil_nama_barang").innerHTML = "";
    }

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
        document.getElementById("ada_satuan").value = ada;
        document.getElementById("satuan").value = satuan;
		document.getElementById("satuan").readOnly = true;
        document.getElementById("akronim").value = akronim;
		document.getElementById("akronim").readOnly = true;
        document.getElementById("hasil_satuan").innerHTML = "";
    }
	
</script>
<!---AKHIR JS AUTOCOMPLE-->  

<script type="application/javascript">
function reset_form() {
document.getElementById("myform").reset();
document.getElementById("tombol_validasi").disabled=false;
document.getElementById("tombol").disabled=true;
document.getElementById("jenis_barang").readOnly=false;
document.getElementById("merek_barang").readOnly=false;
document.getElementById("nama_barang").readOnly=false;
document.getElementById("satuan").readOnly=false;
document.getElementById("akronim").readOnly=false;
}
</script>
   
<script type="application/javascript">
    function validasi_kode() { 
       var jenis_barang = document.getElementById('jenis_barang').value;
       var merek_barang = document.getElementById('merek_barang').value;
       var nama_barang = document.getElementById('nama_barang').value;
		if (jenis_barang == "") {
            swal("Gagal!", "Jenis Barang Harus Terisi", "error");
        
		} else if (merek_barang == "") {
            swal("Gagal!", "Merek Barang Harus Terisi", "error");
        
		} else if (nama_barang == "") {
            swal("Gagal!", "Nama Barang Harus Terisi", "error");
	   
	   } else {
		$.ajax({
			type:'POST',
			data:'distributor=<?=$_SESSION['distributor']?>&jenis_barang='+jenis_barang+'&merek_barang='+merek_barang+'&nama_barang='+nama_barang,
			url:'ajax_kode.php?cari_kode_bujur',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				swal("Sukses!", "Kode "+response.barang+" Adalah "+response.kode, "success");
				document.getElementById("kode_barang").value = response.kode;
				document.getElementById('jenis_barang').readOnly = true;
				document.getElementById('merek_barang').readOnly = true;
				document.getElementById('nama_barang').readOnly = true;
				document.getElementById('tombol_validasi').disabled = true;
        		document.getElementById('tombol').disabled = false;
				} else if (response.error){
				swal({
        		title: "Kode Sudah Ada!",
        		text: response.barang,
        		html: true
    			});
				} else {
					alert('gagal');
				}
			}
		});
	  }	
	}
</script>   
                            
<script>
function hilang_titik(string) {
            return string.split('.').join('');
        }

</script> 

<script type="application/javascript">
 function tambah_kode() {
 var akronim   = document.getElementById("akronim").value;
 var kode_barang   = document.getElementById("kode_barang").value;
 var satuan   = document.getElementById("satuan").value;
 var jenis_barang   = document.getElementById("jenis_barang").value;
 var merek_barang   = document.getElementById("merek_barang").value;
 var nama_barang   = document.getElementById("nama_barang").value;
 var ada_jenis   = document.getElementById("ada_jenis").value;
 var ada_merek   = document.getElementById("ada_merek").value;
 var ada_nama   = document.getElementById("ada_nama").value;
 var ada_satuan   = document.getElementById("ada_satuan").value;
 var harga_barang   = hilang_titik(document.getElementById("harga_barang").value);
 var level_1   = hilang_titik(document.getElementById("level_1").value);
 var level_2   = hilang_titik(document.getElementById("level_2").value);
 var level_3   = hilang_titik(document.getElementById("level_3").value);
    swal({
        title: "Tambah Kode Produk",
        text: "Tekan OK untuk Generate Kode "+kode_barang,
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function () {
        $.ajax({
		url	     : 'crud_katalog_barang.php?tambah_kode_barang',
		type     : 'POST',
		dataType : 'html',
		data     : 'distributor=<?=$_SESSION['distributor']?>&kode_barang='+kode_barang+'&akronim='+akronim+'&satuan='+satuan+'&jenis_barang='+jenis_barang+'&merek_barang='+merek_barang+'&nama_barang='+nama_barang+'&ada_jenis='+ada_jenis+'&ada_merek='+ada_merek+'&ada_nama='+ada_nama+'&ada_satuan='+ada_satuan+'&harga_barang='+harga_barang+'&level_1='+level_1+'&level_2='+level_2+'&level_3='+level_3,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			swal("Sukses!", response.pesan, "success");
			$(".list-data").load("crud_katalog_barang.php?data_stok&tabel=stok_barang&distributor=<?=$_SESSION['distributor']?>");
			document.getElementById("myform").reset();
			document.getElementById("tombol_validasi").disabled=false;
			document.getElementById("tombol").disabled=true;
			document.getElementById("jenis_barang").readOnly=false;
			document.getElementById("merek_barang").readOnly=false;
			document.getElementById("nama_barang").readOnly=false;
			document.getElementById("satuan").readOnly=false;
			document.getElementById("akronim").readOnly=false;
			} else if (response.error){
			swal("Gagal!", response.pesan, "error");
			} else {
			swal("Gagal!", response.pesan, "error");
			}
		},
	})
    });
}
</script>   

<script type="application/javascript">
function klik_fungsi() {
  document.getElementById("satuan").value = '';
  document.getElementById("akronim").value = '';
}
</script>


<script>
$(document).ready(function(){
  $("#nama_barang").keypress(function(e){
    var keyCode = e.which;
    if ( keyCode == 39) {
      e.preventDefault();
    }
  });
});
</script>

</body>

</html>