<!--Header-->
<?php include "../../partial/header.php";?>
<!--End Header-->

    <!-- Page Loader -->
    <?php include "../../partial/page_loader.php";?>
    <!-- #END# Page Loader -->
    
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <?php include "../../partial/top_bar.php";?>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
         <?php include "../../partial/left_siderbar.php";
		 
		 ?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>
<!--JUDUL-->
    <section class="content">
        <div class="container-fluid">
           <ol class="breadcrumb breadcrumb-bg-pink">
               <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
               <li><a href="javascript:void(0);"><i class="material-icons">phone</i> Setting Modem</a></li>
               <li class="active"><i class="material-icons">mail_outline</i> Konfigurasi Balas Otomatis</li>
           </ol>
<!-- JUDUL -->
        <!-- Tabs With Custom Animations -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Konfigurasi Balas Otomatis
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#home_animation_1" data-toggle="tab">FORMAT SMS</a></li>
                                        <li role="presentation"><a href="#profile_animation_1" data-toggle="tab">REPLY MODEM</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane animated flipInX active" id="home_animation_1">
                                <!--TABLE FORMAT SMS-->            
                                				<table class="table table-bordered table-striped">
                                    			<thead>
                                       			<tr>
                                            	<th>NO</th>
                                            	<th>KEYWORD</th>
                                            	<th>FORMAT</th>
                                            	<th>KETERANGAN</th>
                                            	<th>AKTIVASI</th>
                                            	<th>EDIT</th>
                                        		</tr>
                                    			</thead>
                                    			<tbody>
<?php 
$pemilih=$conn->query("select * from mst_setting where id<10 order by id ASC");
$no=1;
while ($x=$pemilih->fetch_array()) {
if ($x['set']==1) {$set="AKTIF";} else {$set="TIDAK AKTIF";}
?>
                                        				<tr>
                                            			<td><?php echo $no++;?></td>
                                            			<td><?php echo $x['keyword'];?></td>
                                            			<td><?php echo $x['format'];?></td>
                                            			<td><?php echo $x['keterangan'];?></td>
                                            			<td><?php echo $set;?></td>
                                            			<td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".pps" data-id="<?php echo $x['id'];?>">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
														</td>
                                        				</tr>
                                    					<?php }?>    
                                    				</tbody>
                                				</table>
                                <!--END TABLE FORMAT SMS-->            
                                        </div>
                                        <div role="tabpanel" class="tab-pane animated flipInX" id="profile_animation_1">
                                <!--TABLE FORMAT SMS-->            
                                				<table class="table table-bordered table-striped">
                                    			<thead>
                                       			<tr>
                                            	<th>REPLY MODEM</th>
                                            	<th>BALAS DARI MODEM YANG SAMA</th>
                                            	<th>EDIT</th>
                                        		</tr>
                                    			</thead>
                                    			<tbody>
<?php 
$pemilih=$conn->query("select * from mst_setting where id='11'");
$no=1;
while ($x=$pemilih->fetch_array()) {
if ($x['set']==1) {
	$set="TIDAK"; 
	$modem=str_replace("_"," # ",$x['keterangan']);
	} elseif ($x['set']==2){
	$set="BALAS DARI PROVIDER SAMA"; 
	$modem="PROVIDER YANG SAMA";
	} else {
	$set="YA";
	$modem="-";
	}
?>
                                        				<tr>
                                            			<td><?php echo $modem;?></td>
                                            			<td><?php echo $set;?></td>
                                            			<td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".pps" data-id="<?php echo $x['id'];?>">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
														</td>
                                        				</tr>
                                    					<?php }?>    
                                    				</tbody>
                                				</table>
                                <!--END TABLE FORMAT SMS-->            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Custom Animations -->

        </div>
    </section>
<!--END MODAL PPS-->        
<div class="modal fade pps" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">EDIT DATA BALAS SMS OTOMATIS</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-data"></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                        	<i class="material-icons">report_problem</i><span>Batal</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
<!-- Javasrip Modal Detail pps-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.pps').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'edit.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail pps-->
</body>

</html>