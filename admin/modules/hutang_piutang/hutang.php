
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']>2) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../kasir'</script>";
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
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Hutang</a></li>
			</ol>  
<?php
$hutang=$conn->query("select * from tabel_pembelian where distributor like '%".$_SESSION['distributor']."%' and metode_bayar='1' order by tgl_nota DESC");
$hutang2=$conn->query("select * from tabel_pengeluaran where distributor like '%".$_SESSION['distributor']."%' and metode_bayar='1' order by tgl_nota DESC");
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA HUTANG
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier</th>
                                            <th>No Innvoice</th>
                                            <th>Tanggal Invoice</th>
                                            <th>Total Pembelian</th>
                                            <th>Total Hutang</th>
                                            <th>Remark</th>
                                            <th>Jenis</th>
                                            <th>Rincian Pembayaran</th>
                                            <th>Pelunasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$hutang->fetch_array()) :
									$file=$x['file'];
									if (file_exists($file)) {
									$tampil='<a href="'.$file.'" target="_blank"><button type="button" class="btn btn-info btn-xs waves-effect">Tampil</button</a>';
									} else {
									$tampil='<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target=".upload" data-id="'.$x['id_pembelian'].'#'.$x['id_pembelian'].'#tabel_pembelian#'.$file.'">Upload</button>';
									} 
									if ($x['remark'] !='0000-00-00' ) { 
									$remark=tanggal_indo($x['remark']); 
									} else {
									$remark='';
									}
									if ($x['is_lunas']==0) {
									$tombol='<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target=".rincian" data-id="'.$x['id_pembelian'].'#tabel_pembelian"><i class="fa fa-money"></i> Belum Lunas</button>';
									} else {
									$tombol='<button type="button" class="btn btn-success btn-xs waves-effect" onclick="sweet()"><i class="fa fa-money"></i> Pelunasan</button>';
									}
									$supplier=$conn->query(" SELECT nama from tabel_supplier where id='".$x['supplier']."' ")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td><?=angka($x['jumlah_hutang'])?></td>
                                            <td><a href="#" class="live_edit" data-name="keterangan_lain" data-type="text" data-pk="<?=$x['id_pembelian']?>" data-title="Keterangan"><?=$x['keterangan_lain']?></a></td>
                                            <td>Pembelian</td>
                                            <td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_pembelian'].'#'.'tabel_pembelian'?>">Rincian</button>
                                            <td><?=$tombol?></td>
                                        </tr>
                                    <?php endwhile;
                                    $no2=$no;
									while ($x=$hutang2->fetch_array()) :
									$file='../stok/upload/'.$x['file'];
									if (file_exists($file)) {
									$tampil='<a href="'.$file.'" target="_blank"><button type="button" class="btn btn-info btn-xs waves-effect">Tampil</button</a>';
									} else {
									$tampil='<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target=".upload" data-id="'.$x['id_pembelian'].'#'.$x['id_pembelian'].'#tabel_pengeluaran#'.$file.'">Upload</button>';
									} 
									if ($x['remark'] !='0000-00-00' ) { 
									$remark=tanggal_indo($x['remark']); 
									} else {
									$remark='';
									}
									if ($x['is_lunas']==0) {
									$tombol='<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target=".rincian" data-id="'.$x['id_pembelian'].'#tabel_pengeluaran"><i class="fa fa-money"></i> Belum Lunas</button>';
									} else {
									$tombol='<button type="button" class="btn btn-success btn-xs waves-effect" onclick="sweet()"><i class="fa fa-money"></i> Pelunasan</button>';
									}
									$supplier=$conn->query(" SELECT nama from tabel_supplier where id='".$x['supplier']."' ")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no2++?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td><?=angka($x['jumlah_hutang'])?></td>
                                            <td><a href="#" class="edit_pengeluaran" data-name="keterangan_lain" data-type="text" data-pk="<?=$x['id_pembelian']?>" data-title="Keterangan"><?=$x['keterangan_lain']?></a></td>
                                            <td>Pengeluaran Operasional</td>
                                            <td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_pembelian'].'#'.'tabel_pengeluaran'?>">Rincian</button>
                                            <td><?=$tombol?></td>
                                        </tr>
                                    <?php endwhile;
									?>  
                                      
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
                            <h4 class="modal-title" id="largeModalLabel">Pembayaran Hutang</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
<!-- Default Size -->
            <div class="modal fade biaya" id="ModalBiaya" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">RINCIAN PEMBAYARAN</h4>
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
            
            
<!--MODAL EDIT-->        
				<div class="modal fade upload" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">UPLOAD FILE INVOICE</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-upload"></div>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT-->  

            <!-- Small Size -->
            <div class="modal fade modal_upload" id="modal_upload" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_upload">Upload File Bukti Pembayaran</h4>
                        </div>
                        <div class="modal-body">
						<div class="fetched-modal"></div>
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
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
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
                url : 'detail.php?pelunasan',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<script>
function sweet() {
    swal({
        title: "Lunas..!",
        text: "",
        imageUrl: "../../../images/thumbs-up.png",
		html: true
    });
}
</script>  

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.upload').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../stok/form_crud.php?upload',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-upload').html(data);//menampilkan data ke dalam modal
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
                url : '../global/modal_detail.php?rincian_bayar',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.ambil-biaya').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>

<script type="text/javascript">
    $('.live_edit').editable({
           url: '../global/update.php?live_edit&tabel=tabel_pembelian&jenis_id=id_pembelian',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
</script>
<script type="text/javascript">
    $('.edit_pengeluaran').editable({
           url: '../global/update.php?live_edit&tabel=tabel_pengeluaran&jenis_id=id_pembelian',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
</script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.modal_upload').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../global/modal_detail.php?modal_upload_bayar',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-modal').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

    
</body>

</html>