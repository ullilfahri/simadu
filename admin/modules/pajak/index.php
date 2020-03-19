
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
if (isset($_GET['pjk_jual'])) {
$trx=$conn->query("select * from barang_keluar where jumlah=is_ambil AND distributor NOT LIKE '%INDV%' AND distributor like '%".$_SESSION['distributor']."%' order by no_faktur DESC");
$jumlah=$trx->num_rows;
$harus=$conn->query("select * from tabel_arsip where id_jenis=6")->num_rows;
$belum = $jumlah - $harus;
$kategori = 'PENJUALAN';
$tabel='barang_keluar';
$id_arsip = 'between 1 AND 3';
$invoice=1;
$retur=$conn->query(" select * from tabel_retur where kode=1 AND distributor NOT LIKE '%INDV%' AND distributor like '%".$_SESSION['distributor']."%'  ")->num_rows;
$url='pjk_jual';
} else {

$trx=$conn->query("select * from tabel_pembelian where is_final=1 AND distributor NOT LIKE '%INDV%' AND distributor like '%".$_SESSION['distributor']."%'");
$jumlah=$trx->num_rows;
$harus=$conn->query("select * from tabel_arsip where id_jenis=7")->num_rows;
$belum = $jumlah - $harus;
$kategori = 'PEMBELIAN';
$tabel='tabel_pembelian';
$id_arsip = 'between 4 AND 5';
$jumlah_arsip=2;
$url='pjk_beli';
}


if ($belum > 0) :
  echo '<script type="text/javascript">';
  echo 'setTimeout(function () { swal("Perhatian..!","Terdapat '.$belum.' dari '.$harus.' Faktur Pajak '.ucwords($kategori).' Yang Belum diunggah..!","error");';
  echo '}, 1000);</script>';
endif;

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Pajak</a></li>
			</ol>  
            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PAJAK <?=$kategori?>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>File</th>
                                            <th>Arsip <?=ucwords(strtolower($kategori))?></th>
                                            <th>Pogress</th>
                                            <th>Remark</th>
                                            <th>Distributor</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Transaksi</th>
                                            <th>Rincian Barang</th>
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
									
									if (isset($_GET['pjk_jual'])) {
									$id=$x['id'];
									$barang_sql=$conn->query("select * from tabel_trx where no_faktur='".$x['no_faktur']."' AND distributor='".$x['distributor']."'");
									ob_start();
									while ($y=$barang_sql->fetch_array()) :
									echo $y['nama_barang'].' '.$y['jumlah'].' '.$y['satuan'].'<br>';
									endwhile;
									$barang=ob_get_contents();
									ob_end_clean();
									$total=$conn->query("select SUM(sub_total) from tabel_trx where no_faktur='".$x['no_faktur']."' AND distributor='".$x['distributor']."'")->fetch_array();
									$total_trx=$total[0];
									$tgl_trx=date('Y-m-d',$x['no_faktur']);
									$modal=$x['no_faktur'].'-'.$x['distributor'].'#'.$x['id'].'#'.'6#pjk_jual#'.$x['distributor'].'#'.$x['no_faktur'];
									$file=$conn->query("SELECT `file`, COUNT(*) FROM `tabel_arsip` WHERE `no_faktur`='".$x['no_faktur']."' and `distributor`= '".$x['distributor']."' and `id_jenis`=6")->fetch_array();
									

									} else {
									$id=$x['id_pembelian'];
									$tgl_trx=$x['tgl_nota'];
									$total_trx=$x['total'];
									$modal=$x['id_pembelian'].'-'.$x['distributor'].'#'.$x['id_pembelian'].'#7#pjk_beli#'.$x['distributor'].'#'.$x['id_pembelian'];
									$barang_sql=$conn->query("select * from pembelian_sementara where id_pembelian='".$x['id_pembelian']."' AND distributor='".$x['distributor']."'");
									ob_start();
									while ($y=$barang_sql->fetch_array()) :
									echo $y['nama_barang'].' '.$y['jumlah'].'<br>';
									endwhile;
									$barang=ob_get_contents();
									ob_end_clean();
									$file=$conn->query("SELECT `file`, COUNT(*) FROM `tabel_arsip` WHERE `no_faktur`='".$x['id_pembelian']."' and `distributor`= '".$x['distributor']."' and `id_jenis`=7")->fetch_array();

									}
									
									if ($file[1] > 0) {
									$pajak='<font style="color:#99FF00"><strong>SUDAH</strong></font>';
									$tampil='<a href="'.$file[0].'" target="_blank"><button type="button" class="btn btn-info waves-effect">Tampil</button></a>';
									} else {
									$pajak='<font style="color:#FF0000" class="anic"><strong>BELUM</strong></font>';
									$tampil='';
									}
									
									$arsip = $conn->query("SELECT * FROM tabel_arsip where no_faktur = '".$x['no_faktur']."' AND id_jenis $id_arsip AND distributor = '".$x['distributor']."'");
									$jml_arsip = $arsip->num_rows;
									if (isset($_GET['pjk_beli'])) {
									$progress=$jml_arsip/$jumlah_arsip*100;
									} else {
									$surat_jalan=$conn->query("SELECT * from ambil_barang where id_barang_keluar = '".$x['id']."' ")->num_rows;
									$progress=$jml_arsip/($invoice+$surat_jalan+$retur)*100;
									}
									
																		
									if ($jml_arsip > 0) {
									$btn_class='dropdown-toggle';
									$btn_data = 'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
									ob_start();
									echo '<ul class="dropdown-menu">';
									while ($f=$arsip->fetch_array()) :
									$jenis=$conn->query("select jenis_arsip, php_pdf from jenis_arsip where id = '".$f['id_jenis']."'")->fetch_array();
									echo '<li role="separator" class="divider"></li>';
									if ($f['id_jenis'] == 2) {
									$prt=$conn->query(" SELECT partial from ambil_barang where id_pengambilan = '".$f['id_trx']."' ")->fetch_array();
									echo '<li><a href="'.$jenis[1].$f['file'].'" target="_blank">'.$jenis[0].' Nomor : '.$x['no_faktur'].'-'.surat_jalan($prt[0]).'</a></li>';
									} else {
									echo '<li><a href="'.$jenis[1].$f['file'].'" target="_blank">'.$jenis[0].'</a></li>';
									}
									endwhile;
									echo '<li role="separator" class="divider"></li>';
									echo '</ul>';
									$jenis_jenis=ob_get_contents();
									ob_end_clean();
									} else {
									$btn_class='';
									$btn_data = 'data-toggle="modal" data-target="#defaultModal"';
									$jenis_jenis='';
									}
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><div class="btn-group" role="group">
                                        		<button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	FILE
                                            	<span class="caret"></span>
                                        		</button>
                                        			<ul class="dropdown-menu">
                                            			<li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal" data-id="<?=$modal?>">Upload Faktur Pajak</a></li>
<?php if ($file[1] > 0) :?>                                                        
                                                        <li role="separator" class="divider"></li>
                                                        <li><a href="<?=$file[0]?>" target="_blank">Tampil File</a></li>
<?php endif;?>                                                        
                                        			</ul>
                                    			</div>
                                            </td>
                                            
                                            <td>
                                            <div class="btn-group <?=$btn_class?>">
                                            <button type="button" class="btn btn-primary btn-block waves-effect <?=$btn_class?>" <?=$btn_data?>><span class="caret"></span><span class="sr-only">Progress <span class="badge"><?=round($progress,2)?> %</span></span></button>
                                            	
                                                <?=$jenis_jenis?>
                                                
                                            </div>
                                            </td>
                                            
                                            <?php if ($file[1] == 0) {?>
                                            <td><a href="#" class="proses" data-pk="<?=$id?>" data-name="proses" data-type="select" data-value="<?=$x['proses']?>"></a></td>
                                            <?php } else {?>
                                            <td><div class="progress"><div class="progress-bar bg-green progress-bar-striped active" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div></div></td>
                                            <?php }?>
                                            <td><a href="#" class="update" data-name="keterangan_lain" data-type="text" data-pk="<?=$id?>" data-title="Remark"><?=$x['keterangan_lain']?></a></td>
                                            <td><?=$distributor?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($tgl_trx)?></td>
                                            <td><?=angka($total_trx)?></td>
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
            <!-- Large Size -->
            <div class="modal fade rincian" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Upload File</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data"></div>
                        </div><!--#End <div class="modal-body">-->
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            
            <!-- Default Size -->
            <div class="modal fade kirim_pesan" id="defaultModal" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Kirim Pesan..!</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" autocomplete="off" method="post" action="form_crud.php">
                            <input type="hidden" name="pengirim" value="<?=$_SESSION['id']?>" />   
                            <input type="hidden" name="url" value="<?=$url?>" />   
                                
                                
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
                                                <textarea rows="2" name="isi_pesan" class="form-control no-resize auto-growth" required>Nomor Faktur Belum Ada Arsip</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Pilih Jenis Dokumen</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-file fa-lg"></i></span>
                                    		<select name="jenis_arsip[]" class="form-control" multiple required>
                                            <?php
                                            $arsip_modal=$conn->query("select * from jenis_arsip where id $id_arsip");
											while ($am=$arsip_modal->fetch_array()) :
											?>
                                        	<option value="<?=$am['jenis_arsip']?>"><?=$am['jenis_arsip']?></option>
                                            <?php endwhile;?>
                                    		</select>                                        
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

	<script src="<?=PLG?>bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    
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
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
  	<script src="<?=PLG?>jsgrid/bootstrap-editable.min.js"></script>
    <script src="<?=PLG?>editable/bootstrap-editable.js"></script>
    
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rincian').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'upload/upload.php?manual',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<script type="text/javascript">
    $('.update').editable({
           url: 'form_crud.php?editable=<?=$tabel?>',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
	
	
	
</script>

<script type="text/javascript">
var source = [{'value': 0, 'text': 'Belum'}, {'value': 1, 'text': 'On Proses'}, {'value': 2, 'text': 'Selesai'}];

	$('.proses').editable({
           url: 'form_crud.php?editable=<?=$tabel?>',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Proses :',
    	   source: function() {return source;}
});

</script>

<script>
$(function () {
    $('.js-sweetalert button').on('click', function () {
        var type = $(this).data('type');
         if (type === 'prompt') {
            showPromptMessage();
        }
    });
});

//These codes takes from http://t4t5.github.io/sweetalert/
function showPromptMessage() {
    swal("Arsip <?=ucwords(strtolower($kategori))?>", "Belum Lengkap, Hubungi Admin!", "warning");
}

</script>

</body>

</html>