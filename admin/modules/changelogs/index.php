
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_form2.php';
include MDL.'login/session.php';
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
				<li><a href="javascript:void(0);"><i class="fa fa-hourglass-half fa-lg"></i> Changelogs</a></li>
			</ol>  
            
            <!-- Changelogs -->
            <div class="block-header">
                <h2>CHANGELOGS</h2>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>v1.0
                                <small>16th December 2018</small>
                            </h2>
                        </div>
                        <div class="body">
                            <p>- New Server Machine has been Upgraded On ASANA NEVADA, Ketapang</p>
                            <p>- Combine AJAX, C++ With PHP as backbone</p>
                            <p>- Si'AKO v.1.0.2 Beta Migration To SIMADU (Sistem Informasi & MAnajamen Aplikasi terpaDU) v.1.0</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>v1.0.2 beta
                                <small>18th November 2018</small>
                            </h2>
                        </div>
                        <div class="body">
                            <p>- Uploaded On Server Asana Nevada</p>
                            <p>- Bug fix on javascript code</p>
                            <p>- All Menu has been improved</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>v1.0.1 beta
                                <small>12th November 2018</small>
                            </h2>
                        </div>
                        <div class="body">
                            <p>- Dashboard on distributor has been improved</p>
                            <p>- Menu changelogs added</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>v1.0.0
                                <small>10th November 2018</small>
                            </h2>
                        </div>
                        <div class="body">
                            Version 1.0.0 Uploaded On Server Asana Nevada.
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Changelogs -->
            
                             
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

    function autoInsert(sisa_stok, nama_barang, kode_barang, distributor, satuan) { //fungsi mengisi input text dengan hasil pencarian yang dipilih

        document.getElementById("inputan").value = nama_barang;

        document.getElementById("idf").value = kode_barang;
		
        document.getElementById("sisa_stok").value = sisa_stok;

        document.getElementById("distributor").value = distributor;
		
        document.getElementById("satuan").value = satuan;

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

</body>

</html>