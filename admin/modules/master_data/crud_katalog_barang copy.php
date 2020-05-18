<?php
include '../../../sysconfig.php';
//include MDL.'login/session.php';

if (isset($_GET['data'])) :
$tabel=$_GET['tabel'];
$kolom1=$_GET['kolom1'];
$kolom2=$_GET['kolom2'];
$kata1=str_replace('_',' ',$kolom1);
$kata2=str_replace('_',' ',$kolom2);
$sql=$conn->query("SELECT * FROM $tabel");
?>

                           <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th><?=ucwords($kata1)?></th>
                                            <th><?=ucwords($kata2)?></th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$sql->fetch_array()) :
									
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?php if ($tabel != 'jenis_pengeluaran'){?><a href="#" class="live_edit" data-name="<?=$kolom1?>" data-type="text" data-pk="<?=$x['id']?>" data-title="<?=$x[$kolom1]?>"><?=$x[$kolom1]?></a><?php } else { echo $x[$kolom1]; }?></td>
                                            <td><a href="#" class="live_edit" data-name="<?=$kolom2?>" data-type="text" data-pk="<?=$x['id']?>" data-title="<?=$x[$kolom2]?>"><?=$x[$kolom2]?></a></td>
                                            <td><a href="#" class="aktif" data-pk="<?=$x['id']?>" data-name="non_aktif" data-type="select" data-value="<?=$x['non_aktif']?>"></a></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
                            </div>
                            

<!--

<script>

$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});

</script> 
-->
<script type="text/javascript">
    $('.live_edit').editable({
           url: '../global/update.php?live_edit&tabel=<?=$tabel?>&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Enter name'
    });	
</script>
<script type="text/javascript">
var source = [{'value': 0, 'text': 'Aktif'}, {'value': 1, 'text': 'Non Aktif'}];

	$('.aktif').editable({
           url: '../global/update.php?live_edit&tabel=<?=$tabel?>&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Status :',
    	   source: function() {return source;}
});

$(document).ready(function() {      
    var table = $('#example').DataTable({
       order: [[ 3, 'asc' ]],
       drawCallback: function(settings){
          var api = this.api();    
		var source = [{'value': 0, 'text': 'Aktif'}, {'value': 1, 'text': 'Non Aktif'}];

		$('.stok_aktif').editable({
           url: '../global/update.php?live_edit&tabel=<?=$tabel?>&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Status :',
    	   source: function() {return source;}
		});

       }
    });    
    
} );


</script>


<?php
endif;

if (isset($_GET['kirim'])) :
$tabel=$_GET['tabel'];
if ($tabel=="jenis_pengeluaran") {
$cari=$conn->query(" SELECT * FROM jenis_pengeluaran ")->num_rows;
$digit=$cari+1;
$digit = str_pad($digit, 4, '0', STR_PAD_LEFT);
$value='OP'.$digit;
} else {
$value=addslashes($_POST['value']);
}
$value2=addslashes($_POST['value2']);
$kolom1=addslashes($_GET['kolom1']);
$kolom2=addslashes($_GET['kolom2']);

$ada=$conn->query("SELECT * FROM $tabel where $kolom2 = '$value2'")->num_rows;
if ($ada == 0) {
$masuk=$conn->query("INSERT INTO $tabel ($kolom1, $kolom2) VALUES ('$value', '$value2')");
	if ($masuk) {
	echo json_encode(array('status' =>true, 'pesan' => ' '. $_POST['value2'].' Berhasil Diinput..!'));
	} else {
	echo json_encode(array('status' =>false, 'pesan' => 'Error Query.!'));
	}
} else {
$masuk=$conn->query("INSERT INTO $tabel ($kolom1, $kolom2) VALUES ('$value', '$value2')");
echo json_encode(array('status' =>true, 'pesan' => ' '. $_POST['value2'].' Berhasil Diinput..!'));
}



endif;

if (isset($_GET['data_stok'])) :
$tabel=$_GET['tabel'];
$distributor=$_GET['distributor'];
$sql=$conn->query("SELECT a.kode_barang, b.jenis_barang, b.merek_barang, a.distributor, b.nama_barang, a.satuan, a.harga_barang, a.sisa_stok, a.level_1, a.level_2, a.level_3, a.id, a.is_aktif FROM stok_barang AS a LEFT JOIN kode_barang AS b ON a.kode_barang = b.kode_barang where a.distributor = '$distributor' ");
?>

                           <div class="table-responsive">
                           <form method="post" action="cetak_barcode.php" target="_blank">
                                <table id="example" class="table table-bordered table-striped table-hover basic">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" class="chk-col-red"><label for="checkAll">Cek All</label></th>
                                            <th>Status</th>
                                            <th>Kode Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Kepemilikan</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Harga Jual</th>
                                            <th>Stok</th>
                                            <th>Lv 1</th>
                                            <th>Lv 2</th>
                                            <th>Lv 3</th>
                                            <th>User</th>
                                            <th>Ubah</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    	<tr>
                                            <th><button type="submit" class="btn btn-warning btn-xs waves-effect" colspan="13">Cetak Barcode</button></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$sql->fetch_array()) :
									?>
                                        <tr>
                                        	<td><input type="checkbox" name="cek[]" value="<?=$x[0]?>" class="chk-col-red" id="oke<?=$x[11]?>"><label for="oke<?=$x[11]?>"></label></td>
                              </form>  
                                            <td><a href="#" class="stok_aktif" data-pk="<?=$x[11]?>" data-name="is_aktif" data-type="select" data-value="<?=$x[12]?>"></a></td>
                                            <td><?=$x[0]?></td>
                                            <td><?=$x[1]?></td>
                                            <td><?=$x[2]?></td>
                                            <td><?=$x[3]?></td>
                                            <td><?=$x[4]?></td>
                                            <td><?=$x[5]?></td>
                                            <td><?=angka($x[6])?></td>
                                            <td><?=angka($x[7])?></td>
                                            <td><?=angka($x[8])?></td>
                                            <td><?=angka($x[9])?></td>
                                            <td><?=angka($x[10])?></td>
                                            <td><?php 
                                            
                                            echo "XX" ;
                                            
                                            ?></td>
                                            <td><a href="kode_barang.php?katalog_barang=ubah_data&id=<?=$x[11]?>"><button type="button" class="btn btn-info btn-xs waves-effect">Ubah</button></a></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>
                            </div>
                            


<script>

$(document).ready(function() {      
    var table = $('#example').DataTable({
       order: [[ 3, 'asc' ]],
       drawCallback: function(settings){
          var api = this.api();    
		var source = [{'value': 0, 'text': 'Aktif'}, {'value': 1, 'text': 'Non Aktif'}];

		$('.stok_aktif').editable({
           url: '../global/update.php?live_edit&tabel=<?=$tabel?>&jenis_id=id',
           type: 'text',
           pk: 1,
           name: 'name',
           title: 'Status :',
    	   source: function() {return source;}
		});

       }
    });    
    
} );

</script>

<script>

$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

</script>

<?php
endif;

if (isset($_GET['tambah_kode_barang'])) :

$akronim = $_POST['akronim'];
$satuan_barang = $_POST['satuan'];
$jenis_barang = addslashes($_POST['jenis_barang']);
$merek_barang = addslashes($_POST['merek_barang']);
$nama_barang = addslashes($_POST['nama_barang']);
$ada_jenis = $_POST['ada_jenis'];
$ada_merek = $_POST['ada_merek'];
$ada_nama = $_POST['ada_nama'];
$ada_satuan = $_POST['ada_satuan'];
$distributor = $_POST['distributor'];
$kode_barang = $_POST['kode_barang'];
$nama_lengkap = $jenis_barang.' '.$merek_barang.' '.$nama_barang;
$harga_barang = $_POST['harga_barang'];
$level_1 = $_POST['level_1'];
$level_2 = $_POST['level_2'];
$level_3 = $_POST['level_3'];

if (empty($ada_jenis) || empty($ada_merek) ) :
$conn->query("REPLACE INTO barang_jenis(jenis_barang, merek_barang) VALUES('$jenis_barang', '$merek_barang') ");
endif;

if ($ada_satuan != 1) :
$conn->query("REPLACE INTO barang_satuan(satuan_barang, akronim) VALUES('$satuan_barang', '$akronim') ");
endif;


$userlogen = $_SESSION['adminUsername'] ; 

$masuk=$conn->query("insert into stok_barang(kode_barang, nama_barang, harga_barang, sisa_stok, satuan, distributor, `level_1`, `level_2`, `level_3` , `user` ) VALUES('$kode_barang', '$nama_lengkap','$harga_barang','0', '$akronim', '$distributor', '$level_1', '$level_2', '$level_3' , '$userlogen' )");

$masuk=$conn->query(" INSERT INTO `kode_barang`(`kode_barang`, `distributor`, `jenis_barang`, `merek_barang`, `nama_barang` , `user`) VALUES('$kode_barang', '$distributor', '$jenis_barang', '$merek_barang', '$nama_barang' , '$userlogen') ");

if ($masuk) {
echo json_encode(array('status' =>true, 'pesan' =>'Berhasil Menyinmpan Barang '.$nama_lengkap.''));
} else {
echo json_encode(array('error' =>true, 'pesan' =>'Gagal Menyinmpan Barang '.$nama_lengkap.''));
}


endif;

if (isset($_POST['ubah_data'])) :
$tgl_ubah=strtotime(date('Y-m-d H:i:s'));
$id = $_POST['id'];
$x=$conn->query("SELECT * FROM stok_barang WHERE id='$id'")->fetch_array();
$level_1 = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['level_1']);
$level_2 = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['level_2']);
$level_3 = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['level_3']);
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$kode_barang = $_POST['kode_barang'];
$jenis_barang = $_POST['jenis_barang'];
$merek_barang = $_POST['merek_barang'];
$nama_barang = $_POST['nama_barang'];
$satuan = $_POST['akronim'];
$nama_lengkap = $jenis_barang.' '.$merek_barang.' '.$nama_barang;
$update=$conn->query("UPDATE stok_barang SET level_1='$level_1', level_2='$level_2', level_3='$level_3', harga_barang='$harga_barang', nama_barang='$nama_lengkap', satuan='$satuan' WHERE id = '$id' ");
$update2=$conn->query("UPDATE alokasi_stok SET nama_barang='$nama_lengkap' WHERE kode_barang = '$kode_barang' ");
$update2=$conn->query("UPDATE kode_barang SET nama_barang='$nama_barang' WHERE kode_barang = '$kode_barang' ");

if ($x['harga_barang'] != $harga_barang || $x['level_1'] != $level_1 || $x['level_2'] != $level_2 || $x['level_3'] != $level_3) :
$masuk=$conn->query("INSERT INTO `perubahan_barang`(`kode_barang`, `nama_barang`, `harga_barang`, `satuan`, `distributor`, `level_1`, `level_2`, `level_3`, tgl_ubah, master) SELECT `kode_barang`, `nama_barang`, '".$x['harga_barang']."', `satuan`, `distributor`, '".$x['level_1']."', '".$x['level_2']."', '".$x['level_3']."', '$tgl_ubah', '1' FROM `stok_barang` WHERE id = '$id'");
$masuk=$conn->query("INSERT INTO `perubahan_barang`(`kode_barang`, `nama_barang`, `harga_barang`, `satuan`, `distributor`, `level_1`, `level_2`, `level_3`, tgl_ubah, master) SELECT `kode_barang`, `nama_barang`, `harga_barang`, `satuan`, `distributor`, level_1, level_2, level_3, '$tgl_ubah', '2' FROM `stok_barang` WHERE id = '$id'");
endif;

if ($update) {
	    echo "<script>window.alert('Ubah Data Barang Tersimpan..!') 
		window.location='kode_barang.php?katalog_barang=kode_barang'</script>";
	} else {
	    echo "<script>window.alert('Ubah Data Barang GAGAL Tersimpan..!') 
		window.location='kode_barang.php?katalog_barang=ubah_data&id=$id'</script>";
	}

endif;

?>


