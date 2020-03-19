
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] != 3) :
	echo "<script>window.alert('Hanya Admin Toko Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
if ($_SESSION['sub_level'] > 4) :
	echo "<script>window.alert('Hanya Admin Toko Memiliki Hak Akses..!')
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
            window.location = "index.php?JmnJUHS";
        });
    }, 1000);
</script>';
endif;


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
                                FORM RETUR BARANG <p id="dis"></p><br>
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" id="form" class="form-input" autocomplete="off" name="retur">
                            <input type="hidden" name="user_approve" value="<?=$_SESSION['id']?>"/>
                            <input type="hidden" name="id_toko" value="<?=$_SESSION['toko']?>"/>
                            <input type="hidden" name="id_ambil_barang" id="id_ambil_barang"/>
                            <input type="hidden" name="distributor" id="distributor"/>
                            <input type="hidden" name="retur_hide" id="retur_hide"/>
                            <input type="hidden" name="jumlah_pengambilan" id="jumlah_pengambilan"/>
                            <input type="hidden" name="id_trx" value="<?=$id_trx?>"/>
                            <input type="hidden" name="tanggal" value="<?=date('Y-m-d H:i:s')?>"/>
                            <input type="hidden" name="kode" value="1"/>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="inputan">Masukan Nomor Faktur (*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="inputan" name="no_faktur" class="form-control no_faktur" onkeyup='autoComplete();' autofocus required/>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="jumlah_ambil">Masukan Jumlah Retur (*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="jumlah_barang" id="jumlah_barang" class="form-control" onFocus="startCalc();" onBlur="stopCalc();"  required>
                                            </div>
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
                                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="satuan">Satuan</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="satuan" name="satuan"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="satuan">Kode Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="kode_barang" name="kode_barang"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="satuan">Jumlah Barang Yang Diambil</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="jumlah_diambil" name="jumlah_diambil"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="satuan">Maksimal Retur</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="jumlah_retur" name="jumlah_retur"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="button" class="btn btn-primary m-t-15 waves-effect" onclick="return validasi();">Entry</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->            

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA RETUR
                            </h2>
                        </div>
                        <div class="body">
							<div class="list-data"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->     
            
            <!-- Large Size -->
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Finalisasi Retur Barang</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="cetak.php" id="form_modal">
                            <input type="hidden" name="id_trx" value="<?=$id_trx?>" />
                            <input type="hidden" name="kode" value="1" />
                                <label for="email_address">Biaya Administrasi</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="checkbox" id="biaya_administrasi" name="biaya_administrasi" value="1"/>
                                        <label for="biaya_administrasi">Beri Tanda Centang (&#10004;) Jika Pelanggan Dikenakan Biaya Administrasi</label>
                                    </div>
                                </div>
                                
                                <div id="field_biaya_administrasi" style="display:none">
                                <label for="jumlah_biaya_administrasi">Biaya Administrasi</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="jumlah_biaya_administrasi" name="jumlah_biaya_administrasi" class="form-control uang" placeholder="Masukan Jumlah Biaya Administrasi (Rp)">
                                    </div>
                                </div>
                                <label for="tabel_biaya_administrasi">Pilih Kas</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="tabel_biaya_administrasi" id="tabel_biaya_administrasi" class="form-control">
                                        <option value="">-- Pilih Kas --</option>
                                        <option value="konfirmasi_tunai">Tunai</option>
                                        <?php
                                        $admin_bank=$conn->query("SELECT * FROM rekening_bank where id_toko='".$_SESSION['toko']."'");
										while ($adm=$admin_bank->fetch_array()) :
										?>
                                        <option value="konfirmasi_bank#<?=$adm['id']?>">Rekening <?=$adm['bank']?> No. Rek <?=$adm['no_rek']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                </div><!--field_biaya_administrasi-->
                                <br />

                                <label for="biaya_kembali">Pengembalian Uang Kepada Customer</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="checkbox" id="biaya_kembali" name="biaya_kembali" value="2"/>
                                        <label for="biaya_kembali">Beri Tanda Centang (&#10004;) Jika Pengembalian Uang kepada Customer</label>
                                    </div>
                                </div>
                                
                                <div id="field_biaya_kembali" style="display:none">
                                <label for="jumlah_biaya_kembali">Pengembalian Uang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="jumlah_biaya_kembali" name="jumlah_biaya_kembali" class="form-control uang" placeholder="Masukan Jumlah Pengembalian Uang (Rp)">
                                    </div>
                                </div>
                                <label for="tabel_biaya_kembali">Pilih Kas</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="tabel_biaya_kembali" id="tabel_biaya_kembali" class="form-control">
                                        <option value="">-- Pilih Kas --</option>
                                        <option value="konfirmasi_tunai">Tunai</option>
                                        <?php
										 $kbl_bank=$conn->query("SELECT * FROM rekening_bank where id_toko='".$_SESSION['toko']."'");
										while ($kbl=$kbl_bank->fetch_array()) :
										?>
                                        <option value="konfirmasi_bank#<?=$kbl['id']?>">Rekening <?=$kbl['bank']?> No. Rek <?=$kbl['no_rek']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>
                                </div>
                                </div><!--<div id="field_biaya_kembali" style="display:none">-->
                                
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="cetak" class="btn btn-success waves-effect">Cetak</button>
                            <button type="button" onclick="tombol_reset()"class="btn btn-danger waves-effect" data-dismiss="modal">Batal</button>
                        </div>
                            </form>
                        
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
    
    
<script src="<?=PLG?>jmask/jquery.mask.min.js"></script>                           
<script type="text/javascript">
            $(document).ready(function(){

                // Format mata uang.
                $( '.uang' ).mask('000.000.000', {reverse: true});

            })
</script>
    



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
            ajaxRequest.open("GET","proses_ajax.php?retur_barang&id_trx=<?=$id_trx?>&input="+input);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert(id_ambil_barang, no_faktur, nama_barang, satuan, kode_barang, jumlah_diambil, distributor, nama_dis, jumlah_retur) { 

        document.getElementById("inputan").value = no_faktur;
        document.getElementById("distributor").value = distributor;
        document.getElementById("id_ambil_barang").value = id_ambil_barang;
        document.getElementById("nama_barang").value = nama_barang;
        document.getElementById("satuan").value = satuan;
        document.getElementById("kode_barang").value = kode_barang;
        document.getElementById("jumlah_diambil").value = jumlah_diambil;
        document.getElementById("jumlah_pengambilan").value = jumlah_diambil;
        document.getElementById("jumlah_retur").value = jumlah_retur;
        document.getElementById("retur_hide").value = jumlah_retur;
        document.getElementById("dis").innerHTML = nama_dis;
        document.getElementById("hasil").innerHTML = "";
    }
</script>    
<!---AKHIR JS AUTOCOMPLE-->   

<script>
    function startCalc(){
    		interval = setInterval("calc()",1);
    }
    function calc(){
	    jumlah_barang = document.retur.jumlah_barang.value;
	    jumlah_pengambilan = document.retur.jumlah_pengambilan.value;
	    retur_hide = document.retur.retur_hide.value;

	    total_awal = jumlah_pengambilan - jumlah_barang;
		document.retur.jumlah_diambil.value = total_awal;
		
	    mak_retur = retur_hide - jumlah_barang;
		document.retur.jumlah_retur.value = mak_retur;
		

	}
    function stopCalc(){
    	clearInterval(interval);
    }
</script>


<script type="text/javascript">
$(".list-data").load("data_retur.php?id_trx=<?=$id_trx?>&kode=1");
    function validasi() {
		var error="";
		var jumlah_barang = document.getElementById( "jumlah_barang" );
		var jumlah_diambil = document.getElementById( "jumlah_diambil" );
		var jumlah_retur = document.getElementById( "jumlah_retur" );

		if( jumlah_barang.value <  1)	{
    		swal("Gagal!", "Jumlah Retur Barang harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if(jumlah_diambil.value < 0)	{
    		swal("Gagal!", "Jumlah Retur Barang Melebihi Jumlah Jumlah yang diambil!", "error");
			return false;
			
			} else if(jumlah_retur.value < 0)	{
    		swal("Gagal!", "Jumlah Retur Barang Melebihi Maksimal Retur!", "error");
			return false;
			
			
			} else {
			var data=$(".form-input").serialize();
			$.ajax({
				type:'POST',
				url:'simpan.php?simpan_data',
				data:data,
				success  : function(result){
				var response = JSON.parse(result);
				if (response.status){
				$.notify({icon: 'glyphicon glyphicon-thumbs-up',title: '<strong>Success..!</strong>',message: response.pesan},{type: 'success'});
				$(".list-data").load("data_retur.php?id_trx=<?=$id_trx?>&kode=1");
				document.getElementById("form").reset();
				} else if (response.error) {
				swal("Gagal!", response.pesan, "error");
				} else {
				swal("Gagal!", response.pesan, "error");
				}
				},
			});
			}
    }
</script>

<script>
$(document).ready(function () {
    var biaya_administrasi = $('#biaya_administrasi');
    var field_biaya_administrasi = document.getElementById("field_biaya_administrasi");
    $('input').on('click',function () {
        if (biaya_administrasi.is(':checked')) {
            field_biaya_administrasi.style.display = "block";
			document.getElementById('jumlah_biaya_administrasi').required = true;
			document.getElementById('tabel_biaya_administrasi').required = true;
        } else {
            field_biaya_administrasi.style.display = "none";
			document.getElementById('jumlah_biaya_administrasi').required = false;
			document.getElementById('tabel_biaya_administrasi').required = false;
        }
    });
});
</script>


<script>
$(document).ready(function () {
    var biaya_kembali = $('#biaya_kembali');
    var field_biaya_kembali = document.getElementById("field_biaya_kembali");
    $('input').on('click',function () {
        if (biaya_kembali.is(':checked')) {
            field_biaya_kembali.style.display = "block";
			document.getElementById('jumlah_biaya_kembali').required = true;
			document.getElementById('tabel_biaya_kembali').required = true;
        } else {
            field_biaya_kembali.style.display = "none";
			document.getElementById('jumlah_biaya_kembali').required = false;
			document.getElementById('tabel_biaya_kembali').required = false;
        }
    });
});
</script>

<script>
function tombol_reset() {
    document.getElementById("form_modal").reset();
	field_biaya_administrasi.style.display = "none";
	document.getElementById('jumlah_biaya_administrasi').required = false;
	document.getElementById('tabel_biaya_administrasi').required = false;
	document.getElementById('jumlah_field_biaya_kembali').required = false;
	document.getElementById('tabel_biaya_kembali').required = false;
}
</script>



</body>

</html>

