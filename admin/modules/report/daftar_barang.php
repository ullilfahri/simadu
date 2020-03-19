<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php 
include MDL.'login/session.php';

if (isset($_GET['ambil_data'])) :

$cari=$_GET['cari'];
$stok=$conn->query("select * from stok_barang where distributor like '%".$_SESSION['distributor']."%' AND nama_barang LIKE '%$cari%' OR distributor like '%".$_SESSION['distributor']."%' AND kode_barang LIKE '%$cari%'");
?>

            <!-- Exportable Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable-beli">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Uraian Barang</th>
                                            <th>Total QTY Beli</th>
                                            <th>Total QTY Terjual</th>
                                            <th>Jumlah Fisik Barang</th>
                                            <th>Total QTY Belum Diambil</th>
                                            <th>QTY Belum Dialokasikan</th>
                                            <th>QTY Jual Belum Finalisasi</th>
                                            <th>QTY Retur</th>
                                            <th>QTY Tersedia</th>
                                            <th>Total Barang</th>
                                            <th>Generate Stock Opname</th>
                                            <th>Detail</th>
                                        </tr>
                                        <tr>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>
                                            <th>11=6-7-9</th>
                                            <th>12=11+8</th>
                                            <th>13</th>
                                            <th>14</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$stok->fetch_array()) :
									$qty_beli=$conn->query("select SUM(jumlah) from pembelian_sementara where kode_barang='".$x['kode_barang']."' AND id_pembelian IN (SELECT id_pembelian from tabel_pembelian where is_final = 1)")->fetch_array();
									$qty_jual=$conn->query("select SUM(jumlah) from tabel_trx where kode_barang='".$x['kode_barang']."' AND no_faktur IN (SELECT no_faktur from tabel_faktur where total_trx > 0)")->fetch_array();
									$alokasi_transfer=$conn->query(" SELECT SUM(`jumlah_barang`)-SUM(`is_alokasi`) FROM `tabel_retur` where kode_barang = '".$x['kode_barang']."' ")->fetch_array();
									
									$stok_masuk=$conn->query("select SUM(jumlah) from barang_masuk where kode_barang='".$x['kode_barang']."'")->fetch_array();
									$stok_fisik=$conn->query(" SELECT SUM(jumlah) FROM alokasi_stok where kode_barang = '".$x['kode_barang']."' ")->fetch_array();
									$belum_alokasi=$qty_beli[0]-$stok_masuk[0]+$alokasi_transfer[0];
									$belum_ambil=$conn->query(" SELECT SUM(`jumlah`)-SUM(`is_ambil`) FROM `barang_keluar` where kode_barang = '".$x['kode_barang']."' ")->fetch_array();
									$keranjang=$conn->query(" SELECT SUM(`jumlah`) FROM `alokasi_stok_jual` where kode_barang = '".$x['kode_barang']."' ")->fetch_array();
									$retur=$conn->query(" SELECT SUM(`jumlah_barang`)-SUM(`is_alokasi`), SUM(`jumlah_barang`) FROM `tabel_retur` where kode_barang = '".$x['kode_barang']."' AND kode=1 ")->fetch_array();
									$transfer=$conn->query(" SELECT SUM(`jumlah_barang`)-SUM(`is_alokasi`) FROM `tabel_retur` where kode_barang = '".$x['kode_barang']."' AND kode=2 ")->fetch_array();
									$belum_final=$conn->query("SELECT SUM(jumlah) FROM tabel_trx WHERE kode_barang = '".$x['kode_barang']."' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE total_trx=0) ")->fetch_array();
									
									
									/* UNTUK PENYESUAIAN STOK */
									$sisa_stok=$stok_fisik[0]-$belum_ambil[0]-$belum_final[0]+$belum_alokasi;
									if ($x['sisa_stok'] == $sisa_stok) {
									$penyesuaian=angka($x['sisa_stok']);
									} else {
									$selisih=$sisa_stok-$x['sisa_stok'];
									$kode=$x['kode_barang'];
									$penyesuaian='<button type="button" class="btn btn-warning waves-effect" onclick="sesuai(\''.$selisih.'\', \''.$kode.'\')">'.angka($selisih).'</button>';
									}
									?>
                                        <tr>
                                            <th scope="row"><?=$no++?></th>
                                            <th scope="row"><?=$x['kode_barang']?></th>
                                            <td><?=$x['nama_barang']?></td>
                                            <th scope="row"><?=angka($qty_beli[0])?></th>
                                            <th scope="row"><?=angka($qty_jual[0])?></th>
                                            <th scope="row"><?=angka($stok_fisik[0])?></th>
                                            <th><a href="javascript:void(0);" data-toggle="modal" data-target="#belum_ambil" data-id="<?=$x['kode_barang'];?>"><?=angka($belum_ambil[0])?></a></th>
                                            <th scope="row"><a href="javascript:void(0);" data-toggle="modal" data-target="#belum_alokasi" data-id="<?=$x['kode_barang'];?>"><?=angka($belum_alokasi)?></a></th>
                                            <th scope="row"><?=angka($belum_final[0])?></th>
                                            <th scope="row"><?=angka($retur[1])?></th>
                                            <th scope="row"><?=angka($stok_fisik[0]-$belum_ambil[0]-$belum_final[0])?></th>
                                            <th scope="row"><?=$penyesuaian?></th>
                                            <td><button type="button" class="btn btn-primary waves-effect" onclick="tes(<?=$x['id']?>)">Generate</button></td>
                                            <td><div class="btn-group" role="group">
                                        		<button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	Rincian
                                            	<span class="caret"></span>
                                        		</button>
                                        			<ul class="dropdown-menu">
                                            			<li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal" data-id="<?=$x['kode_barang'];?>">Pembelian</a></li>
                                            			<li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal2" data-id="<?=$x['kode_barang'];?>">Penjualan</a></li>
                                                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#largeModal3" data-id="<?=$x['kode_barang'];?>">Stok Fisik</a></li>
                                        			</ul>
                                    			</div>
                                            </td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                </table>
                            </div>
            <!-- #END# Exportable Table -->

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

if (isset($_GET['input'])) :

$cari=$_POST['cari'];
$ada=$conn->query("select * from stok_barang where distributor like '%".$_SESSION['distributor']."%' AND nama_barang LIKE '%$cari%' OR distributor like '%".$_SESSION['distributor']."%' AND kode_barang LIKE '%$cari%'")->num_rows;

if ($ada > 0) {
echo json_encode(array('status' =>true, 'pesan' => 'Generate Data Log Barang', 'cari' => $cari));
} else {
echo json_encode(array('error' =>true, 'pesan' => 'Tidak Ada Nama/Kode '.$cari.' Pada Distributor '.$_SESSION['distributor']));
}

endif;
?>