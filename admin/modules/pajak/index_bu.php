
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
$harus=$conn->query("select * from tabel_arsip where id_jenis=3")->num_rows;
$belum = $jumlah - $harus;
$kategori = 'PENJUALAN';
} else {
$trx=$conn->query("select * from tabel_pembelian where is_final=1 AND distributor NOT LIKE '%INDV%' AND distributor like '%".$_SESSION['distributor']."%'");
$jumlah=$trx->num_rows;
$harus=$conn->query("select * from tabel_arsip where id_jenis=4")->num_rows;
$belum = $jumlah - $harus;
$kategori = 'PEMBELIAN';
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
                                            <th>Is Process</th>
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
									$modal=$x['no_faktur'].'-'.$x['distributor'].'#'.$x['id'];
									$file=$conn->query("SELECT `file`, COUNT(*) FROM `tabel_arsip` WHERE `no_faktur`='".$x['no_faktur']."' and `distributor`= '".$x['distributor']."' and `id_jenis`=3")->fetch_array();
									$id=$x['id'];

									} else {
									$id=$x['id_pembelian'];
									$tgl_trx=$x['tgl_nota'];
									$total_trx=$x['total'];
									$modal=$x['id_pembelian'].'-'.$x['distributor'].'#'.$x['id_pembelian'];
									$barang_sql=$conn->query("select * from pembelian_sementara where id_pembelian='".$x['id_pembelian']."' AND distributor='".$x['distributor']."'");
									ob_start();
									while ($y=$barang_sql->fetch_array()) :
									echo $y['nama_barang'].' '.$y['jumlah'].'<br>';
									endwhile;
									$barang=ob_get_contents();
									ob_end_clean();
									$file=$conn->query("SELECT `file`, COUNT(*) FROM `tabel_arsip` WHERE `no_faktur`='".$x['id_pembelian']."' and `distributor`= '".$x['distributor']."' and `id_jenis`=4")->fetch_array();

									}
									
									if ($file[1] > 0) {
									$pajak='<font style="color:#99FF00"><strong>SUDAH</strong></font>';
									$tampil='<a href="'.$file[0].'" target="_blank"><button type="button" class="btn btn-info waves-effect">Tampil</button></a>';
									} else {
									$pajak='<font style="color:#FF0000" class="anic"><strong>BELUM</strong></font>';
									$tampil='';
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
                                            <?php if ($x['proses'] < 2) {?>
                                            <td><a href="#" class="proses" data-pk="<?=$id?>" data-name="proses" data-type="select" data-value="<?=$x['proses']?>"></a></td>
                                            <?php } else {?>
                                            <td><?=$tampil?></td>
                                            <?php }?>
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
           url: 'form_crud.php?editable',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
</script>

<script type="text/javascript">
var source = [{'value': 0, 'text': 'Belum'}, {'value': 1, 'text': 'On Proses'}];

	$('.proses').editable({
           url: 'form_crud.php?editable',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Proses :',
    	   source: function() {return source;}
});

</script>


</body>

</html>