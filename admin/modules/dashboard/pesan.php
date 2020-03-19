
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
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
$pesan=$conn->query("SELECT * FROM `kirim_pesan` WHERE `tujuan`='".$_SESSION['id']."' ORDER BY tgl_kirim DESC ");
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-envelope fa-lg"></i> Pesan</a></li>
			</ol>  
            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PESAN
                            </h2>
                            <br><button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#defaultModal"><i class="fa fa-envelope"></i><span>Kirim Pesan</span></button>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="pilih_semua" class="chk-col-red"><label for="pilih_semua">Tandai Semua</label></th>
                                            <th>Nama Pengirim</th>
                                            <th>Isi Pesan</th>
                                            <th>Waktu Pesan</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    	<tr>
                                            <th class="baris_dipilih" id="jumlah_pilih"> 0 Dipilih</th>
                                            <th><button type="button" id="baca_record" class="btn btn-warning">Tandai Dibaca</button></th>
                                            <th><button type="button" id="hapus_record" class="btn btn-danger">Hapus Pesan</button></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$pesan->fetch_array()) :
									$pengirim=$conn->query("select nama from user where id = '".$x['pengirim']."'")->fetch_array();
									if ($x['is_read']==0) {
									$text='class="font-bold col-teal"';
									} else {
									$text='';
									}
									
									?>
                                        <tr id="<?php echo $x['id']; ?>">
                                            <td><input type="checkbox" class="chk-col-red pgw_checkbox" id = "data-pwg-id<?=$no?>" data-pwg-id="<?=$x['id']?>"><label for="data-pwg-id<?=$no?>"></label></td>
                                            <td <?=$text?>><?=strtoupper($pengirim[0])?></td>
                                            <td <?=$text?>><?=$x['isi_pesan']?></td>
                                            <td <?=$text?>><?=$x['tgl_kirim']?> (<?=time_since(strtotime($x['tgl_kirim']))?>)</td>
                                        </tr>
                                    <?php $no++; endwhile;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
            
            
            <!-- Default Size -->
            <div class="modal fade kirim_pesan" id="defaultModal" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Kirim Pesan..!</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" autocomplete="off" method="post" action="pesan_crud.php">
                            <input type="hidden" name="pengirim" value="<?=$_SESSION['id']?>" />   
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Pilih Penerima (Penerima bisa lebih dari satu)</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-user fa-lg"></i></span>
                                    		<select name="tujuan[]" class="form-control" data-live-search="true" multiple required>
                                            <?php
                                            $user_tujuan=$conn->query("select * from user order by id");
											while ($ut=$user_tujuan->fetch_array()) :
											?>
                                        	<option value="<?=$ut['id']?>"><?=$ut['nama']?></option>
                                            <?php endwhile;?>
                                    		</select>                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Isi Pesan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-envelope fa-lg"></i></span>
                                            <div class="form-line">
                                                <textarea rows="2" name="isi_pesan" class="form-control no-resize auto-growth" placeholder="Isi Pesan" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" name="kirim_pesan" class="btn btn-success m-t-15 waves-effect">Kirim</button>
                                        <button type="button" class="btn btn-danger m-t-15 waves-effect" data-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Default Size -->
                             
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
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
 	<script src="<?=JS?>pages/ui/modals.js"></script>    
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
jQuery('#pilih_semua').on('click', function(e) {
 if($(this).is(':checked',true)) {
  $(".pgw_checkbox").prop('checked', true);
 }
 else {
  $(".pgw_checkbox").prop('checked',false);
 }
 // mengatur semua jumlah checkbox yang dicentang
 $("#jumlah_pilih").html($("input.pgw_checkbox:checked").length+" Dipilih");
});
// mengatur jumlah checkbox tertentu yang dicentang
$(".pgw_checkbox").on('click', function(e) {
 $("#jumlah_pilih").html($("input.pgw_checkbox:checked").length+" Dipilih");
});
</script>

<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">

// hapus record yang dicentang
jQuery('#hapus_record').on('click', function(e) {
 var pesan = [];
 $(".pgw_checkbox:checked").each(function() {
  pesan.push($(this).data('pwg-id'));
 });
 if(pesan.length <=0)  {
  alert("Silahkan pilih record.");
 }
 else {
  var message = "Apakah Anda yakin ingin menghapus record yang dipilih?";
  var checked = confirm(message);
  if(checked == true) {
   var selected_values = pesan.join(",");
   $.ajax({
    type: "POST",
    url: "form_crud.php?hapus_pesan",
    cache:false,
    data: 'pwg_id='+selected_values,
    success: function(response) {
     // menghilangkan baris pesan yang dihapus
     var pgw_ids = response.split(",");
     for (var i=0; i<pgw_ids.length; i++ ) {
      $("#"+pgw_ids[i]).remove();
     }
    }
   });
  }
 }
});

</script>
<!--Akhir Javasrip Modal Delete-->  

<script type="text/javascript">

// hapus record yang dicentang
jQuery('#baca_record').on('click', function(e) {
 var pesan = [];
 $(".pgw_checkbox:checked").each(function() {
  pesan.push($(this).data('pwg-id'));
 });
 if(pesan.length <=0)  {
  alert("Silahkan pilih record.");
 }
 else {
  var message = "Apakah Anda yakin ingin Menandai Pesan yang dipilih?";
  var checked = confirm(message);
  if(checked == true) {
   var selected_values = pesan.join(",");
   $.ajax({
    type: "POST",
    url: "form_crud.php?baca_pesan",
    cache:false,
    data: 'pwg_id='+selected_values,
    success: function(response) {
     // menghilangkan baris pesan yang dihapus
     var pgw_ids = response.split(",");
     for (var i=0; i<pgw_ids.length; i++ ) {
      alert("Sukses");
	  window.location.href = 'pesan.php';
     }
    }
   });
  }
 }
});

</script>


</body>

</html>