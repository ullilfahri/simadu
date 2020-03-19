
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
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Transaksi</a></li>
			</ol>

            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PILIH RENTANG WAKTU
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tgl_1" class="datepicker form-control" placeholder="Tanggal dan Waktu Awal">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tgl_2" class="datepicker form-control" placeholder="Tanggal dan Waktu Akhir">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                            <button type="submit" name="tampil" class="btn btn-info waves-effect">
                                    		<i class="fa fa-search"></i>
                                			Tampilkan</button>
                                </div>
                                
                             </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->

            
<?php
if (isset($_GET['tampil'])) :
if ($_GET['tampil'] != 'upload') :
$date = date_create_from_format('l d F Y', $_GET['tgl_1']);
$date=date_format($date, 'Y-m-d');
//$date=strtotime($date);

$tgl_awal = date_create_from_format('l d F Y', $_GET['tgl_1']);
$tgl_awal2 = date_create_from_format('l d F Y', $_GET['tgl_1']);
$tgl_awal = date_format($tgl_awal, 'Y-m-d');
$tgl_awal=tanggal_indo($tgl_awal);

$date2 = date_create_from_format('l d F Y', $_GET['tgl_2']);
$date2=date_format($date2, 'Y-m-d');
//$date2=strtotime($date2);

$tgl_akhir = date_create_from_format('l d F Y', $_GET['tgl_2']);
$tgl_akhir2 = date_create_from_format('l d F Y', $_GET['tgl_2']);
$tgl_akhir = date_format($tgl_akhir, 'Y-m-d');
$tgl_akhir=tanggal_indo($tgl_akhir);
endif;

?>            
                        
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR TRANSAKSI PEMBELIAN
                            </h2>
                            <?php if ($_GET['tampil'] != 'upload') :?><small>PERIODE <?=strtoupper($tgl_awal)?> s.d <?=strtoupper($tgl_akhir)?></small><?php endif;?>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>UNGGAH DAN TAMPIL FILE</th>
                                            <th>NOMOR FAKTUR</th>
                                            <th>TANGGAL NOTA</th>
                                            <th>TOTAL</th>
                                            <th>PEMBAYARAN</th>
                                            <th>USER APPROV</th>
                                            <th>SUPPLIER</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									if ($_GET['tampil']=='upload') {
									$trx=$conn->query("select * from tabel_pembelian where id_pembelian = '".$_GET['id_pembelian']."'");
									} else {
									$trx=$conn->query("select * from tabel_pembelian where tgl_nota between '".$date."' and '".$date2."' and total > '0' and distributor like '%".$_SESSION['distributor']."%' order by id_pembelian ASC");
									}
									while ($x=$trx->fetch_array()):
									$owner=$conn->query("SELECT * from user where id='".$x['id_owner']."'")->fetch_array();
									if ($x['metode_bayar']==0) {
									$bayar='Cash';
									} else {
									$bayar='Pembayaran Mundur, Tanggal Jatuh Tempo '.tanggal_indo($x['jatuh_tempo']);
									}
									$inv=$conn->query("SELECT COUNT(*), file from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis='4'")->fetch_array();
									if ($inv[0] == 0) {
									 $file='<li class="font-line-through col-pink"><a href="javascript:void(0);">Invoice Belum Diupload</a></li>';
									 } else {
									 $file='<li class="font-bold col-blue-grey"><a href="'.$inv[1].'" target="_blank">Invoice</a></li>';
									 }
									$fak=$conn->query("SELECT COUNT(*), file from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis='5'")->fetch_array();
									if ($fak[0] == 0) {
									 $file2='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Nota Pembelian Belum Diupload</a></li>';
									 } else {
									 $file2='<li class="font-bold col-pink"><a href="'.$fak[1].'" target="_blank">Nota Pembelian</a></li>';
									 }
									 $progress_sql=$conn->query("SELECT * from tabel_arsip where id_trx = '".$x['id_pembelian']."' and id_jenis between 4 and 5")->num_rows;
									 $progress= $progress_sql/2*100;
									?>
                                        <tr>
                                            <td>
                                            <div class="btn-group dropup">
                                            <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target=".edit" data-id="<?php echo $x['id_pembelian'];?>">Upload</button>
                                            <button type="button" class="btn btn-success waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	<span class="caret"></span>
                                                <span class="sr-only">File</span>
                                            </button>
                                            	<ul class="dropdown-menu">
                                                	<?=$file?>
                                                    <?=$file2?>
                                                </ul>
                                            </div>
                                            <br><br />
                            				<div class="progress">
                               			 	<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%"><p class="font-bold col-pink"><?=$progress?> %</p></div></div>                                            
											</td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td><?=$bayar?></td>
                                            <td><?=$owner['nama']?></td>
                                            <td><?=strtoupper($x['supplier'])?></td>
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
<?php endif;?>            
                    
            </div>
    </section>
<!--MODAL EDIT-->        
<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">UPLOAD FILE INVOICE</h4>
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
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>

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
    

</body>

</html>