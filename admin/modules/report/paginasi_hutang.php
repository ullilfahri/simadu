<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['tampil_data'])) :

$supplier = $_GET['supplier'];
$status_hutang = $_GET['status_hutang'];
	if ($status_hutang==0) {
		$qry_status='jumlah_hutang = 0';
		$stts='LUNAS';
		} else {
		$qry_status='jumlah_hutang != 0';
		$stts='BELUM LUNAS';
		}
$kriteria_tanggal =  $_GET['kriteria_tanggal'];
$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d',$awal);
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d',$akhir);
	if ($kriteria_tanggal=='tanggal_jatuh_tempo') {
		$qry_tanggal='jatuh_tempo';
		} else {
		$qry_tanggal='tgl_nota';
		} 

$hutang=$conn->query("select * from tabel_pembelian where distributor like '%".$_SESSION['distributor']."%' and metode_bayar='1' AND supplier IN ($supplier) AND $qry_status AND $qry_tanggal BETWEEN '$tgl_awal' and '$tgl_akhir' order by tgl_nota ASC");

?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA HUTANG BERDASARKAN SORTIR <?=strtoupper(str_replace('_',' ',$kriteria_tanggal))?> DAN STATUS HUTANG <?=$stts?>
                                <small>Periode <?=tanggal_indo($tgl_awal)?> Sampai Dengan <?=tanggal_indo($tgl_akhir)?></small>
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
                                            <th>Sisa Hutang</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Rincian Pembayaran</th>
                                            <th>Generate PDF</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$hutang->fetch_array()) :
									$supplier=$conn->query(" SELECT nama from tabel_supplier where id='".$x['supplier']."' ")->fetch_array();
									$bayar_tunai=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_bayar='".$x['id_pembelian']."'")->fetch_array();
									$bayar_bank=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_bank WHERE id_bayar='".$x['id_pembelian']."'")->fetch_array();
									$bayar=$bayar_tunai[0]+$bayar_bank[0];
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td><?=angka($x['jumlah_hutang'])?></td>
                                            <td><?=angka($bayar)?></td>
                                            <td><?=tanggal_indo($x['jatuh_tempo'])?></td>
                                            <td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_pembelian']?>">Rincian</button>
                                            <td><a href="generate_hutang.php?id=<?=$x['id_pembelian']?>" target="_blank"><button type="button"  class="btn btn-warning btn-xs">Generate Laporan</button></a></td>
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

if (isset($_GET['tampil_supplier'])) :

$supplier = $_GET['supplier'];

$hutang=$conn->query("select * from tabel_pembelian where distributor like '%".$_SESSION['distributor']."%' and metode_bayar='1' AND supplier IN ($supplier) order by tgl_nota ASC");
?>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA HUTANG BERDASARKAN SORTIR SUPPLIER
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
                                            <th>Sisa Hutang</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Rincian Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$hutang->fetch_array()) :
									$supplier=$conn->query(" SELECT nama from tabel_supplier where id='".$x['supplier']."' ")->fetch_array();
									$bayar_tunai=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_tunai WHERE id_bayar='".$x['id_pembelian']."'")->fetch_array();
									$bayar_bank=$conn->query("SELECT SUM(jumlah_bayar) FROM konfirmasi_bank WHERE id_bayar='".$x['id_pembelian']."'")->fetch_array();
									$bayar=$bayar_tunai[0]+$bayar_bank[0];
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$supplier[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=tanggal_indo($x['tgl_nota'])?></td>
                                            <td><?=angka($x['total'])?></td>
                                            <td><?=angka($x['jumlah_hutang'])?></td>
                                            <td><?=angka($bayar)?></td>
                                            <td><?=tanggal_indo($x['jatuh_tempo'])?></td>
                                            <td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#ModalBiaya" data-id="<?=$x['id_pembelian']?>">Rincian</button>
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
            