<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php
include MDL.'login/session.php';
$distributor= $_SESSION['distributor'];

if (isset($_GET['generate'])) :

$awal = date_create_from_format('d-m-Y', $_POST['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d 00:00:00',$awal);
$akhir = date_create_from_format('d-m-Y', $_POST['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d 23:59:59',$akhir);

$reservasi=$_POST['reservasi'];

$hapus=$conn->query(" TRUNCATE log_tunai ");

$hapus=$conn->query(" INSERT INTO `log_tunai`(`tanggal_trx`, `jenis_trx`, `toko`, `jumlah_bayar`, `keterangan`, `distributor`, `reservasi`) SELECT `tgl_approve`, `jenis`, `id_toko`, `jumlah_bayar`, CONCAT(`keterangan`,' No Faktur ', `no_faktur`), '$distributor', '$reservasi' FROM `konfirmasi_tunai` WHERE distributor='$distributor' AND jenis = 1 ");

$hapus=$conn->query(" INSERT INTO `log_tunai`(`tanggal_trx`, `jenis_trx`, `toko`, `jumlah_bayar`, `keterangan`, `distributor`, `reservasi`) SELECT `tgl_approve`, `jenis`, `id_toko`, CONCAT('-',jumlah_bayar), `keterangan`, '$distributor', '$reservasi' FROM `konfirmasi_tunai` WHERE distributor='$distributor' AND jenis = 2 ");

$hapus=$conn->query(" INSERT INTO `log_tunai`(`tanggal_trx`, `jenis_trx`, `toko`, `jumlah_bayar`, `keterangan`, `distributor`, `reservasi`) SELECT `tgl_approve`, `jenis`, `id_toko`, jumlah_bayar, `keterangan`, '$distributor', '$reservasi' FROM `konfirmasi_tunai` WHERE distributor='$distributor' AND jenis = 3 ");

$hapus=$conn->query(" INSERT INTO `log_tunai`(`tanggal_trx`, `jenis_trx`, `toko`, `jumlah_bayar`, `keterangan`, `distributor`, `reservasi`) SELECT `tgl_transaksi`, '1', `id_toko`, `jumlah_bayar`, CONCAT('Pembayaran Tunai, No. Faktur ',`no_faktur`), '$distributor', '$reservasi' FROM `tabel_bayar` WHERE `metode_bayar`=0 AND `kode_bayar`=0 AND distributor='$distributor' ");

$hapus=$conn->query(" INSERT INTO `log_tunai`(`tanggal_trx`, `jenis_trx`, `toko`, `jumlah_bayar`, `keterangan`, `distributor`, `reservasi`) SELECT tgl_transaksi, '1', id_toko, jumlah_bayar, CONCAT('Pembayaran Uang Muka, No. Faktur ', no_faktur, ' Dari Jumlah Transaksi Sebesar Rp. ', CONVERT(FORMAT(jumlah_transaksi,0) using utf8)), '$distributor', '$reservasi' FROM tabel_bayar WHERE metode_bayar=0 AND kode_bayar=1 AND jumlah_bayar !='' AND distributor='$distributor' ");



	if ($hapus) {
	echo json_encode(array('status' =>true, 'pesan' => 'Generate Data Log Tunai BERHASIL..!'));
	} else {
	echo json_encode(array('error' =>true, 'pesan' => 'Generate Data Log Tunai Distributor '.$distributor.' GAGAL..!'));
	}

endif;	

if (isset($_GET['tampilkan_data'])) :

$reservasi=$_GET['reservasi'];
$toko=$_GET['toko'];
$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d 00:00:00',$awal);
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d 23:59:59',$akhir);

$trx=$conn->query(" SELECT * FROM log_tunai WHERE distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' AND toko IN ($toko) AND jenis_trx < 3 ORDER BY tanggal_trx  ASC");

$tot_masuk=$conn->query(" SELECT SUM(jumlah_bayar) FROM log_tunai WHERE distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' AND jenis_trx=1 AND jumlah_bayar > 0 AND toko IN ($toko) ")->fetch_array();
$tot_keluar_1=$conn->query(" SELECT SUM(jumlah_bayar) FROM log_tunai WHERE distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' AND jenis_trx=1 AND jumlah_bayar < 0 AND toko IN ($toko)")->fetch_array();
$tot_keluar_2=$conn->query(" SELECT SUM(jumlah_bayar) FROM log_tunai WHERE distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' AND jenis_trx=2 AND toko IN ($toko)")->fetch_array();
$tot_keluar=$tot_keluar_1[0]+$tot_keluar_2[0];


?>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA KAS TUNAI
                                <small>Periode <?=tanggal_indo(date('Y-m-d',$awal))?> Sampai Dengan <?=tanggal_indo(date('Y-m-d',$akhir))?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Outlet</th>
                                            <th>Saldo Awal</th>
                                            <th>Pemasukan</th>
                                            <th>Pengeluaran</th>
                                            <th>Saldo</th>
                                            <th>Keterangan</th>
                                        </tr>                                        
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total Periode <?=tanggal_indo(date('Y-m-d',$awal))?> s/d <?=tanggal_indo(date('Y-m-d',$akhir))?></th>
                                            <th class="align-right"><?=angka($tot_masuk[0])?></th>
                                            <th class="align-right"><?=angka($tot_keluar)?></th>
                                            <th class="align-right"><?=angka($tot_masuk[0]+$tot_keluar)?></th>
                                            <th></th>
                                        </tr>                                        
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$trx->fetch_array()) :
									$pecah=explode(' ',$x['tanggal_trx']);
									$tgl=tanggal_indo($pecah[0]);
									$saldo_awal=$conn->query(" SELECT SUM(jumlah_bayar) from log_tunai where distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx < '".$x['tanggal_trx']."' AND jenis_trx < 3 ")->fetch_array();
									if ($x['jenis_trx']==1 && $x['jumlah_bayar'] < 0) {
									$pengeluaran=$x['jumlah_bayar'];
									$pemasukan=0;
									} else if ($x['jenis_trx']==2) {
									$pengeluaran=$x['jumlah_bayar'];
									$pemasukan=0;
									} else {
									$pemasukan=$x['jumlah_bayar'];
									$pengeluaran=0;
									}										
									$saldo=$saldo_awal[0]+$pemasukan+$pengeluaran;
									
									if ($x['toko'] > 0) {
									$toko_sql=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$x['toko']."'")->fetch_array();
									$toko=$toko_sql[0];
									} else {
									$toko='Kas Distributor '.$x['distributor'];
									}
									
									?>
                                        <tr>
                                            <td class="align-center"><?=$no++?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$toko?></td>
                                            <td class="align-right"><?=angka($saldo_awal[0])?></td>
                                            <td class="align-right"><?=angka($pemasukan)?></td>
                                            <td class="align-right"><?=angka($pengeluaran)?></td>
                                            <td class="align-right"><?=angka($saldo)?></td>
                                            <td><?=$x['keterangan']?></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>  
<script type="application/javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 3 || column === 4 || column === 5 || column === 6 ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.apa').DataTable({
        dom: 'Bfrtip',
		searching: false,
        responsive: true,
		info:     true,
        buttons: [
            { extend: 'copyHtml5', footer: true, text: '<i class="fa fa-copy"></i> Copy', title: $('h1').text() },
			//{ extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel' },
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: false, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});

</script>            
   
            
           <!-- List Example -->
<?php
$jual_tunai=$conn->query("SELECT SUM(jumlah_bayar) FROM log_tunai WHERE keterangan LIKE '%Pembayaran Tunai%'  AND distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' ")->fetch_array();

$retur=$conn->query("SELECT SUM(jumlah_bayar) FROM log_tunai WHERE keterangan LIKE '%Biaya Pengembalian Atas Retur Barang%' AND distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' ")->fetch_array();
$uang_muka=$conn->query("SELECT SUM(jumlah_bayar) FROM log_tunai WHERE keterangan LIKE '%Pembayaran Uang Muka%' AND distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir'  ")->fetch_array();
$keluar_non=$conn->query("SELECT SUM(jumlah_bayar) FROM log_tunai WHERE toko=0 AND jenis_trx=2 AND distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' ")->fetch_array();
$setor=$conn->query("SELECT SUM(jumlah_bayar) FROM log_tunai WHERE jenis_trx=3 AND distributor = '$distributor' AND reservasi = '$reservasi' AND tanggal_trx BETWEEN '$tgl_awal' and '$tgl_akhir' ")->fetch_array();

?>           
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                RINGKASAN DATA BUKU KAS UMUM (KALKULASI GLOBAL)
                            </h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-pink"><?=angka($jual_tunai[0])?></span> PENDAPATAN DARI PENJUALAN TUNAI
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-cyan"><?=angka($uang_muka[0])?></span> PENDAPATAN DARI PENJUALAN BERUPA UANG MUKA
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-teal"><?=angka($retur[0])?></span> PENGELUARAN DARI PENGEMBALIAN ATAS RETUR BARANG
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-teal"><?=angka($keluar_non[0])?></span> PENGELUARAN NON OUTLET
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-teal"><?=angka($setor[0])?></span> PENYETORAN DARI OUTLET
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# List Example -->

 <?php
endif;
?>	
