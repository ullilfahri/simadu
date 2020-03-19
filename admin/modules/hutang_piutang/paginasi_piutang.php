<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['tampil_data'])) :

$id_toko = $_GET['id_toko'];
$kategori = $_GET['kategori'];
$customer = $_GET['customer'];

if ($kategori=='tanggal') {
	$awal = date_create_from_format('d-m-Y', $_GET['awal']);
	$awal = date_format($awal, 'Y-m-d');
	$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
	$akhir = date_format($akhir, 'Y-m-d');
	$piutang=$conn->query("SELECT a.*, b.* FROM tabel_faktur AS a LEFT JOIN tabel_bayar AS b ON a.no_faktur=b.no_faktur WHERE a.metode_bayar = 1 AND b.jumlah_transaksi-b.jumlah_bayar > 0 AND a.jatuh_tempo BETWEEN '$awal' and '$akhir' AND a.id_toko = '$id_toko' GROUP BY b.distributor,b.no_faktur ORDER BY a.jatuh_tempo DESC");
	$foot='Pencarian Jatuh Tempo Periode '.tanggal_indo($awal).' s.d '.tanggal_indo($akhir);
} else {
	$piutang=$conn->query("SELECT a.*, b.* FROM tabel_faktur AS a LEFT JOIN tabel_bayar AS b ON a.no_faktur=b.no_faktur WHERE a.metode_bayar = 1 AND b.jumlah_transaksi-b.jumlah_bayar > 0 AND a.customer LIKE '$customer' AND a.id_toko = '$id_toko' GROUP BY b.distributor,b.no_faktur ");
	$foot='Pencarian Berdasrakan Customer';
}
?>            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PIUTANG
                            </h2>
                            <small><?=$foot?></small>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tabel-piutang">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Terbayar</th>
                                            <th>Status</th>
                                            <th>Customer</th>
                                            <th>No faktur</th>
                                            <th>Distrbutor</th>
                                            <th>Tanggal Jatuh Tempo</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Transaksi</th>
                                            <th>Sisa Piutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$piutang->fetch_array()) :
									$customer=$conn->query("select * from tabel_customer where id='".$x['customer']."'")->fetch_array();
									$dis=$conn->query("select *, SUM(jumlah_bayar) from bayar_hutang where id_hutang = '".$x['id']."' GROUP BY via_bayar DESC");
									ob_start();
									echo '<li role="separator" class="divider"></li>';
									while ($y=$dis->fetch_array()) :								
									echo '<li><a href="javascript:void(0);" data-toggle="modal" data-target=".modal_bayar"  data-id="'.$y['id_hutang'].'#'.$y['via_bayar'].'">'.$y['via_bayar'].' : Rp. '.angka($y[8]).'</a></li>';
									echo '<li role="separator" class="divider"></li>';
									endwhile;
									$trx=ob_get_contents();
									ob_end_clean();
									
										if ($x['jumlah_transaksi']-$x['jumlah_bayar'] > 0) {
										$tombol='<button type="button" class="btn btn-warning btn-sm waves-effect" data-toggle="modal" data-target=".bayar_hutang" data-id="'.$x['no_faktur'].'#'.$x['distributor'].'"><i class="fa fa-money"></i> Entry </button>';
										} else {
										$tombol='<button type="button" class="btn btn-success btn-sm waves-effect" onclick="lunas()"><i class="fa fa-money"></i> Lunas</button>';
										}
										
									$jatuh_tempo=$conn->query("select jatuh_tempo from tabel_faktur where no_faktur='$x[no_faktur]'")->fetch_array();


									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td>
                                            <div class="btn-group">
                                            <button type="button" class="btn bg-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Rp. <?=angka($x['jumlah_bayar'])?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                            <?=$trx?>
                                            </ul>
                                            </div>
                                            </td>
                                            <td><?=$tombol?></td>
                                            <td><?=$customer['nama']?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$x['distributor']?></td>
                                            <td><?=tanggal_indo($jatuh_tempo[0])?></td>
                                            <td><?=date("d-m-Y",$x['no_faktur'])?></td>
                                            <td><?=angka($x['jumlah_transaksi'])?></td>
                                            <td><?=angka($x['jumlah_transaksi']-$x['jumlah_bayar'])?></td>
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
     var table = $('#tabel-piutang').DataTable({
                dom: 'Bfrtip',
				responsive: true,
				buttons: ['copy', 'csv', 'excel']
            });
            // Apply the search
            $("#tabel-piutang thead th input[type=text]").on( 'keyup change', function () {
	    	
	        table
	            .column( $(this).closest('th').index()+':visible' )
	            .search( this.value )
	            .draw();
	            
	    });
            // Apply the search
            $("#tabel-piutang thead th select").on('change', function () {
	    	
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
