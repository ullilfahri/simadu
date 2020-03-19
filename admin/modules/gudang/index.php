
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_form2.php';
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
                                ALOKASI STOK
                                <small>Pilih Barang Untuk Dialokasikan ke masing-masing gudang</small>
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" class="form-input" autocomplete="off" action="form_crud.php">
                            <input type="hidden" id="idf" name="kode_barang"/>
                            <input type="hidden" id="no_faktur" name="no_faktur"/>
                            <input type="hidden" id="tgl_nota" name="tgl_nota"/>
                            <input type="hidden" name="distributor" id="distributor"/>
                            <input type="hidden" name="supplier" id="supplier"/>
                            <input type="hidden" name="satuan" id="satuan"/>
                            <input type="hidden" name="id_user" value="<?=$_SESSION['id']?>"/>
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="nama_barang" id="inputan" class="form-control" onkeyup='autoComplete();' autofocus required/>
                                                <label class="form-label">Masukan Nama Barang</label>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="sisa_stok" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--END <div class="row clearfix">-->
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Penempatan Gudang</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class='form-control show-tick' name='id_gudang' id="gudang" onchange="javascript:rubah(this)" required>
                                                <option value=''>-- Silahkan Pilih Gudang --</option>
                                                <?php 
												$gudang=$conn->query("select id_lokasi, nama from lokasi where id_lokasi like '%".$_SESSION['gudang']."%' order by nama asc");
												while ($g=$gudang->fetch_array()):
												?>
                                                <option value="<?=$g[0]?>"><?=$g[1]?></option><?php endwhile;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Penempatan Pintu/Sekat/Ruang</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class='form-control show-tick' name='pintu_gudang' id="pintu" required>
                                                <option value=''>-- Silahkan Pilih Pintu --</option>
                                                <?php 
												$pintu=$conn->query("select a.nama_pintu, a.id_gudang from pintu_gudang as a left join lokasi as b on a.id_gudang = b.id_lokasi order by a.id_gudang asc");
												while ($p=$pintu->fetch_array()):
												?>
                                                <option id="pintu" class="<?=$p[1]?>" value="<?=$p[0]?>"><?=$p[0]?></option><?php endwhile;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Jumlah</label>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-7">
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <div class="form-line">
                                                <input type="text" name="jumlah" id="jumlah" class="form-control text-center" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Sisa Stok Belum dialokasikan</label>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-7">
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <div class="form-line">
                                                <input type="text" name="totstok" id="totstok" class="form-control text-center" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row clearfix">
                                        <button type="submit" name="alokasi_stok" class="btn btn-primary m-t-15 waves-effect" onclick="return validasi();">Simpan</button>
                                </div>
                            
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Inline Layout | With Floating Label -->
            
                             
            </div>
    </section>



    <!-- Jquery Core Js -->
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>

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

            ajaxRequest.open("GET","proses_ajax.php?alokasi_stok&input="+input);

            ajaxRequest.onreadystatechange = function() {

                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;

            }

            ajaxRequest.send(null);

        }

    }

    function autoInsert(sisa_stok, nama_barang, kode_barang, distributor, satuan, no_faktur, tgl_nota, supplier) { //fungsi mengisi input text dengan hasil pencarian yang dipilih

        document.getElementById("inputan").value = nama_barang;

        document.getElementById("idf").value = kode_barang;
		
        document.getElementById("sisa_stok").value = sisa_stok;

        document.getElementById("distributor").value = distributor;
		
        document.getElementById("satuan").value = satuan;
        document.getElementById("no_faktur").value = no_faktur;
        document.getElementById("tgl_nota").value = tgl_nota;
        document.getElementById("supplier").value = supplier;

        document.getElementById("hasil").innerHTML = "";

    }

</script>    
<!---AKHIR JS AUTOCOMPLE-->   

<!-- Kalkulator -->
<script type="text/javascript">
$("#jumlah").keyup(function(){
        var sisa_stok  = parseInt($("#sisa_stok").val());
        var jumlah  = parseInt($("#jumlah").val());
        var total = sisa_stok - jumlah;
        $("#totstok").val(total);
      });
</script> 
<!-- END Kalkulator -->

<script type="text/javascript">
    function validasi() {
		var error="";
		var totstok = document.getElementById( "totstok" );
		var jumlah = document.getElementById( "jumlah" );
		if( jumlah.value <  1)	{
    		swal("Gagal!", "Jumlah Stok harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if( totstok.value < 0 )	{
    		swal("Gagal!", "Jumlah Sisa Stok Tidak Boleh Negatif!", "error");
			return false; 


			} else {
				return true;
			}
    }
</script>


</body>

</html>