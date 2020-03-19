<?php
include '../../../sysconfig.php';

if (isset($_POST['finalisasi'])) :
if (!empty($_POST['metode_bayar'])) { 
	$metode_bayar = $_POST['metode_bayar']; 
	$jatuh_tempo = $_POST['jatuh_tempo'];
	$jumlah_hutang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_hutang']);
	} else { 
	$metode_bayar='0';
	$jatuh_tempo='0000-00-00';
	$jumlah_hutang='';
}
$jenis = $_POST['jenis_biaya'];
$biaya = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_biaya']);
$id_pembelian = $_POST['id_pembelian'];
$jumlah_dipilih = count($jenis);

for($x=0;$x<$jumlah_dipilih;$x++) :
	$conn->query("INSERT INTO biaya_operasional values('', '$id_pembelian', '$jenis[$x]', '$biaya[$x]')");
	
endfor;

$conn->query("DELETE FROM biaya_operasional WHERE jumlah_biaya = '' OR jumlah_biaya = 0");


$file_pajak = $_POST['file_pajak'];
//$biaya = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['biaya']);
$potongan = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['potongan']);
$total = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['total']);
$distributor = $_POST['distributor'];
$supplier = $_POST['supplier'];
$no_faktur = $_POST['no_faktur'];
$tgl_nota = $_POST['tgl_nota'];
$id_owner = $_POST['id_owner'];
if (!empty($_POST['include_pajak'])) { $include_pajak = $_POST['include_pajak']; } else { $include_pajak = '0'; }


$update=$conn->query("UPDATE `tabel_pembelian` SET `potongan`='$potongan',  `total`='$total', `is_final`='1', `id_owner`='$id_owner', `metode_bayar`='$metode_bayar', `jatuh_tempo`='$jatuh_tempo', `supplier`='$supplier', `no_faktur`='$no_faktur', tgl_nota='$tgl_nota', distributor='$distributor', jumlah_hutang='$jumlah_hutang', file_pajak='$file_pajak', include_pajak='$include_pajak' WHERE id_pembelian='$id_pembelian'");

$stok=$conn->query("select * from pembelian_sementara where id_pembelian='$id_pembelian'");
while ($x=$stok->fetch_array()) :
$sisa=$conn->query("select sisa_stok from stok_barang where kode_barang = '".$x['kode_barang']."'")->fetch_array();
$tambah=$sisa[0]+$x['jumlah'];
$update_stok=$conn->query("update stok_barang set sisa_stok='".$tambah."' where kode_barang='".$x['kode_barang']."'");
endwhile;

        echo "<script>window.alert('Pembelian Tersimpan, Stok Bertambah') 
		window.location='../gudang/index.php?VBgfTGG'</script>";


		
endif;

?>
