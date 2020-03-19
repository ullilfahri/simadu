<?php
include '../../../sysconfig.php';
$no_faktur=$_GET['no_faktur'];
$query=$conn->query("select * from tabel_trx where no_faktur='$no_faktur' ");
$total=$conn->query("select SUM(sub_total) from tabel_trx where no_faktur='$no_faktur'")->fetch_array();
?>

								<button type="button" id="custId" data-id="<?php echo $no_faktur;?>" class="btn btn-info waves-effect" data-toggle="modal" data-target="#smallModal" <?php if ($total[0]==0):?>disabled<?php endif;?>>
                                	<i class="fa fa-print fa-2x"></i>
                                	<span>Cetak Struk</span>
                                </button>
                                
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NO</th>
											<th>QTY</th>
											<th>KODE</th>
											<th>NAMA BARANG</th>
											<th>HARGA SATUAN</th>
                                            <th>POTONGAN</th>
											<th>JUMLAH</th>
											<th>DARI STOK</th>
											<th>KETERANGAN *</th>
											<th>HAPUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$no=1;
									while ($q=$query->fetch_array()) { 
									$gudang=$conn->query("select * from lokasi where id_lokasi='".$q['id_gudang']."'")->fetch_array();
									$pintu=$conn->query("select pintu_gudang from alokasi_stok where id='".$q['id_alokasi']."'")->fetch_array();
									?>
                                        <tr>
											<td><?=$no++?></td>
											<td><?php echo $q['jumlah']; ?></td>
											<td><?php echo $q['kode_barang']; ?></td>
											<td><?php echo $q['nama_barang']; ?></td>
											<td><?php echo angka($q['harga_barang']); ?></td>
                                            <td><?php echo angka($q['potongan']); ?></td>
											<td><?php echo angka($q['sub_total']); ?></td>
											<td><?php echo $gudang['nama'].', '.$pintu[0]?></td>
											<td><?php echo $q['keterangan']; ?></td>
											<td><button onclick="hapus(<?php echo $q['id']; ?>)">Hapus</button></td>
                                        </tr>
	<?php	
	}
	?>
                                    </tbody>
                                </table>
                            </div>





<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Apakah Anda yakin tidak mencetak struk pada Transaksi ini?</h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Yakin</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal Delete-->

<script>
	function hapus(id){
		$.ajax({
			type:'POST',
			data:'id='+id,
			url:'hapus.php',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				$.notify({icon: 'glyphicon glyphicon-warning-sign',title: '<strong>Hapus..!</strong>',message: 'Data Dihapus..'},{type: 'danger'});
				$(".list-data").load("data.php?no_faktur=<?=$no_faktur?>");
				}
				else
				{
					alert('gagal');
				}
			}
		});
	}
</script>

    
<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
<!--Akhir Javasrip Modal Delete--> 

