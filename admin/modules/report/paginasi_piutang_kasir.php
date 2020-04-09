<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['tampil_data'])) :
$id_toko = $_GET['id_toko'];
$distributor = $_GET['distributor'];
$customer = $_GET['customer'];
$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal = strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir = strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$tgl_awal = tanggal_indo(date('Y-m-d',$awal));
$tgl_akhir = tanggal_indo(date('Y-m-d',$akhir));
$kriteria_sortir = $_GET['kriteria_sortir'];
$status_piutang = $_GET['status_piutang'];

if ($status_piutang=='belum_lunas') {
	$kolom='AND jumlah_transaksi-jumlah_bayar > 0';
	} else if ($status_piutang=='lunas') {
	$kolom='AND jumlah_transaksi-jumlah_bayar = 0';
	} else {
	$kolom='';
	}
if ($kriteria_sortir==1) {
	$kriteria="jatuh_tempo BETWEEN FROM_UNIXTIME($awal) and FROM_UNIXTIME($akhir)";
	$ket='Jatuh Tempo';
	} else {
	$kriteria='no_faktur BETWEEN '.$awal.' and '.$akhir;
	$ket='Tanggal Transaksi';
	}

$toko=$conn->query("SELECT nama FROM lokasi WHERE id_lokasi='$id_toko'")->fetch_array();
	
$piutang=$conn->query("SELECT * from tabel_bayar where metode_bayar='1'  $kolom  AND id_toko = '$id_toko' AND distributor LIKE '$distributor' AND customer LIKE '$customer' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE $kriteria) order by no_faktur ASC");
$total=$conn->query("SELECT SUM(jumlah_bayar), SUM(jumlah_transaksi) from tabel_bayar where metode_bayar='1'  $kolom  AND id_toko = '$id_toko' AND distributor LIKE '$distributor' AND customer LIKE '$customer' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE $kriteria) order by no_faktur ASC")->fetch_array();

?>            

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PIUTANG
                                <small> Data Piutang Berdasarkan <?=$ket?> Dari Tanggal <?=$tgl_awal?> s/d <?=$tgl_akhir?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-biaya">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Outlet Penjualan</th>
                                            <th>Distributor</th>
                                            <th>No faktur</th>
                                            <th>Customer</th>
                                            <th>Tgl Transaksi</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Sisa Piutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$piutang->fetch_array()) :
									$customer=$conn->query("select nama from tabel_customer where id='".$x['customer']."'")->fetch_array();
									$jatuh_tempo=$conn->query("select jatuh_tempo from tabel_faktur where no_faktur='$x[no_faktur]'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=$x['distributor']?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$customer[0]?></td>
                                            <td><?=tanggal_indo(date("Y-m-d",$x['no_faktur']))?></td>
                                            <td><?=tanggal_indo($jatuh_tempo[0])?></td>
                                            <td><?=angka($x['jumlah_transaksi'])?></td>
                                            <td><?=angka($x['jumlah_bayar'])?></td>
                                            <td><?=angka($x['jumlah_transaksi']-$x['jumlah_bayar'])?></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?=angka($total[1])?></th>
                                            <th><?=angka($total[0])?></th>
                                            <th><?=angka($total[1]-$total[0])?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
<script language="javascript">
$(function () {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    return column === 7 || column === 8 || column === 9  ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.js-biaya').DataTable({
        dom: 'Bfrtip',
		searching: false,
        responsive: true,
		info:     true,
        buttons: [
            { extend: 'copyHtml5', footer: true, text: '<i class="fa fa-copy"></i> Copy', title: $('h1').text() },
			//{ extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel' },
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});
</script>                            

<!--
<script language="javascript">
$('table.data-table').DataTable({
  paging: false,
  columnDefs: [{
    targets: 'no-sort',
    orderable: false
  }],
  dom: '<"row"<"col-sm-6"Bl><"col-sm-6"f>>' +
    '<"row"<"col-sm-12"<"table-responsive"tr>>>' +
    '<"row"<"col-sm-5"i><"col-sm-7"p>>',
  fixedHeader: {
    header: true
  },
  buttons: {
    buttons: [{
      extend: 'print',
      text: '<i class="fa fa-print"></i> Print',
      title: $('h1').text(),
      exportOptions: {
        columns: ':not(.no-print)'
      },
      footer: true,
      autoPrint: false
    }, {
      extend: 'pdf',
      text: '<i class="fa fa-file-pdf-o"></i> PDF',
      title: $('h1').text(),
      exportOptions: {
        columns: ':not(.no-print)'
      },
      footer: true
    }],
    dom: {
      container: {
        className: 'dt-buttons'
      },
      button: {
        className: 'btn btn-default'
      }
    }
  }
});
</script>
-->

<?php
endif;
            