
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] > 2) :
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
$kode=$conn->query("select * from kode_voucher where is_pakai = 0 AND distributor like '".$_SESSION['distributor']."' order by tgl_generate DESC");
$kode_sudah=$conn->query("select * from kode_voucher where is_pakai = 1 AND distributor like '".$_SESSION['distributor']."' order by tgl_generate DESC");
$generate = acak(5);

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-user fa-lg"></i> Customer</a></li>
			</ol>  
            
            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                KODE VOUCHER
                            </h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#buat" data-toggle="tab">
                                        <i class="fa fa-edit fa-2x"></i> Generate Kode
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#sudah" data-toggle="tab">
                                        <i class="fa fa-info-circle fa-2x"></i> Sudah Digunakan
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#belum" data-toggle="tab">
                                        <i class="fa fa-info fa-2x"></i> Belum Digunakan
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="buat"><!--Start <div role="tabpanel" class="tab-pane fade in active" id="buat">-->
                                    <b>Generate Kode Voucher</b>
                                	<div class="js-sweetalert">
                                    <button type="button" data-type="prompt" class="btn bg-light-blue waves-effect"<?php if ($_SESSION['level'] != 2) :?> disabled<?php endif;?>>Generate Kode</button>
                                	</div>
                                </div><!--End <div role="tabpanel" class="tab-pane fade in active" id="buat">-->
                                
                                
                                <div role="tabpanel" class="tab-pane fade" id="sudah"><!--Start <div role="tabpanel" class="tab-pane fade" id="sudah">-->
            					<!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA VOUCHER SUDAH DIKLAIM
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="mainTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Distibutor</th>
                                            <th>Jumlah Potongan</th>
                                            <th>Tanggal Generate</th>
                                            <th>Kasir Klaim</th>
                                            <th>Pelanggan Klaim</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ny=1;
									while ($y=$kode_sudah->fetch_array()) :
									$distributory=$conn->query("select pengguna from mst_hak_akses where kode='".$y['distributor']."'")->fetch_array();
									$pecahy=explode(' ',$y['tgl_generate']);
									$tgly=tanggal_indo($pecahy[0]).' '.$pecahy[1];
									$kasiry=$conn->query("SELECT  `nama` FROM `user` WHERE id='".$y['user']."'")->fetch_array();
									$pelanggan=$conn->query("SELECT  `nama` FROM `tabel_customer` WHERE id='".$y['customer']."'")->fetch_array();
									?>
                                        <tr>
                                            <th scope="row"><?=$ny++?></th>
                                            <td><?=$y['kode']?></td>
                                            <td><?=$distributory[0]?></td>
                                            <td><?=angka($y['jumlah_potongan'])?></td>
                                            <td><?=$tgly?></td>
                                            <td><?=$kasiry[0]?></td>
                                            <td><?=$pelanggan[0]?></td>
                                            <td><button type="button" class="btn btn-danger btn-sm" onClick="confirm_modal('detail_piutang.php?hapus_voucher&&modal_id=<?=$y['id']; ?>');">Hapus</button></td>
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
                                </div><!--END <div role="tabpanel" class="tab-pane fade" id="sudah">-->
                                
                                
                                <div role="tabpanel" class="tab-pane fade" id="belum"><!--Start <div role="tabpanel" class="tab-pane fade" id="belum">-->
            					<!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                 DATA VOUCHER BELUM DIKLAIM
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="mainTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Distibutor</th>
                                            <th>Jumlah Potongan</th>
                                            <th>Tanggal Generate</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$kode->fetch_array()) :
									$distributor=$conn->query("select pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									$pecah=explode(' ',$x['tgl_generate']);
									$tgl=tanggal_indo($pecah[0]).' '.$pecah[1];
									?>
                                        <tr>
                                            <th scope="row"><?=$no++?></th>
                                            <td><?=$x['kode']?></td>
                                            <td><?=$distributor[0]?></td>
                                            <td><?=angka($x['jumlah_potongan'])?></td>
                                            <td><?=$tgl?></td>
                                            <td><button type="button" class="btn btn-danger btn-sm" onClick="confirm_modal('detail_piutang.php?hapus_voucher&&modal_id=<?=$x['id']; ?>');">Hapus</button></td>
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
                                </div><!--End <div role="tabpanel" class="tab-pane fade" id="belum">-->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Icon Title --> 
            
            
<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Hapus Kode ?</h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal Delete-->
                 
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
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
 	<script src="<?=JS?>pages/ui/modals.js"></script>    
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->

<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
<!--Akhir Javasrip Modal Delete-->  

<script type="application/javascript">
$(function () {
    $('.js-sweetalert button').on('click', function () {
        var type = $(this).data('type');
        if (type === 'prompt') {
            showPromptMessage();
        }
    });
});

function hilang_titik(string) {
            return string.split('.').join('');
        }

function showPromptMessage() {
    swal({
        title: "Generate Kode Voucher",
        text: "Jumlah Potongan:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
		html: true,
        animation: "slide-from-top",
        inputPlaceholder: "Isi Jumlah Potongan (Rp)"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (!/^[0-9.]+$/.test(inputValue) || inputValue === "") {
            swal.showInputError("Hanya numeric yang diijinkan, misal 1000 <br>atau menggunakan titik misal 1.000"); return false
        }
    swal({
        title: "Anda Yakin?",
        text: "Kode Voucher Yang akan digenerate : <?=$generate?>, Jumlah Potongan sebesar Rp. " + tandaPemisahTitik(hilang_titik(inputValue)),
        type: "warning",
        showCancelButton: true,
		html: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yakin!",
        cancelButtonText: "Batal!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
        sweetAlert({
		title: "Kode Voucher Digenerate!",
        timer: 2000,
        showConfirmButton: false,
		type: "success"
		},
		function () {
    	window.location.href = 'detail_piutang.php?kode_voucher=<?=$generate?>&distributor=<?=$_SESSION['distributor']?>&jumlah_potongan=' + inputValue;
		});
        } else {
            swal("Dibatalkan", "Anda telah membatalkan Kode Voucher", "error");
        }
    });
    });
}

</script>

</body>

</html>