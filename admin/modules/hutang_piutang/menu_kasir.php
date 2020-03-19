<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>

<?php
include DOT.'partial/header_index.php';
include MDL.'login/session.php';

if ($_SESSION['level'] != 3) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
	
	if ($_SESSION['sub_level']==3) {
		$qry='AND user_approve = '.$_SESSION['id'];
		$qry2='AND kasir = '.$_SESSION['id'];
		$url='&id_kasir='.$_SESSION['id'].'&toko='.$_SESSION['toko'];
		} else {
		$qry='';
		$qry2='';
		$url='&id_kasir=&toko='.$_SESSION['toko'];
		}
	
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
$cek=$conn->query(" SELECT * FROM konfirmasi_tunai where keterangan = 'Pembukaan Kas' AND tgl_approve like '%".date('Y-m-d')."%' AND id_toko = '".$_SESSION['toko']."'")->num_rows;
	if ($cek==0) {
		$display='block';
		} else {
		$display='none';
		}

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
            
            <!-- Vertical Layout | With Floating Label -->
         <div style="display:<?=$display?>"   
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY DATA PEMBUKAAN KAS HARI INI
                                <small>Form ini akan otomatis hilang jika Admin Toko sudah mengisi Pembukaan Kas Pada Hari ini</small>
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="form_crud.php">
                            <input type="hidden" name="jenis" value="1" />
                            <input type="hidden" name="user_approve" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" name="id_toko" value="<?=$_SESSION['toko']?>" />
                            <input type="hidden" name="keterangan" value="Pembukaan Kas" />
                            
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="jumlah_bayar"  name="jumlah_bayar" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                        <label class="form-label">Jumlah Uang (Rp)</label>
                                    </div>
                                </div>

                            

                                <button type="submit" name="tambah_pembukaan_kas" class="btn btn-primary m-t-15 waves-effect">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->
            <?php if ($_SESSION['sub_level']==4) :?>
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY PENGELUARAN
                            </h2>
                        </div>
                        <div class="body">
                            <form name="form_awal">
                                <div class="form-group form-float">
                                <p><b>Kriteria Pengeluaran</b></p>
                                    <div class="form-line">
                                        <select name="pilih_pengeluaran" onchange="kriteria()" class="form-control show-tick" required>
                                        <option value="">--Pilih Kriteria Pengeluaran--</option>
                                        <option value="1">PENGELUARAN RUTIN</option>
                                        <option value="2">PENYETORAN KEPADA DISTRIBUTOR</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
              </div>
              <?php endif;?>  
            <!-- Vertical Layout | With Floating Label -->
             
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix" id="field_rutin" style="display:none"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY PENGELUARAN RUTIN
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="form_crud.php">
                            <input type="hidden" name="jenis" value="2" />
                            <input type="hidden" name="user_approve" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" name="id_toko" value="<?=$_SESSION['toko']?>" />
                            
                                <div class="form-group form-float">
                                <p><b>Jumlah Uang (Rp)</b></p>
                                    <div class="form-line">
                                        <input type="text" id="jumlah_bayar"  name="jumlah_bayar" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                        <label class="form-label">Jumlah Uang (Rp)</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                <p><b>Keterangan</b></p>
                                    <div class="form-line">
                                        <textarea name="keterangan" class="form-control"></textarea>
                                        <label class="form-label">Keterangan</label>
                                    </div>
                                </div>

                                <button type="submit" name="entry_pengeluaran" class="btn btn-primary m-t-15 waves-effect">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
              </div>  
            <!-- Vertical Layout | With Floating Label -->
            
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix" id="field_setor" style="display:none"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY PENYETORAN
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="form_crud.php" name="field_setor">
                            <input type="hidden" name="jenis" value="2" />
                            <input type="hidden" name="user_approve" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" name="id_toko" value="<?=$_SESSION['toko']?>" />
                            <input type="hidden" name="keterangan" value="Penyetoran Kepada Distributor" />
                            
                                <div class="form-group form-float">
                                <p><b>Distributor</b></p>
                                    <div class="form-line">
                                        <select name="distributor" id="distributor_tujuan" class="form-control show-tick" data-show-subtext="true" required>
                                        <option value="">--Pilih Distributor--</option>
                                        <?php
                                        $dis_sql=$conn->query("SELECT * FROM mst_hak_akses WHERE id_akses=2 ORDER BY kode DESC");
										while ($d=$dis_sql->fetch_array()) :
										$tabel_bayar=$conn->query("SELECT SUM(jumlah_bayar) FROM tabel_bayar WHERE id_toko='".$_SESSION['toko']."' AND distributor='".$d['kode']."' AND metode_bayar=0 AND kode_bayar BETWEEN 0 and 1 AND jumlah_bayar !='' ")->fetch_array();
										$konfirmasi_tunai=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko = '".$_SESSION['toko']."' AND jenis=1 AND distributor = '".$d['kode']."'")->fetch_array();
										$total=$tabel_bayar[0]+$konfirmasi_tunai[0];
										$sdh=$conn->query("SELECT jumlah_bayar FROM konfirmasi_tunai WHERE keterangan = 'Penyetoran Kepada Distributor $d[pengguna]' ")->fetch_array();
										$sudah=angka($sdh[0]);
										$belum=angka($total-$sdh[0]);
										?>
                                        <option value="<?=$d['kode']?>" data-subtext="Total Tunai Rp. <?=angka($total)?>, Sudah Disetor Sebesar Rp. <?=$sudah?>, Belum Disetor Rp. <?=$belum?>"><?=$d['pengguna']?></option>
                                        <?php endwhile;?>
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="form-group form-float">
                                <p><b>Metode Setor</b></p>
                                    <div class="form-line">
                                        <input name="via_bayar" type="radio" id="tunai" value="konfirmasi_tunai"onclick="field_bank()" class="with-gap radio-col-deep-orange" checked/><label for="tunai">Setor Tunai</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input name="via_bayar" type="radio" id="bank" value="konfirmasi_bank" onclick="field_bank()" class="with-gap radio-col-deep-orange" unchecked/><label for="bank">Transfer Bank</label>
                                    </div>
                                </div>

                                <div class="form-group form-float" id="form_bank" style="display:none">
                                <p><b>Pilih Rekening Tujuan</b></p>
                                    <div class="form-line">
                                    <select name="id_bank" id="bank_tujuan" class="form-control show-tick" data-show-subtext="true">
                                        <option value="">--Pilih Rekening Distributor--</option>
                                    <?php
                                    $bank_sql=$conn->query("SELECT * FROM rekening_bank");
									while ($b=$bank_sql->fetch_array()) :
									$rek_toko=$conn->query("SELECT nama from lokasi where id_lokasi = '".$b['id_toko']."' ")->fetch_array();
									$rek_dis=$conn->query("SELECT pengguna from mst_hak_akses where kode= '".$b['distributor']."' ")->fetch_array();
									if ($b['stts'] == 1) {
										$stts_rek='Kepemilikan '.$rek_toko[0].' Untuk Distributor '.$rek_dis[0];
										} else {
										$stts_rek='Kepemilikan '.$rek_dis[0].' Non Penjualan';
										}
									?>    
                                        <option value="<?=$b['id']?>" data-subtext="<?=$stts_rek?>" class="<?=$b['distributor']?>"><?=$b['bank']?> No. Rek <?=$b['no_rek']?></option>
                                     <?php endwhile;?>
                                     </select>   
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                <p><b>Jumlah Penyetoran (Rp)</b></p>
                                    <div class="form-line">
                                        <input type="text" id="jumlah_bayar"  name="jumlah_bayar" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                        <label class="form-label">Jumlah Uang (Rp)</label>
                                    </div>
                                </div>

                                <button type="submit" name="entry_penyetoran" class="btn btn-primary m-t-15 waves-effect">Entry</button>
                            </form>
                        </div>
                    </div>
                </div>
              </div>  
            <!-- Vertical Layout | With Floating Label -->
             
<?php
if (isset($_GET['hari_ini'])) :

		$tunai=$conn->query("select * from konfirmasi_tunai where id_toko = '".$_SESSION['toko']."' AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' $qry ORDER BY tgl_approve DESC");
		$bank=$conn->query("select * from konfirmasi_bank where id_toko = '".$_SESSION['toko']."' AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' $qry ORDER BY tgl_approve DESC");
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA ARUS KAS HARI INI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Approve</th>
                                            <th>Pemasukan</th>
                                            <th>Pengeluaran</th>
                                            <th>Keterangan</th>
                                            <th>Status Kas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nt=1;
									while ($x=$tunai->fetch_array()) :
									if ($x['jenis']==1) {
										$pemasukan=angka($x['jumlah_bayar']);
										$pengeluaran='';
										} else {
										$pengeluaran=angka($x['jumlah_bayar']);
										$pemasukan='';
										}
									?>
                                        <tr>
                                            <td><?=$nt?></td>
                                            <td><?=date_format(date_create_from_format('Y-m-d H:i:s', $x['tgl_approve']), 'd-m-Y')?></td>
                                            <td><?=$pemasukan?></td>
                                            <td><?=$pengeluaran?></td>
                                            <td><?=ucwords(strtolower($x['keterangan']))?></td>
                                            <td>Cash In Hand</td>
                                        </tr>
                                    <?php $nt++; endwhile;?>    
                                    <?php
                                    $nb=$nt+0;
									while ($y=$bank->fetch_array()) :
									$data_bank=$conn->query("SELECT bank, no_rek FROM rekening_bank where id= '".$y['id_bank']."' ")->fetch_array();
									if ($y['jenis']==1) {
										$pemasukan=angka($y['jumlah_bayar']);
										$pengeluaran='';
										} else {
										$pengeluaran=angka($y['jumlah_bayar']);
										$pemasukan='';
										}
									?>
                                        <tr>
                                            <td><?=$nb?></td>
                                            <td><?=date_format(date_create_from_format('Y-m-d H:i:s', $y['tgl_approve']), 'd-m-Y')?></td>
                                            <td><?=$pemasukan?></td>
                                            <td><?=$pengeluaran?></td>
                                            <td><?=ucwords(strtolower($y['keterangan']))?></td>
                                            <td>Bank, <?=$data_bank[0]?>, No Rek. <?=$data_bank[1]?></td>
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
            
<?php
$awal=strtotime(date('Y-m-d 00:00:00'));
$akhir=strtotime(date('Y-m-d 23:59:59'));
$sql=$conn->query(" SELECT SUM(total_trx), SUM(hutang), SUM(jumlah_diskon) FROM tabel_faktur where no_faktur between $awal AND $akhir AND id_toko = '".$_SESSION['toko']."' $qry2 ")->fetch_array();
$total_trx=$sql[0]-$sql[2];
$hutang=$sql[1];
	if ($_SESSION['sub_level']==4) {
	$tunai=$conn->query(" SELECT SUM(uang_muka) FROM tabel_faktur where no_faktur between $awal AND $akhir AND metode_bayar=0 AND id_toko = '".$_SESSION['toko']."' ")->fetch_array();
	} else {
	$tunai=$conn->query(" SELECT SUM(uang_muka) FROM tabel_faktur where no_faktur between $awal AND $akhir AND metode_bayar=0 AND id_toko = '".$_SESSION['toko']."' AND kasir = '".$_SESSION['id']."'")->fetch_array();
	}
	if ($_SESSION['sub_level']==4) {
	$transfer=$conn->query(" SELECT SUM(dalam_bank) FROM tabel_faktur where no_faktur between $awal AND $akhir AND metode_bayar=0 AND id_toko = '".$_SESSION['toko']."' ")->fetch_array();
	} else {
	$transfer=$conn->query(" SELECT SUM(dalam_bank) FROM tabel_faktur where no_faktur between $awal AND $akhir AND metode_bayar=0 AND id_toko = '".$_SESSION['toko']."' AND kasir = '".$_SESSION['id']."'")->fetch_array();
	}
$pendapatan=$conn->query(" SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko = '".$_SESSION['toko']."' AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' AND jenis=1  $qry ")->fetch_array();
$pengeluaran=$conn->query(" SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko = '".$_SESSION['toko']."' AND tgl_approve between '".date('Y-m-d 00:00:00')."' and '".date('Y-m-d 23:59:59')."' AND jenis=2 $qry ")->fetch_array();
?> 
            <!-- List Example -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SUMMARY PENJUALAN HARI INI
                                <br>Klik Untuk Rincian
                            </h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                                <a href="laporan_transaksi.php?klasifikasi=total_trx<?=$url?>" target="_blank" class="list-group-item">
                                    <span class="badge bg-red"><?=rupiah($total_trx)?></span> Total Transaksi
                                </a>
                                <a href="laporan_transaksi.php?klasifikasi=jual_tunai<?=$url?>" target="_blank" class="list-group-item">
                                    <span class="badge bg-teal"><?=rupiah($tunai[0])?></span> Penjualan Tunai
                                </a>
                                <a href="laporan_transaksi.php?klasifikasi=jual_transfer<?=$url?>" target="_blank" class="list-group-item">
                                    <span class="badge bg-teal"><?=rupiah($transfer[0])?></span> Penjualan Via Transfer Bank
                                </a>
                                <a href="laporan_transaksi.php?klasifikasi=jual_hutang<?=$url?>" target="_blank" class="list-group-item">
                                    <span class="badge bg-teal"><?=rupiah($hutang)?></span> Penjualan Dengan Pembayaran Mundur
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# List Example -->
            
            <!-- List Example -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                KEADAAN KAS HARI INI
                                <br>Untuk Menu Ini, Informasi Arus Kas Sudah Muncul Di Atas, Yaitu pada Tabel Arus Kas <span class="fa fa-smile-o"></span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-teal"><?=rupiah($tunai[0])?></span> Pendapatan Dari Penjualan Tunai
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-teal"><?=rupiah($pendapatan[0])?></span> Pendapatan Lain-lain diluar Penjualan Tunai
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-teal"><?=rupiah($pengeluaran[0])?></span> Pengeluaran
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-red"><?=rupiah($tunai[0]-$pengeluaran[0]+$pendapatan[0])?></span> Jumlah Kas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# List Example -->
            
            
<?php endif; ?>

                 
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
    
<script>
function kriteria() {
pilih_pengeluaran =document.form_awal.pilih_pengeluaran.value;
var field_rutin = document.getElementById("field_rutin");
var field_setor = document.getElementById("field_setor");

		if (pilih_pengeluaran=='1') {
			field_rutin.style.display = "block";
			field_setor.style.display = "none";
			} else if (pilih_pengeluaran=='2') {
			field_setor.style.display = "block";
			field_rutin.style.display = "none";
			} else {
			field_setor.style.display = "none";
			field_rutin.style.display = "none";
			}

}
</script>    
    
<script>
function field_bank() {
via_bayar =document.field_setor.via_bayar.value;
var form_bank = document.getElementById("form_bank");

		if (via_bayar=='konfirmasi_bank') {
			swal("Perhatian!", "Jangan Lupa Untuk Memilih Distributor Agar Menu field Rekening Tujuan Terbuka, Jika Distributor Telah dipilih, Field Rekening Tujuan Tidak Dapat Diakses, Hubungi Distributor", "info");
			form_bank.style.display = "block";
			document.getElementById("bank_tujuan").required=true;
			} else {
			form_bank.style.display = "none";
			document.getElementById("bank_tujuan").required=false;
			}
}
</script>  
  
<script src="<?=JS?>jquery.chained.min.js"></script>
<script type="application/javascript">
$(function(){
 $("#bank_tujuan").chained("#distributor_tujuan");
});
</script>
    
</body>

</html>