<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php
if (isset($_GET['ambil_data'])) :

$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$kasir = $_GET['kasir'];

$trx=$conn->query("SELECT * FROM tabel_faktur where no_faktur BETWEEN $awal and $akhir AND kasir = '$kasir' AND total_trx > 0 ORDER BY no_faktur ASC");
$total=$conn->query("SELECT SUM(total_trx)-SUM(jumlah_diskon), SUM(uang_muka), SUM(dalam_bank), SUM(hutang) FROM tabel_faktur where no_faktur BETWEEN $awal and $akhir AND kasir = '$kasir' AND total_trx > 0")->fetch_array();

?>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                RINCIAN LAPORAN TRANSAKSI
                                <small>Periode <?=tanggal_indo(date('Y-m-d',$awal))?> s/d <?=tanggal_indo(date('Y-m-d',$akhir))?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kasir</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal</th>
                                            <th>Customer</th>
                                            <th>Transaksi</th>
                                            <th>Tunai</th>
                                            <th>Transfer</th>
                                            <th>Hutang</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                            <th colspan="5" class="align-center">Total</th>
                                            <th><?=angka($total[0])?></th>
                                            <th><?=angka($total[1])?></th>
                                            <th><?=angka($total[2])?></th>
                                            <th><?=angka($total[3])?></th>
                                    </tfoot>
                                    <tbody>
                                    <?php
									
									$no=1;
									while ($x=$trx->fetch_array()) :
									$user=$conn->query("select nama from user where id='$x[kasir]'")->fetch_array();
									$pecah=date('Y-m-d',$x['no_faktur']);
									$pecah2=date('H:i',$x['no_faktur']);
									$tgl=tanggal_indo($pecah).', '.$pecah2;
									if ($x['customer'] > 0) {
										$cst_sql=$conn->query(" SELECT nama from tabel_customer where id= '$x[customer]' ")->fetch_array();
										$cst=$cst_sql[0];
										} else {
										$arr = json_decode($x['cus_umum'], true);
										$cst='Umum, '.$arr["umum"]["nama"];
									}	 
									
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$user[0]?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$cst?></td>
                                            <td><?=angka($x['total_trx']-$x['jumlah_diskon'])?></td>
                                            <td><?=angka(intval($x['uang_muka']))?></td>
                                            <td><?=angka(intval($x['dalam_bank']))?></td>
                                            <td><?=angka(intval($x['hutang']))?></td>
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
            
<script type="application/javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 5 || column === 6 || column === 7 || column === 8  ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.apa').DataTable({
        dom: 'Bfrtip',
		searching: false,
        responsive: true,
		info:     true,
        buttons: [
            { extend: 'copyHtml5', footer: true, text: '<i class="fa fa-copy"></i> Copy', title: $('h1').text() },
			//{ extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel' },
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});

</script>            

<?php
endif;
?>