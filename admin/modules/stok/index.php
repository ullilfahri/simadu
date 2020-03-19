
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] != 2) :
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
$ambil=$conn->query("SELECT id_pembelian FROM `tabel_pembelian` WHERE is_final=0 and id_owner='".$_SESSION['id']."'")->fetch_array();
$hapus=$conn->query("DELETE FROM `pembelian_sementara` WHERE id_pembelian='".$ambil[0]."'");
$hapus=$conn->query("DELETE FROM `tabel_pembelian` WHERE is_final=0 and id_owner='".$_SESSION['id']."'");
$file='upload/'.$ambil[0].'.pdf';
if (file_exists($file)) : unlink($file); endif;
$id_pembelian=strtotime(date('Y-m-d H:i:s'));
$file=$id_pembelian.'.pdf';
$masuk=$conn->query("INSERT INTO `tabel_pembelian`(`id_pembelian`, `id_owner`, `file`) VALUES ('$id_pembelian', '".$_SESSION['id']."', '$file')");

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
                                DATA PEMBELIAN
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" id="form" class="form-input" autocomplete="off">
							<input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>">
							<input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Nama Barang</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="nama_barang" id="inputan" class="form-control" onkeyup='autoComplete();' <?php if (!empty($_GET['input'])):?> value="<?=$_GET['input']?>" <?php endif;?> autofocus required/>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Kode Barang</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="kode_barang" name="kode_barang" class="form-control"  <?php if (!empty($_GET['kode'])):?> value="<?=$_GET['kode']?>" <?php endif;?> readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Harga Beli</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="harga_barang" id="harga_barang" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Quantity</label>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-7">
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <div class="form-line">
                                                <input type="text" name="jumlah" id="qty"  class="form-control text-center" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                            </div>
                                            <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                        	</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                       <button type="button" class="btn btn-primary m-t-15 waves-effect" id="tombol_simpan" onclick="return validasi();">Entry</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="reset" class="btn btn-danger m-t-15 waves-effect">&nbsp;Reset&nbsp;</button>
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
                                DATA BARANG PEMBELIAN
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

<!-- Modal Small Size -->
            <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">Finalisasi Data</h4>
                        </div>
                        <div class="modal-body">
						<div class="fetched-data"></div>
                        
                    </div>
                </div>
            </div>
<!--MODAL-->


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

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
function hilang_titik(string) {
            return string.split('.').join('');
        }
		

</script> 


<script>
	$(document).ready(function(){
		$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
		$(".simpan").click(function(){
			var data=$(".form-input").serialize();
			$.ajax({
				type:'POST',
				url:'simpan.php',
				data:data,
				success:function(){
					document.getElementById("form").reset();
					$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
				}
			});
		});
	});
</script>
<script type="text/javascript">
$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
    function validasi() {
		var error="";
		var harga_barang = document.getElementById( "harga_barang" );
		var qty = document.getElementById( "qty" );
		var inputan = document.getElementById( "inputan" );
		if( harga_barang.value <  1)	{
    		swal("Gagal!", "Harga Barang harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if( qty.value < 1 )	{
    		swal("Gagal!", "Quantity Pembelian harus bilangan bulat positif", "error");
			return false; 
			
			} else if( inputan.value =="" )	{
    		swal("Gagal!", "Form Field tidak diisi dengan prosedural", "error");
			return false; 


			} else {
			var data=$(".form-input").serialize();
			$.ajax({
				type:'POST',
				url:'simpan.php',
				data:data,
				success:function(){
					$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
				}
			});
	document.getElementById("form").reset();
			}
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

    function autoComplete() { //fungsi menangkap input search dan menampilkan hasil search

        getAjax();

        input = document.getElementById('inputan').value;if (input == "") {

            document.getElementById("hasil").innerHTML = "";

        }

        else {

            ajaxRequest.open("GET","proses_ajax.php?entry_pembelian&input="+input);

            ajaxRequest.onreadystatechange = function() {

                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;

            }

            ajaxRequest.send(null);

        }

    }

    function autoInsert(id, kode_barang, nama_barang) { //fungsi mengisi input text dengan hasil pencarian yang dipilih

        document.getElementById("inputan").value = nama_barang;

        document.getElementById("kode_barang").value = kode_barang;

        document.getElementById("hasil").innerHTML = "";

    }

</script>    
<!---AKHIR JS AUTOCOMPLE-->   

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('#smallModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?modal&id_owner=<?=$_SESSION['id']?>',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
<script type="text/javascript">
    function validasi2() {
		var error="";
		var uang_muka = document.getElementById(hilang_titik("uang_muka"));
		var diskon = document.getElementById( hilang_titik("diskon" ));
		var jumlah_hutang = document.getElementById( hilang_titik("jumlah_hutang" ));
		var harga = document.getElementById( hilang_titik("harga" ));
		var biaya = document.getElementById( hilang_titik("biaya" ));
		if( uang_muka.value >  harga.value)	{
    		swal("Gagal!", "Uang Muka Tidak Boleh Melebihi Dari Harga Pembelian!", "error");
			return false;
			
			} else if( diskon.value < 0 )	{
    		swal("Gagal!", "Jumlah Potongan harus bernilai 0 atau lebih", "error");
			return false; 
			
			} else if( biaya.value < 0 )	{
    		swal("Gagal!", "Jumlah Biaya harus bernilai 0 atau lebih", "error");
			return false; 

			
			} else if( jumlah_hutang.value < 0 )	{
    		swal("Gagal!", "Jumlah Terhutang Tidak Boleh Negatif", "error");
			return false; 


			} else {
				return true;
			}
    }
</script>


</body>

</html>