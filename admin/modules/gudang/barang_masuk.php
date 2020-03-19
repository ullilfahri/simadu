
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']==3 || $_SESSION['level']==5 ) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Transaksi</a></li>
			</ol>


            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SORTIR BARANG MASUK BERDASARKAN WAKTU
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tgl_1" class="datetimepicker form-control" placeholder="Tanggal dsn Waktu Awal">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tgl_2" class="datetimepicker form-control" placeholder="Tanggal dan Waktu Akhir">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                            <button type="submit" name="tampil" class="btn btn-info waves-effect">
                                    		<i class="fa fa-search"></i>
                                			Tampilkan</button>
                                </div>
                                
                             </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--#END# DateTime Picker -->



<?php if (isset($_GET['KHhdhydv'])) : ?>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR BARANG MASUK HARI INI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>TANGGAL INVOICE</th>
                                            <th>NO FAKTUR PEMBELIAN</th>
                                            <th>SUPPLIER</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY BELI</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>GUDANG</th>
                                            <th>PINTU/RAK/RUANG</th>
                                            <th>USER APPROV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$gudang=$conn->query("select * from barang_masuk where tanggal like '%".date('Y-m-d')."%' and id_gudang like '%".$_SESSION['gudang']."%' AND distributor like '%".$_SESSION['distributor']."%' order by tanggal DESC");
									$no=1;
									while ($x=$gudang->fetch_array()):
									$user=$conn->query("SELECT nama from user where id='".$x['id_user']."'")->fetch_array();
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									$lokasi=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$pecah=explode(' ',$x['tanggal']);
									$supplier=$conn->query("SELECT nama from tabel_supplier where id = '".$x['supplier']."' ")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah'].' '.$x['satuan']?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$lokasi[0]?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$user[0]?></td>
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

<?php endif;

if (isset($_GET['tampil'])) :
$date = date_create_from_format('l d F Y - H:i', $_GET['tgl_1']);
$date=date_format($date, 'Y-m-d H:i:s');
//$date=strtotime($date);

$tgl_awal = date_create_from_format('l d F Y - H:i', $_GET['tgl_1']);
$tgl_awal2 = date_create_from_format('l d F Y - H:i', $_GET['tgl_1']);
$tgl_awal = date_format($tgl_awal, 'Y-m-d');
$tgl_awal=tanggal_indo($tgl_awal).', '.date_format($tgl_awal2, 'H:i');

$date2 = date_create_from_format('l d F Y - H:i', $_GET['tgl_2']);
$date2=date_format($date2, 'Y-m-d H:i:s');
//$date2=strtotime($date2);

$tgl_akhir = date_create_from_format('l d F Y - H:i', $_GET['tgl_2']);
$tgl_akhir2 = date_create_from_format('l d F Y - H:i', $_GET['tgl_2']);
$tgl_akhir = date_format($tgl_akhir, 'Y-m-d');
$tgl_akhir=tanggal_indo($tgl_akhir).', '.date_format($tgl_akhir2, 'H:i');


?>            
                        
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR BARANG MASUK
                            </h2>
                            <small>PERIODE <?=strtoupper($tgl_awal)?> WIB s.d <?=strtoupper($tgl_akhir)?> WIB</small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>TANGGAL INVOICE</th>
                                            <th>NO FAKTUR PEMBELIAN</th>
                                            <th>SUPPLIER</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY BELI</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>GUDANG</th>
                                            <th>PINTU/RAK/RUANG</th>
                                            <th>USER APPROV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$gudang=$conn->query("select * from barang_masuk where tanggal between '".$date."' and '".$date2."' and id_gudang like '%".$_SESSION['gudang']."%' AND distributor like '%".$_SESSION['distributor']."%' order by tanggal DESC");
									$no=1;
									while ($x=$gudang->fetch_array()):
									$user=$conn->query("SELECT nama from user where id='".$x['id_user']."'")->fetch_array();
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									$lokasi=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$pecah=explode(' ',$x['tanggal']);
									$supplier=$conn->query("SELECT nama from tabel_supplier where id = '".$x['supplier']."' ")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah'].' '.$x['satuan']?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$lokasi[0]?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$user[0]?></td>
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