<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

$sql=$conn->query("select * from perubahan_barang WHERE kode_barang = '".$_GET['kode_barang']."' AND master=1 order by tgl_ubah DESC");
$ada=$sql->num_rows;
if ($ada > 0) {
?>            

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA PERUBAHAN HARGA BARANG
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-metode">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Update</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Barang Sebelum Perubahan</th>
                                            <th>LV 1</th>
                                            <th>LV 2</th>
                                            <th>LV 3</th>
                                            <th>Harga Barang Setelah Perubahan</th>
                                            <th>LV 1</th>
                                            <th>LV 2</th>
                                            <th>LV 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$sql->fetch_array()) :
									$y=$conn->query("select * from perubahan_barang WHERE kode_barang = '".$x['kode_barang']."' AND tgl_ubah = '".$x['tgl_ubah']."'  AND master=2")->fetch_array();
									if ($y['harga_barang'] > $x['harga_barang']) {
										$class_harga='class="col-pink"';
										$class_icon='<i class="material-icons">arrow_drop_up</i>';
									} else if ($y['harga_barang'] < $x['harga_barang']) {
										$class_harga='class="col-yellow"';
										$class_icon='<i class="material-icons">arrow_drop_down</i>';
									} else {
										$class_harga='class="col-green"';
										$class_icon='<i class="material-icons">more_horiz</i>';
									}
									if ($y['level_1'] > $x['level_1']) {
										$class_lv1='class="col-pink"';
									} else if ($y['level_1'] < $x['level_1']) {
										$class_lv1='class="col-yellow"';
									} else {
										$class_lv1='class="col-green"';
										$icon_lv1='<i class="material-icons">more_horiz</i>';
									}
									if ($y['level_2'] > $x['level_2']) {
										$class_lv2='class="col-pink"';
									} else if ($y['level_2'] < $x['level_2']) {
										$class_lv2='class="col-yellow"';
									} else {
										$class_lv2='class="col-green"';
									}
									if ($y['level_3'] > $x['level_3']) {
										$class_lv3='class="col-pink"';
									} else if ($y['level_3'] < $x['level_3']) {
										$class_lv3='class="col-yellow"';
									} else {
										$class_lv3='class="col-green"';
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=tanggal_indo(date("Y-m-d",$x['tgl_ubah']))?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($x['level_1'])?></td>
                                            <td><?=angka($x['level_2'])?></td>
                                            <td><?=angka($x['level_3'])?></td>
                                            <td <?=$class_harga?>><?=angka($y['harga_barang'])?></td>
                                            <td <?=$class_lv1?>><?=angka($y['level_1'])?></td>
                                            <td <?=$class_lv2?>><?=angka($y['level_2'])?></td>
                                            <td <?=$class_lv3?>><?=angka($y['level_3'])?></td>
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
                    return column === 3 || column === 4 || column === 5 || column === 6 || column === 7 || column === 8 || column === 9 || column === 10 ?
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
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]

    });
});
</script>  
            
<?php
} else {
	echo "<script>window.alert('Tidak Ada Data Perubahan Harga')
    		</script>";

$x=$conn->query("select * from stok_barang WHERE kode_barang = '".$_GET['kode_barang']."'")->fetch_array();
?>  
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA HARGA BARANG <?=$x['nama_barang']?>
                                <small>Tidak Ada Perubahan Harga</small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-metode">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Harga Barang</th>
                                            <th>LV 1</th>
                                            <th>LV 2</th>
                                            <th>LV 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?php if ($x['harga_barang']!=''){ echo angka($x['harga_barang']); } else {'';}?></td>
                                            <td><?=angka($x['level_1'])?></td>
                                            <td><?=angka($x['level_2'])?></td>
                                            <td><?=angka($x['level_3'])?></td>
                                        </tr>
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
                    return column === 1 || column === 2 || column === 3 || column === 4  ?
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
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]

    });
});
</script>             
            
<?php
}
?>            
            
