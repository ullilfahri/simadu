<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['hari_ini'])) {
$awal=strtotime(date('Y-m-d 00:00:00'));
$akhir=strtotime(date('Y-m-d 23:59:59'));
$gudang=$conn->query("SELECT * from ambil_barang where id_pengambilan BETWEEN $awal and $akhir AND id_gudang='".$_SESSION['gudang']."'  order by id_barang_keluar, id ASC");
$ket='HARI INI';
} else if (isset($_GET['cari_tanggal'])) {
	$date_1 = date_create_from_format('d-m-Y', $_GET['date_1']);
	$date_1=date_format($date_1, 'Y-m-d 00:00:00');
	$tgl_1=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_1']), 'Y-m-d'));
	$awal=strtotime($date_1);
	$date_2 = date_create_from_format('d-m-Y', $_GET['date_2']);
	$date_2=date_format($date_2, 'Y-m-d 23:59:59');
	$tgl_2=tanggal_indo(date_format(date_create_from_format('d-m-Y', $_GET['date_2']), 'Y-m-d'));
	$akhir=strtotime($date_2);
	$ket=$tgl_1.' s/d '.$tgl_2;
$gudang=$conn->query("SELECT * from ambil_barang where id_pengambilan BETWEEN $awal and $akhir AND id_gudang='".$_SESSION['gudang']."'  order by id_barang_keluar, id ASC");
$ket='PERIODE '.tanggal_indo(date('Y-m-d', $awal)).' s.d '.tanggal_indo(date('Y-m-d', $akhir));

} else {
$gudang=$conn->query("SELECT * FROM ambil_barang WHERE id_gudang='".$_SESSION['gudang']."' AND id_barang_keluar IN (SELECT id FROM barang_keluar WHERE no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE no_faktur = '".$_GET['no_faktur']."')) order by partial, id_pengambilan ASC");
$ket='No Faktur Penjualan '.$_GET['no_faktur'];
}


?>


            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DAFTAR PENGAMBILAN BARANG
                                <small><?=$ket?></small>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <form method="get" name="form_cek" action="form_metode.php?metode_ambil=KHhdhydv">
                                <table class="table table-bordered table-striped table-hover dataTable js-metode">
                                    <thead>
                                        <tr>
                                            <th>CEK</th>
                                            <th>NO</th>
                                            <th>CUSTOMER</th>
                                            <th>NO SURAT JALAN</th>
                                            <th>UTILITAS FILE</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY AMBIL</th>
                                            <th>SATUAN</th>
                                            <th>QTY RETUR / SJ</th>
                                            <th>QTY DISTRIBUSI</th>
                                            <th>Harga Per Item</th>
                                            <th>TGL AMBIL</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>OUTLET</th>
                                            <th>GUDANG</th>
                                            <th>PINTU/RAK/RUANG</th>
                                            <th>DDL Antar / Ambil / Pending</th>
                                            <th>DDL Plat Mobil</th>
                                            <th>DDL Supir</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    	<tr>
                                            <th><button type="submit" onClick="return validate();" name="metode_ambil" value="KHhdhydv" class="btn btn-warning btn-xs waves-effect" colspan="21">Entry Metode Ambil</button></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$gudang->fetch_array()):
									$dis=$conn->query("SELECT pengguna from mst_hak_akses where kode='".$x['distributor']."'")->fetch_array();
									
									$gudang_sql=$conn->query("SELECT nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();

									$fak=$conn->query("SELECT no_faktur, kode_barang, nama_barang, satuan FROM barang_keluar where id = '".$x['id_barang_keluar']."' ")->fetch_array();
									
									$cst=$conn->query("SELECT customer, cus_umum, id_toko from tabel_faktur where no_faktur = '".$fak[0]."' ")->fetch_array();
									if ($cst[0] > 0) {
									$tetap=$conn->query("SELECT nama FROM tabel_customer where id = '$cst[0]' ")->fetch_array();
									$pelanggan=$tetap[0];
									} else {
									$arr = json_decode($cst[1], true);
									$pelanggan=$arr["umum"]["nama"];
									}
									
									if ($x['partial'] > 0) {
										$srt_jalan=$fak[0].'-'.surat_jalan($x['partial']);
										} else {
										$srt_jalan=$fak[0];
										}
									$file=$x['id_pengambilan'].'.pdf';
									$ada=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$file;
									if (file_exists($ada)) {
									$disabled='';
									} else {
									$disabled='disabled';
									}
									
									
									$harga=$conn->query("SELECT * FROM tabel_trx WHERE no_faktur='".$fak[0]."' AND kode_barang='".$fak[1]."' ")->fetch_array();
									$retur=$conn->query("SELECT SUM(jumlah_barang) FROM tabel_retur WHERE no_faktur='".$fak[0]."' AND kode_barang='".$fak[1]."' ")->fetch_array();
									$toko=$conn->query("SELECT nama from lokasi where id_lokasi='".$cst[2]."'")->fetch_array();
									
									if ($x['stts']==1) {
									$antar=$conn->query("SELECT * FROM metode_ambil WHERE no_surat_jalan = '$srt_jalan'")->fetch_array();
									$stts='Ambil Sendiri Pada '.tanggal_indo(date('Y-m-d', $antar['waktu_ambil'])).' Jam '.date('H:i', $antar['waktu_ambil']);
									$plat='-';
									$sopir='-';
									$lokasi='-';
									} else if ($x['stts']==2) {
									$antar=$conn->query("SELECT a.waktu_ambil, b.plat_mobil, c.nama_karyawan, d.jarak FROM metode_ambil AS a LEFT JOIN tabel_mobil AS b ON a.plat_mobil = b.id LEFT JOIN tabel_karyawan AS c ON a.sopir = c.id LEFT JOIN lokasi_antar AS d ON a.lokasi=d.id WHERE a.no_surat_jalan = '$srt_jalan'")->fetch_array();
									$plat=$antar[1];
									$sopir=$antar[2];
									$lokasi=$antar[3].' KM';
									$stts='Diantar Pada '.tanggal_indo(date('Y-m-d', $antar[0])).' Jam '.date('H:i', $antar[0]);
									} else {
									$stts='Pending';
									$plat='-';
									$sopir='-';
									$lokasi='-';
									}
									
									$sudah=$conn->query("SELECT * FROM metode_ambil WHERE id_ambil_barang='".$x['id']."'")->num_rows;
									if ($sudah == 0) {
									$disabled_cek='';
									} else {
									$disabled_cek='disabled';
									}
									$harga_dasar=$harga['potongan']/$harga['jumlah'];
									$harga_item=$harga['harga_barang']-$harga_dasar;	
									?>
                                        <tr>
                                            <td><input type="checkbox" name="cek[]" value="<?=$x['id']?>" class="chk-col-red" id="oke<?=$x['id']?>" <?=$disabled_cek?>><label for="oke<?=$x['id']?>"></label></td>
                            </form>    
                                            <td><?=$no++?></td>
                                            <td><?=$pelanggan?></td>
                                            <td><?=$srt_jalan?></td>
                                            <td>
                                            <button type="button" class="btn btn-danger waves-effect btn-sm" onClick="openNewTab(<?=$x['id_pengambilan']?>)" <?=$disabled?>>
                                            	<i class="fa fa-print fa-xs"></i>
                                            </button>
                                            <button type="button" class="btn btn-success waves-effect btn-sm" onClick="generate(<?=$x['id_pengambilan']?>)">
                                            	<i class="fa fa-file-pdf-o fa-xs"></i>
                                            </button>
                                            </td>
                                            <td><?=$fak[1]?></td>
                                            <td><?=$fak[2]?></td>
                                            <td><?=$x['jumlah_ambil']?></td>
                                            <td><?=$fak[3]?></td>
                                            <td><?=$retur[0]?></td>
                                            <td><?=$x['jumlah_ambil']-$retur[0]?></td>
                                            <td><?=angka($harga_item)?></td>
                                            <td><?=tanggal_indo(date('Y-m-d',$x['id_pengambilan']))?></td>
                                            <td><?=$dis[0]?></td>
                                            <td><?=$toko[0]?></td>
                                            <td><?=$gudang_sql[0]?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$stts?></td>
                                            <td><?=$plat?></td>
                                            <td><?=$sopir?></td>
                                            <td><?=$lokasi?></td>
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
                    return column === 9 ?
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
                    columns: [ 1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
                }
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]

    });
	
	
});

</script>  

<script type="text/javascript">
    function openNewTab(file) {
        window.open("../pdf_viewer/index.php?dir=surat_jalan&file="+file+'.pdf');
		//alert(file);
    }
</script>

<script type="text/javascript">
    function generate(file) {
        window.open("regenerate_pdf.php?cetak_langsung&id_pengambilan="+file);
		//alert(file);
    }
</script>

<script language="javascript">
function validate() {
var chks = document.getElementsByName('cek[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++){
	if (chks[i].checked) {
	hasChecked = true;
	break;
	}
}

if (hasChecked == false)
	{
	swal("Perhatian!", "Harap Centang Salah Satu", "error");
	return false;
	}

return true;
}
</script>
  
