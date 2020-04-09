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

if (isset($_GET['hari_ini'])) {
	$awal=strtotime(date('Y-m-d 00:00:00'));
	$akhir=strtotime(date('Y-m-d 23:59:59'));
	$small='HARI INI';
	$trx=$conn->query("SELECT * FROM tabel_trx where id_gudang LIKE '%".$_SESSION['gudang']."%' AND no_faktur between $awal and $akhir AND distributor NOT LIKE 'INDV' group by distributor,no_faktur ORDER BY no_faktur DESC");
	} else if (isset($_GET['sukses_upload'])){
	$awal=$_GET['no_faktur'];
	$akhir=$_GET['no_faktur'];
	$small='HARI INI';
	$trx=$conn->query("SELECT * FROM tabel_trx where id_gudang LIKE '%".$_SESSION['gudang']."%' AND no_faktur between $awal and $akhir AND distributor NOT LIKE 'INDV' group by distributor,no_faktur ORDER BY no_faktur DESC");
	} else if (isset($_GET['cari_tanggal'])){
	$date_1 = date_create_from_format('l d F Y', $_GET['date_1']);
	$date_1=date_format($date_1, 'Y-m-d 00:00:00');
	$tgl_1=tanggal_indo(date_format(date_create_from_format('l d F Y', $_GET['date_1']), 'Y-m-d'));
	$awal=strtotime($date_1);
	$date_2 = date_create_from_format('l d F Y', $_GET['date_2']);
	$date_2=date_format($date_2, 'Y-m-d 23:59:59');
	$tgl_2=tanggal_indo(date_format(date_create_from_format('l d F Y', $_GET['date_2']), 'Y-m-d'));
	$akhir=strtotime($date_2);
	$small=$tgl_1.' s/d '.$tgl_2;
	$trx=$conn->query("SELECT * FROM tabel_trx where id_gudang LIKE '%".$_SESSION['gudang']."%' AND no_faktur between $awal and $akhir AND distributor NOT LIKE 'INDV' group by distributor,no_faktur ORDER BY no_faktur DESC");
	} else {
	$id=$_GET['id'];
	$trx=$conn->query("SELECT * FROM tabel_trx where id = '$id'");
	$small='';
	}
	

if ($_SESSION['level']==4) {
	$tutup='';
	$kunci='disabled';
	} else if ($_SESSION['level']==6) {
	$tutup='';
	$kunci='';
	} else {
	$tutup='disabled';
	$kunci='disabled';
	}


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
                                PENCARIAN TRANSAKSI PENJUALAN BERDASARKAN NOMOR FAKTUR
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-12">
                                <b>No Faktur</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_faktur" class="form-control" placeholder="Masukan No Faktur" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
								<button type="submit" name="sukses_upload" value="" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
                                </div>

                            </form>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->
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
								<button type="submit" name="cari_tanggal" value="" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
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
                                            <th>Distributor</th>
                                            <th>No Faktur</th>
                                            <th>Rincian Pengambilan Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									$xyz=$conn->query("SELECT * FROM `ambil_barang` WHERE id_barang_keluar IN (SELECT id from barang_keluar  WHERE no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."') AND id_gudang = '".$x['id_gudang']."' AND is_final=1 ")->fetch_array();
									
									 
									$fak=$conn->query("SELECT COUNT(*), file from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' and id_jenis='2' AND id_trx = '".$xyz['id_pengambilan']."' ")->fetch_array();
									if ($fak[0] == 0) {
									 $file2='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Surat Jalan Belum diupload</a></li>';
									 } else {
									 $file2='<li class="font-bold col-pink"><a href="../pdf_viewer/gudang_internal.php?dir=penjualan&no_faktur='.$x['no_faktur'].'&id_gudang='.$x['id_gudang'].'&distributor='.$x['distributor'].'" target="_blank">Surat Jalan</a></li>';
									 }
									 
									 
									 $barang_keluar=$conn->query("SELECT COUNT(*), id, jumlah-is_ambil from barang_keluar where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' ")->fetch_array();
									 
									 $ambil_barang=$conn->query("SELECT * from ambil_barang where id_gudang = '".$x['id_gudang']."' AND id_barang_keluar IN (select id from barang_keluar WHERE no_faktur='".$x['no_faktur']."' AND distributor='".$x['distributor']."')")->num_rows;
									 $upload_surat_jalan=$conn->query("SELECT * from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' AND id_jenis = 2 AND id_trx IN (SELECT id_pengambilan from ambil_barang where id_gudang = '".$x['id_gudang']."' ) ")->num_rows;

									  $progress=round(@($upload_surat_jalan/$ambil_barang)*100,2);
									 
									  $dis=$conn->query("SELECT pengguna from mst_hak_akses where kode = '".$x['distributor']."' ")->fetch_array();

									  if ($x['kunci']==0) {
									  	$lock='';
										$tombol_lock='
										<button type="button" onclick="tutup_kunci('.$x['id'].')" class="btn btn-warning waves-effect m-r-17" '.$kunci.'><i class="fa fa-unlock fa-lg"></i></button>
										';
									  	} else {
										$lock='disabled';
										$tombol_lock='
										<button type="button" onclick="buka_kunci('.$x['id'].')" class="btn btn-danger waves-effect m-r-17" '.$kunci.'><i class="fa fa-lock fa-lg"></i></button>
										';
										}
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                           <?=$tombol_lock?> 
                                           <button type="button" class="btn btn-info waves-effect m-r-17" data-toggle="modal" data-target=".upload" data-id="<?=$x['no_faktur'].'#'.$x['distributor']?>" <?=$tutup.' '.$lock?>><i class="fa fa-upload fa-lg"></i>Upload</button>
                                            
                                            <div class="btn-group dropdowns">
                                            <button type="button" class="btn btn-success waves-effect m-r-17 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	<span class="caret"></span>
                                                <span class="sr-only">Arsip Surat Jalan *</span>
                                            </button>
                                            	<ul class="dropdown-menu">
                                                    <?=$file2?>
                                                </ul>
                                            </div>
                                            <br><br />
                            				<div class="progress">
                               			 	<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%"><p class="font-bold col-pink"><?=$progress?> %</p></div></div>                                            
											</td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target=".edit" data-id="<?=$x['no_faktur'].'#'.$x['distributor']?>">Rincian Barang</button></td>
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
                                         
            </div>
    </section>
<!--MODAL EDIT-->        
<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">RINCIAN DAFTAR PENGAMBILAN BARANG</h4>
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

<!--MODAL EDIT-->        
<div class="modal fade upload" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Upload Dokumen Penjualan</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-upload"></div>
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
                url : 'upload.php?transaksi',
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
        $('.upload').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'upload.php?modal_upload',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-upload').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
 
<script>
	function tutup_kunci(id){
		$.ajax({
			type:'POST',
			data:'id='+id,
			url:'../global/update.php?tutup_kunci&tabel=tabel_trx&jenis_id=id&url=../gudang/unggah_dokumen_bu.php?akses_kunci',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				swal({ title: "Oke!", text: "Akses File Ditutup..!", type: "success", timer: 1000, showConfirmButton: false }, function(){ window.location.href = response.url; });
				} else {
					alert('gagal');
				}
			}
		});
	}
</script>
<script>
	function buka_kunci(id){
		$.ajax({
			type:'POST',
			data:'id='+id,
			url:'../global/update.php?buka_kunci&tabel=tabel_trx&jenis_id=id&url=../gudang/unggah_dokumen_bu.php?akses_kunci',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				swal({ title: "Sip!", text: "Akses File Dibuka..!", type: "success", timer: 1000, showConfirmButton: false }, function(){ window.location.href = response.url; });
				} else {
					alert('gagal');
				}
			}
		});
	}
</script>

</body>

</html>