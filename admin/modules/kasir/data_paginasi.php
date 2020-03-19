<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['hari_ini'])) {
	$awal=strtotime(date('Y-m-d 00:00:00'));
	$akhir=strtotime(date('Y-m-d 23:59:59'));
	$small='HARI INI';
	$trx=$conn->query("SELECT * FROM tabel_trx where id_toko LIKE  '%".$_SESSION['toko']."%' AND no_faktur between $awal and $akhir  AND distributor LIKE '%".$_SESSION['distributor']."%' group by distributor,no_faktur ORDER BY no_faktur DESC");
	$url='unggah_dokumen.php?hari_ini';
	$page='hari_ini';
	$uri='hari_ini';
	} else if (isset($_GET['sukses_upload'])){
	$awal=$_GET['no_faktur'];
	$akhir=$_GET['no_faktur'];
	$small='NO FAKTUR '.$awal;
	$trx=$conn->query("SELECT * FROM tabel_trx where id_toko LIKE  '%".$_SESSION['toko']."%' AND no_faktur between $awal and $akhir  AND distributor LIKE '%".$_SESSION['distributor']."%' group by distributor,no_faktur ORDER BY no_faktur DESC");
	$url='unggah_dokumen.php?paginasi=sukses_upload:no_faktur='.$awal;
	$page='sukses_upload:no_faktur='.$awal;
	$uri='sukses_upload&no_faktur='.$awal;
	} else if (isset($_GET['akses_kunci'])){
	$id=$_GET['id'];
	$trx=$conn->query("SELECT * FROM tabel_trx where id = '$id'");
	$small='';
	} else {
	$date_1 = date_create_from_format('d-m-Y', $_GET['date_1']);
	$date_1=date_format($date_1, 'Y-m-d 00:00:00');
	$tgl_1=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_1']), 'Y-m-d'));
	$awal=strtotime($date_1);
	$date_2 = date_create_from_format('d-m-Y', $_GET['date_2']);
	$date_2=date_format($date_2, 'Y-m-d 23:59:59');
	$tgl_2=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_2']), 'Y-m-d'));
	$akhir=strtotime($date_2);
	$small=$tgl_1.' s/d '.$tgl_2;
	$trx=$conn->query("SELECT * FROM tabel_trx where id_toko LIKE  '%".$_SESSION['toko']."%' AND no_faktur between $awal and $akhir  AND distributor LIKE '%".$_SESSION['distributor']."%' group by distributor,no_faktur ORDER BY no_faktur DESC");
	$url='unggah_dokumen.php?paginasi=cari_tanggal:date_1='. $_GET['date_1'].':date_2='.$_GET['date_2'];
	$page='cari_tanggal:date_1='. $_GET['date_1'].':date_2='.$_GET['date_2'];
	$uri='cari_tanggal&date_1='. $_GET['date_1'].'&date_2='.$_GET['date_2'];
	}
	

if ($_SESSION['level']==3) {
	$tutup='';
	$kunci='disabled';
	} else if ($_SESSION['level']==6) {
	$tutup='';
	$kunci='';
	} else {
	$tutup='disabled';
	$kunci='disabled';
	}

?>            
            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SUMMMARY PENJUALAN
                            </h2>
                            <small>Periode <?=$small?></small>
                        </div>
                        <div class="body">
<div class="overlay"></div>                           
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="data-table-example4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Arsip Penjualan</th>
                                            <th>Distributor</th>
                                            <th>No Faktur</th>
                                            <th>Outlet</th>
                                            <th>Customer</th>
                                            <th>Rincian Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['id_toko']."'")->fetch_array();
									
									
                                    $inv=$conn->query("SELECT COUNT(*), file from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' and id_jenis='1'")->fetch_array();
									if ($inv[0] == 0) {
									 $file='<li class="font-line-through col-pink"><a href="javascript:void(0);">Faktur Penjualan Belum Diupload</a></li>';
									 } else {
									 $file='<li class="font-bold col-blue-grey"><a href="../pdf_viewer/dari_kasir.php?dir=penjualan&file='.$inv[1].'" target="_blank">Faktur Penjualan</a></li>';
									 }
									 
									$ada_retur=$conn->query(" SELECT * FROM tabel_retur WHERE kode=1 AND no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' ")->num_rows;
									if ($ada_retur > 0) {
										$retur=$conn->query("SELECT COUNT(*), file from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' and id_jenis='3'")->fetch_array();
										$file_retur=$ada_retur;
										$file_retur_upload=$retur[0];			
										if ($retur[0] == 0) {
									 		$file3='<li class="font-line-through col-blue-grey"><a href="javascript:void(0);">Bukti Retur Belum diupload</a></li>';
									 		} else {
									 		$file3='<li class="font-bold col-pink"><a href="../pdf_viewer/bukti_retur.php?dir=penjualan&no_faktur='.$x['no_faktur'].'" target="_blank">Bukti Retur</a></li>';
									 	}
									} else {
									$file3='';
									$file_retur=0;
									$file_retur_upload=0;
									}	

									 
									 $invoice=1;
									 $invoice_upload=$conn->query("SELECT * from tabel_arsip where no_faktur = '".$x['no_faktur']."' AND distributor = '".$x['distributor']."' AND id_jenis = 1 ")->num_rows;
									
									 
									  $progress=round(($invoice_upload+$file_retur_upload)/($invoice+$file_retur)*100,2);
									 
									  $dis=$conn->query("SELECT pengguna from mst_hak_akses where kode = '".$x['distributor']."' ")->fetch_array();
									  
									  if ($x['kunci']==0) {
									  	$lock='';
										$tombol_lock='
										<button type="button"  class="btn btn-warning waves-effect m-r-17" onclick="tutup_kunci('.$x['id'].')"'.$kunci.'><i class="fa fa-unlock fa-lg"></i></button>
										';
									  	} else {
										$lock='disabled';
										$tombol_lock='
										<button type="button" onclick="buka_kunci('.$x['id'].')" class="btn btn-danger waves-effect m-r-17" '.$kunci.'><i class="fa fa-lock fa-lg"></i></button>
										';
										}
									
									$toko=$conn->query("SELECT * FROM lokasi where id_lokasi = '".$x['id_toko']."' ")->fetch_array();
									$y=$conn->query("SELECT customer, cus_umum FROM tabel_faktur where no_faktur='".$x['no_faktur']."' AND id_toko = '".$x['id_toko']."' ")->fetch_array();
									if ($y[0] > 0) {
										$arr=$conn->query("SELECT nama FROM tabel_customer WHERE id = '$y[0]' ")->fetch_array();
										$customer=$arr[0];
										} else {
										$arr = json_decode($y[1], true);
										$customer='UMUM ['.$arr["umum"]["nama"].']';
										}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                            <?=$tombol_lock?>
                                           <button type="button" class="btn btn-info waves-effect m-r-18" data-toggle="modal" data-target=".upload" data-id="<?=$x['no_faktur'].'#'.$x['distributor'].'#'.$page?>" <?=$tutup.' '.$lock?> ><i class="fa fa-upload fa-lg"></i>Upload</button>
                                            
                                            <div class="btn-group dropdowns">
                                            <button type="button" class="btn btn-success waves-effect m-r-18 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            	<span class="caret"></span>
                                                <span class="sr-only">Arsip Penjualan *</span>
                                            </button>
                                            	<ul class="dropdown-menu">
                                                	<?=$file?>
                                                    <?=$file3?>
                                                </ul>
                                            </div>
                                            <br><br />
                            				<div class="progress">
                               			 	<div class="progress-bar bg-orange progress-bar-striped active " role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%"><p class="font-bold col-pink"><?=$progress?> %</p></div></div>                                            
											</td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$toko['nama']?></td>
                                            <td><?=$customer?></td>
                                            <td><button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target=".edit" data-id="<?=$x['no_faktur'].'#'.$x['distributor']?>">Rincian Barang</button></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
            <!-- Blockquotes --> 
                        <div class="body">
                            <blockquote>
                                <p class="font-bold font-italic font-underline col-black">*) Keterangan (Arsip Penjualan)</p>
                                <footer>Arsip/Dokumen Penjualan terdiri dari <cite title="Source Title"><strong>Faktur Penjualan</strong></cite> yang diunggah oleh Admin Toko</footer>
                                <footer>Dokumen Faktur Pajak Penjualan diakses pada menu Pajak</footer>
                                <footer>Semua dokumen penjualan juga dapat dipantau di menu <strong>Pajak</strong>, memungkinkan bagi Admin Pajak dan Distributor memantau Progress</footer>
                                <footer>Khusus <strong>Supervisor</strong>, Membuka dan Menutup Akses File dengan Menekan Tombol Ikon Paling Kiri</footer>
                            </blockquote>
                        </div>
            <!-- #END# Blockquotes -->   
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->   
            
<script language="javascript">
$(function () {
     var table = $('#data-table-example4').DataTable({
                dom: 'Bfrtip',
				responsive: true,
				buttons: ['copy', 'csv', 'excel']
            });
            // Apply the search
            $("#data-table-example4 thead th input[type=text]").on( 'keyup change', function () {
	    	
	        table
	            .column( $(this).closest('th').index()+':visible' )
	            .search( this.value )
	            .draw();
	            
	    });
            // Apply the search
            $("#data-table-example4 thead th select").on('change', function () {
	    	
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

	        table
	            .column( $(this).closest('th').index()+':visible' )
	            .search( val ? '^'+val+'$' : '', true, false )
	            .draw();
	            
	    } );
});
</script>

<script>
	function tutup_kunci(id){
		$.ajax({
			type:'POST',
			data:'id='+id,
			url:'../global/update.php?tutup_kunci&tabel=tabel_trx&jenis_id=id&url=<?=$uri?>',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				swal("Sukses!", 'Akses File Ditutup', "info");
				$('.data_paginasi').load('data_paginasi.php?<?=$uri?>');
				} else {
					alert('gagal');
				}
			}
		});
	}
</script>
<script>
	function buka_kunci(id){
		$.ajax({
			type:'POST',
			data:'id='+id,
			url:'../global/update.php?buka_kunci&tabel=tabel_trx&jenis_id=id&url=<?=$uri?>',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				//swal({ title: "Sip!", text: "Akses File Dibuka..!", type: "success", timer: 1000, showConfirmButton: false }, function(){ window.location.href = response.url; });
				swal("Sukses!", 'Akses File Dibuka', "success");
				$('.data_paginasi').load('data_paginasi.php?<?=$uri?>');
				} else {
					alert('gagal');
				}
			}
		});
	}
</script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.upload').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?modal_upload',
                data :  'rowid='+ rowid ,
                success : function(data){
                $('.fetched-upload').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

            