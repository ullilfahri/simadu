<?php
include '../../../sysconfig.php';

if (isset($_POST['alokasi_stok'])) :

$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$id_gudang = $_POST['id_gudang'];
$id_user = $_POST['id_user'];
if (!empty($_POST['pintu_gudang'])) { $pintu_gudang = $_POST['pintu_gudang']; } else {$pintu_gudang = '';}
$jumlah = $_POST['jumlah'];
$distributor = $_POST['distributor'];
$satuan = $_POST['satuan'];
$no_faktur = $_POST['no_faktur'];
$tgl_nota = $_POST['tgl_nota'];
$supplier = $_POST['supplier'];

$ada=$conn->query("select COUNT(*), SUM(jumlah) from alokasi_stok where kode_barang='$kode_barang' and id_gudang='$id_gudang' and pintu_gudang='$pintu_gudang' and distributor='$distributor' ")->fetch_array();
if ($ada[0] > 0) {
$sisa=$jumlah+$ada[1];
$masuk=$conn->query("update alokasi_stok set jumlah='$sisa' where kode_barang='$kode_barang' and id_gudang='$id_gudang' and pintu_gudang='$pintu_gudang' and distributor='$distributor'");
} else {
$masuk=$conn->query("INSERT INTO `alokasi_stok`(`id_gudang`, `nama_barang`, `kode_barang`, `jumlah`, `pintu_gudang`, `distributor`) VALUES('$id_gudang', '$nama_barang', '$kode_barang', '$jumlah', '$pintu_gudang', '$distributor') ");
}

$barang_masuk=$conn->query("INSERT INTO `barang_masuk`(`id_gudang`, `pintu_gudang`, `kode_barang`, `nama_barang`, `distributor`, `tanggal`, `jumlah`, `id_user`, `satuan`, no_faktur, tgl_nota, supplier) VALUES('$id_gudang', '$pintu_gudang', '$kode_barang', '$nama_barang', '$distributor', '".date('Y-m-d H:i:s')."', '$jumlah', '$id_user', '$satuan', '$no_faktur', '$tgl_nota', '$supplier')  ");

echo "<script>window.alert('Alokasi Stok Gudang Tersimpan') 
		window.location='index.php'</script>";


endif;

if (isset($_GET['detail_transaksi'])) :

$id_barang_keluar = $_POST['rowid'];
$ambil=$conn->query("select * from ambil_barang where id_barang_keluar='$id_barang_keluar' order by remark ASC ");
?>

                                <table class="table js-exportable-stok">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pintu Gudang</th>
                                            <th>Tanggal Pengambilan</th>
                                            <th>QTY Ambil</th>
                                            <th>Utilitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$ambil->fetch_array()) :
									$pecah=explode(' ', $x['remark']);
									$tgl=tanggal_indo($pecah[0]);
									$file=$x['id_pengambilan'].'.pdf';
									$ada=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$file;
									if (file_exists($ada)) {
									$dis='';
									} else {
									$dis='disabled';
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$tgl?></td>
                                            <td><?=$x['jumlah_ambil']?></td>
                                            <td>
                                            <button type="button" class="btn btn-success waves-effect" onClick="openNewTab(<?=$x['id_pengambilan']?>)" <?=$dis?>>
                                            	<i class="fa fa-print fa-lg"></i>
                                                <span>Cetak Surat Jalan</span>
                                            </button>
                                            </td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-stok').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
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

<?php
endif;

if (isset($_POST['form_metode'])) :
$metode = $_POST['metode'];

		if (empty($_POST['sopir'])) {
		$sopir='';
		} else {
		$sopir=$_POST['sopir'];
		}
		if (empty($_POST['plat_mobil'])) {
		$plat_mobil='';
		} else {
		$plat_mobil=$_POST['plat_mobil'];
		}
		if (empty($_POST['lokasi'])) {
		$lokasi='';
		$premi='';
		} else {
		$pecah = explode("#", $_POST['lokasi']);
		$lokasi=$pecah[0];
		$premi=preg_replace('/[^A-Za-z0-9\  ]/', '', $pecah[1]);
		}


$id_sj=implode(", ", $_POST['id_sj']);
$y=$conn->query("SELECT * FROM ambil_barang where id IN ($id_sj) ");
while ($x=$y->fetch_array()) :
$fak=$conn->query("SELECT no_faktur FROM barang_keluar where id = '".$x['id_barang_keluar']."' ")->fetch_array();
	if ($x['partial'] > 0) { 
	$no_surat_jalan = $fak[0].'-'.surat_jalan($x['partial']); 
	} else {
	$no_surat_jalan = $fak[0];
	}
$masuk=$conn->query(" INSERT INTO `metode_ambil`(`id_ambil_barang`, `no_surat_jalan`, `metode`, `jumlah_ambil`, `sopir`, `plat_mobil`, `lokasi`, `premi`, `waktu_ambil`) SELECT id,  '$no_surat_jalan', '$metode', jumlah_ambil, '$sopir', '$plat_mobil', '$lokasi', '$premi', '".strtotime(date('Y-m-d H:i:s'))."' FROM ambil_barang where id = '".$x['id']."' ");		

$update=$conn->query("UPDATE ambil_barang SET stts='$metode' where id = '".$x['id']."'");
endwhile;

echo "<script>window.alert('Metode Pengambilan Tersimpan')
    		window.location='metode_ambil.php?KHhdhydv'</script>";
endif;

?>