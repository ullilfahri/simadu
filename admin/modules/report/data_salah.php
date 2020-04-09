<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php 
include MDL.'login/session.php';

if (isset($_GET['ambil_data'])) :

$stok=$conn->query("SELECT * FROM `tabel_retur` WHERE `jumlah_barang` < is_alokasi AND distributor= '".$_SESSION['distributor']."' ");
?>

            <!-- Exportable Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable-beli">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User Approve</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Keterangan</th>
                                            <th>Gudang Alokasi</th>
                                            <th>Pintu/Rak/Ruang</th>
                                            <th>Jumlah Barang</th>
                                            <th>QTY Alokasi</th>
                                            <th>QTY Selisih</th>
                                            <th>Penyesuaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$stok->fetch_array()) :
									$user=$conn->query("SELECT nama FROM user where id = '".$x['user_approve']."'")->fetch_array();
									if ($x['kode']==1){
									$ket='Retur Barang, No Faktur '.$x['no_faktur'];
									} else {
									$asal=$conn->query("SELECT nama FROM lokasi where id_lokasi = '".$x['id_gudang']."'")->fetch_array();
									$ket='Transfer dari '.$asal[0];
									}
									
									if ($x['keterangan_lain'] != ''){
									$dis='disabled';
									} else {
									$dis='';
									}
									
									$tujuan=$conn->query("SELECT nama FROM lokasi where id_lokasi = '".$x['gudang_tujuan']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no?></td>
                                            <td><?=$user[0]?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$ket?></td>
                                            <td><?=$tujuan[0]?></td>
                                            <td><?=$x['pintu_tujuan']?></td>
                                            <td><?=angka($x['jumlah_barang'])?></td>
                                            <td><?=angka($x['is_alokasi'])?></td>
                                            <td><?=angka($x['jumlah_barang']-$x['is_alokasi'])?></td>
                                            <td><button class="btn btn-success btn-xs waves-effect" onclick="sesuai('<?=$x['id']?>', '<?=$x['is_alokasi']-$x['jumlah_barang']?>', '<?=$x['kode_barang']?>', '<?=$x['gudang_tujuan']?>', '<?=$x['pintu_tujuan']?>')" <?=$dis?>>Sesuaikan</button></td>
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

$id = $_POST['id'];
$jumlah_barang = $_POST['jumlah_barang'];
$kode_barang = $_POST['kode_barang'];
$id_gudang = $_POST['gudang_tujuan'];
$pintu_gudang = $_POST['pintu_tujuan'];
$keterangan_lain='Dilakukan Perbaikan Sejumlah '.$jumlah_barang;

$update=$conn->query(" UPDATE alokasi_stok SET jumlah=jumlah-$jumlah_barang where id_gudang='$id_gudang' AND pintu_gudang='$pintu_gudang' AND kode_barang='$kode_barang' ");
$update_retur=$conn->query(" UPDATE tabel_retur set is_alokasi=is_alokasi-$jumlah_barang, keterangan_lain='$keterangan_lain' where id='$id' ");

echo json_encode(array('status' =>true, 'pesan' => ''));
endif;
?>