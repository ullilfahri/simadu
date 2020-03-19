<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['tampil_data'])) :
	if ($_GET['distributor'] != '') {
	$dis=$conn->query("SELECT kode, pengguna FROM mst_hak_akses WHERE kode='".$_GET['distributor']."'")->fetch_array();
	$distributor=$dis[0];
	$nama_distributor=$dis[1];
	} else {
	$distributor='';
	$nama_distributor='SEMUA DISTRIBUTOR';
	}
$id_toko = $_GET['id_toko'];
	
$kriteria_sortir = $_GET['kriteria_sortir'];
	if ($kriteria_sortir==0) {
		$awal = date_create_from_format('d-m-Y', $_GET['awal']);
		$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
		$tgl_awal = tanggal_indo(date('Y-m-d',$awal));
		$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
		$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
		$tgl_akhir = tanggal_indo(date('Y-m-d',$akhir));
		$smal='Transaksi Periode '.$tgl_awal.' s.d '.$tgl_akhir;
	} else {
		$awal=strtotime(date('Y-m-d 00:00:00'));
		$akhir=strtotime(date('Y-m-d 23:59:59'));
		$smal='Transaksi Hari Ini';
	}

	if ($_GET['id_kasir'] !='') {
		$id_kasir = $_GET['id_kasir'];
		$kasir=$conn->query("SELECT nama FROM user WHERE id='$id_kasir'")->fetch_array();
		$nama_kasir=$kasir[0];
		} else {
		$id_kasir = '';
		$nama_kasir='SEMUA KASIR';
		}	
	
$tunai=$conn->query("SELECT SUM(sub_total) FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=0 AND `total_trx`-`uang_muka`=0 )")->fetch_array();

$mundur=$conn->query("SELECT SUM(sub_total) FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=1)")->fetch_array();

$transfer=$conn->query("SELECT SUM(sub_total) FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=0 AND `total_trx`-`dalam_bank`=0 )")->fetch_array();

$piutang_tunai=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Piutang%' AND user_approve LIKE '%$id_kasir%'")->fetch_array();
		
$piutang_transfer=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_bank WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Piutang%' AND user_approve LIKE '%$id_kasir%'")->fetch_array();
		
$retur=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Retur%' AND user_approve LIKE '%$id_kasir%'")->fetch_array();
		
$keluar=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND jenis = '2' AND user_approve LIKE '%$id_kasir%'")->fetch_array();

$pengeluaran=$retur[0]-$keluar[0];
		
?> 
			<div class="block-header">
               <h2>RINCIAN TRANSAKSI <?=$nama_distributor?><br>
               KASIR : <?=strtoupper($nama_kasir)?><br>
               <?=$smal?><br>
               Klik Untuk Menampilkan Rincian Data Transaksi
               </h2>
            </div>   
                    
            <div class="row clearfix">
                <!-- Linked Items -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PEMBAYARAN TUNAI (CASH)
                            </h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                            <ul class="list-group">
                                <button type="button" data-toggle="modal" data-target=".modal_rincian" data-detail="tunai" data-toko="<?=$id_toko?>" data-kasir="<?=$id_kasir?>" data-awal="<?=$awal?>" data-akhir="<?=$akhir?>" data-distributor="<?=$distributor?>" class="list-group-item">Penjualan Tunai <span class="badge bg-cyan"><?=rupiah($tunai[0])?></span></button>
                                
                                <button type="button" data-toggle="modal" data-target=".modal_rincian" data-detail="piutang_tunai" data-toko="<?=$id_toko?>" data-kasir="<?=$id_kasir?>" data-awal="<?=$awal?>" data-akhir="<?=$akhir?>" data-distributor="<?=$distributor?>" class="list-group-item">Penerimaan Piutang <span class="badge bg-cyan"><?=rupiah($piutang_tunai[0])?></span></button>
                                
                                <button type="button" data-toggle="modal" data-target=".modal_rincian" data-detail="pengeluaran_tunai" data-toko="<?=$id_toko?>" data-kasir="<?=$id_kasir?>" data-awal="<?=$awal?>" data-akhir="<?=$akhir?>" data-distributor="<?=$distributor?>" class="list-group-item">Pengeluaran <span class="badge bg-red"><?=rupiah($pengeluaran)?></span></button>
                                
                                <li class="list-group-item">Total (Uang Tunai) <span class="badge bg-green"><?=rupiah(($piutang_tunai[0]+$tunai[0])+$pengeluaran)?></span></li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
              
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PEMBAYARAN TUNAI (TRANSFER)
                            </h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                            <ul class="list-group">
                                <button type="button" data-toggle="modal" data-target=".modal_rincian" data-detail="transfer" data-toko="<?=$id_toko?>" data-kasir="<?=$id_kasir?>" data-awal="<?=$awal?>" data-akhir="<?=$akhir?>" data-distributor="<?=$distributor?>" class="list-group-item">Penjualan Tunai <span class="badge bg-cyan"><?=rupiah($transfer[0])?></span></button>
                                
                                <button type="button" data-toggle="modal" data-target=".modal_rincian" data-detail="piutang_transfer" data-toko="<?=$id_toko?>" data-kasir="<?=$id_kasir?>" data-awal="<?=$awal?>" data-akhir="<?=$akhir?>" data-distributor="<?=$distributor?>" class="list-group-item">Penerimaan Piutang <span class="badge bg-cyan"><?=rupiah($piutang_transfer[0])?></span></button>
                                
                                <li class="list-group-item">Total (Pembayaran Transfer) <span class="badge bg-pink"><?=rupiah($piutang_transfer[0]+$transfer[0])?></span></li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
             </div>   

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PEMBAYARAN MUNDUR
                            </h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                            <ul class="list-group">
                                <button type="button" data-toggle="modal" data-target=".modal_rincian" data-detail="mundur" data-toko="<?=$id_toko?>" data-kasir="<?=$id_kasir?>" data-awal="<?=$awal?>" data-akhir="<?=$akhir?>" data-distributor="<?=$distributor?>" class="list-group-item">Penjualan Pembayaran Mundur <span class="badge bg-cyan"><?=rupiah($mundur[0])?></span></button>
                                
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
             </div>   

<?php
endif;

if (isset($_POST['detail'])) :

$detail = $_POST['detail'];
$id_toko = $_POST['id_toko'];
$id_kasir = $_POST['id_kasir'];
$awal = $_POST['awal'];
$akhir = $_POST['akhir'];
$distributor = $_POST['distributor'];

	if ($detail=='tunai') {
		$trx=$conn->query("SELECT id_toko, sub_total, no_faktur, distributor  FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=0 AND `total_trx`-`uang_muka`=0 )"); 
		$total=$conn->query("SELECT SUM(sub_total)  FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=0 AND `total_trx`-`uang_muka`=0 )")->fetch_array(); 
		
		} else if ($detail=='piutang_tunai') {
		$trx=$conn->query("SELECT id_toko, jumlah_bayar, no_faktur, distributor FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Piutang%' AND user_approve LIKE '%$id_kasir%'");
		$total=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Piutang%' AND user_approve LIKE '%$id_kasir%'")->fetch_array(); 

		} else if ($detail=='pengeluaran_tunai') {
		$trx=$conn->query("SELECT id_toko, jumlah_bayar, no_faktur, distributor FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND jenis = '2' AND user_approve LIKE '%$id_kasir%' OR id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Retur%' AND user_approve LIKE '%$id_kasir%'");
		$total=$conn->query("SELECT SUM(-`jumlah_bayar`) FROM konfirmasi_tunai WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND jenis = '2' AND user_approve LIKE '%$id_kasir%' OR id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Retur%' AND user_approve LIKE '%$id_kasir%'")->fetch_array(); 
		
		} else if ($detail=='transfer') {
		$trx=$conn->query("SELECT id_toko, sub_total, no_faktur, distributor FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=0 AND `total_trx`-`dalam_bank`=0 )");
		$total=$conn->query("SELECT SUM(sub_total) FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=0 AND `total_trx`-`dalam_bank`=0 )")->fetch_array();
		
		
		} else if ($detail=='piutang_transfer') {
		$trx=$conn->query("SELECT id_toko, jumlah_bayar, no_faktur, distributor FROM konfirmasi_bank WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Piutang%' AND user_approve LIKE '%$id_kasir%'");
		$total=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_bank WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND tgl_approve BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir) AND keterangan LIKE '%Piutang%' AND user_approve LIKE '%$id_kasir%'")->fetch_array();
		
		} else if ($detail=='mundur') {
		$total=$conn->query("SELECT SUM(sub_total) FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=1)")->fetch_array();
		$trx=$conn->query("SELECT id_toko, sub_total, no_faktur, distributor FROM tabel_trx WHERE id_toko='$id_toko' AND distributor LIKE '%$distributor%' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur BETWEEN $awal and $akhir AND kasir LIKE '%$id_kasir%' AND total_trx > 0 AND metode_bayar=1)");
		}
?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-metode">
		<thead>
			<tr>
				<th>No</th>
				<th>Kasir</th>
				<th>No Faktur</th>
                <!--
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>QTY</th>
                -->
				<th>Customer</th>
				<th>Distributor</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="5">Total</th>
				<th class="align-right"><?=angka($total[0])?></th>
			</tr>
		</tfoot>
		<tbody>
<?php
$no=1;
while ($x=$trx->fetch_array()) :
$kasir=$conn->query("SELECT nama FROM user WHERE id IN (SELECT kasir FROM tabel_faktur WHERE no_faktur='".$x[2]."')")->fetch_array();
$cst=$conn->query("SELECT customer, cus_umum FROM tabel_faktur WHERE no_faktur='".$x[2]."'")->fetch_array();
	if ($cst[0]==0) {
	$arr = json_decode($cst[1], true);
	$customer='Umum : '.$arr["umum"]["nama"];
	} else {
	$customer_sql=$conn->query("select nama from tabel_customer where id='".$cst[0]."'")->fetch_array();
	$customer=$customer_sql[0];
	}
?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$x[2]?></td>
				<td><?=$kasir[0]?></td>
				<td><?=$customer?></td>
				<td><?=$x[3]?></td>
				<td class="align-right"><?=angka($x[1])?></td>
			</tr>
<?php endwhile;?>     
		</tbody>
	</table>         
</div>

<script type="application/javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 5  ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.js-metode').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]

    });
});
</script>  
                            

<?php
endif;

?>                