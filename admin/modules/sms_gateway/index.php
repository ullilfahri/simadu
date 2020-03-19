<!--Header-->
<?php
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] > 1) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
?>	
<!--End Header-->

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
$sql_modem=$conn->query("select * from phones ORDER BY ID ASC");
	
?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>
<?php //###### DEKLARASI MODEM ######
	  //require "dir.php";
?>
<!--JUDUL-->
    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-phone fa-lg"></i> SMS Gateway</a></li>
			</ol>  
      
<!-- JUDUL -->
            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                STATUS MODEM
                            </h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#Modem_1" data-toggle="tab">
                                        <i class="fa fa-phone fa-1.5x"></i> Modem #1
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#Modem_2" data-toggle="tab">
                                        <i class="fa fa-phone fa-1.5x"></i> Modem #2
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#Modem_3" data-toggle="tab">
                                        <i class="fa fa-phone fa-1.5x"></i> Modem #3
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane animated fadeInRight active" id="Modem_1">
                                    <b>Status Modem #1 : </b><br><br>
									<?php
									passthru("net start > service.log");
									// membuka file service.log
									$Modem_1_handle = fopen("service.log", "r");
									// status awal = 0 (dianggap servicenya tidak jalan)
									$Modem_1_status = 0;
									$Modem_1_button='<button class="btn btn-danger btn-block btn-lg waves-effect" type="submit" name="hidup" value="Modem_1"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><span><strong>Modem_1</strong> Dihentikan..!, Klik Untuk Menghidupkan</span></button>';
									// proses pembacaan isi file
									while (!feof($Modem_1_handle)) :
   									// baca baris demi baris isi file
   									$Modem_1_baristeks = fgets($Modem_1_handle);
   									if (substr_count($Modem_1_baristeks, 'Gammu SMSD Service (Modem_1)') > 0) :
     								// jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     								// statusnya berubah menjadi 1
     								$Modem_1_status = 1;
	 								$Modem_1_button='<button class="btn btn-success btn-block btn-lg waves-effect" type="submit" name="mati" value="Modem_1"><i class="fa fa-check-square fa-spin fa-3x fa-fw"></i><span><strong>Modem_1</strong> Sedang Berjalan..!!, Klik Untuk Mematikan</span></button>';
   									endif;
									endwhile;
									// menutup file
									fclose($Modem_1_handle);
									?>
                                    <form method="post" action="bin/win/start_gammu.php">
                                    <?=$Modem_1_button?>
                                    </form>
                                </div>
                                
                                
                                
                                
                                <div role="tabpanel" class="tab-pane animated fadeInRight" id="Modem_2">
                                    <b>Status Modem #2 : </b><br><br>
									<?php
									passthru("net start > service.log");
									// membuka file service.log
									$Modem_2_handle = fopen("service.log", "r");
									// status awal = 0 (dianggap servicenya tidak jalan)
									$Modem_2_status = 0;
									$Modem_2_button='<button class="btn btn-danger btn-block btn-lg waves-effect" type="submit" name="hidup" value="Modem_2"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><span><strong>Modem_2</strong> Dihentikan..!, Klik Untuk Menghidupkan</span></button>';
									// proses pembacaan isi file
									while (!feof($Modem_2_handle)) :
   									// baca baris demi baris isi file
   									$Modem_2_baristeks = fgets($Modem_2_handle);
   									if (substr_count($Modem_2_baristeks, 'Gammu SMSD Service (Modem_2)') > 0) :
     								// jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     								// statusnya berubah menjadi 1
     								$Modem_2_status = 1;
	 								$Modem_2_button='<button class="btn btn-success btn-block btn-lg waves-effect" type="submit"  name="mati" value="Modem_2"><i class="fa fa-check-square fa-spin fa-3x fa-fw"></i><span><strong>Modem_2</strong> Sedang Berjalan..!!, Klik Untuk Mematikan</span></button>';
   									endif;
									endwhile;
									// menutup file
									fclose($Modem_2_handle);
									?>
                                    <form method="post" action="bin/win/start_gammu.php">
                                    <?=$Modem_2_button?>
                                    </form>
                                </div>
                                
                                
                                
                                <div role="tabpanel" class="tab-pane animated fadeInRight" id="Modem_3">
                                    <b>Status Modem #3 : </b><br><br>
									<?php
									passthru("net start > service.log");
									// membuka file service.log
									$Modem_3_handle = fopen("service.log", "r");
									// status awal = 0 (dianggap servicenya tidak jalan)
									$Modem_3_status = 0;
									$Modem_3_button='<button class="btn btn-danger btn-block btn-lg waves-effect" type="submit" name="hidup" value="Modem_3"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><span><strong>Modem_3</strong> Dihentikan..!, Klik Untuk Menghidupkan</span></button>';
									// proses pembacaan isi file
									while (!feof($Modem_3_handle)) :
   									// baca baris demi baris isi file
   									$Modem_3_baristeks = fgets($Modem_3_handle);
   									if (substr_count($Modem_3_baristeks, 'Gammu SMSD Service (Modem_3)') > 0) :
     								// jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     								// statusnya berubah menjadi 1
     								$Modem_3_status = 1;
	 								$Modem_3_button='<button class="btn btn-success btn-block btn-lg waves-effect" type="submit" name="mati" value="Modem_3"><i class="fa fa-check-square fa-spin fa-3x fa-fw"></i><span><strong>Modem_3</strong> Sedang Berjalan..!!, Klik Untuk Mematikan</span></button>';
   									endif;
									endwhile;
									// menutup file
									fclose($Modem_3_handle);
									?>
                                    <form method="post" action="bin/win/start_gammu.php">
                                    <?=$Modem_3_button?>
                                    </form>
                                </div>
                                
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Icon Title -->

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
    
    <!-- Jquery Spinner Plugin Js -->
    <script src="<?=PLG?>jquery-spinner/js/jquery.spinner.js"></script>


    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
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
<!-- Javascript untuk popup modal Delete--> 

<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>

<!--Akhir Javasrip Modal Delete-->  
</body>
</html>