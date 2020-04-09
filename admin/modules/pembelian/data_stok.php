
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']!=2) :
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
$stok=$conn->query("select * from stok_barang where distributor like '%".$_SESSION['distributor']."%'");

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-edit fa-lg"></i> Stok</a></li>
			</ol>  
            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA STOK
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="mainTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Uraian Barang</th>
                                            <th>Harga Pokok Penjualan</th>
                                            <th>Jumlah Stok</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$stok->fetch_array()) :
									?>
                                        <tr>
                                            <th scope="row"><?=$no++?></th>
                                            <th scope="row"><?=$x['kode_barang']?></th>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'nama_barang','<?=$x['id']?>')" onClick="showEdit(this);"><?=$x['nama_barang']?></td>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'harga_barang','<?=$x['id']?>')" onClick="showEdit(this);"><?=angka($x['harga_barang'])?></td>
                                            <th scope="row"><?=$x['sisa_stok']?></th>
                                            <td><div class="btn-group" role="group">
                                        		<button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	Rincian
                                            	<span class="caret"></span>
                                        		</button>
                                        			<ul class="dropdown-menu">
                                            			<li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal" data-id="<?=$x['kode_barang'];?>">Pembelian</a></li>
                                            			<li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal2" data-id="<?=$x['kode_barang'];?>">Penjualan</a></li>
                                                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal3" data-id="<?=$x['kode_barang'];?>">Alokasi Stok</a></li>
                                        			</ul>
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
            <!-- Large Size -->
            <div class="modal fade rincian" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Pembelian</h4>
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
            <!-- Large Size -->
            <div class="modal fade rincian2" id="largeModal2" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Penjualan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data2"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            <div class="modal fade rincian3" id="largeModal3" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Alokasi Stok</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data3"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
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
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
function saveToDatabase(editableObj,column,id) {
	$(editableObj).css("background","#FFF url(img/loader.gif) no-repeat right");
	$.ajax({
		url: "form_crud.php?live_edit",
		type: "POST",
		data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
		success: function(data){
			$(editableObj).css("background","#FDFDFD");
		}        
   });
}
</script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rincian').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail.php?detail_pembelian',
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
        $('.rincian2').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail.php?detail_penjualan',
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
        $('.rincian3').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail.php?alokasi_stok',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data3').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->


</body>

</html>