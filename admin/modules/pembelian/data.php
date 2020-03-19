<?php

include '../../../sysconfig.php';
$id_pembelian=$_GET['id_pembelian'];
$query=$conn->query("select * from pembelian_sementara where id_pembelian='$id_pembelian' ");
$total=$conn->query("select SUM(sub_total) from pembelian_sementara where id_pembelian='$id_pembelian'")->fetch_array();
?>

								<button type="button" id="custId" data-id="<?php echo $id_pembelian;?>" class="btn btn-info waves-effect" data-toggle="modal" data-target="#smallModal" <?php if ($total[0]==0):?>disabled<?php endif;?>>
                                	<i class="fa fa-save fa-2x"></i>
                                	<span>Finalisasi Data</span>
                                </button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<!--<button type="button" class="btn btn-warning waves-effect" onClick="scanAndUploadDirectly();" <?php if ($total[0]==0):?>disabled<?php endif;?>>
                                	<i class="fa fa-qrcode fa-2x"></i>
                                	<span>Scan Invoice</span>
                                </button>-->
                                <br>
                                <div id="server_response"></div>
                                
                                
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NO</th>
											<th>QTY</th>
											<th>KODE</th>
											<th>NAMA BARANG</th>
											<th>HARGA SATUAN</th>
											<th>JUMLAH</th>
											<th>UBAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$no=1;
									while ($q=$query->fetch_array()) { ?>
                                        <tr>
											<td><?=$no++?></td>
											<td><?php echo angka($q['jumlah']); ?></td>
											<td><?php echo $q['kode_barang']; ?></td>
											<td><?php echo $q['nama_barang']; ?></td>
											<td><?php echo angka($q['harga_barang']); ?></td>
											<td><?php echo angka($q['sub_total']); ?></td>
											<td><button onclick="hapus(<?php echo $q['id']; ?>)">Hapus</button></td>
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
			url:'hapus.php',
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


    <script src="class/scanner.js" type="text/javascript"></script>
    <script>
        function scanAndUploadDirectly() {
            scanner.scan(displayServerResponse,
                {
                    "output_settings": [
                        {
                            "type": "upload",
                            "format": "pdf",
                            "upload_target": {
                                "url": "http://<?=$_SERVER['HTTP_HOST']?>/siako/admin/modules/stok/upload.php?action=dump&id_pembelian=<?=$id_pembelian?>",
                                "post_fields": {
                                    "sample-field": "Test scan"
                                },
                                "cookies": document.cookie,
                                "headers": [
                                    "Referer: " + window.location.href,
                                    "User-Agent: " + navigator.userAgent
                                ]
                            }
                        }
                    ]
                }
            );
        }

        function displayServerResponse(successful, mesg, response) {
            if(!successful) { // On error
                document.getElementById('server_response').innerHTML = 'Failed: ' + mesg;
                return;
            }

            if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
                document.getElementById('server_response').innerHTML = 'User cancelled';
                return;
            }

            document.getElementById('server_response').innerHTML = scanner.getUploadResponse(response);
        }
    </script>
    
     <!-- End Scan Plugin -->


