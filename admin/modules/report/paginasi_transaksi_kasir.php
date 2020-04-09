
<?php 
include '../../../sysconfig.php';

$awal = date_create_from_format('d-m-Y', $_GET['awal']);
$awal=strtotime(date_format($awal, 'Y-m-d 00:00:00'));
$akhir = date_create_from_format('d-m-Y', $_GET['akhir']);
$akhir=strtotime(date_format($akhir, 'Y-m-d 23:59:59'));
$kasir=$_GET['kasir'];
$id_toko=$_GET['id_toko'];

$user=$conn->query("SELECT nama FROM user WHERE id ='$kasir'")->fetch_array();

$transaksi=$conn->query("SELECT * from tabel_trx WHERE no_faktur BETWEEN $awal and $akhir AND id_toko = '$id_toko' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE kasir='$kasir' AND total_trx > 0) ");


$ket='PERIODE '.tanggal_indo(date('Y-m-d', $awal)).' s.d '.tanggal_indo(date('Y-m-d', $akhir));


?>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR TRANSAKSI PER KASIR : <?=strtoupper($user[0])?>
                                <small><?=$ket?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable apa">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>TGL PEMBELIAN</th>
                                            <th>NO FAKTUR</th>
                                            <th>CUSTOMER</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>SATUAN</th>
                                            <th>QTY BELI</th>
                                            <th>HARGA SATUAN</th>
                                            <th>DISKON</th>
                                            <th>SPESIAL DISKON</th>
                                            <th>TOTAL</th>
                                            <th>QTY RETUR</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>OUTLET</th>
                                            <th>GUDANG</th>
                                            <th>KASIR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$transaksi->fetch_array()):
									
									$cst=$conn->query("SELECT * from tabel_faktur where no_faktur = '".$x['no_faktur']."' ")->fetch_array();
									
									if ($cst['customer'] > 0) {
									$tetap=$conn->query("SELECT nama FROM tabel_customer where id = '$cst[customer]' ")->fetch_array();
									$pelanggan=$tetap[0];
									} else {
									$arr = json_decode($cst['cus_umum'], true);
									$pelanggan='[UMUM] '.$arr["umum"]["nama"];
									}
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									$retur=$conn->query("SELECT SUM(jumlah_barang) FROM tabel_retur WHERE no_faktur='".$x['no_faktur']."' AND kode_barang='".$x['kode_barang']."' ")->fetch_array();
									$gudang_sql=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi='".$cst['id_toko']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=tanggal_indo(date('Y-m-d', $x['no_faktur']))?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$pelanggan?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['satuan']?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($x['potongan']/$x['jumlah'])?></td>
                                            <td><?=$x['spc_diskon']?></td>
                                            <td><?=angka($x['sub_total'])?></td>
                                            <td><?=$retur[0]?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=$gudang_sql[0]?></td>
                                            <td><?=strtoupper($user[0])?></td>
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
                    return column === 8 || column === 9 || column === 10 || column === 11  ?
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
			$.extend( true, {}, buttonCommon, { extend: 'excelHtml5', footer: true, text: '<i class="fa fa-floppy-o"></i> Excel', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8, 9, 10, 11, 12, 13, 14, 15, 16] } } ),
			{ extend: 'print', footer: true, text: '<i class="fa fa-print"></i> Cetak', exportOptions: {columns: ':not(.no-print)'}, title: $('h1').text()  }
        ]
    });
});

</script>            
   
    
</body>

</html>