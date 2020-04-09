<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['sortir_tanggal'])) {
$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$tgl_awal = date('Y-m-d',$awal);
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_akhir = date('Y-m-d',$akhir);
$kriteria_tanggal=$_GET['kriteria_tanggal'];
	if ($kriteria_tanggal=="tanggal_transaksi") {
		$qry_tanggal='no_faktur BETWEEN '.$awal.' AND '.$akhir;
		} else {
		$qry_tanggal='no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE jatuh_tempo BETWEEN $tgl_awal and $tgl_akhir)';
		}
$status_piutang=$_GET['status_piutang'];
	if ($status_piutang=="1") {
		$qry_status='jumlah_transaksi-jumlah_bayar = 0';
		} else {
		$qry_status='jumlah_transaksi-jumlah_bayar > 0';
		}
$piutang=$conn->query("select * from tabel_bayar where metode_bayar='1' AND distributor = '".$_SESSION['distributor']."' AND $qry_tanggal AND $qry_status order by no_faktur DESC");
} else {
$piutang=$conn->query("select * from tabel_bayar where metode_bayar='1' AND distributor = '".$_SESSION['distributor']."' AND customer = '".$_GET['customer']."' order by no_faktur DESC");
}
?>            

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PIUTANG
                                <small>Sortir Data Dapat Dilakukan dengan Menu Dropdown di Customer dan Status Pelunasan</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="data-table-example4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="with-input">
                            					<select class="form-control show-tick" data-live-search="true">
                            					<option value="">--PILIH CUSTOMER--</option>
                                                <?php
                                                $cust_sql=$conn->query(" SELECT a.customer, b.nama FROM tabel_bayar as a LEFT JOIN tabel_customer as b ON a.customer = b.id WHERE a.metode_bayar = 1  AND a.distributor = '".$_SESSION['distributor']."' GROUP BY a.customer ORDER BY b.nama ASC");
												while ($y=$cust_sql->fetch_array()) :
												?>
                            					<option value="<?=$y[1]?>"><?=$y[1]?></option>
                                                <?php endwhile;?>
                            					</select>
                            				</th>
                                            <th>No faktur</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Transaksi</th>
                                            <th>Sisa Piutang</th>
                                            <th class="with-input">
                            					<select class="form-control show-tick">
                            					<option value="">--STATUS--</option>
                            					<option value="LUNAS">LUNAS</option>
                            					<option value="BELUM LUNAS">BELUM LUNAS</option>
                            					</select>
                            				</th>
                                            <th>Jatuh Tempo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$piutang->fetch_array()) :
									$customer=$conn->query("select * from tabel_customer where id='".$x['customer']."'")->fetch_array();
									$jatuh_tempo=$conn->query("select jatuh_tempo from tabel_faktur where no_faktur='$x[no_faktur]'")->fetch_array();
									
									if ($x['jumlah_transaksi']-$x['jumlah_bayar']==0) {
										$status='LUNAS';
										} else {
										$status='BELUM LUNAS';
										}

									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$customer['nama']?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=date("d-m-Y",$x['no_faktur'])?></td>
                                            <td><?=angka($x['jumlah_transaksi'])?></td>
                                            <td><?=angka($x['jumlah_transaksi']-$x['jumlah_bayar'])?></td>
                                            <td><?=$status?></td>
                                            <td><?=tanggal_indo($jatuh_tempo[0])?></td>
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
            