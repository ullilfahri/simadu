
<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';

$uri=$_GET['uri'];

if ($uri=='hari_ini') {
	$awal=strtotime(date('Y-m-d 00:00:00'));
	$akhir=strtotime(date('Y-m-d 23:59:59'));
	$small='Hari ini';
	$trx=$conn->query("SELECT * FROM tabel_retur where id_gudang LIKE '%".$_SESSION['gudang']."%' AND id_trx between $awal and $akhir  AND kode=2 OR gudang_tujuan LIKE '%".$_SESSION['gudang']."%' AND id_trx between $awal and $akhir  AND kode=2 ORDER BY id_trx ASC");
	$url='paginasi_transfer.php?uri=hari_ini';
	$modal_uri='menu:uri=hari_ini';
	} else if ($uri=='sukses_upload') {
	$awal=$_GET['no_faktur'];
	$akhir=$_GET['no_faktur'];
	$trx=$conn->query("SELECT * FROM tabel_retur where id_gudang LIKE '%".$_SESSION['gudang']."%' AND id_trx between $awal and $akhir  AND kode=2 OR gudang_tujuan LIKE '%".$_SESSION['gudang']."%' AND id_trx between $awal and $akhir  AND kode=2 ORDER BY id_trx ASC");
	$small='Nomor Surat Transfer '.$awal;
	$url='paginasi_transfer.php?uri=sukses_upload&no_faktur='.$awal;
	$modal_uri='menu=sukses_upload:uri=sukses_upload:no_faktur='.$awal;
	} else if ($uri=='cari_tanggal') {
	$date_1 = date_create_from_format('d-m-Y', $_GET['date_1']);
	$date_1=date_format($date_1, 'Y-m-d 00:00:00');
	$tgl_1=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_1']), 'Y-m-d'));
	$awal=strtotime($date_1);
	$date_2 = date_create_from_format('d-m-Y', $_GET['date_2']);
	$date_2=date_format($date_2, 'Y-m-d 23:59:59');
	$tgl_2=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_2']), 'Y-m-d'));
	$akhir=strtotime($date_2);
	$trx=$conn->query("SELECT * FROM tabel_retur where id_gudang LIKE '%".$_SESSION['gudang']."%' AND id_trx between $awal and $akhir  AND kode=2 OR gudang_tujuan LIKE '%".$_SESSION['gudang']."%' AND id_trx between $awal and $akhir  AND kode=2 ORDER BY id_trx ASC");
	$small='Periode '.$tgl_1.' sd. '.$tgl_2;
	$url='paginasi_transfer.php?uri=cari_tanggal&date_1='.$_GET['date_1'].'&date_2='.$_GET['date_2'];
	$modal_uri='menu=cari_tanggal:uri=cari_tanggal:date_1='.$_GET['date_1'].':date_2='.$_GET['date_2'];
	} else {
	$id=$_GET['id'];
	$trx=$conn->query("SELECT * FROM tabel_retur where id = '$id'");
	$small='';
	}
	

if ($_SESSION['level']==4) {
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
                                SUMMMARY TRANSFER BARANG
                                <small><?=$small?></small>
                            </h2>
                        </div>
                        <div class="body">
<div class="overlay"></div>                           
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="data-table-example4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Surat Jalan</th>
                                            <th>Tanggal Transfer</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>QTY Transfer</th>
                                            <th>Gudang Asal</th>
                                            <th>Pintu/Ruang/Sekat Gudang Asal</th>
                                            <th>Gudang Tujuan</th>
                                            <th>Pintu/Ruang/Sekat Gudang Tujuan</th>
                                            <th>Status Alokasi</th>
                                            <th>Distributor</th>
                                            <th>Arsip Transfer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									  if ($x['proses']==0) {
										$ijin='';
										$tombol_lock='
										<button type="button" onclick="tutup_kunci('.$x['id'].')" class="btn btn-warning waves-effect" '.$kunci.'><i class="fa fa-unlock fa-lg"></i></button>
										';
									  	} else {
										$ijin='disabled';
										$tombol_lock='
										<button type="button" onclick="buka_kunci('.$x['id'].')" class="btn btn-danger waves-effect" '.$kunci.'><i class="fa fa-lock fa-lg"></i></button>
										';
										}
										
										$asal=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$x['id_gudang']."'")->fetch_array();
										$tujuan=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='".$x['gudang_tujuan']."'")->fetch_array();
										
										if ($x['jumlah_barang']-$x['is_alokasi']==0) {
											$status='Complete';
											} else {
											$status=$x['jumlah_barang']-$x['is_alokasi'].' '.$x['satuan'].' Belum Dialokasi';
											}
										
										if ($_SESSION['level']==6 || $_SESSION['gudang']==$x['id_gudang']) {
											$akses='';
											} else {
											$akses='disabled';
											}

										$ada_arsip=$conn->query("SELECT file FROM `tabel_arsip` WHERE `id_jenis`=12 AND `id_trx`='".$x['id_trx']."'")->fetch_array();
										if ($ada_arsip[0]==0) {
											$href='javascript:void(0);';
											$target='';
											$disabled='disabled';
											} else {
											$target='_blank';
											$disabled='';
											$href='../pdf_viewer/index.php?dir=file_transfer_retur&file='.$ada_arsip[0];
											}
										
										
											
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['id_trx']?></td>
                                            <td><?=tanggal_indo(date('Y-m-d',$x['id_trx']))?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah_barang'].' '.$x['satuan']?></td>
                                            <td><?=$asal[0]?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$tujuan[0]?></td>
                                            <td><?=$x['pintu_tujuan']?></td>
                                            <td><?=$status?></td>
                                            <td><?=$x['distributor']?></td>
                                            <td>
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            	<div class="btn-group" role="group" aria-label="First group">
                                           		<?=$tombol_lock?> 
                                            	</div>
                                                <div class="btn-group" role="group" aria-label="Second group">
                                                <button type="button" class="btn btn-info waves-effect" data-toggle="modal" data-target=".upload" data-id="<?=$x['id_trx']?>" data-distributor="<?=$x['distributor']?>" data-uri="<?=$modal_uri?>"  <?=$akses?> <?=$ijin?>><i class="fa fa-upload fa-lg"></i></button>
                                                </div>
                                                <div class="btn-group" role="group" aria-label="Third group">
                                                <a href="<?=$href?>" target="<?=$target?>">
                                                <button type="button" class="btn btn-success waves-effect" <?=$disabled?>><i class="fa fa-file-text-o fa-lg"></i></button>
                                                </a>
                                                </div>
                                            </div>
											</td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
<!--MODAL EDIT-->        
				<div class="modal fade upload" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Upload Dokumen Transfer</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-upload"></div>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT--> 
                            
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
			url:'upload_transfer.php?tutup_kunci&tabel=tabel_retur&jenis_id=id&url=<?=$url?>',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				$('.paginasi_transfer').load('<?=$url?>');
				$.notify({icon: 'glyphicon glyphicon-warning-sign',title: '<strong>File Ditutup..!</strong>',message: 'Akses File Ditutup'},{type: 'danger'});
				}
				else
				{
					alert('gagal');
				}
			}
		});
	}
</script>


<script type="application/javascript">
 function buka_kunci(id){
    swal({
        title: "Buka Akses File?",
        text: "Tekan OK untuk Membuka Akses File",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function () {
        $.ajax({
		url:'upload_transfer.php?buka_kunci&tabel=tabel_retur&jenis_id=id&url=<?=$url?>',
		type     : 'POST',
		dataType : 'html',
		data     : 'id='+id,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			$('.paginasi_transfer').load('<?=$url?>');
			swal("Sukses!", 'Akses File Dibuka', "success");
			} else if (response.error){
			swal("Gagal!", 'Gagal Buka Kunci', "error");
			} else {
			swal("Gagal!", 'Gagal Buka Kunci', "error");
			}
		},
	})
    });
}
</script>

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.upload').on('show.bs.modal', function (e) {
            var id_trx = $(e.relatedTarget).data('id');
			var distributor = $(e.relatedTarget).data('distributor');
			var uri = $(e.relatedTarget).data('uri');
            $.ajax({
                type : 'post',
                url : 'upload_transfer.php?modal_upload',
                data :  'id_trx='+id_trx+'&distributor='+distributor+'&uri='+uri,
                success : function(data){
                $('.fetched-upload').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->


