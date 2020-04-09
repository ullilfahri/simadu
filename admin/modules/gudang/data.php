<?php
include '../../../sysconfig.php';
$id_pengambilan=$_GET['id_pengambilan'];
$query=$conn->query("select SUM(a.jumlah_ambil), b.satuan, b.nama_barang, b.no_faktur, a.id, a.id_barang_keluar, b.jumlah from ambil_barang as a left join barang_keluar as b on a.id_barang_keluar = b.id where a.id_pengambilan='$id_pengambilan' GROUP BY a.id_pengambilan, a.id_barang_keluar");
$ada=$query->num_rows;
?>
								<?php if ($ada > 0):?>
								<a href="cetak.php?id_pengambilan=<?=$id_pengambilan?>&cetak_langsung" ><button type="button" class="btn btn-info waves-effect">
                                	<i class="fa fa-print fa-2x"></i>
                                	<span>Cetak Surat Jalan</span>
                                </button></a>
                                <?php endif;?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NO</th>
											<th>FAKTUR PEMBELIAN</th>
											<th>NAMA BARANG</th>
											<th>JUMLAH PEMBELIAN</th>
											<th>JUMLAH PENGAMBILAN</th>
											<th>JUMLAH BELUM DIAMBIL</th>
											<th>HAPUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$no=1;
									while ($q=$query->fetch_array()) { 
									$s=$conn->query("select jumlah, is_ambil from barang_keluar where id='".$q[5]."'")->fetch_array();
									$sisa=$s[0]-$s[1];
									?>
                                        <tr>
											<td><?=$no++?></td>
											<td><?php echo $q[3]; ?></td>
											<td><?php echo $q[2]; ?></td>
											<td><?php echo $q[6].' '.$q[1]; ?></td>
											<td><?php echo $q[0].' '.$q[1]; ?></td>
											<td><?php echo $sisa.' '.$q[1]; ?></td>
											<td><button onclick="hapus(<?php echo $q[4]; ?>)">Hapus</button></td>
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
					$.notify({icon: 'glyphicon glyphicon-warning-sign',title: '<strong>Hapus..!</strong>',message: 'Data Terhapus'},{type: 'danger'});
				$(".list-data").load("data.php?id_pengambilan=<?=$id_pengambilan?>");
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

