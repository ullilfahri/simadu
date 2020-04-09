
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']!=2) :
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
if (isset($_GET['hari_ini'])) {
	$awal=strtotime(date('Y-m-d 00:00:00'));
	$akhir=strtotime(date('Y-m-d 23:59:59'));
	$small='HARI INI';
	} else if (isset($_GET['tampi_upload'])){
	$awal=$_GET['tanggal'];
	$akhir=$_GET['tanggal'];
	$small='';
	} else {
	$date_1 = date_create_from_format('l d F Y', $_GET['date_1']);
	$date_1=date_format($date_1, 'Y-m-d 00:00:00');
	$tgl_1=tanggal_indo(date_format(date_create_from_format('l d F Y', $_GET['date_1']), 'Y-m-d'));
	$awal=strtotime($date_1);
	$date_2 = date_create_from_format('l d F Y', $_GET['date_2']);
	$date_2=date_format($date_2, 'Y-m-d 23:59:59');
	$tgl_2=tanggal_indo(date_format(date_create_from_format('l d F Y', $_GET['date_2']), 'Y-m-d'));
	$akhir=strtotime($date_2);
	$small=$tgl_1.' s/d '.$tgl_2;
	}
	
$trx=$conn->query("SELECT * FROM tabel_pembelian where distributor like '%".$_SESSION['distributor']."%' AND is_final=1 AND id_pembelian between $awal and $akhir ORDER by id_pembelian DESC");
$total=$conn->query("SELECT SUM(total) FROM tabel_pembelian where distributor like '%".$_SESSION['distributor']."%' AND is_final=1 AND id_pembelian between $awal and $akhir")->fetch_array();

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Summary Pembelian</a></li>
			</ol>

            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN TRANSAKSI PEMBELIAN BERDASARKAN TANGGAL
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-6">
                                <b>Tanggal Awal</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="date_1" class="datepicker form-control" placeholder="Masukan Tanggal Awal" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                <b>Tanggal Akhir</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="date_2" class="datepicker form-control" placeholder="Masukan Tanggal Akhir" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
								<button type="submit" name="cari_tanggal" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
                                </div>

                            </form>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->
            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SUMMMARY PEMBELIAN
                            </h2>
                            <small>Periode <?=$small?></small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Upload dan Tampil File</th>
                                            <th>Supplier</th>
                                            <th>Faktur Pajak</th>
                                            <th>No Faktur</th>
                                            <th>Tgl Faktur</th>
                                            <th>Jumlah Transaksi (Rp)</th>
                                            <th>Include Pajak</th>
                                            <th>Rincian Barang</th>
                                            <th>Rincian Biaya</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6">Total</th>
                                            <th  colspan="4"><?=angka($total[0])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									$data_supplier=$conn->query("SELECT nama from tabel_supplier where id='".$x['supplier']."'")->fetch_array();
									$inv=$conn->query("SELECT COUNT(*), file from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis='4'")->fetch_array();
									if ($inv[0] == 0) {
									 $file='<li class="font-line-through col-pink"><a href="javascript:void(0);">Invoice Belum Diupload</a></li>';
									 } else {
									 $file='<li class="font-bold col-blue-grey"><a href="http://'.$_SERVER['HTTP_HOST'].$inv[1].'" target="_blank">Invoice</a></li>';
									 }
									$fak=$conn->query("SELECT COUNT(*), file from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis='5'")->fetch_array();
									if ($fak[0] == 0) {
									 $file2='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Surat Jalan Belum diupload</a></li>';
									 } else {
									 $file2='<li class="font-bold col-pink"><a href="http://'.$_SERVER['HTTP_HOST'].$fak[1].'" target="_blank">Surat Jalan</a></li>';
									 }
									$pjk=$conn->query("SELECT COUNT(*), file from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis='6'")->fetch_array();
									if ($pjk[0] == 0) {
									 $file3='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Pajak Pembelian Belum Diupload</a></li>';
									 } else {
									 $file3='<li class="font-bold col-pink"><a href="http://'.$_SERVER['HTTP_HOST'].$pjk[1].'" target="_blank">Pajak Pembelian</a></li>';
									 }
									 $progress_sql=$conn->query("SELECT * from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis between 4 and 6")->num_rows;
									 $progress = round($progress_sql/3*100 ,2);
									 if ($x['include_pajak']==0) {
									 $include = '<span class="glyphicon glyphicon-remove">';
									 } else {
									 $include = '<span class="glyphicon glyphicon-ok">';
									 }
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                            <div class="btn-group dropdowns">
                                            <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target=".edit" data-id="<?php echo $x['id_pembelian'];?>">Upload</button>
                                            <button type="button" class="btn btn-success waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	<span class="caret"></span>
                                                <span class="sr-only">File</span>
                                            </button>
                                            	<ul class="dropdown-menu">
                                                	<?=$file?>
                                                    <?=$file2?>
                                                    <?=$file3?>
                                                </ul>
                                            </div>
                                            <br><br />
                            				<div class="progress">
                               			 	<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%"><p class="font-bold col-pink"><?=$progress?> %</p></div></div>                                            
											</td>
                                            <td><?=strtoupper($data_supplier[0])?></td>
                                            <td><a href="#" class="live_edit" data-name="file_pajak" data-type="text" data-pk="<?=$x['id_pembelian']?>" data-title="No Faktur Pajak"><?=$x['file_pajak']?></a></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td class="align-center"><?=$include?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#largeModal" data-id="<?=$x['id_pembelian'].'#'.$x['distributor']?>">Barang</button></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_pembelian']?>">Biaya</button>
                                            </td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->             
                    
<!--MODAL EDIT-->        
				<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">UPLOAD FILE PEMBELIAN</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-data"></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                        	<i class="fa fa-times"></i><span>Tutup</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT-->     

<!-- Default Size -->
            <div class="modal fade rinci" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">RINCIAN BARANG PEMBELIAN</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data2"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-teal waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- Default Size -->
            <div class="modal fade biaya" id="ModalBiaya" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">RINCIAN BIAYA</h4>
                        </div>
                        <div class="modal-body">
                            <div class="ambil-biaya"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-teal waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
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

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    
    <!-- Autosize Plugin Js -->
    <script src="<?=PLG?>autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?=PLG?>jquery-countto/jquery.countTo.js"></script>
    
    <!-- Sparkline Chart Plugin Js -->
    <script src="<?=PLG?>jquery-sparkline/jquery.sparkline.js"></script>
            
    <!-- Jquery DataTable Plugin Js -->
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
	<script src="<?=PLG?>jsgrid/bootstrap-editable.min.js"></script>
    <script src="<?=PLG?>editable/bootstrap-editable.js"></script>
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
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
<script type="text/javascript">
    $('.live_edit').editable({
           url: '../global/update.php?live_edit&tabel=tabel_pembelian&jenis_id=id_pembelian',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
</script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.edit').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?upload',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rinci').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?rinci_beli',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.biaya').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../global/modal_detail.php?tampil_modal&url=summary_pembelian&tabel=tabel_pembelian&jenis_id=id',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.ambil-biaya').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

    

</body>

</html>