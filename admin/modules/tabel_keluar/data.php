<?php
include '../../../sysconfig.php';
$id_pembelian=$_GET['id_pembelian'];
$query=$conn->query("select * from pengeluaran_sementara where id_pembelian='$id_pembelian' ");
$total=$conn->query("select SUM(sub_total) from pengeluaran_sementara where id_pembelian='$id_pembelian'")->fetch_array();
?>

								<button type="button" id="custId" data-id="<?php echo $id_pembelian;?>" class="btn btn-info waves-effect" data-toggle="modal" data-target="#largeModal" <?php if ($total[0]==0):?>disabled<?php endif;?>>
                                	<i class="fa fa-save fa-2x"></i>
                                	<span>Finalisasi Data</span>
                                </button>
                                <br><br>
                                
                                
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable data_pengeluaran">
                                    <thead>
                                        <tr>
											<th>NO</th>
											<th>KODE</th>
											<th>QTY</th>
											<th>NAMA BARANG</th>
											<th>HARGA SATUAN</th>
											<th>JUMLAH</th>
											<th>KETERANGAN</th>
											<th>HAPUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$no=1;
									while ($q=$query->fetch_array()) { ?>
                                        <tr>
											<td><?=$no++?></td>
											<td><?php echo $q['kode_barang']; ?></td>
											<td>
                                            <a href="#" class="live_edit" data-name="jumlah" data-type="text" data-pk="<?=$q['id']?>" data-title="QTY"><?=angka($q['jumlah'])?></a>
                                            </td>
											<td><?php echo $q['nama_barang']; ?></td>
											<td>
                                            <a href="#" class="live_edit" data-name="harga_barang" data-type="text" data-pk="<?=$q['id']?>" data-title="Harga Satuan"><?=angka($q['harga_barang'])?></a>
                                            </td>
											<td><?php echo angka($q['sub_total']); ?></td>
											<td>
											<a href="#" class="edit_keterangan" data-name="keterangan" data-type="text" data-pk="<?=$q['id']?>" data-title="Keterangan"><?=$q['keterangan']?></a>
                                            </td>
											<td><button class="btn bg-red btn-block btn-sm waves-effect" onClick="hapus(<?php echo $q['id']; ?>)">Hapus</button></td>
                                        </tr>
	<?php	
	}
	?>
                                    </tbody>
                                </table>
                            </div>


<script>
	function hapus(id){
		$.ajax({
			type:'POST',
			data:'id='+id,
			url:'form_crud.php?hapus_daftar_pengeluaran',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				$.notify({icon: 'glyphicon glyphicon-warning-sign',title: '<strong>Hapus..!</strong>',message: 'Data Dihapus..'},{type: 'danger'});
				$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
				}
				else
				{
					alert('gagal');
				}
			}
		});
	}
</script>

<script>
$(function () {
    $('.data_pengeluaran').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

<script type="text/javascript">
    $('.live_edit').editable({
           url: 'form_crud.php?live_edit',
           type: 'text',
           pk: 1,
           name: 'name',
		   tpl: "<input type='text' class='uang'>",
           title: 'Enter name',
		   success:function(result){
		   		var response = JSON.parse(result);
				$.notify({icon: 'glyphicon glyphicon-warning-sign',title: '<strong>Update..!</strong>',message: response.pesan},{type: 'info'});
				$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
		   }
    });	
	
</script>
<script type="text/javascript">
    $('.edit_keterangan').editable({
           url: 'form_crud.php?live_edit',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name',
		   success:function(result){
		   		var response = JSON.parse(result);
				$.notify({icon: 'glyphicon glyphicon-warning-sign',title: '<strong>Update..!</strong>',message: response.pesan},{type: 'info'});
				$(".list-data").load("data.php?id_pembelian=<?=$id_pembelian?>");
		   }
    });	
	
</script>

<script src="<?=PLG?>jmask/jquery.mask.min.js"></script>                           
<script type="text/javascript">
            $(document).ready(function(){
                $( '.uang' ).mask('000.000.000', {reverse: true});
            })
</script>


