
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']>3) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
	
if ($_SESSION['level']==1) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-edit fa-lg"></i> Stok</a></li>
			</ol>  
<?php
if ($_SESSION['level']==3) {
$piutang=$conn->query("SELECT a.*, b.* FROM tabel_faktur AS a LEFT JOIN tabel_bayar AS b ON a.no_faktur=b.no_faktur WHERE a.metode_bayar = 1 AND b.jumlah_transaksi-b.jumlah_bayar > 0 AND a.jatuh_tempo = '".date('Y-m-d')."' AND a.id_toko = '".$_SESSION['toko']."' GROUP BY b.distributor,b.no_faktur ");
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PIUTANG JATUH TEMPO HARI INI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="data-table-example4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Terbayar</th>
                                            <th class="with-input">
                            					<select class="form-control show-tick" data-live-search="true">
                            					<option value="">--Status--</option>
                            					<option value=" Lunas">Lunas</option>
                            					<option value=" Entry ">Belum Lunas</option>
                            					</select>
                            				</th>
                                            <th class="with-input">
                            					<select class="form-control show-tick" data-live-search="true">
                            					<option value="">--PILIH CUSTOMER--</option>
                                                <?php
                                                $cust_sql=$conn->query(" SELECT a.customer, b.nama FROM tabel_bayar as a LEFT JOIN tabel_customer as b ON a.customer = b.id WHERE a.metode_bayar = 1  GROUP BY a.customer ORDER BY b.nama ASC");
												while ($y=$cust_sql->fetch_array()) :
												?>
                            					<option value="<?=$y[1]?>"><?=$y[1]?></option>
                                                <?php endwhile;?>
                            					</select>
                            				</th>
                                            <th>No faktur</th>
                                            <th class="with-input">
                            					<select class="form-control show-tick" data-live-search="true">
                            					<option value="">--Sortir Distrbutor--</option>
                                                <?php
                                                $dis_sql=$conn->query(" SELECT kode, pengguna FROM mst_hak_akses WHERE kode !='' ORDER BY pengguna ASC");
												while ($z=$dis_sql->fetch_array()) :
												?>
                            					<option value="<?=$z[0]?>"><?=$z[1]?></option>
                                                <?php endwhile;?>
                            					</select>
                            				</th>
                                            <th class="with-input">
                            					<select class="form-control show-tick" data-live-search="true">
                            					<option value="">--Sortir Tanggal Jatuh Tempo--</option>
                                                <?php
                                                $jth=$conn->query(" SELECT jatuh_tempo FROM tabel_faktur WHERE jatuh_tempo <= '".date('Y-m-d')."' AND no_faktur IN (SELECT no_faktur from tabel_bayar where metode_bayar='1' AND id_toko = '".$_SESSION['toko']."' AND jumlah_transaksi-jumlah_bayar > 0 ) GROUP BY jatuh_tempo ASC");
												while ($j=$jth->fetch_array()) :
												?>
                            					<option value="<?=tanggal_indo($j[0])?>"><?=tanggal_indo($j[0])?></option>
                                                <?php endwhile;?>
                            					</select>
                            				</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Transaksi</th>
                                            <th>Sisa Piutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$piutang->fetch_array()) :
									$customer=$conn->query("select * from tabel_customer where id='".$x['customer']."'")->fetch_array();
									$dis=$conn->query("select *, SUM(jumlah_bayar) from bayar_hutang where id_hutang = '".$x['id']."' GROUP BY via_bayar DESC");
									ob_start();
									echo '<li role="separator" class="divider"></li>';
									while ($y=$dis->fetch_array()) :								
									echo '<li><a href="javascript:void(0);" data-toggle="modal" data-target=".modal_bayar"  data-id="'.$y['id_hutang'].'#'.$y['via_bayar'].'">'.$y['via_bayar'].' : Rp. '.angka($y[8]).'</a></li>';
									echo '<li role="separator" class="divider"></li>';
									endwhile;
									$trx=ob_get_contents();
									ob_end_clean();
									
										if ($x['jumlah_transaksi']-$x['jumlah_bayar'] > 0) {
										$tombol='<button type="button" class="btn btn-warning btn-sm waves-effect" data-toggle="modal" data-target=".bayar_hutang" data-id="'.$x['no_faktur'].'#'.$x['distributor'].'"><i class="fa fa-money"></i> Entry </button>';
										} else {
										$tombol='<button type="button" class="btn btn-success btn-sm waves-effect" onclick="lunas()"><i class="fa fa-money"></i> Lunas</button>';
										}
										
									$jatuh_tempo=$conn->query("select jatuh_tempo from tabel_faktur where no_faktur='$x[no_faktur]'")->fetch_array();


									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                            <div class="btn-group">
                                            <button type="button" class="btn bg-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Rp. <?=angka($x['jumlah_bayar'])?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <?=$trx?>
                                            </ul>
                                            </div>
                                            </td>
                                            <td><?=$tombol?></td>
                                            <td><?=$customer['nama']?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$x['distributor']?></td>
                                            <td><?=tanggal_indo($jatuh_tempo[0])?></td>
                                            <td><?=date("d-m-Y",$x['no_faktur'])?></td>
                                            <td><?=angka($x['jumlah_transaksi'])?></td>
                                            <td><?=angka($x['jumlah_transaksi']-$x['jumlah_bayar'])?></td>
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
            

            <!-- Advanced Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PENCARIAN TRANSAKSI PIUTANG
                            </h2>
                        </div>
                        <div class="body">
                        
                        	<form name="form_tanggal" style="display:block">
                                <div class="row clearfix">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">Kriteria Pencarian</h2>
                                        <input name="kriteria_sortir" type="radio" id="radio_1" value="1" onclick="check(this.value)" class="radio-col-indigo" />
                                		<label for="radio_1">Berdasarkan Customer</label>
                                        <br>
                                    	<input name="kriteria_sortir" type="radio" id="radio_2" value="0" onclick="check(this.value)" class="radio-col-indigo"/>
                                		<label for="radio_2">Tanggal Jatuh Tempo</label>
                                    </div>    
                                </div>
                             </form>   
                        
                        	<form name="form_awal">
                            <input type="hidden" id="kategori" name="kategori">   
                            <input type="hidden" id="id_toko" name="id_toko" value="<?=$_SESSION['toko']?>">   
                                <div class="row clearfix" id="sortir_tanggal" style="display:none"> 
                                	<div class="col-md-12">
                                		<div class="col-sm-6">
                                		<b>Tanggal Awal</b>
                                    		<div class="form-group">
                                        		<div class="form-line">
                                            	<input type="text" name="awal" id="awal" class="tanggal_picker form-control" placeholder="Masukan Tanggal Awal" required>
                                        		</div>
                                    		</div>
                                		</div>
                                		<div class="col-sm-6">
                                		<b>Tanggal Akhir</b>
                                    		<div class="form-group">
                                        		<div class="form-line">
                                            	<input type="text" name="akhir" id="akhir" class="tanggal_picker form-control" placeholder="Masukan Tanggal Akhir" required>
                                        		</div>
                                    		</div>
                                		</div>
                                    </div>    
                                </div>

                                <div class="row clearfix" id="sortir_customer" style="display:none">
                                	<div class="col-md-12">
                                		<h2 class="card-inside-title">CUSTOMER</h2>
                                        <select name="customer" id="customer" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0">--PILIH CUSTOMER--</option>
                                        <option value="%%">SEMUA CUSTOMER</option>
                                        <?php 
										$customer=$conn->query("SELECT * FROM tabel_customer WHERE id IN (SELECT customer FROM tabel_faktur WHERE id_toko='".$_SESSION['toko']."' AND metode_bayar=1) GROUP BY nama ASC");
										while ($y=$customer->fetch_array()) :
										?>
                                        <option value="<?=$y['id']?>"><?=$y['nama']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>    
                                </div>
                            
								<button type="button" onclick="tampil_data();" class="btn btn-primary m-t-15 waves-effect">
								<i class="fa fa-file-o fa-1.5x"></i>
								<span>Tampilkan Data</span>
								</button>

                             </form> 
                         </div>      
                   </div> 
				</div>
			</div>
            <!-- #END# Advanced Select -->
            <!-- #Starr# paginasit -->
            <div class="paginasi_piutang"></div>
            <!-- #END# paginasit -->
            

<?php
} else {
$piutang=$conn->query("SELECT a.*, b.* FROM tabel_faktur AS a LEFT JOIN tabel_bayar AS b ON a.no_faktur=b.no_faktur WHERE a.metode_bayar = 1 AND b.jumlah_transaksi-b.jumlah_bayar > 0 AND a.jatuh_tempo <= '".date('Y-m-d')."' AND b.distributor = '".$_SESSION['distributor']."' ");
?>            

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PIUTANG
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Terbayar</th>
                                            <th>Entry Pembayaran</th>
                                            <th>Customer</th>
                                            <th>No faktur</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Transaksi</th>
                                            <th>Sisa Piutang</th>
                                            <th>Jatuh Tempo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$piutang->fetch_array()) :
									$customer=$conn->query("select * from tabel_customer where id='".$x['customer']."'")->fetch_array();
									$dis=$conn->query("select *, SUM(jumlah_bayar) from bayar_hutang where id_hutang = '".$x['id']."' GROUP BY via_bayar DESC");
									ob_start();
									echo '<li role="separator" class="divider"></li>';
									while ($y=$dis->fetch_array()) :								
									echo '<li><a href="javascript:void(0);" data-toggle="modal" data-target=".modal_bayar"  data-id="'.$y['id_hutang'].'#'.$y['via_bayar'].'">'.$y['via_bayar'].' : Rp. '.angka($y[8]).'</a></li>';
									echo '<li role="separator" class="divider"></li>';
									endwhile;
									$trx=ob_get_contents();
									ob_end_clean();
									
										if ($x['jumlah_transaksi']-$x['jumlah_bayar'] > 0) {
										$tombol='<button type="button" class="btn btn-warning btn-sm waves-effect" data-toggle="modal" data-target=".bayar_hutang" data-id="'.$x['no_faktur'].'#'.$_SESSION['distributor'].'"><i class="fa fa-money"></i> Entry </button>';
										} else {
										$tombol='<button type="button" class="btn btn-success btn-sm waves-effect" onclick="lunas()"><i class="fa fa-money"></i> Lunas</button>';
										}
										
										
									$jatuh_tempo=$conn->query("select jatuh_tempo from tabel_faktur where no_faktur='$x[no_faktur]'")->fetch_array();

									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                            <div class="btn-group">
                                            <button type="button" class="btn bg-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Rp. <?=angka($x['jumlah_bayar'])?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <?=$trx?>
                                            </ul>
                                            </div>
                                            </td>
                                            <td><?=$tombol?></td>
                                            <td><?=$customer['nama']?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=date("d-m-Y",$x['no_faktur'])?></td>
                                            <td><?=angka($x['jumlah_transaksi'])?></td>
                                            <td><?=angka($x['jumlah_transaksi']-$x['jumlah_bayar'])?></td>
                                            <td><?=tanggal_indo($jatuh_tempo[0])?></td>
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
<?php }?>

            
            <!-- Large Size -->
            <div class="modal fade rincian" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Piutang</h4>
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
            <div class="modal fade bayar_hutang" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Pembayaran Hutang</h4>
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
            <!-- Large Size -->
            <div class="modal fade modal_bayar" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Piutang</h4>
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
    
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    <!-- Light Gallery Plugin Js -->
    <script src="<?=PLG?>light-gallery/js/lightgallery-all.js"></script>
    
    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


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
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rincian').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail.php?rincian_bayar',
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
        $('.bayar_hutang').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail_piutang.php?entry_bayar',
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
        $('.modal_bayar').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail.php?modal_bayar',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data3').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.dis_hutang').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail_piutang.php?entry_bayar',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data4').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<script>
function lunas() {
  swal("Lunas!", "Piutang Lunas..!", "success");
}
</script>

<script language="javascript">
$(function () {
     var table = $('#data-table-example4').DataTable({
                dom: 'Bfrtip',
				responsive: true,
				buttons: ['copy', 'csv', 'excel']
            });
            // Apply the search
            $("#data-table-example4 thead th input[type=text]").on( 'keyup change', function () {
	    	
	        table
	            .column( $(this).closest('th').index()+':visible' )
	            .search( this.value )
	            .draw();
	            
	    });
            // Apply the search
            $("#data-table-example4 thead th select").on('change', function () {
	    	
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

	        table
	            .column( $(this).closest('th').index()+':visible' )
	            .search( val ? '^'+val+'$' : '', true, false )
	            .draw();
	            
	    } );
});
</script>

<script type="application/javascript">
$(function () {
    //Datetimepicker plugin
    $('.tanggal_picker').bootstrapMaterialDatePicker({
        format: 'DD-MM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

});
</script>

<script>
function check(kriteria_sortir) {
kriteria_sortir = document.form_tanggal.kriteria_sortir.value;
var sortir_tanggal = document.getElementById("sortir_tanggal");
  if (kriteria_sortir==1) {
  	sortir_tanggal.style.display = "none";
  	sortir_customer.style.display = "block";
	document.form_awal.kategori.value='customer';
	} else {
  	sortir_tanggal.style.display = "block";
  	sortir_customer.style.display = "none";
	document.form_awal.kategori.value='tanggal';
	}
}

</script> 


<script>
function tampil_data() {
id_toko = document.form_awal.id_toko.value;
awal = document.form_awal.awal.value;
akhir = document.form_awal.akhir.value;
kategori = document.form_awal.kategori.value;
customer = document.form_awal.customer.value;
if (kategori == '') {
	swal("Perhatian!", "Harap Isi Kriteria Sortir", "error");
	} else if (kategori == 'tanggal' && awal =='' ) {
	swal("Perhatian!", 'Harap Isi Field Tanggal Awal', "error");
	} else if (kategori == 'tanggal' && akhir =='' ) {
	swal("Perhatian!", 'Harap Isi Field Tanggal Akhir', "error");
	} else if (kategori == 'customer' && customer =='0' ) {
	swal("Perhatian!", 'Harap Isi Field customer', "error");
	} else {
	$('.paginasi_piutang').load('paginasi_piutang.php?tampil_data&id_toko='+id_toko+'&awal='+awal+'&akhir='+akhir+'&kategori='+kategori+'&customer='+customer);
	}
}
</script>  



</body>

</html>