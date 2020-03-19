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
?>

