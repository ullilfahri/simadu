<?php
include '../../../sysconfig.php';
if (isset($_GET['detail_pembelian'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from pembelian_sementara where kode_barang='$kode_barang' order by id_pembelian ASC ");
?>

                                <table class="table js-exportable-beli">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga Pembelian</th>
                                            <th>Jumlah Pembelian</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$det=$conn->query("select * from tabel_pembelian where id_pembelian='".$x['id_pembelian']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=tanggal_indo($det['tgl_nota'])?></td>
                                            <td><?=$det['supplier']?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-beli').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           

<?php
endif;
if (isset($_GET['detail_penjualan'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from tabel_trx where kode_barang='$kode_barang'  GROUP by id_gudang, no_faktur ORDER BY no_faktur DESC");
?>

                                <table class="table js-exportable-jual">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga Penjualan</th>
                                            <th>Jumlah Penjualan</th>
                                            <th>Tanggal Penjualan</th>
                                            <th>Kasir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$det=$conn->query("select a.metode_bayar, b.nama from tabel_faktur as a left join user as b on a.kasir=b.id where a.no_faktur='".$x['no_faktur']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=date("d-m-Y, H:i:s", $x['no_faktur'])?></td>
                                            <td><?=$det[1]?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-jual').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           
<?php
endif;


if (isset($_GET['alokasi_stok'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from alokasi_stok where kode_barang='$kode_barang' order by id_gudang ASC ");
?>

                                <table class="table js-exportable-stok">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Gudang</th>
                                            <th>Pintu/Ruang/Sekat</th>
                                            <th>Jumlah Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$det=$conn->query("select nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$det[0]?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$x['jumlah']?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-stok').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           
<?php
endif;

if (isset($_GET['detail_surat_jalan'])) :
$no_faktur = $_POST['rowid'];

$stok=$conn->query("select SUM(sub_total), SUM(jumlah), SUM(potongan), harga_barang, nama_barang, id_gudang  from tabel_trx where no_faktur='$no_faktur' GROUP by kode_barang, id_gudang  ");

$total=$conn->query("select SUM(sub_total) from tabel_trx where no_faktur='$no_faktur'")->fetch_array();


?>

                                <table class="table js-exportable-jual">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga Penjualan</th>
                                            <th>Jumlah Penjualan</th>
                                            <th>Potongan</th>
                                            <th>Sub Total</th>
                                            <th>Asal Stok</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
                                       		<th colspan="5" align="center">Total</th>
                                            <th colspan="2" align="center"><?=rupiah($total[0])?></th>
                                       </tr>    
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$gudang=$conn->query("select nama from lokasi where id_lokasi='".$x[5]."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x[4]?></td>
                                            <td><?=angka($x[3])?></td>
                                            <td><?=$x[1]?></td>
                                            <td><?=angka($x[2])?></td>
                                            <td><?=angka($x[0])?></td>
                                            <td><?=$gudang[0]?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-jual').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            

<?php
endif;


if (isset($_GET['belum_ambil'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from barang_keluar where kode_barang='$kode_barang' AND jumlah - is_ambil > 0 ");
?>
                            <div class="table-responsive">
                                <table class="table js-exportable-belum_ambil">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Faktur</th>
                                            <th>Customer</th>
                                            <th>Barang</th>
                                            <th>Gudang Pengambilan</th>
                                            <th>Outlet Penjualan</th>
                                            <th>QTY Jual</th>
                                            <th>QTY Ambil</th>
                                            <th>QTY Retur</th>
                                            <th>Remark Jual</th>
                                            <th>Remark Ambil</th>
                                            <th>QTY Belum Diambil</th>
                                        </tr>
                                        <tr>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>6</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10=7-9</th>
                                            <th>11=8-9</th>
                                            <th>12=10-11</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$det=$conn->query("select nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$toko=$conn->query("select nama from lokasi where id_lokasi IN (select id_toko FROM tabel_faktur WHERE no_faktur = '".$x['no_faktur']."') ")->fetch_array();
									$cst=$conn->query("select customer, cus_umum FROM tabel_faktur WHERE no_faktur = '".$x['no_faktur']."' ")->fetch_array();
									if ($cst[0] > 0) {
									$customer=$conn->query("select * from tabel_customer where id='".$cst[0]."'")->fetch_array();
									$nama_customer=$customer['nama'];
									} else  {
									$arr = json_decode($cst[1], true);
									$nama_customer=$arr["umum"]["nama"].' (Customer Umum)';
									} 
									
									$retur=$conn->query(" SELECT SUM(jumlah_barang) FROM tabel_retur WHERE no_faktur='".$x['no_faktur']."' AND kode_barang='".$x['kode_barang']."' AND kode=1")->fetch_array();
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$nama_customer?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$det[0]?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=angka($x['jumlah'])?></td>
                                            <td><?=angka($x['is_ambil'])?></td>
                                            <td><?=angka($retur[0])?></td>
                                            <td><?=angka($x['jumlah']-$retur[0])?></td>
                                            <td><?=angka($x['is_ambil']-$retur[0])?></td>
                                            <td><?=angka($x['jumlah']-$x['is_ambil'])?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             </div>    
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-belum_ambil').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           
<?php
endif;

if (isset($_GET['belum_alokasi'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from tabel_retur where kode_barang='$kode_barang' ");
$qty_beli=$conn->query("select SUM(jumlah), nama_barang from pembelian_sementara where kode_barang='$kode_barang' AND id_pembelian IN (SELECT id_pembelian from tabel_pembelian where is_final = 1)")->fetch_array();
$stok_masuk=$conn->query("select SUM(jumlah) from barang_masuk where kode_barang='$kode_barang'")->fetch_array();
$belum_alokasi=$qty_beli[0]-$stok_masuk[0];
?>

                                <table class="table js-exportable-belum_alokasi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>QTY Barang</th>
                                            <th>QTY Sudah Alokasi</th>
                                            <th>QTY Belum Alokasi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><?=$qty_beli[1]?></td>
                                            <td><?=angka($qty_beli[0])?></td>
                                            <td><?=angka($stok_masuk[0])?></td>
                                            <td><?=angka($belum_alokasi)?></td>
                                            <td>Barang Bersumber Dari Pembelian</td>
                                        </tr>                                    
                                    <?php
									$no=2;
                                    while ($x=$stok->fetch_array()) :
									if ($x['kode']==1) {
									$ket='Retur Barang dari No. Faktur '.$x['no_faktur'];
									} else {
									$asal=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$dest=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$x['gudang_tujuan']."'")->fetch_array();
									$ket='Transfer Barang Dari '.$asal[0].' Ke '.$dest[0];
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=angka($x['jumlah_barang'])?></td>
                                            <td><?=angka($x['is_alokasi'])?></td>
                                            <td><?=angka($x['jumlah_barang']-$x['is_alokasi'])?></td>
                                            <td><?=$ket?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-belum_alokasi').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           
<?php
endif;