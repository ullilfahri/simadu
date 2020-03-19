<?php
include '../../../sysconfig.php';
$id_trx=$_GET['id_trx'];
$id_gudang=$_GET['id_gudang'];
$kode='2';
$query=$conn->query("SELECT * FROM tabel_retur where id_trx='$id_trx' AND kode = '$kode'");
$ada=$query->num_rows;
$gudang=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi = '$id_gudang' ")->fetch_array();
?>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA TRANSFER BARANG DARI <?=$gudang[0]?>
                                <small><?=$id_trx?></small>
                            </h2>
                        </div>
                        <div class="body">

								<?php if ($ada>0):?>
                                <a href="cetak_transfer.php?id_trx=<?=$id_trx?>">
                                <button type="button" class="btn btn-info waves-effect m-r-20">
                                	<i class="fa fa-folder-open fa-2x"></i>
                                	<span>Finalisasi dan Cetak Surat Jalan Transfer Barang</span>
                                </button>
                                </a>
                                <?php endif;?>
                                
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NO</th>
											<th>KODE BARANG</th>
											<th>NAMA BARANG</th>
											<th>JUMLAH TRANSFER</th>
											<th>ASAL BARANG</th>
											<th>GUDANG TUJUAN</th>
											<th>HAPUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$no=1;
									while ($x=$query->fetch_array()) { 
									$tujuan=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$x['gudang_tujuan']."'")->fetch_array();
									?>
                                        <tr>
											<td><?=$no++?></td>
											<td><?=$x['kode_barang']?></td>
											<td><?=$x['nama_barang']?></td>
											<td><?=$x['jumlah_barang'].' '.$x['satuan']?></td>
											<td><?=$x['pintu_gudang']?></td>
											<td><?=$tujuan[0]?></td>
											<td><button class="btn btn-danger btn-sm waves-effect" onclick="hapus('<?=$x['id']?>', '<?=$id_gudang?>', '<?=$x['kode_barang']?>', '<?=$x['pintu_gudang']?>', '<?=$x['jumlah_barang']?>')">Hapus</button></td>
                                        </tr>
	<?php	
	}
	?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->     


<script>
	function hapus(id, id_gudang, kode_barang, pintu_gudang, jumlah_barang){
		$.ajax({
			type:'POST',
			data:'id='+id+'&id_gudang='+id_gudang+'&kode_barang='+kode_barang+'&pintu_gudang='+pintu_gudang+'&jumlah_barang='+jumlah_barang,
			url:'form_crud.php?hapus_transfer',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				$.notify({icon: 'glyphicon glyphicon-remove',title: '<strong>Penghapusan..!</strong>',message: response.pesan},{type: 'danger'});
				$(".paginasi_transfer").load("paginasi_transfer.php?id_trx=<?=$id_trx?>&id_gudang=<?=$id_gudang?>");
				}
				else
				{
					alert('gagal');
				}
			}
		});
	}
</script>
