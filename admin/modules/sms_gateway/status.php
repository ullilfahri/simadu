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

           <!-- MODEM 1 -->

<?php if (isset($_GET['status1'])) {
	$info=$conn->query("select * from phones where ID='Modem_1'")->fetch_array();
	passthru("net start > service.log");

// membuka file service.log
	$handle = fopen("service.log", "r");

// status awal = 0 (dianggap servicenya tidak jalan)
	$status = 0;

// proses pembacaan isi file
	while (!feof($handle))
	{
   // baca baris demi baris isi file
   $baristeks = fgets($handle);
   if (substr_count($baristeks, 'Gammu SMSD Service (Modem_1)') > 0)
   {
     // jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     // statusnya berubah menjadi 1
     $status = 1;
   }
}
// menutup file
	fclose($handle);

?>
<?php
// jika status terakhir = 1, maka gammu service running
	if ($status == 1) { $stts= "Modem #1 Sedang Berjalan..!!";
?>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                STATUS MODEM # 1
                            </h2>
                        </div>
                        <div class="body">
                    <form method="post" action="bin/win/start_gammu.php">

                  <button class="btn btn-success btn-lg waves-effect" type="submit" name="mati"><i class="fa fa-check-square fa-lg"></i>
                      <span><?php echo $stts?>, Klik Untuk Mematikan</span>
                  </button>
</form>

            <!-- Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
<!-- INFO BOX -->                        
               <div class="row clearfix"> 
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-signal fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SINYAL</div>
                            <div class="number"><?=$info['Signal']?>%</div>
                        </div>
                    </div>
                </div>   
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-yellow hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-sign-in fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SMS DITERIMA</div>
                            <div class="number"><?=$info['Received']?></div>
                        </div>
                    </div>
                </div>   
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-green hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-paper-plane fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SMS KELUAR</div>
                            <div class="number"><?=$info['Sent']?></div>
                        </div>
                    </div>
                </div>   

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-battery-full fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">BATTERY</div>
                            <div class="number"><?=$info['Battery']?>%</div>
                        </div>
                    </div>
                </div>   
                            
               </div> 
<!-- INFO BOX -->                        
                            
                            <h2>
                                LOG MODEM #1
                            </h2>
							<button type="button" class="btn btn-danger btn-lg" 
                            onClick="confirm_modal('hapus_log.php?status=status1&modal_id=logsmsdrc');">KOSONGKAN LOG MODEM #1
                            </button>                            
                        </div>
                        <div class="body">
                            <div class="row clearfix">
  <div class="embed-responsive embed-responsive-16by9">
    <iframe class="embed-responsive-item" src="bin/win/baca_log.php?modem=logsmsdrc"></iframe>
  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Select -->



<?php  }	else { $stts= "Modem #1 Dihentikan..!";
// jika status terakhir = 0, maka service gammu berhenti
?>

                    <form method="post" action="bin/win/start_gammu.php">

                  <button class="btn btn-danger btn-lg waves-effect" type="submit" name="hidup"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                      <span><?php echo $stts?>, Klik Untuk Menghidupkan</span>
                  </button>
</form>

<?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# MODEM 1 -->
<?php }?>
 
 
           <!-- MODEM 1 -->

<?php if (isset($_GET['status2'])) {
	$info=$conn->query("select * from phones where ID='Modem_2'")->fetch_array();
	passthru("net start > service.log");

// membuka file service.log
	$handle = fopen("service.log", "r");

// status awal = 0 (dianggap servicenya tidak jalan)
	$status = 0;

// proses pembacaan isi file
	while (!feof($handle))
	{
   // baca baris demi baris isi file
   $baristeks = fgets($handle);
   if (substr_count($baristeks, 'Gammu SMSD Service (Modem_2)') > 0)
   {
     // jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     // statusnya berubah menjadi 1
     $status = 1;
   }
}
// menutup file
	fclose($handle);

?>
<?php
// jika status terakhir = 1, maka gammu service running
	if ($status == 1) { $stts= "Modem #2 Sedang Berjalan..!!";
?>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                STATUS MODEM # 2
                            </h2>
                        </div>
                        <div class="body">
                    <form method="post" action="bin/win/start_gammu.php">

                  <button class="btn btn-success btn-lg waves-effect" type="submit" name="mati2"><i class="material-icons">warning</i>
                      <span><?php echo $stts?>, Klik Untuk Mematikan</span>
                  </button>
				   </form>

            <!-- Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
<!-- INFO BOX -->                        
               <div class="row clearfix"> 
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-signal fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SINYAL</div>
                            <div class="number"><?=$info['Signal']?>%</div>
                        </div>
                    </div>
                </div>   
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-yellow hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-sign-in fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SMS DITERIMA</div>
                            <div class="number"><?=$info['Received']?></div>
                        </div>
                    </div>
                </div>   
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-green hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-paper-plane fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SMS KELUAR</div>
                            <div class="number"><?=$info['Sent']?></div>
                        </div>
                    </div>
                </div>   

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-battery-full fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">BATTERY</div>
                            <div class="number"><?=$info['Battery']?>%</div>
                        </div>
                    </div>
                </div>   
                            
               </div> 
<!-- INFO BOX -->                        
                            <h2>
                                LOG MODEM #2
                            </h2>
							<button type="button" class="btn btn-danger btn-lg" 
                            onClick="confirm_modal('hapus_log.php?status=status2&modal_id=logsmsdrc2');">KOSONGKAN LOG MODEM #2
                            </button>                            
                        </div>
                        <div class="body">
                            <div class="row clearfix">
  <div class="embed-responsive embed-responsive-16by9">
    <iframe class="embed-responsive-item" src="bin/win/baca_log.php?modem=logsmsdrc2"></iframe>
  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Select -->

<?php  }	else { $stts= "Modem #2 Dihentikan..!";
// jika status terakhir = 0, maka service gammu berhenti
?>

                    <form method="post" action="bin/win/start_gammu.php">

                  <button class="btn btn-danger btn-lg waves-effect" type="submit" name="hidup2"><i class="material-icons">replay</i>
                      <span><?php echo $stts?>, Klik Untuk Menghidupkan</span>
                  </button>
</form>

<?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# MODEM 2 -->
<?php }?>

           <!-- MODEM 3 -->

<?php if (isset($_GET['status3'])) {
	$info=$conn->query("select * from phones where ID='Modem_3'")->fetch_array();
	passthru("net start > service.log");

// membuka file service.log
	$handle = fopen("service.log", "r");

// status awal = 0 (dianggap servicenya tidak jalan)
	$status = 0;

// proses pembacaan isi file
	while (!feof($handle))
	{
   // baca baris demi baris isi file
   $baristeks = fgets($handle);
   if (substr_count($baristeks, 'Gammu SMSD Service (Modem_3)') > 0)
   {
     // jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     // statusnya berubah menjadi 1
     $status = 1;
   }
}
// menutup file
	fclose($handle);

?>
<?php
// jika status terakhir = 1, maka gammu service running
	if ($status == 1) { $stts= "Modem #3 Sedang Berjalan..!!";
?>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                STATUS MODEM # 3
                            </h2>
                        </div>
                        <div class="body">
                    <form method="post" action="bin/win/start_gammu.php">

                  <button class="btn btn-success btn-lg waves-effect" type="submit" name="mati3"><i class="material-icons">warning</i>
                      <span><?php echo $stts?>, Klik Untuk Mematikan</span>
                  </button>
</form>

            <!-- Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">

<!-- INFO BOX -->                        
               <div class="row clearfix"> 
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-signal fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SINYAL</div>
                            <div class="number"><?=$info['Signal']?>%</div>
                        </div>
                    </div>
                </div>   
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-yellow hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-sign-in fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SMS DITERIMA</div>
                            <div class="number"><?=$info['Received']?></div>
                        </div>
                    </div>
                </div>   
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-green hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-paper-plane fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">SMS KELUAR</div>
                            <div class="number"><?=$info['Sent']?></div>
                        </div>
                    </div>
                </div>   

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="fa fa-battery-full fa-2x"></i>
                        </div>
                        <div class="content">
                            <div class="text">BATTERY</div>
                            <div class="number"><?=$info['Battery']?>%</div>
                        </div>
                    </div>
                </div>   
                            
               </div> 
<!-- INFO BOX -->                        
                            <h2>
                                LOG MODEM #3
                            </h2>
							<button type="button" class="btn btn-danger btn-lg" 
                            onClick="confirm_modal('hapus_log.php?status=status3&modal_id=logsmsdrc3');">KOSONGKAN LOG MODEM #3
                            </button>                            
                        </div>
                        
                        <div class="body">
                            <div class="row clearfix">
  <div class="embed-responsive embed-responsive-16by9">
    <iframe class="embed-responsive-item" src="bin/win/baca_log.php?modem=logsmsdrc3"></iframe>
  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Select -->

<?php  }	else { $stts= "Modem #3 Dihentikan..!";
// jika status terakhir = 0, maka service gammu berhenti
?>

                    <form method="post" action="bin/win/start_gammu.php">

                  <button class="btn btn-danger btn-lg waves-effect" type="submit" name="hidup3"><i class="material-icons">replay</i>
                      <span><?php echo $stts?>, Klik Untuk Menghidupkan</span>
                  </button>
</form>

<?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# MODEM 3 -->
<?php }?>


        </div>
    </section>
    
<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Hapus Pesan ?</h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal delete-->
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