<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php

if (isset($_GET['generate'])) :
$id= $_POST['id'];
$sql=$conn->query(" SELECT kode_barang, nama_barang from stok_barang where id='$id' ")->fetch_array();
$kode_barang= $sql[0];
$hapus=$conn->query(" TRUNCATE log_trx ");

$hapus=$conn->query(" INSERT INTO `log_trx`(`jenis_trx`, `kode_barang`, `jumlah`, `tanggal_trx`) SELECT '1', kode_barang, jumlah, FROM_UNIXTIME(id_pembelian) from pembelian_sementara where kode_barang = '$kode_barang' AND id_pembelian IN (select id_pembelian from tabel_pembelian where is_final = 1 ) ORDER BY id_pembelian ASC");

$hapus=$conn->query(" INSERT INTO `log_trx`(`jenis_trx`, `kode_barang`, `jumlah`, `tanggal_trx`) SELECT '2', kode_barang, jumlah_barang, tanggal from tabel_retur where kode = '1' AND kode_barang = '$kode_barang'");

$hapus=$conn->query(" INSERT INTO `log_trx`(`jenis_trx`, `kode_barang`, `jumlah`, `tanggal_trx`) SELECT '3', kode_barang, -jumlah, FROM_UNIXTIME(no_faktur) from tabel_trx where kode_barang = '$kode_barang' AND no_faktur IN (select no_faktur from tabel_faktur where total_trx > 0) ORDER BY no_faktur ASC");


	if ($hapus) {
	echo json_encode(array('status' =>true, 'pesan' => 'Generate Data Log Barang '.$sql[1].' BERHASIL..!', 'kode' => $kode_barang));
	} else {
	echo json_encode(array('error' =>true, 'pesan' => 'Generate Data Log Kode Barang '.$kode_barang.' GAGAL..!'));
	}
endif;	
?>

<?php if (isset($_GET['data'])) :
$kode_barang=$_GET['kode_barang'];
$trx=$conn->query(" SELECT * FROM log_trx WHERE kode_barang = '$kode_barang' ORDER BY tanggal_trx  ASC");
?>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-opname">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Stok Awal</th>
                                            <th>QTY Bertambah</th>
                                            <th>QTY Berkurang</th>
                                            <th>Jumlah Stok</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$trx->fetch_array()) :
									$jenis=$conn->query(" SELECT keterangan from jenis_trx where id = '".$x['jenis_trx']."' ")->fetch_array();
									$pecah=explode(' ',$x['tanggal_trx']);
									$tgl=tanggal_indo($pecah[0]);
									$stok_awal=$conn->query(" SELECT SUM(jumlah) from log_trx where kode_barang = '$kode_barang' AND tanggal_trx < '".$x['tanggal_trx']."'")->fetch_array();
									if ($x['jenis_trx']==3) {
									$berkurang=$x['jumlah'];
									$bertambah=0;
									} else {
									$bertambah=$x['jumlah'];
									$berkurang=0;
									}										
									
									$jumlah_stok=$stok_awal[0]+$x['jumlah'];
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$jenis[0]?></td>
                                            <td><?=angka($stok_awal[0])?></td>
                                            <td><?=angka($bertambah)?></td>
                                            <td><?=angka($berkurang)?></td>
                                            <td><?=angka($jumlah_stok)?></td>
                                        </tr>
                                   <?php endwhile;?> 
                                    </tbody>
                                </table>
                            </div>
                            
<script type="application/javascript">
$(function () {
    $('.js-opname').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel'
        ]
    });
});
</script>                            

<?php endif;

if (isset($_GET['penyesuaian'])) :

$selisih = $_POST['selisih'];
$kode = $_POST['kode'];

$eks=$conn->query("UPDATE stok_barang SET sisa_stok = sisa_stok + $selisih WHERE kode_barang='$kode'");
echo json_encode(array('status' =>true, 'pesan' => 'Penyesuaian '.$kode.' BERHASIL..!'));

endif;

?>