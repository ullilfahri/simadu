<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
$pecah=explode(';',$_GET['customer']);

if ($_SESSION['level']==2) {
	if ($pecah[1]=='tetap') {
		$sql=$conn->query("select * from tabel_trx WHERE distributor = '".$_SESSION['distributor']."' AND no_faktur IN  (SELECT no_faktur from tabel_faktur WHERE customer = '$pecah[0]') order by no_faktur DESC");
		} else {
		$sql=$conn->query("select * from tabel_trx WHERE distributor = '".$_SESSION['distributor']."' AND no_faktur IN  (SELECT no_faktur from tabel_faktur WHERE cus_umum like '%$pecah[0]%') order by no_faktur DESC");

	}

} else if ($_SESSION['level']==3){
	if ($pecah[1]=='tetap') {
		$sql=$conn->query("select * from tabel_trx WHERE id_toko = '".$_SESSION['toko']."' AND no_faktur IN  (SELECT no_faktur from tabel_faktur WHERE customer = '$pecah[0]') order by no_faktur DESC");
		} else {
		$sql=$conn->query("select * from tabel_trx WHERE id_toko = '".$_SESSION['toko']."' AND no_faktur IN  (SELECT no_faktur from tabel_faktur WHERE cus_umum like '%$pecah[0]%') order by no_faktur DESC");

	}

} else {
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";

}	
?>            

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PERUBAHAN HARGA CUSTOMER
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-metode">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Customer</th>
                                            <th>No faktur</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Harga Dasar</th>
                                            <th>Harga Jual</th>
                                            <th>Jumlah Potongan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$sql->fetch_array()) :
									$cst_sql=$conn->query("select customer from tabel_faktur where no_faktur='".$x['no_faktur']."'")->fetch_array();
									if ($cst_sql[0]==0) {
										$customer_sql=$conn->query("select cus_umum from tabel_faktur where no_faktur='".$x['no_faktur']."'")->fetch_array();
										$arr = json_decode($customer_sql[0], true);
										$customer=$arr["umum"]["nama"].' (Pelanggan Umum)';
										} else {
										$customer_sql=$conn->query("select nama from tabel_customer where id='".$cst_sql[0]."'")->fetch_array();
										$customer=$customer_sql[0].' (Pelanggan Tetap)';
										} 
									$harga_jual=$x['sub_total']/$x['jumlah'];
									$diskon=$x['harga_barang']-$harga_jual;
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$customer?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=date("d-m-Y",$x['no_faktur'])?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($harga_jual)?></td>
                                            <td><?=angka($diskon)?></td>
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
                    return column === 6 || column === 7 || column === 8  ?
                        data.replace( /[.]/g, '' ) :
                        data;
                }
            }
        }
    };
    //Exportable table
    $('.js-metode').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]

    });
});
</script>             

            