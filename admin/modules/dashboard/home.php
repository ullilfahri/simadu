<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';

?>  
<ol class="breadcrumb breadcrumb-bg-teal align-left">
<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Beranda</a></li>
</ol> 

<?php if ($_SESSION['level'] != 2) {?>           
            <!-- CPU Usage -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>CPU USAGE (%)</h2>
                                </div>
                                <div class="col-xs-12 col-sm-6 align-right">
                                    <div class="switch panel-switch-btn">
                                        <span class="m-r-10 font-12">REAL TIME</span>
                                        <label>OFF<input type="checkbox" id="realtime" checked><span class="lever switch-col-cyan"></span>ON</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div id="real_time_chart" class="dashboard-flot-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# CPU Usage -->
<?php } else { 
$dis=$conn->query("SELECT `pengguna`, kode FROM `mst_hak_akses` WHERE kode = '".$_SESSION['distributor']."'")->fetch_array();
$awal=strtotime(date('Y-m-d 00:00:00'));
$akhir=strtotime(date('Y-m-d 23:59:59'));

$trx=$conn->query("SELECT id_toko, COUNT(no_faktur), SUM(sub_total)  FROM `tabel_trx` WHERE distributor = '".$dis[1]."' AND no_faktur between $awal and $akhir GROUP BY id_toko");
$jml_trx=$conn->query("SELECT COUNT(no_faktur), SUM(sub_total)  FROM `tabel_trx` WHERE distributor = '".$dis[1]."' AND no_faktur between $awal and $akhir GROUP BY distributor")->fetch_array();

$trx_tunai=$conn->query("SELECT COUNT(*), SUM(jumlah_transaksi) from tabel_bayar WHERE distributor = '".$dis[1]."' AND no_faktur between $awal and $akhir AND metode_bayar = 0 AND kode_bayar = 0 GROUP BY distributor ")->fetch_array();
$trx_hutang=$conn->query("SELECT COUNT(*), SUM(jumlah_transaksi) from tabel_bayar WHERE distributor = '".$dis[1]."' AND no_faktur between $awal and $akhir AND metode_bayar = 1 GROUP BY distributor ")->fetch_array();
$trx_transfer=$conn->query("SELECT COUNT(*), SUM(jumlah_transaksi) from tabel_bayar WHERE distributor = '".$dis[1]."' AND no_faktur between $awal and $akhir AND metode_bayar = 0 AND kode_bayar = 2 GROUP BY distributor ")->fetch_array();



$beli=$conn->query("SELECT id_owner, COUNT(id_pembelian), SUM(total)  FROM `tabel_pembelian` WHERE distributor = '".$dis[1]."' AND id_pembelian between $awal and $akhir AND is_final = 1 GROUP BY id_owner");
$jml_beli=$conn->query("SELECT COUNT(id_pembelian), SUM(total)  FROM `tabel_pembelian` WHERE distributor = '".$dis[1]."' AND id_pembelian between $awal and $akhir AND is_final = 1 GROUP BY id_owner")->fetch_array();


?>  

<!--Jual-->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>INFO PENJUALAN HARI INI <?=$dis[0]?></h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Outlet</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Total Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th><?=angka($jml_trx[0])?></th>
                                            <th><?=angka($jml_trx[1])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
									$no=1;
									while ($x=$trx->fetch_array()) :
									$toko=$conn->query("SELECT nama FROM lokasi where id_lokasi = '$x[0]'")->fetch_array();
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><span class="label bg-green"><?=$x[1]?></span></td>
                                            <td><?=angka($x[2])?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!-- #END#Jual -->

<!--Klasifikasi-->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>INFO PENJUALAN HARI INI <?=$dis[0]?></h2>
                            <small>Menurut Klasifikasi Metode Pembayaran</small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Jumlah Transaksi</th>
                                            <th>Jumlah Tunai</th>
                                            <th>Jumlah Piutang</th>
                                            <th>Jumlah Transfer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="label bg-green"><?=$trx_tunai[0]+$trx_hutang[0]+$trx_transfer[0]?></span></td>
                                            <th><?=angka($trx_tunai[1])?></th>
                                            <th><?=angka($trx_hutang[1])?></th>
                                            <th><?=angka($trx_transfer[1])?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!-- #END#Klasifikasi -->
                
<!--Beli-->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>INFO PEMBELIAN HARI INI <?=$dis[0]?></h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User Approve</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Total Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th><?=angka($jml_beli[0])?></th>
                                            <th><?=angka($jml_beli[1])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
									$ny=1;
									while ($y=$beli->fetch_array()) :
									$user=$conn->query("SELECT nama FROM user where id = '$y[0]'")->fetch_array();
									
									?>
                                        <tr>
                                            <td><?=$ny++?></td>
                                            <td><?=$user[0]?></td>
                                            <td><span class="label bg-green"><?=$y[1]?></span></td>
                                            <td><?=angka($y[2])?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!-- #END# Beli -->
          
<?php } ?>            
            
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?=PLG?>bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?=PLG?>jquery-countto/jquery.countTo.js"></script>



    <!-- Flot Charts Plugin Js-->
    <script src="<?=PLG?>flot-charts/jquery.flot.js"></script>
    <script src="<?=PLG?>flot-charts/jquery.flot.resize.js"></script>
    <script src="<?=PLG?>flot-charts/jquery.flot.pie.js"></script>
    <script src="<?=PLG?>flot-charts/jquery.flot.categories.js"></script>
    <script src="<?=PLG?>flot-charts/jquery.flot.time.js"></script> 


    <script src="<?=JS?>pages/index.js"></script>

