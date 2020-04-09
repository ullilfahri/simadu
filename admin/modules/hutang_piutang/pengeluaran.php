<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>

<?php
include DOT.'partial/header_index.php';
include MDL.'login/session.php';

if ($_SESSION['level'] == 4 || $_SESSION['level'] == 5) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
	
if ($_SESSION['level']==3 && $_SESSION['sub_level']==3) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-money fa-lg"></i> Pengeluaran</a></li>
			</ol>  
            
            <!-- Font Sizes -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Pilihan
                            </h2>
                        </div>
                        <div class="body">
                                <a href="<?=$_SERVER['PHP_SELF']?>?faktual"><button type="button" class="btn bg-green waves-effect">Tampilkan Semua Data Pengeluaran</button></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="<?=$_SERVER['PHP_SELF']?>?entry_pengeluaran">
                                <button type="button" class="btn bg-light-blue waves-effect" <?php if ($_SESSION['level'] ==1 || $_SESSION['level'] ==6) : echo 'disabled'; endif;?>>Entry Pengeluaran
                                </button></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Font Sizes -->
             
<?php
if (isset($_GET['main'])) :

	if ($_SESSION['level']==2) {
		$tunai=$conn->query("select * from konfirmasi_tunai where distributor = '".$_SESSION['distributor']."' AND jenis=2 AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' ORDER BY tgl_approve DESC");
		$bank=$conn->query("select * from konfirmasi_bank where distributor = '".$_SESSION['distributor']."' AND jenis=2 AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' ORDER BY tgl_approve DESC");
		} else if ($_SESSION['level']==3) {
		$tunai=$conn->query("select * from konfirmasi_tunai where id_toko = '".$_SESSION['toko']."' AND jenis=2 AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' ORDER BY tgl_approve DESC");
		$bank=$conn->query("select * from konfirmasi_bank where id_toko = '".$_SESSION['toko']."' AND jenis=2 AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' ORDER BY tgl_approve DESC");
		} else {
		$tunai=$conn->query("select * from konfirmasi_tunai where jenis=2 AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' ORDER BY tgl_approve DESC");
		$bank=$conn->query("select * from konfirmasi_bank where jenis=2 AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' ORDER BY tgl_approve DESC");
	}

?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PENGELUARAN HARI INI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Approve</th>
                                            <th>Jumlah</th>
                                            <th>Item Pengeluaran</th>
                                            <th>Status Kas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nt=1;
									while ($x=$tunai->fetch_array()) :
									?>
                                        <tr>
                                            <td><?=$nt?></td>
                                            <td><?=date_format(date_create_from_format('Y-m-d H:i:s', $x['tgl_approve']), 'd-m-Y')?></td>
                                            <td><?=angka($x['jumlah_bayar'])?></td>
                                            <td><?=ucwords(strtolower($x['keterangan']))?></td>
                                            <td>Cash In Hand</td>
                                        </tr>
                                    <?php $nt++; endwhile;?>    
                                    <?php
                                    $nb=$nt+0;
									while ($y=$bank->fetch_array()) :
									$data_bank=$conn->query("SELECT bank, no_rek FROM rekening_bank where id= '".$y['id_bank']."' ")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$nb?></td>
                                            <td><?=date_format(date_create_from_format('Y-m-d H:i:s', $y['tgl_approve']), 'd-m-Y')?></td>
                                            <td><?=angka($y['jumlah_bayar'])?></td>
                                            <td><?=ucwords(strtolower($y['keterangan']))?></td>
                                            <td><?=$data_bank[0]?>, No Rek. <?=$data_bank[1]?></td>
                                        </tr>
                                    <?php $nb++; endwhile;?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
<?php endif; ?>

<?php if (isset($_GET['faktual'])) : 

if ($_SESSION['level']==2) {
	$data_paginasi='distributor.'.$_SESSION['distributor'];
	} else if ($_SESSION['level']==3){
	$data_paginasi='kasir.'.$_SESSION['toko'];
	} else {
	$data_paginasi='admin#';
	}

?>
            <!-- Font Sizes -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               PILIH KRITERIA SORTIR
                            </h2>
                        </div>
                        
                        <div class="body">
                            <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
                            <input type="hidden" name="data_paginasi" value="<?=$data_paginasi?>" />
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
												<input name="tabel" type="radio" id="radio_1" onchange="radio_tunai()" value="konfirmasi_tunai" checked/>
                                					<label for="radio_1">Cash In Hand</label>
                                				<input name="tabel" type="radio" id="radio_2"  onchange="radio_tunai()" value="konfirmasi_bank"/>
                                					<label for="radio_2">Cash On Bank</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

							<div id="form_tunai" style="visibility:visible"><!--<div id="form_tunai" style="visibility:visible">-->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" name="tampil" class="btn btn-primary btn-lg m-l-15 waves-effect">Tampilkan Semua Pengeluaran</button>
                                    </div>
                                </div> 
                                <h3 class="align-center">ATAU</h3><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <p><b>Tanggal dan Waktu Awal</b></p>
                                            <div class="form-line">
                                                <input name="awal" type="text" class="datepicker form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <p><b>Tanggal dan Waktu Akhir</b></p>
                                            <div class="form-line">
                                                <input name="akhir" type="text" class="datepicker form-control">
                                            </div>
                                        </div>
                                    </div>  
                                        <button type="submit" name="tampil" class="btn btn-primary btn-lg m-l-15 waves-effect">Tampilkan Berdasarkan Range Tanggal</button>
                                </div> 
                            </div><!-- #END <div id="form_tunai" style="visibility:visible">-->  

							<div id="form_bank" style="visibility:hidden">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" name="tampil" class="btn btn-primary btn-lg m-l-15 waves-effect">Tampilkan Semua Pengeluaran</button>
                                    </div>
                                </div> 
                                <h3 class="align-center">ATAU</h3><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <p><b>Tanggal dan Waktu Awal</b></p>
                                            <div class="form-line">
                                                <input name="awal" type="text" class="datepicker form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <p><b>Tanggal dan Waktu Akhir</b></p>
                                            <div class="form-line">
                                                <input name="akhir" type="text" class="datepicker form-control">
                                            </div>
                                        </div>
                                    </div>  
                                        <button type="submit" name="tampil" class="btn btn-primary btn-lg m-l-15 waves-effect">Tampilkan Berdasarkan Range Tanggal</button>
                                </div> 
                                
                            </div>                                 

                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- #END# Font Sizes -->

<?php endif; ?>


<?php if (isset($_POST['tampil'])) :
$data_paginasi=$_POST['data_paginasi'];
$tabel=$_POST['tabel'];
if (!empty($_POST['awal']) && !empty($_POST['akhir'])) {
$awal=date_format(date_create_from_format('l d F Y', $_POST['awal']), 'Y-m-d');
$akhir=date_format(date_create_from_format('l d F Y', $_POST['akhir']), 'Y-m-d');
} else {
$awal='';
$akhir='';
}

?>            
            
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               DATA PENGELUARAN <?=$_POST['awal']?> 
                            </h2>
                        </div>
                        <div class="body">

							<div class="embed-responsive embed-responsive-16by9">
								<iframe class="embed-responsive-item" src="paginasi_pengeluaran.php?data_paginasi=<?=$data_paginasi?>&tabel=<?=$tabel?>&awal=<?=$awal?>&akhir=<?=$akhir?>">
                                </iframe>
							</div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
<?php endif; ?>      

<?php if (isset($_GET['entry_pengeluaran'])) :
?>

            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY DATA PENGELUARAN
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="form_crud.php">
                            <input type="hidden" name="jenis" value="2" />
                            <input type="hidden" name="user_approve" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" name="id_toko" value="<?=$_SESSION['toko']?>" />
                            <input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>" />
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select class="form-control show-tick" id="tabel" name="tabel" onchange="open_bank()" required>
                                        <option value="">--PILIH SUMBER KAS--</option>
                                        <option value="konfirmasi_tunai">Cash In Hand</option>
                                        <option value="konfirmasi_bank">Cash On Bank</option>
                                    </select>
                                    </div>
                                </div>
                                
							<div id="field_bank" style="display:none">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="id_bank" name="id_bank" data-show-subtext="true">
                                        <option value="">--PILIH REKENING BANK--</option>
                           <?php
						   if ($_SESSION['level']==2) {
						   $id_bank=$conn->query("select id, no_rek, bank, id_toko, distributor from rekening_bank WHERE distributor = '".$_SESSION['distributor']."' AND is_aktif=1");
						   } else {
						   $id_bank=$conn->query("select id, no_rek, bank, id_toko, distributor from rekening_bank WHERE id_toko = '".$_SESSION['toko']."' is_aktif=1");
						   }
						   while ($data=$id_bank->fetch_array()) : 
						   $dis=$conn->query("select pengguna from mst_hak_akses where kode = '".$data[4]."'")->fetch_array();
						   $toko=$conn->query("select nama from lokasi where id_lokasi = '".$data[3]."'")->fetch_array();
						   if ($data[3] > 0) {
						   	   $stts='Rekening Untuk Transaksi Penjualan '.$toko[0].'  distributor '.$dis[0];
							   } else {
							   $stts='Rekening Untuk Transaksi Pembelian etc';
							   }
							?>
                                        <option value="<?=$data[0]?>" data-subtext="No Rek <?=$data[1]?>, <?=$stts?>"><?=$data[2]?></option>
						   <?php endwhile; ?>
                                    	</select>
                                    </div>
                                </div>
                       		</div> 
                            
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="jumlah_bayar"  name="jumlah_bayar" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                        <label class="form-label">Jumlah Pengeluaran (Rp)</label>
                                    </div>
                                </div>

                            
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="3" class="form-control no-resize auto-growth" name="keterangan" id="keterangan" required></textarea>
                                        <label class="form-label">Keterangan Pengeluaran</label>
                                    </div>
                                </div>

                                <button type="submit" name="tambah_pengeluaran" class="btn btn-primary m-t-15 waves-effect">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->
            
<?php endif;?> 
            
<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Hapus Customer ?</h4>
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
    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="<?=PLG?>bootstrap-tagsinput/bootstrap-tagsinput.js"></script>    
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
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
function saveToDatabase(editableObj,column,id) {
	$(editableObj).css("background","#FFF url(../stok/img/loader.gif) no-repeat right");
	$.ajax({
		url: "form_crud_supplier.php?live_edit=tabel_customer",
		type: "POST",
		data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
		success: function(data){
			$(editableObj).css("background","#FDFDFD");
		}        
   });
}
</script>

<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
<!--Akhir Javasrip Modal Delete-->  


<script>
function radio_tunai() {
    var form_tunai = document.getElementById("form_tunai");
    var form_bank = document.getElementById("form_bank");
    if (form_tunai.style.display === "none") {
        form_tunai.style.display = "block";
		form_bank.style.display = "none";
		document.getElementById('form_tunai').style.visibility = 'visible';
    } else {
        form_tunai.style.display = "none";
		form_bank.style.display = "block";
		document.getElementById('form_bank').style.visibility = 'visible';
    }
}
</script>

<script>
function open_bank() {
    var tabel = document.getElementById("tabel");
    if (tabel.value=="" || tabel.value=="konfirmasi_tunai") {
		document.getElementById('field_bank').style.display = 'none';
		document.getElementById('id_bank').disabled = true;
    } else {
		document.getElementById('field_bank').style.display = 'block';
		document.getElementById('field_bank').style.visibility = 'visible';
		document.getElementById('id_bank').disabled = false;
		document.getElementById('id_bank').required = true;
	}
}
</script>

</body>

</html>