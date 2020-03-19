<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] > 2) :
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
	
$trx=$conn->query("SELECT * FROM tabel_trx where distributor like '%".$_SESSION['distributor']."%' AND no_faktur between $awal and $akhir ORDER by no_faktur DESC");
$total=$conn->query("SELECT SUM(sub_total) FROM tabel_trx where distributor like '%".$_SESSION['distributor']."%' AND no_faktur between $awal and $akhir")->fetch_array();
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Summary Penjualan</a></li>
			</ol>
            
            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN TRANSAKSI PENJUALAN BERDASARKAN TANGGAL
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
                                SUMMMARY PENJUALAN
                            </h2>
                            <small>Periode <?=$small?></small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Arsip Penjualan</th>
                                            <th>Outlet</th>
                                            <th>Customer</th>
                                            <th>No Faktur</th>
                                            <th>Rincian Barang</th>
                                            <th>Jumlah (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th><?=angka($total[0])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['id_toko']."'")->fetch_array();
									$customer = $conn->query(" SELECT customer, cus_umum from tabel_faktur where no_faktur = '".$x['no_faktur']."' ")->fetch_array();
									if ($customer[0] > 0) {
										$cst_sql=$conn->query(" SELECT nama from tabel_customer where id= '$customer[0]' ")->fetch_array();
										$cst=$cst_sql[0];
										} else {
										$arr = json_decode($customer[1], true);
										$cst=$arr["umum"]["nama"];
									}	 
									
                                    $inv=$conn->query("SELECT COUNT(*), file from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' and id_jenis='1'")->fetch_array();
									if ($inv[0] == 0) {
									 $file='<li class="font-line-through col-pink"><a href="javascript:void(0);">Faktur Penjualan Belum Diupload</a></li>';
									 } else {
									 $file='<li class="font-bold col-blue-grey"><a href="../pdf_viewer/dari_kasir.php?dir=penjualan&file='.$inv[1].'" target="_blank">Faktur Penjualan</a></li>';
									 }
									 
									$fak=$conn->query("SELECT COUNT(*), file from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' and id_jenis='2'")->fetch_array();
									if ($fak[0] == 0) {
									 $file2='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Surat Jalan Belum diupload</a></li>';
									 } else {
									 $file2='<li class="font-bold col-pink"><a href="../pdf_viewer/surat_jalan.php?dir=penjualan&no_faktur='.$x['no_faktur'].'" target="_blank">Surat Jalan</a></li>';
									 }
									 
									$ada_retur=$conn->query(" SELECT * FROM tabel_retur WHERE kode=1 AND no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' ")->num_rows;
									if ($ada_retur > 0) {
										$retur=$conn->query("SELECT COUNT(*), file from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' and id_jenis='3'")->fetch_array();
										$file_retur=$ada_retur;
										$file_retur_upload=$retur[0];			
										if ($retur[0] == 0) {
									 		$file3='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Bukti Retur Belum diupload</a></li>';
									 		} else {
									 		$file3='<li class="font-bold col-pink"><a href="../pdf_viewer/bukti_retur.php?dir=penjualan&no_faktur='.$x['no_faktur'].'" target="_blank">Bukti Retur</a></li>';
									 	}
									} else {
									$file3='';
									$file_retur=0;
									$file_retur_upload=0;
									}	


									 
									 $barang_keluar=$conn->query("SELECT COUNT(*), id, jumlah-is_ambil from barang_keluar where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' ")->fetch_array();
									 
									 if ($barang_keluar[2] == 0) {
									 $ambil_barang=0;
									 $upload_surat_jalan=1;
									 } else {
									 $ambil_barang=$conn->query("SELECT * from ambil_barang where id_barang_keluar = '".$barang_keluar[1]."' ")->num_rows;
									 $upload_surat_jalan=$conn->query("SELECT * from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' AND id_jenis = 2 ")->num_rows;
									 }
									 
									 $invoice=1;
									 $invoice_upload=$conn->query("SELECT * from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' AND id_jenis = 1 ")->num_rows;
									
									 
									  $progress=round(($invoice_upload+$upload_surat_jalan+$file_retur_upload)/($barang_keluar[0]+$invoice+$ambil_barang+$file_retur)*100,2);
									
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                            <div class="btn-group dropdowns">
                                            <button type="button" class="btn btn-success waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	<span class="caret"></span>
                                                <span class="sr-only">Arsip Penjualan *</span>
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
                                            <td><?=$toko[0]?></td>
                                            <td><?=$cst?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target=".edit" data-id="<?=$x['no_faktur'].'#'.$x['distributor']?>">Rincian Barang</button></td>
                                            <td><?=angka($x['sub_total'])?></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
            <!-- Blockquotes -->
                        <div class="body">
                            <blockquote>
                                <p class="font-bold font-italic font-underline col-black">*) Keterangan (Arsip Penjualan)</p>
                                <footer>Arsip/Dokumen Penjualan terdiri dari <cite title="Source Title"><strong>Faktur Penjualan, Surat Jalan dan Bukti Pengambilan Barang</strong></cite> yang diunggah oleh Admin Toko</footer>
                                <footer>Dokumen Faktur Pajak Penjualan diakses pada menu Pajak</footer>
                                <footer>Semua dokumen penjualan juga dapat dipantau di menu <strong>Pajak</strong>, memungkinkan bagi Admin Pajak dan Distributor memantau Progress</footer>
                            </blockquote>
                        </div>
            <!-- #END# Blockquotes -->   
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->   
                                         
            </div>
    </section>
<!--MODAL EDIT-->        
<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">RINCIAN DAFTAR TRANSAKSI</h4>
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
                url : 'form_crud.php?transaksi',
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