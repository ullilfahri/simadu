
<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';

$uri=$_GET['uri'];

if ($uri=='hari_ini') {
	$awal=strtotime(date('Y-m-d 00:00:00'));
	$akhir=strtotime(date('Y-m-d 23:59:59'));
	$small='Hari ini';
	$trx=$conn->query("SELECT * FROM ambil_barang where id_gudang LIKE '%".$_SESSION['gudang']."%' AND id_pengambilan between $awal and $akhir  AND is_final=1 GROUP BY distributor,id_pengambilan ORDER BY id_barang_keluar ASC");
	$url='data_paginasi.php?uri=hari_ini';
	$modal_uri='uri=hari_ini';
	} else if ($uri=='sukses_upload') {
	$awal=$_GET['no_faktur'];
	$akhir=$_GET['no_faktur'];
	$trx=$conn->query("SELECT * FROM ambil_barang where id_gudang LIKE '%".$_SESSION['gudang']."%' AND id_barang_keluar IN (select id from barang_keluar where no_faktur between $awal and $akhir)  AND is_final=1 GROUP BY distributor,id_pengambilan");
	$small='Nomor Faktur '.$awal;
	$url='data_paginasi.php?uri=sukses_upload&no_faktur='.$awal;
	$modal_uri='uri=sukses_upload:no_faktur='.$awal;
	} else if ($uri=='cari_tanggal') {
	$date_1 = date_create_from_format('d-m-Y', $_GET['date_1']);
	$date_1=date_format($date_1, 'Y-m-d 00:00:00');
	$tgl_1=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_1']), 'Y-m-d'));
	$awal=strtotime($date_1);
	$date_2 = date_create_from_format('d-m-Y', $_GET['date_2']);
	$date_2=date_format($date_2, 'Y-m-d 23:59:59');
	$tgl_2=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_2']), 'Y-m-d'));
	$akhir=strtotime($date_2);
	$trx=$conn->query("SELECT * FROM ambil_barang where id_gudang LIKE '%".$_SESSION['gudang']."%' AND id_pengambilan between $awal and $akhir  AND is_final=1  GROUP BY distributor,id_pengambilan ORDER BY id_pengambilan DESC");
	$small='Periode '.$tgl_1.' sd. '.$tgl_2;
	$url='data_paginasi.php?uri=cari_tanggal&date_1='.$_GET['date_1'].'&date_2='.$_GET['date_2'];
	$modal_uri='uri=cari_tanggal:date_1='.$_GET['date_1'].':date_2='.$_GET['date_2'];
	} else {
	$id=$_GET['id'];
	$trx=$conn->query("SELECT * FROM tabel_trx where id = '$id'");
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
                                SUMMMARY PENJUALAN
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
                                            <th>Arsip Penjualan</th>
                                            <th>Distributor</th>
                                            <th>No Faktur</th>
                                            <th>Customer</th>
                                            <th>No Surat Jalan</th>
                                            <th>Asal Barang</th>
                                            <th>Outlet Penjualan</th>
                                            <th>Status Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									
									 $y=$conn->query("SELECT * FROM barang_keluar where id = '".$x['id_barang_keluar']."' ")->fetch_array();
									 
									 $z=$conn->query("SELECT id_toko FROM tabel_trx where no_faktur = '".$y['no_faktur']."' ")->fetch_array();
									 
									 $toko=$conn->query("SELECT nama FROM lokasi where id_lokasi = '".$z[0]."' ")->fetch_array();
									 
									 
									$fak=$conn->query("SELECT COUNT(*), file from tabel_arsip where distributor = '".$x['distributor']."' and id_jenis='2' AND id_trx = '".$x['id_pengambilan']."' ")->fetch_array();
									if ($fak[0] > 0) {
									 $status='<span class="glyphicon glyphicon-ok"></span>';
									 $ena='';
									 } else {
									 $status='<span class="glyphicon glyphicon-remove"></span>';
									 $ena='disabled';
									 }
									 
									  $dis=$conn->query("SELECT pengguna from mst_hak_akses where kode = '".$x['distributor']."' ")->fetch_array();

									  if ($x['kunci']==0) {
									  	$lock='';
										$tombol_lock='
										<button type="button" onclick="tutup_kunci('.$x['id'].')" class="btn btn-warning waves-effect m-r-17" '.$kunci.'><i class="fa fa-unlock fa-lg"></i></button>
										';
									  	} else {
										$lock='disabled';
										$tombol_lock='
										<button type="button" onclick="buka_kunci('.$x['id'].')" class="btn btn-danger waves-effect m-r-17" '.$kunci.'><i class="fa fa-lock fa-lg"></i></button>
										';
										}
										
										if ($x['partial'] > 0) {
										$no_surat=$y['no_faktur'].'-'.surat_jalan($x['partial']);
										} else {
										$no_surat=$y['no_faktur'];
										}
									$gdg=$conn->query("SELECT * FROM lokasi where id_lokasi = '".$x['id_gudang']."' ")->fetch_array();

									$pelanggan=$conn->query("SELECT customer, cus_umum FROM tabel_faktur where no_faktur='".$y['no_faktur']."' AND id_toko = '".$z[0]."' ")->fetch_array();
									if ($pelanggan[0] > 0) {
										$arr=$conn->query("SELECT nama FROM tabel_customer WHERE id = '$pelanggan[0]' ")->fetch_array();
										$customer=$arr[0];
										} else {
										$arr = json_decode($pelanggan[1], true);
										$customer='UMUM ['.$arr["umum"]["nama"].']';
										}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                           <?=$tombol_lock?> 
                                           <button type="button" class="btn btn-info waves-effect m-r-17" data-toggle="modal" data-target=".upload" data-id="<?=$y['no_faktur'].'#'.$x['distributor'].'#'.$x['id_pengambilan']?>" <?=$tutup.' '.$lock?>><i class="fa fa-upload fa-lg"></i>Upload</button>
                                           <a href="../pdf_viewer/dari_kasir.php?dir=penjualan&file=<?=$fak[1]?>" target="_blank"><button type="button" class="btn btn-success waves-effect m-r-17" <?=$ena?>><i class="fa fa-file fa-lg"></i>File</button></a>
											</td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$y['no_faktur']?></td>
                                            <td><?=$customer?></td>
                                            <td><?=$no_surat?></td>
                                            <td><?=$gdg['nama']?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=$status?></td>
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
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Upload Dokumen Penjualan</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-upload"></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                        	<i class="fa fa-times"></i><span>Tutup</span>
                          </button>
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
			url:'../global/update.php?tutup_kunci&tabel=ambil_barang&jenis_id=id&url=<?=$url?>',
			success:function(result){
				var response = JSON.parse(result);
				if (response.status){
				$('.data_paginasi').load('<?=$url?>');
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
		url:'../global/update.php?buka_kunci&tabel=ambil_barang&jenis_id=id&url=<?=$url?>',
		type     : 'POST',
		dataType : 'html',
		data     : 'id='+id,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			$('.data_paginasi').load('<?=$url?>');
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
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'upload.php?modal_upload&<?=$modal_uri?>',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-upload').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

