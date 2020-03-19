
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] !=2) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-university fa-lg"></i> Summary Bank</a></li>
			</ol>  


            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PILIH REKENING BANK
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
                                <div class="col-md-12">
                                    <p>
                                        <b>Pilih Rekening Bank (Pilihan dapat lebih dari Satu)</b>
                                    </p>
                                    <select name="id_bank[]" class="form-control show-tick" multiple data-live-search="true" data-show-subtext="true" required>
                                    <?php
									$data_bank=$conn->query("SELECT * FROM rekening_bank where distributor LIKE '%".$_SESSION['distributor']."%'");
									while ($x=$data_bank->fetch_array()) :
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['id_toko']."'")->fetch_array();
									
									?>
                                        <option value="<?=$x['id']?>" data-subtext="Outlet : <?=$toko[0]?>"><?=$x['bank']?> No. Rek <?=$x['no_rek']?></option>
                                    <?php endwhile;?>    
                                    </select>
                                    
                                </div>
                                
                            </div>
                            <button type="submit" name="tampil" class="btn btn-info waves-effect">Tampilkan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Advanced Select -->

<?php
if (isset($_POST['tampil'])) :

$id_bank=implode(", ", $_POST['id_bank']);

$kas=$conn->query("SELECT * FROM `konfirmasi_bank` WHERE id_bank IN ($id_bank) ORDER BY tgl_approve");
$tot_masuk=$conn->query("select SUM(jumlah_bayar) FROM `konfirmasi_bank`  WHERE id_bank IN ($id_bank) and jenis=1 OR id_bank IN ($id_bank) and jenis=3 ")->fetch_array();
$tot_keluar=$conn->query("select SUM(jumlah_bayar) FROM `konfirmasi_bank` WHERE id_bank IN ($id_bank) and jenis=2 OR id_bank IN ($id_bank) and jenis=4 ")->fetch_array();
$total_pemasukan=$tot_masuk[0];
$total_pengeluaran=$tot_keluar[0];
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                KAS PADA BANK
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Bank</th>
                                            <th>No Rek</th>
                                            <th>Status Kepemilikan (Outlet)</th>
                                            <th>Pemasukan</th>
                                            <th>Pengeluaran</th>
                                            <th>Transaksi</th>
                                            <th>Saldo</th>
                                            <th>Keterangan</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th colspan="1"><?=angka($total_pemasukan)?></th>
                                            <th colspan="4"><?=angka($total_pengeluaran)?></th>
                                        </tr> 
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$kas->fetch_array()) :
									$pecah=explode(' ',$x['tgl_approve']);
									$tgl=tanggal_indo($pecah[0]);
									$toko_sql=$conn->query("select nama from lokasi where id_lokasi='".$x['id_toko']."'")->fetch_array();
									$toko=$toko_sql[0];
									if ($x['jenis']==1) {
									$pemasukan=angka($x['jumlah_bayar']);
									$pengeluaran='0';
									$transaksi='Penjualan';
									
									} else if ($x['jenis']==3) {
									$pemasukan=angka($x['jumlah_bayar']);
									$pengeluaran='0';
									$transaksi='Transfer Masuk';

									} else if ($x['jenis']==4) {
									$pengeluaran=angka($x['jumlah_bayar']);
									$pemasukan='0';
									$transaksi='Transfer Keluar';

									} else {
									$pemasukan='0';
									$pengeluaran=angka($x['jumlah_bayar']);
									$transaksi='Pembelian';
									}
									$det_bank=$conn->query("SELECT bank, no_rek from rekening_bank where id='".$x['id_bank']."'")->fetch_array();
									$sld_masuk=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_bank WHERE id_bank='".$x['id_bank']."' AND tgl_approve <= '".$x['tgl_approve']."' AND jenis = 1 OR id_bank='".$x['id_bank']."' AND tgl_approve <= '".$x['tgl_approve']."' AND jenis = 3 ")->fetch_array();
									$sld_keluar=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_bank WHERE id_bank='".$x['id_bank']."' AND tgl_approve <= '".$x['tgl_approve']."' AND jenis = 2 OR id_bank='".$x['id_bank']."' AND tgl_approve <= '".$x['tgl_approve']."' AND jenis = 4 ")->fetch_array();
									$sld=$sld_masuk[0]-$sld_keluar[0];
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$det_bank[0]?></td>
                                            <td><?=$det_bank[1]?></td>
                                            <td><?=strtoupper($toko)?></td>
                                            <td><?=$pemasukan?></td>
                                            <td><?=$pengeluaran?></td>
                                            <td><?=$transaksi?></td>
                                            <td><?=angka($sld)?></td>
                                            <td><a href="#" class="live_edit" data-name="keterangan" data-type="text" data-pk="<?=$x['id']?>" data-title="Keterangan"><?=ucwords($x['keterangan'])?></a></td>
                                            <td><?=ucwords($x['keterangan'])?></td>
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
    
<script type="text/javascript">
    $('.live_edit').editable({
           url: '../global/update.php?live_edit&tabel=konfirmasi_bank&jenis_id=id',
           type: 'textarea',
           pk: 1,
		   placement: 'top',
           name: 'name',
           title: 'Enter name'
    });	
	
	
	
</script>
    

<script type="application/javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 5 || column === 6 || column === 8 ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.apa').DataTable({
        dom: 'Bfrtip',
		searching: false,
        responsive: true,
		info:     true,
		"columnDefs": [{ "visible": false, "targets": 10 }],
        buttons: [
            { extend: 'copyHtml5', footer: true, text: '<i class="fa fa-copy"></i> Copy', title: $('h1').text() },
			//{ extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel' },
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: false, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8, 10 ] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});

</script>            


</body>

</html>