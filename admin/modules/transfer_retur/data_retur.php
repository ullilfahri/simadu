<?php
include '../../../sysconfig.php';
$id_trx=$_GET['id_trx'];
$kode=$_GET['kode'];
$query=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx' AND kode = '$kode'");
$ada=$query->num_rows;
?>

								<?php if ($ada>0):?>
                                <button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">
                                	<i class="fa fa-folder-open fa-2x"></i>
                                	<span>Finalisasi dan Cetak Bukti Retur Barang</span>
                                </button>
                                <?php endif;?>
                                
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NO</th>
											<th>NO FAKTUR</th>
											<th>NAMA BARANG</th>
											<th>JUMLAH PENGEMBALIAN</th>
											<th>HAPUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$no=1;
									while ($x=$query->fetch_array()) { 
									?>
                                        <tr>
											<td><?=$no++?></td>
											<td><?=$x['no_faktur']?></td>
											<td><?=$x['nama_barang']?></td>
											<td><?=$x['jumlah_barang'].' '.$x['satuan']?></td>
											<td><button class="btn btn-danger btn-sm waves-effect" onclick="hapus('<?=$x['id']?>', '<?=$x['jumlah_barang']?>', '<?=$x['kode_barang']?>')">Hapus</button></td>
                                        </tr>
	<?php	
	}
	?>
                                    </tbody>
                                </table>
                            </div>




<script>
	function hapus(id, jumlah_barang, kode_barang){
		$.ajax({
			type:'POST',
			data:'id='+id+'&jumlah_barang='+jumlah_barang+'&kode_barang='+kode_barang,
			url:'hapus.php',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
					$.notify({icon: 'glyphicon glyphicon-remove',title: '<strong>Penghapusan..!</strong>',message: 'Data Dihapus'},{type: 'danger'});
				$(".list-data").load("data_retur.php?id_trx=<?=$id_trx?>&kode=1");
				}
				else
				{
					alert('gagal');
				}
			}
		});
	}
</script>
