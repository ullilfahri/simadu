
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
                                SORTIR BARANG BERDASARKAN NOMOR FAKTUR PENJUALAN
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                            <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_faktur" class="form-control" placeholder="Masukan Nomor Faktur">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-12">
                                            <button type="submit" name="tampil" value="no_faktur" class="btn btn-info waves-effect">
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
            
            
            <!--DateTime Picker -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SORTIR BARANG KELUAR BERDASARKAN WAKTU
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
                                            <button type="submit" name="tampil" value="tanggal_waktu" class="btn btn-info waves-effect">
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


<?php if (isset($_GET['JMJggj'])) : ?>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR BARANG KELUAR HARI INI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>DETAIL</th>
                                            <th>NO FAKTUR</th>
                                            <th>CUSTOMER</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>SATUAN</th>
                                            <th>QTY BELI</th>
                                            <th>QTY AMBIL</th>
                                            <th>SISA QTY</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>GUDANG</th>
                                            <th>KASIR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$gudang=$conn->query("select * from barang_keluar where tanggal like '%".date('Y-m-d')."%' and id_gudang like '%".$_SESSION['gudang']."%' AND distributor like '%".$_SESSION['distributor']."%' OR remark like '%".date('Y-m-d')."%' and id_gudang like '%".$_SESSION['gudang']."%' AND distributor like '%".$_SESSION['distributor']."%' order by remark DESC");
									$no=1;
									while ($x=$gudang->fetch_array()):
									$user=$conn->query("SELECT nama from user where id='".$x['id_kasir']."'")->fetch_array();
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									$lokasi=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$pecah=explode(' ',$x['tanggal']);
									$sisa=$x['jumlah']-$x['is_ambil'];
									$id_pengambilan=$conn->query("select id_pengambilan, pintu_gudang from ambil_barang where id_barang_keluar='".$x['id']."'")->fetch_array();
									if ($x['remark']!='0000-00-00 00:00:00') {
										$remark=explode(' ',$x['remark']);
										$remark=$remark[0].', '.$remark[1].'';
										} else {
										$remark='-';
										}
									$cst=$conn->query("SELECT customer, cus_umum from tabel_faktur where no_faktur = '".$x['no_faktur']."' ")->fetch_array();
									if ($cst[0] > 0) {
									$tetap=$conn->query("SELECT nama FROM tabel_customer where id = '$cst[0]' ")->fetch_array();
									$pelanggan=$tetap[0];
									} else {
									$arr = json_decode($cst[1], true);
									$pelanggan=$arr["umum"]["nama"];
									}
										
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-id="<?=$x['id'];?>" data-target=".edit">DETAIL</button></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$pelanggan?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['satuan']?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=$x['is_ambil']?></td>
                                            <td><?=$sisa?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$lokasi[0]?></td>
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
if ($_GET['tampil'] == 'tanggal_waktu') {
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
$gudang=$conn->query("select * from barang_keluar where tanggal between '".$date."' and '".$date2."' and id_gudang like '%".$_SESSION['gudang']."%' order by tanggal DESC");

$periode='PERIODE '.strtoupper($tgl_awal).' WIB s.d '.strtoupper($tgl_akhir).' WIB';

} else {
$gudang=$conn->query("select * from barang_keluar where no_faktur = '".$_GET['no_faktur']."' and id_gudang like '%".$_SESSION['gudang']."%' AND distributor like '%".$_SESSION['distributor']."%' order by tanggal DESC");
$periode='No. Faktur Penjualan '.$_GET['no_faktur'];
}


?>            
                        
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR BARANG KELUAR
                            </h2>
                            <small><?=$periode?></small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>DETAIL</th>
                                            <th>NO FAKTUR</th>
                                            <th>CUSTOMER</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY BELI</th>
                                            <th>SATUAN</th>
                                            <th>QTY AMBIL</th>
                                            <th>SISA QTY</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>GUDANG</th>
                                            <th>KASIR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									
									$no=1;
									while ($x=$gudang->fetch_array()):
									$user=$conn->query("SELECT nama from user where id='".$x['id_kasir']."'")->fetch_array();
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									$lokasi=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$pecah=explode(' ',$x['tanggal']);
									$sisa=$x['jumlah']-$x['is_ambil'];
									$id_pengambilan=$conn->query("select id_pengambilan from ambil_barang where id_barang_keluar='".$x['id']."'")->fetch_array();
									if ($x['remark']!='0000-00-00 00:00:00') {
										$remark=explode(' ',$x['remark']);
										$remark=$remark[0].', '.$remark[1].'';
										} else {
										$remark='-';
										}
									$cst=$conn->query("SELECT customer, cus_umum from tabel_faktur where no_faktur = '".$x['no_faktur']."' ")->fetch_array();
									if ($cst[0] > 0) {
									$tetap=$conn->query("SELECT nama FROM tabel_customer where id = '$cst[0]' ")->fetch_array();
									$pelanggan=$tetap[0];
									} else {
									$arr = json_decode($cst[1], true);
									$pelanggan=$arr["umum"]["nama"];
									}
										
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-id="<?=$x['id'];?>" data-target=".edit">DETAIL</button></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$pelanggan?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=$x['satuan']?></td>
                                            <td><?=$x['is_ambil']?></td>
                                            <td><?=$sisa?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$lokasi[0]?></td>
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
                          <h4 class="modal-title" id="myModalLabel">RINCIAN DAFTAR PENGAMBILAN</h4>
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
                url : 'form_crud.php?detail_transaksi',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
    

<script type="application/javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 6 || column === 7 || column === 8 ?
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
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: false, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 2, 3, 4, 5, 6, 7,8, 9, 10, 11, 12 ] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});

</script>            


</body>

</html>