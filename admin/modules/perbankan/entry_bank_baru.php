<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php 
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] == 4 || $_SESSION['level'] == 5 || $_SESSION['level'] == 1) :
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
            
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TRANSFER BANK
                            </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="eksekusi.php" autocomplete="off" id="form">
							<input type="hidden" name="distributor" id="distributor" value="<?=$_SESSION['distributor']?>">
							<input type="hidden" name="user_approve" id="user_approve" value="<?=$_SESSION['id']?>">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Dari Rekening</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                    		<select name="bank_asal" id="bank_asal" class="form-control show-tick" required>
                                        	<option value="">-- PILIH SUMBER REKENING --</option>
                                    <?php 
									$bank_sql=$conn->query("SELECT * FROM rekening_bank where distributor = '".$_SESSION['distributor']."' and is_aktif = 1 ");
									while ($b=$bank_sql->fetch_array()) :
									$toko=$conn->query(" SELECT nama from lokasi where id_lokasi = '".$b['id_toko']."' ")->fetch_array();
									$dis=$conn->query(" SELECT pengguna from mst_hak_akses where kode = '".$b['distributor']."' ")->fetch_array();
									if ($b['stts'] == 1) {
									$stts='Kepemilikan '.$toko[0].' Untuk Distributor '.$dis[0];
									} else {
									$stts='Kepemilikan '.$dis[0].' Untuk Transaksi Pembelian Barang';
									}
									?>
                                        	<option value="<?=$b['id']?>"><?=$b['bank'].' No Rek '.$b['no_rek'].' '.$stts?></option>
                                    <?php endwhile;?>        
                                    		</select>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Rekening Tujuan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                    		<select name="bank_tujuan" id="bank_tujuan" class="form-control show-tick" required>
                                        	<option value="">-- PILIH REKENING TUJUAN--</option>
                                    <?php 
									$bank_sql2=$conn->query("SELECT * FROM rekening_bank where is_aktif = 1 ");
									while ($b=$bank_sql2->fetch_array()) :
									$toko2=$conn->query(" SELECT nama from lokasi where id_lokasi = '".$b['id_toko']."' ")->fetch_array();
									$dis2=$conn->query(" SELECT pengguna from mst_hak_akses where kode = '".$b['distributor']."' ")->fetch_array();
									if ($b['stts'] == 1) {
									$stts='Kepemilikan '.$toko[0].' Untuk Distributor '.$dis[0];
									} else {
									$stts='Kepemilikan '.$dis[0].' Untuk Transaksi Pembelian Barang';
									}
									?>
                                        	<option value="<?=$b['id']?>"><?=$b['bank'].' No Rek '.$b['no_rek'].' '.$stts?></option>
                                    <?php endwhile;?>        
                                    		</select>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">No Bukti Transfer (Jika ada)</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="bukti_bayar" id="bukti_bayar" value=" " class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Jumlah Dana</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="jumlah_bayar" id="jumlah_bayar" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">Keterangan</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea rows="2" name="keterangan" class="form-control no-resize auto-growth" placeholder="Ex. Gaji Karyawan, Operasional. Note : Entry Pembayaran Hutang via transfer mohon diinput di menu Hutang" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" name="simpan_konfirmasi" class="btn btn-primary m-t-15 waves-effect">&nbsp;Simpan&nbsp;&nbsp;</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->

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

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
</body>

</html>

<?php


?>