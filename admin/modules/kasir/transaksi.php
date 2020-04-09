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
	} else if (isset($_GET['sukses_upload'])){
	$awal=$_GET['no_faktur'];
	$akhir=$_GET['no_faktur'];
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
	
$trx=$conn->query("SELECT * FROM tabel_faktur where id_toko LIKE '%".$_SESSION['toko']."%' AND no_faktur between $awal and $akhir AND total_trx > '0' ORDER by no_faktur DESC");
$total=$conn->query("SELECT SUM(total_trx) FROM tabel_faktur where id_toko LIKE '%".$_SESSION['toko']."%' AND no_faktur between $awal and $akhir")->fetch_array();
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
                                <b>Nomor faktur</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_faktur" class="form-control" placeholder="Masukan Nomor Faktur" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
								<button type="submit" name="sukses_upload" class="btn bg-blue waves-effect"><i class="fa fa-folder-open fa-sm"></i><span>Cari</span></button>
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
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NOMOR FAKTUR</th>
                                            <th>TANGGAL TRANSAKSI</th>
                                            <th>TOTAL</th>
                                            <th>CUSTOMER</th>
                                            <th>KASIR</th>
                                            <th>RINCIAN</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th colspan="5"><?=angka($total[0])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									if ($x['customer'] > 0) {
									$customer=$conn->query("SELECT * from tabel_customer where id='".$x['customer']."'")->fetch_array();
									$pelanggan=$customer['nama'];
									} else {
									$arr = json_decode($x['cus_umum'], true);
									$pelanggan='UMUM ('.$arr["umum"]["nama"].')'; 
									}
									$ada_file=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/bukti_ambil/nota_ambil-".$x['no_faktur'].'.pdf';
									if ($_SESSION['level']==6 && file_exists($ada_file) || $_SESSION['sub_level']==4 && file_exists($ada_file) ) {
									$tbl_nota='<a href="../pdf_viewer/index.php?dir=bukti_ambil&file=nota_ambil-'.$x['no_faktur'].'.pdf" target="_blank"><button type="button" class="btn bg-orange waves-effect"><span class="fa fa-tags fa-lg"></span></button></a>';
									} else {
									$tbl_nota='';
									}
									$kasir=$conn->query("SELECT nama from user where id='".$x['kasir']."'")->fetch_array();
									
									$batal_sql=$conn->query("SELECT SUM(is_ambil) FROM barang_keluar WHERE no_faktur='".$x['no_faktur']."'")->fetch_array();
									if ($batal_sql[0]==0) {
										$txt="'".$x['no_faktur']."', '".$pelanggan."', '".$x['total_trx']."'";
										$tombol_batal='
										<button type="button" class="btn btn-danger waves-effect" onclick="batal('.$txt.')"><span class="fa fa-trash fa-lg"></span></button> 
										';
										} else {
										$tombol_batal='';
										}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=date("d-m-Y", $x['no_faktur'])?></td>
                                            <td><?=angka($x['total_trx'])?></td>
                                            <td><?=$pelanggan?></td>
                                            <td><?=$kasir[0]?></td>
                                            <td>
												<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                 <div class="btn-group" role="group" aria-label="First group">
                                    				<a><button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target=".edit" data-id="<?php echo $x['no_faktur'];?>"><span class="fa fa-file fa-lg"></span></button></a>
                                                 </div>
                                                 <div class="btn-group" role="group" aria-label="Second group">    
                                                    <a href="../pdf_viewer/index.php?dir=no_faktur&file=<?=$x['no_faktur']?>.pdf" target="_blank">
                                                    <button type="button" class="btn bg-cyan waves-effect">
                                        			<span class="fa fa-print fa-lg"></span>
                                                    </button>
                                                    </a>
                                                 </div>
                                                 <div class="btn-group" role="group" aria-label="Third group">   
                                                    <?=$tombol_batal?>
                                                 </div>   
                                                 <div class="btn-group" role="group" aria-label="Fourth group">   
                                                    <?=$tbl_nota?>
                                                 </div>   
                                              </div>                                              
                                			</td>
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
                url : 'form_crud.php?rincian_summary_transaksi',
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
function batal(no_faktur, customer, total_trx) {
    swal({
		html: true,
		title: "Penghapusan Transaksi",
        text: "Penghapusan Transaksi No Faktur "+no_faktur+"<br>Keterangan Penghapusan harus diisi",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        inputPlaceholder: "Isi Keterangan Penghapusan",
        animation: "slide-from-top"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === '') {
            swal.showInputError("Silahkan Isi Terlebih Dahulu Keterangan Penghapusan"); return false
        }
    swal({
        title: "Anda Yakin?",
        text: "Tekan OK untuk Penghapusan No Faktur "+no_faktur+"<br>Keterangan : "+inputValue,
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
		//begin isConfirm
        $.ajax({ /*Begin  $.ajax({ */
		url	     : 'form_crud.php?pembatalan_transaksi',
		type     : 'POST',
		dataType : 'html',
		data     : 'no_faktur='+no_faktur+'&customer='+customer+'&keterangan='+inputValue+'&total_trx='+total_trx,
		success  : function(result){ /*Begin success  : function(result){ */
			var response = JSON.parse(result);
			if (response.status){ /*Begin if (response.status){ */
			swal({title: "Pembatalan No Faktur "+response.pesan+" Berhasil..!", text: "Laman Akan dialihkan dalam 2 detik", type: "success", timer: 2000, showConfirmButton: false}
			,function(){window.location.href = 'summary_pembatalan.php?no_faktur='+no_faktur+'&sukses_upload'; });
			} /*End if (response.status){ */
		}, /*End success  : function(result){ */
		}) /*End  $.ajax({ */
		//end isConfirm
        } else {
            swal("Dibatalkan", "Penghapusan Atas Transaksi No Faktur "+no_faktur+" Telah Dibatalkan", "warning");
        }
    });
    });
}
</script>

<script type="application/javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 3  ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.apa').DataTable({
        dom: 'Bfrtip',
		searching: true,
        responsive: true,
		info:     true,
        buttons: [
            { extend: 'copyHtml5', footer: true, text: '<i class="fa fa-copy"></i> Copy', title: $('h1').text() },
			//{ extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel' },
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: false, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5 ] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});

</script>            
   


</body>

</html>