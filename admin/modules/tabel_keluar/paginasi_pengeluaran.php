<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['metode'])) :

$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d',$awal);
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d',$akhir);

$hutang=$conn->query("select * from tabel_pengeluaran where distributor like '%".$_SESSION['distributor']."%' AND id_pembelian BETWEEN $awal and $akhir order by id_pembelian ASC");

if ($_GET['metode']=="hari_ini") {
	$judul="HARI INI";
	} else {
	$judul=tanggal_indo($tgl_awal).' Sampai Dengan '.tanggal_indo($tgl_akhir);
	}

?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PENGELUARAN
                                <small>Periode <?=$judul?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="data-table-example4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier</th>
                                            <th>No Innvoice</th>
                                            <th>Tanggal Invoice</th>
                                            <th>Total Pembelian</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Rincian Barang/Jasa</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$hutang->fetch_array()) :
									$supplier=$conn->query(" SELECT nama from tabel_supplier where id='".$x['supplier']."' ")->fetch_array();
									if ($x['metode_bayar']==1) {
										$stts="Pembayaran Mundur";
										$jatuh_tempo=tanggal_indo($x['jatuh_tempo']);
										} else {
										$stts="Pembayaran Cash";
										$jatuh_tempo='-';
										}
									$ada_1=$conn->query("SELECT COUNT(a.id), a.file, b.php_pdf FROM tabel_arsip AS a LEFT JOIN jenis_arsip AS b ON a.id_jenis=b.id WHERE a.id_jenis=8 AND a.distributor='".$x['distributor']."' AND a.id_trx='".$x['id_pembelian']."'")->fetch_array();
									$ada_2=$conn->query("SELECT COUNT(a.id), a.file, b.php_pdf FROM tabel_arsip AS a LEFT JOIN jenis_arsip AS b ON a.id_jenis=b.id WHERE a.id_jenis=9 AND a.distributor='".$x['distributor']."' AND a.id_trx='".$x['id_pembelian']."'")->fetch_array();
									$ada_3=$conn->query("SELECT COUNT(a.id), a.file, b.php_pdf FROM tabel_arsip AS a LEFT JOIN jenis_arsip AS b ON a.id_jenis=b.id WHERE a.id_jenis=10 AND a.distributor='".$x['distributor']."' AND a.id_trx='".$x['id_pembelian']."'")->fetch_array();
									if ($ada_1[0]==0) {
									$file_1='<li class="font-line-through"><a href="javascript:void(0);">Faktur Pengeluaran Belum Diupload</a></li>';
									} else {
									$file_1='<li><a href="'.$ada_1[2].$ada_1[1].'" target="_blank">Faktur Pengeluaran</a></li>';
									}
									
									if ($ada_2[0]==0) {
									$file_2='<li class="font-line-through"><a href="javascript:void(0);">Surat Jalan Pengeluaran Belum Diupload</a></li>';
									} else {
									$file_2='<li><a href="'.$ada_2[2].$ada_2[1].'" target="_blank">Surat Jalan Pengeluaran</a></li>';
									}
									
									if ($ada_3[0]==0) {
									$file_3='<li class="font-line-through"><a href="javascript:void(0);">Pajak Pengeluaran Belum Diupload</a></li>';
									} else {
									$file_3='<li><a href="'.$ada_3[2].$ada_3[1].'" target="_blank">Pajak Pengeluaran</a></li>';
									}

									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td><?=$stts?></td>
                                            <td><?=$jatuh_tempo?></td>
                                            <td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_pembelian'].'#'.$x['distributor']?>">Rincian</button></td>
                                            <td>
                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#ModalUpload" data-id="<?=$x['id_pembelian']?>" data-distributor="<?=$x['distributor']?>" data-awal="<?=$_GET['awal']?>" data-akhir="<?=$_GET['akhir']?>">&nbsp;&nbsp;Upload File&nbsp;</button><br><br>
                                    <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-xs waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tampil File
                                    <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                    	<?=$file_1?>
                                    	<?=$file_2?>
                                    	<?=$file_3?>
                                    </ul>
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

<?php
endif;
?>
            