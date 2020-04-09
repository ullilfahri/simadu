
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

$ambil=$conn->query("SELECT id_barang_keluar, jumlah_ambil, pintu_gudang, id_gudang, is_booking FROM ambil_barang WHERE is_final=0 and id_user='".$_SESSION['id']."' ");
while ($a=$ambil->fetch_array()) :

	$retur_ambil=$conn->query("select is_ambil, kode_barang, distributor, no_faktur from barang_keluar where id='".$a[0]."'")->fetch_array();
	$sisa_ambil=$retur_ambil[0]-$a[1];
	$update_ambil=$conn->query("update barang_keluar set is_ambil = '$sisa_ambil' where id='".$a[0]."'");
	$update=$conn->query("UPDATE alokasi_stok SET jumlah = jumlah+$a[1] where id_gudang='$a[3]' AND kode_barang = '$retur_ambil[1]' AND pintu_gudang = '$a[2]' AND distributor = '$retur_ambil[2]'");
	$update=$conn->query("UPDATE alokasi_stok_jual SET jumlah = jumlah+$a[1] where id_gudang='$a[3]' AND no_faktur = '$retur_ambil[3]' ");
	if ($a[4]==1) :
	$update=$conn->query("UPDATE alokasi_booking SET jumlah = jumlah+$a[1] where id_gudang='$a[3]' AND kode_barang = '$retur_ambil[1]' AND pintu_gudang = '$a[2]'");
	endif;

endwhile;


$hapus_ambil_sementara=$conn->query("delete FROM ambil_barang WHERE is_final=0 and id_user='".$_SESSION['id']."'");


$id_pengambilan=strtotime(date('Y-m-d H:i:s'));


$ada=$conn->query("SELECT * FROM ambil_barang where id_pengambilan='$id_pengambilan'")->num_rows;
if ($ada > 0) :
echo '<script>
    setTimeout(function() {
        swal({
            title: "'.$id_pengambilan.'",
            text: "No Transaksi sedang diakses User Lain, Harap Tunggu Sesaat",
            type: "error",
			timer: 5000,
			showConfirmButton: false
        }, function() {
            window.location = "ambil_barang.php?WffEFGHH";
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
                                FORM PENGAMBILAN BARANG
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" id="form" name="booking" class="form-input" autocomplete="off">
                            <input type="hidden" id="id_barang_keluar" name="id_barang_keluar"/>
                            <input type="hidden" name="id_user" value="<?=$_SESSION['id']?>"/>
                            <input type="hidden" name="id_pengambilan" value="<?=$id_pengambilan?>"/>
                            <input type="hidden" name="dist" id="dist"/>
                            <input type="hidden" name="kode_barang" id="kode_barang"/>
                            <input type="hidden" name="id_gudang" id="id_gudang"/>
                            <input type="hidden" name="no_faktur" id="no_faktur"/>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="inputan">Masukan Nomor Faktur (*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="inputan" class="form-control no_faktur" onkeyup='autoComplete();' autofocus required/>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="jumlah_ambil">Masukan Jumlah Pengambilan (*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="jumlah_ambil" id="jumlah_ambil" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="form_pintu" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="pintu_gudang">Pilih Pintu/Ruamg/Sekat (*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div id='gila'></div>
                                            </div>
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
                                                <input type="text" class="form-control" id="satuan"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="satuan">Dari Gudang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="gudang" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="jumlah_beli">Jumlah Pembelian</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="jumlah_beli"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="is_ambil">Jumlah Barang Sudah Diambili</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="is_ambil"  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="totstok">Jumlah Barang Belum Diambil</label>
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
                                        <button type="button" id="tombol_entry" class="btn btn-primary m-t-15 waves-effect" id="tombol_simpan" onclick="return validasi();" disabled>Entry</button>
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
                                DATA PENGAMBILAN
                            </h2>
                        </div>
                        <div class="body">
							<div class="list-data"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->        
            
                             
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
    
<!-- Kalkulator -->
<script type="text/javascript">
$("#jumlah_ambil").keyup(function(){
        var jumlah_ambil  = parseInt($("#jumlah_ambil").val());
        var jumlah_beli  = parseInt($("#jumlah_beli").val());
        var is_ambil  = parseInt($("#is_ambil").val());
        var total = jumlah_beli - is_ambil - jumlah_ambil;
        $("#totstok").val(total);
      });
</script> 
<!-- END Kalkulator -->

<script type="text/javascript">
$(".list-data").load("data.php?id_pengambilan=<?=$id_pengambilan?>");
    function validasi() {
		var error="";
		var jumlah_ambil = document.getElementById( "jumlah_ambil" );
		var jumlah_beli = document.getElementById( "jumlah_beli" );
		var is_ambil = document.getElementById( "is_ambil" );
		var inputan = document.getElementById( "inputan" );
		var no_faktur = document.getElementById( "no_faktur" );
		var pintu = document.getElementById( "pintu" );
		var totstok = document.getElementById( "totstok" );
		var jumlah_beli = document.getElementById( "jumlah_beli" );
		var mentah = document.booking.pintu_gudang.value;
		var data_ambil = document.booking.jumlah_ambil.value;
		var pecah = mentah.split('#');
		var stok_booking = pecah[0];

		if( jumlah_ambil.value <  1)	{
    		swal("Gagal!", "Jumlah Pengambilan Barang harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if( inputan.value == "" )	{
    		swal("Gagal!", "Masukan No Faktur Dengan Benar", "error");
			return false; 
			
			} else if( totstok.value < 0 )	{
    		swal("Gagal!", "Input Jumlah Pengambilan melebihi Stok", "error");
			return false; 
			
			} else if(parseInt(stok_booking) < data_ambil)	{
    		swal("Gagal!", "Input Jumlah Pengambilan melebihi Stok di Pintu/ruang/sekat "+parseInt(stok_booking), "error");
			return false; 
			
			} else if( no_faktur.value !=  inputan.value)	{
    		swal("Gagal!", "Entry Tidak Prosedural", "error");
			return false; 

			
			} else {
			var data=$(".form-input").serialize();
			$.ajax({
				type:'POST',
				url:'simpan.php',
				data:data,
				success  : function(result){
				var response = JSON.parse(result);
				if (response.status){
				$.notify({icon: 'glyphicon glyphicon-thumbs-up',title: '<strong>Success..!</strong>',message: response.pesan},{type: 'success'});
				$(".list-data").load("data.php?id_pengambilan=<?=$id_pengambilan?>");
				document.getElementById("form").reset();
				document.getElementById("form_pintu").style.display = "none";
				document.getElementById("inputan").readOnly = false;
				document.getElementById("tombol_entry").disabled = true;
				} else {
				swal("Gagal!", response.pesan, "error");
				}
				},
			});
			}
    }
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

            ajaxRequest.open("GET","proses_ajax.php?ambil_barang&id_pengambilan=<?=$id_pengambilan?>&input="+input);

            ajaxRequest.onreadystatechange = function() {

                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;

            }

            ajaxRequest.send(null);

        }

    }

    function autoInsert(nama_barang, jumlah_beli, is_ambil, satuan, gudang, id_gudang, id_barang_keluar, dist, no_faktur, kode_barang) { //fungsi mengisi input text dengan hasil pencarian yang dipilih

        document.getElementById("inputan").value = no_faktur;
        document.getElementById("no_faktur").value = no_faktur;
        document.getElementById("nama_barang").value = nama_barang;
        document.getElementById("jumlah_beli").value = jumlah_beli;
        document.getElementById("is_ambil").value = is_ambil;
        document.getElementById("satuan").value = satuan;
        document.getElementById("gudang").value = gudang;
        document.getElementById("id_gudang").value = id_gudang;
        document.getElementById("id_barang_keluar").value = id_barang_keluar;
        document.getElementById("dist").value = dist;
        document.getElementById("kode_barang").value = kode_barang;
        document.getElementById("hasil").innerHTML = "";
        document.getElementById("inputan").readOnly = true;
		document.getElementById("tombol_entry").disabled = false;
		
		
        		$.ajax({url: "proses_ajax.php?ambil_data_stok&id_gudang="+id_gudang+"&no_faktur="+no_faktur+"&kode_barang="+kode_barang, success: function(result){
            	$("#gila").html(result);
				document.getElementById("form_pintu").style.display = "block";
        		}});
    }
</script>    
<!---AKHIR JS AUTOCOMPLE-->   




</body>

</html>