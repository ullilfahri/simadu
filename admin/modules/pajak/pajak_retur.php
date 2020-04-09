<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] == 3 || $_SESSION['level'] == 4) :
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
	$trx=$conn->query("SELECT * FROM tabel_retur where distributor LIKE '%".$_SESSION['distributor']."%' AND distributor NOT LIKE 'INDV' AND id_trx BETWEEN $awal and $akhir  AND kode=1 ORDER BY id_trx DESC");
	} else if (isset($_GET['data_no_faktur'])){
	$no_faktur=$_GET['no_faktur'];
	$trx=$conn->query("SELECT * FROM tabel_retur  WHERE no_faktur = '$no_faktur'  AND kode=1 ");
	$small='';
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
	$trx=$conn->query("SELECT * FROM tabel_retur where distributor LIKE '%".$_SESSION['distributor']."%' AND distributor NOT LIKE 'INDV' AND id_trx BETWEEN $awal and $akhir  AND kode=1 ORDER BY id_trx DESC");
	} else {
	$id=$_GET['id'];
	$trx=$conn->query("SELECT * FROM tabel_retur where id = '$id' ");
	$small='';
	}
	
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-recycle fa-lg"></i> Summary Retur</a></li>
			</ol>
            
            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN RETUR BARANG BERDASARKAN NOMOR FAKTUR
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
								<button type="submit" name="data_no_faktur" value="ungh_dokumen" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
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
                                PENCARIAN PENGAMBILAN BARANG BERDASARKAN TANGGAL
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
								<button type="submit" name="cari_tanggal" value="ungh_dokumen" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
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
                                SUMMMARY RETUR BARANG
                            </h2>
                            <small>Periode <?=$small?></small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Arsip Bukti Retur</th>
                                            <th>Distributor</th>
                                            <th>Customer</th>
                                            <th>No Faktur</th>
                                            <th>Proses Pajak</th>
                                            <th>Keterangan</th>
                                            <th>Rincian Retur Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									
									if ($x['distributor']=='TSNB') {
										$distributor='PT. TRI SUKSES NIAGA BERSAMA';
										} else {
										$distributor='CV. SURYA';
										}
									
									$y=$conn->query(" SELECT a.no_faktur, b.customer, a.nama_barang, a.satuan, b.cus_umum FROM tabel_retur AS a LEFT JOIN tabel_faktur AS b ON a.no_faktur=b.no_faktur WHERE a.no_faktur = '".$x['no_faktur']."' ")->fetch_array();
									
									if ($y[1] > 0 ) {
									$customer=$conn->query("SELECT nama FROM tabel_customer WHERE id = '".$y[1]."' ")->fetch_array();
									$nama_customer=$customer[0];
									} else {
									$arr = json_decode($y[4], true);
									$nama_customer=$arr["umum"]["nama"];
									}
									
									$barang=$y[2].' '.$x['jumlah_barang'].' '.$y[3];	
										
									$fak=$conn->query("SELECT COUNT(*), a.file, b.php_pdf from tabel_arsip AS a LEFT JOIN jenis_arsip AS b ON a.id_jenis=b.id where a.id_trx = '".$x['id_trx']."' AND a.distributor = '".$x['distributor']."' and a.id_jenis='3' ")->fetch_array();
									if ($fak[0] == 0) {
									 $file2='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Bukti Retur Belum diupload</a></li>';
									 } else {
									 $file2='<li class="font-bold col-pink"><a href="'.$fak[2].$fak[1].'" target="_blank">Bukti Retur</a></li>';
									 }
									 
									 
									 $progress=round(@($fak[0]/1)*100,2);
									
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
                                                    <?=$file2?>
                                                </ul>
                                            </div>
                                            <br><br>
                            				<div class="progress">
                               			 	<div class="progress-bar bg-orange progress-bar-striped active" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%"><p class="font-bold col-pink"><?=$progress?> %</p></div></div>                                            
											</td>
                                            <td><?=$distributor?></td>
                                            <td><?=$nama_customer?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><a href="#" class="proses" data-pk="<?=$x['id']?>" data-name="proses" data-type="select" data-value="<?=$x['proses']?>"></a></td>
                                            <td><a href="#" class="update" data-name="keterangan_lain" data-type="text" data-pk="<?=$x['id']?>" data-title="Remark"><?=$x['keterangan_lain']?></a></td>
                                            <td><?=$barang?></td>
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
<div class="modal fade rinci_ambil" tabindex="-1" role="dialog" aria-hidden="true">
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
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
  	<script src="<?=PLG?>jsgrid/bootstrap-editable.min.js"></script>
    <script src="<?=PLG?>editable/bootstrap-editable.js"></script>

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rinci_ambil').on('show.bs.modal', function (e) {
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
 
<script type="text/javascript">
    $('.update').editable({
           url: 'form_crud.php?editable=tabel_retur&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
	
	
	
</script>

<script type="text/javascript">
var source = [{'value': 0, 'text': 'Belum'}, {'value': 1, 'text': 'On Proses'}, {'value': 2, 'text': 'Selesai'}];

	$('.proses').editable({
           url: 'form_crud.php?editable=tabel_retur&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Proses :',
    	   source: function() {return source;}
});

</script>


</body>

</html>