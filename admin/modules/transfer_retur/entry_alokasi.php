<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_form2.php';
include MDL.'login/session.php';
if ($_SESSION['level'] !=4 ) :
	echo "<script>window.alert('Hanya Admin Gudang Memiliki Hak Akses..!')
    		window.location='../transfer_retur/summary_data.php?data=data_retur'</script>";
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
if ($_GET['url']) {
$x=$conn->query("SELECT * FROM tabel_retur where id = '".$_GET['id']."' ")->fetch_array();
$barang=$x['jumlah_barang']-$x['is_alokasi'];
$display='none';
$nama_barang='<input type="text" value="'.$x['nama_barang'].'" id="inputan" class="form-control" readonly/>';
$jumlah='<input type="text" name="jumlah_barang"  id="jumlah_barang" value="" class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required/>';
$util='
<input type="hidden" value="'.$x['id'].'" name="id_retur">
<input type="hidden" name="jenis_form" value="alokasi">
<input type="hidden" name="tot_awal" value="'.$barang.'">
<input type="hidden" value="'.$x['kode_barang'].'" name="kode_barang"/>
';
$judul='ALOKASI STOK DARI RETUR/TRANSFER BARANG';
$tempat='Penempatan Gudang';
$pintu='Penempatan Pintu/Sekat/Ruang';
$jumlah_awal='<input type="text" value="'.$barang.'" name="jumlah_awal" id="jumlah_awal" class="form-control text-center" readonly>';
$req='';
$paginasi='';
$id_trx='';	

} else {
$display='block';
$nama_barang="<input type='text' name='nama_barang' id='inputan' class='form-control' onkeyup='autoComplete();' autofocus required/>";
$jumlah='<input type="text" name="jumlah_barang" id="jumlah_barang" value="" class="form-control" onFocus="startCalc();" onBlur="stopCalc();"  required/>';
$util='
<input type="hidden" id="kode_barang" name="kode_barang"/>
<input type="hidden" name="jenis_form" value="transfer_barang">
<input type="hidden" id="tot_awal" name="tot_awal">
<input type="hidden" id="id_asal" name="id_asal">
';
$judul='TRANSFER BARANG';
$tempat='Dari Gudang';
$pintu='Dari Pintu/Sekat/Ruang';
$jumlah_awal='<input type="text" id="jumlah_awal" name="jumlah_awal" class="form-control text-center" readonly>';
$req='required';
$paginasi='<div class="paginasi_transfer"></div>';
$id_trx=strtotime(date('Y-m-d H:i:s'));	
$ada=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx'")->num_rows;
if ($ada > 0) :
echo '<script>
    setTimeout(function() {
        swal({
            title: "INFO",
            text: "Maaf, Laman ini Sedang Diakses User Lain, Laman akan direload dalam 5 Detik",
            type: "info",
			timer: 5000,
			showConfirmButton: false
        }, function() {
            window.location = "entry_alokasi.php?JmnJUHS";
        });
    }, 1000);
</script>';
endif;

}
$nama_gudang=$conn->query("SELECT id_lokasi, nama from lokasi where id_lokasi = '".$_SESSION['gudang']."'")->fetch_array();

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
                                <?=$judul?>
                                <small>Pilih Barang Untuk Dialokasikan ke masing-masing gudang</small>
                            </h2>
                        </div>
                        <div class="body">
                            <form name="epen" id="form_epen" class="form-input" autocomplete="off">
                            <input type="hidden" name="id_user" value="<?=$_SESSION['id']?>"/>
                            <input type="hidden" name="id_trx" id="id_trx" value="<?=$id_trx?>"/>
                            <input type="hidden" id="gudang_sendiri" value="<?=$_SESSION['gudang']?>"/>
                            <?=$util?>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Nama Barang</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?=$nama_barang?>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Jumlah Alokasi Barang</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?=$jumlah?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2"><?=$tempat?></label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class='form-control show-tick' name='id_gudang' id="gudang" onchange="javascript:rubah(this)" required>
                                                <option value='<?=$nama_gudang[0]?>'><?=$nama_gudang[1]?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2"><?=$pintu?></label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <?php if (isset($_GET['url'])) { ?>
                                                <select class='form-control show-tick' name='pintu_gudang' id="pintu" required>
                                                <option value=''>-- Silahkan Pilih Pintu --</option>
                                                <?php 
												$pintu=$conn->query("select a.nama_pintu, a.id_gudang from pintu_gudang as a left join lokasi as b on a.id_gudang = b.id_lokasi order by a.id_gudang asc");
												while ($p=$pintu->fetch_array()):
												?>
                                                <option id="pintu" class="<?=$p[1]?>" value="<?=$p[0]?>"><?=$p[0]?></option>
                                                <?php endwhile;?>
                                                </select>
                                                <?php } else { ?>
                                                <input type="text" id="pintu_gudang" name="pintu_gudang" class="form-control" readonly>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<div style="display:<?=$display?>">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Gudang Tujuan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class='form-control show-tick' name='gudang_tujuan' id='gudang_tujuan' onchange="buka_rahasia()" <?=$req?>>
                                                <option value=''>-- Silahkan Pilih Gudang --</option>
                                                <?php 
												$gudang_tujuan=$conn->query("select id_lokasi, nama from lokasi order by nama asc");
												while ($gt=$gudang_tujuan->fetch_array()):
												?>
                                                <option value="<?=$gt[0]?>"><?=$gt[1]?></option>
												<?php endwhile;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
</div>                               


<div id='rahasia' style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Pintu Tujuan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class='form-control show-tick' name='pintu_tujuan' id='pintu_tujuan'>
                                                <option value=''>-- Silahkan Pilih Pintu --</option>
                                                <?php 
												$pintu_tujuan=$conn->query("select * from pintu_gudang  where id_gudang='".$_SESSION['gudang']."'");
												while ($pt=$pintu_tujuan->fetch_array()):
												?>
                                                <option id="pintu" value="<?=$pt['nama_pintu']?>"><?=$pt['nama_pintu']?></option>
                                                <?php endwhile;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
</div>   


                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Stok Tersedia</label>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-7">
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <div class="form-line">
                                                <?=$jumlah_awal?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-7">
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <div class="form-line">
                                                <button type="button" class="btn btn-primary m-t-15 waves-effect" onclick="return validasi()">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                


                                        
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Inline Layout | With Floating Label -->
            
            <?=$paginasi?>
            
                             
            </div>
    </section>



    <!-- Jquery Core Js -->
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>
    
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?=PLG?>bootstrap-notify/bootstrap-notify.js"></script>    

    <!-- Bootstrap Colorpicker Js -->
    <script src="<?=PLG?>bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="<?=PLG?>dropzone/dropzone.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="<?=PLG?>jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Multi Select Plugin Js -->
    <script src="<?=PLG?>multi-select/js/jquery.multi-select.js"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="<?=PLG?>jquery-spinner/js/jquery.spinner.js"></script>

    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="<?=PLG?>bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
        <script src="<?=PLG?>jquery-validation/jquery.validate.js"></script>
    <!-- Sweet Alert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>


    <!-- noUISlider Plugin Js -->
    <script src="<?=PLG?>nouislider/nouislider.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/forms/advanced-form-elements.js"></script>
    <script src="<?=JS?>pages/ui/modals.js"></script>
    
    <script src="<?=JS?>jquery.chained.min.js"></script>
   <script>
            $("#pintu").chained("#gudang");
   </script>

<!---AKHIR JS AUTOCOMPLE-->  
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
        input = document.getElementById('inputan').value;if (input == "") {
            document.getElementById("hasil").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","proses_ajax.php?transfer_barang&id_gudang=<?=$_SESSION['gudang']?>&input="+input);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert(id_asal, jumlah_awal, nama_barang, kode_barang, pintu_gudang) {//fungsi mengisi input text dengan hasil pencarian yang dipilih
        document.getElementById("inputan").value = nama_barang;
        document.getElementById("id_asal").value = id_asal;
        document.getElementById("kode_barang").value = kode_barang;
        document.getElementById("jumlah_awal").value = jumlah_awal;
        document.getElementById("tot_awal").value = jumlah_awal;
        document.getElementById("pintu_gudang").value = pintu_gudang;
		document.getElementById("inputan").readOnly = true;
        document.getElementById("hasil").innerHTML = "";
    }

</script>  

<script>
    function startCalc(){
    		interval = setInterval("calc()",1);
    }
    function calc(){
	    tot_awal = document.epen.tot_awal.value;
	    jumlah_barang = document.epen.jumlah_barang.value;
		jumlah_awal=tot_awal-jumlah_barang;

		document.epen.jumlah_awal.value = jumlah_awal;
	}
    function stopCalc(){
    	clearInterval(interval);
    }
</script> <!-- Menghitung otomatis -->
 
<script type="text/javascript">
    function validasi() {
		var error="";
		var jumlah_awal = document.getElementById( "jumlah_awal" );
		var jumlah_barang = document.getElementById( "jumlah_barang" );
		var gudang_tujuan = document.getElementById( "gudang_tujuan" );
		var pintu = document.getElementById( "pintu" );
		if( jumlah_barang.value <  1)	{
    		swal("Gagal!", "Jumlah Alokasi Stok harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if( jumlah_awal.value < 0 )	{
    		swal("Gagal!", "Jumlah Alokasi Barang Melampui stok Tersedia!", "error");
			return false; 
			<?php if (!isset($_GET['url'])) :?>
			} else if( gudang_tujuan.value == '' )	{
    		swal("Gagal!", "Harap Isi Gudang Tujuan!", "error");
			return false; 
			<?php endif;?>
			<?php if (isset($_GET['url'])) :?>
			} else if( pintu.value == '' )	{
    		swal("Gagal!", "Harap Isi Pintu Gudang!", "error");
			return false; 
			<?php endif;?>
			} else if( isNaN(jumlah_barang.value) )	{
    		swal("Gagal!", "Mohon Masukan Hanya Angka", "error");
			return false; 

			} else {
			var data=$(".form-input").serialize();
			$.ajax({
				type:'POST',
				url:'form_crud.php?tambah_transfer',
				data:data,
				success  : function(result){
				var response = JSON.parse(result);
				if (response.status){
				$.notify({icon: 'glyphicon glyphicon-thumbs-up',title: '<strong>Success..!</strong>',message: response.pesan},{type: 'success'});
				$(".paginasi_transfer").load("paginasi_transfer.php?id_trx=<?=$id_trx?>&id_gudang=<?=$_SESSION['gudang']?>");
				document.getElementById("form_epen").reset();
				document.getElementById("inputan").readOnly = false;
				} else if (response.error) {
				swal("Gagal!", response.pesan, "error");
				} else if (response.url) {
				alert(response.pesan);
				window.location.href = response.direct;
				}
				},
			});


			}
    }
</script>

<script>
function buka_rahasia() {
    var gudang_tujuan = document.getElementById("gudang_tujuan");
    var gudang_sendiri = document.getElementById("gudang_sendiri");
    if (gudang_tujuan.value ==  gudang_sendiri.value) {
		document.getElementById('rahasia').style.display = 'block';
		document.getElementById('pintu_tujuan').required = true;
    } else {
		document.getElementById('rahasia').style.display = 'none';
		document.getElementById('pintu_tujuan').required = false;
		document.getElementById('pintu_tujuan').value = '';
	}
}
</script>

<!--
<script type="text/javascript">
$(".paginasi_transfer").load("paginasi_transfer.php?id_trx=<?=$id_trx?>&id_gudang=<?=$_SESSION['gudang']?>");
</script>
<script type="text/javascript">
$(document).ready(function (e) {
	$("#form_epen").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "../transfer_retur/form_crud.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result){
			var response = JSON.parse(result);
			if (response.status){
				//$.notify({icon: 'glyphicon glyphicon-thumbs-up',title: '<strong>Success..!</strong>',message: response.pesan},{type: 'success'});
				alert('TEs');
				}  else if (response.error) {
				swal("Gagal", response.pesan, "error");
				} 
		    },
	   });
	}));
});
</script>
-->

</body>

</html>