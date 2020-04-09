
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] > 4) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
if ($_SESSION['sub_level'] == 3) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-recycle fa-lg"></i> Summary Pembelian</a></li>
			</ol>

<?php

$retur=$conn->query("SELECT * FROM tabel_retur ORDER BY is_alokasi");
?>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SUMMMARY DATA RETUR/TRANSFER
                                <small>Jika Keterangan Transfer, Tombol "Belum" yang merupakan Alokasi Barang Hanya dapat Diakses oleh Admin Gudang Tujuan</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Retur</th>
                                            <th>No Faktur Penjualan</th>
                                            <th>Keterangan</th>
                                            <th>Nama Barang</th>
                                            <th>QTY</th>
                                            <th>Toko</th>
                                            <th>Gudang Asal</th>
                                            <th>Gudang Tujuan</th>
                                            <th>User Approve</th>
                                            <th>QTY Alokasi</th>
                                            <th>Status Alokasi</th>
                                            <th>Cetak Ulang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$retur->fetch_array()) :
									if ($x['jumlah_barang'] - $x['is_alokasi'] > 0) {
										if ($x['gudang_tujuan'] != $_SESSION['gudang'] && $x['kode']==2) {
											$akses='disabled';
											} else {
											$akses='';
											}
										$tombol='<a href="entry_alokasi.php?url=retur_data&id='.$x['id'].'&kode=1"><button type="button" class="btn btn-danger btn-sm" '.$akses.'>Belum</button></a>';
										} else {
										$tombol='<a href="../pdf_viewer/index.php?dir=bukti_ambil&file='.$x['id_trx'].'.pdf" target="_blank"><button type="button" class="btn btn-success btn-sm">Sudah</button></a>';
									}
									$pecah=explode(' ',$x['tanggal']);
									$toko=$conn->query(" SELECT nama from lokasi where id_lokasi='".$x['id_toko']."' ")->fetch_array();
									if ($x['kode']==1) {
											$ket='Retur';
											$gudang_asal='';
											$gudang_tujuan='';
											$prit='<a href="../pdf_viewer/index.php?dir=bukti_ambil&file='.$x['id_trx'].'.pdf" target="_blank"><button type="button" class="btn btn-success btn-sm">Cetak</button></a>';
										} else {
											$ket='Transfer';
											$asal_sq1=$conn->query(" SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."' ")->fetch_array();
											$tujuan_sq1=$conn->query(" SELECT nama from lokasi where id_lokasi='".$x['gudang_tujuan']."' ")->fetch_array();
											$gudang_asal=$asal_sq1[0];
											$gudang_tujuan=$tujuan_sq1[0];
											$prit='<a href="../pdf_viewer/index.php?dir=bukti_ambil&file='.$x['id_trx'].'.pdf" target="_blank"><button type="button" class="btn btn-success btn-sm">Cetak</button></a>';
									}
									
									
									
									$user=$conn->query("SELECT nama FROM user WHERE id='".$x['user_approve']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=tanggal_indo($pecah[0])?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$ket?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah_barang'].' '.$x['satuan']?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=$gudang_asal?></td>
                                            <td><?=$gudang_tujuan?></td>
                                            <td><?=$user[0]?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_trx']?>">Rincian</button></td>
                                            <td><?=$tombol?></td>
                                            <td><?=$prit?></td>
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
            
                    
<!-- Default Size -->
            <div class="modal fade rinci" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">RINCIAN BIAYA</h4>
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