<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['alokasi_stok'])) :

        $input = $_GET['input'];

        $query = $conn->query("SELECT sisa_stok, nama_barang, kode_barang, distributor, satuan FROM stok_barang WHERE nama_barang like '%$input%'  and distributor like '%".$_SESSION['distributor']."%' LIMIT 0 , 5"); //query mencari hasil search

		
        $hasil = $query->num_rows;
		
		if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$input." Tidak Ada di Database<br>";
        } else {
            while ($data = $query->fetch_array()) {
			$stok_beli=$conn->query("select SUM(jumlah) from pembelian_sementara where kode_barang='".$data[2]."'")->fetch_array();
			$stok_masuk=$conn->query("select SUM(jumlah) from barang_masuk where kode_barang='".$data[2]."'")->fetch_array();
			$sisa=$stok_beli[0]-$stok_masuk[0];
			$inv=$conn->query("SELECT b.no_faktur, b.tgl_nota, b.supplier, a.kode_barang from pembelian_sementara AS a left join tabel_pembelian as b ON a.id_pembelian=b.id_pembelian where a.kode_barang =  '".$data[2]."' ORDER BY a.id_pembelian DESC")->fetch_array();
			$final=$conn->query("SELECT COUNT(a.id_pembelian), a.nama_barang, a.kode_barang, a.distributor, b.is_final FROM pembelian_sementara AS a LEFT JOIN tabel_pembelian AS b ON a.id_pembelian=b.id_pembelian WHERE a.kode_barang = '".$data[2]."' ")->fetch_array();
            if ($sisa < 1) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$data[1]." Tidak ada stok ".$sisa."<br>";
			
			} else if ($final[4] == 0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$final[1].", Kode Barang ".$final[2].", Distributor ".$final[3]." Belum Dilakukan Finalisasi<br>";
			
			} else {
			?>
            <i class='fa fa-check fa-lg' style='color:green;'> </i><a href="javascript:autoInsert('<?=$sisa?>','<?=htmlspecialchars($data[1])?>','<?=$data[2]?>','<?=$data[3]?>','<?=$data[4]?>','<?=$inv[0]?>','<?=$inv[1]?>','<?=$inv[2]?>');"><?=$data[1].' Stok : '.$sisa?><br> <!--- hasil -->
            <?php
			  }
            }    
		}

endif;

if (isset($_GET['ambil_barang'])) :

        $input = $_GET['input'];
		$id_pengambilan = $_GET['id_pengambilan'];
		$ada=$conn->query("SELECT * FROM ambil_barang as a left join barang_keluar b ON a.id_barang_keluar = b.id where a.id_pengambilan='$id_pengambilan' AND b.no_faktur NOT LIKE '$input' ")->num_rows;

        $query = $conn->query("SELECT a.nama_barang, a.jumlah, a.is_ambil, a.satuan, b.nama, a.id_gudang, a.id, a.distributor, a.no_faktur, a.kode_barang from barang_keluar as a  join lokasi as b on a.id_gudang = b.id_lokasi where a.no_faktur like '%$input%' and a.id_gudang like '%".$_SESSION['gudang']."%'"); //query mencari hasil search
		
        $hasil = $query->num_rows;
		
		if (strlen($input) < 10 || strlen($input) > 10 ) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Nomor Faktur Harus 10 Digit";
			
		} else if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> No Faktur ".$input." Tidak Ada di Daftar Penjualan";
			
		} else if ($ada > 0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> No Faktur ".$input." Tidak Sama Dengan Entry Sebelumnya";

        } else {
            while ($data = $query->fetch_array()) {
			$sisa=$data[1]-$data[2];
			$confirmasi=$conn->query("SELECT * FROM tabel_bayar where no_faktur='".$data[8]."' AND  jumlah_bayar - jumlah_transaksi  < 0 and distributor = '".$data[7]."' AND no_faktur IN (SELECT no_faktur from tabel_faktur WHERE no_faktur = '".$data[8]."' AND jatuh_tempo = '0000-00-00')")->num_rows;
            if ($sisa < 1) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$data[0]." Sudah Diambil Seluruhnya<br><br>";
			} else if($confirmasi > 0 ) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> No. Faktur ".$data[8]." ".$data[7]." Belum dilakukan Konfirmasi Pembayaran, Hubungi Admin TOKO<br><br>";
			
			} else {
			
            ?> <i class='fa fa-check fa-lg' style='color:green;'> </i><a href="javascript:autoInsert('<?=htmlspecialchars($data[0])?>','<?=$data[1]?>','<?=$data[2]?>','<?=$data[3]?>','<?=$data[4]?>','<?=$data[5]?>','<?=$data[6]?>','<?=$data[7]?>','<?=$data[8]?>','<?=$data[9]?>');"><?=$data[0]?>, Distributor : <?=$data[7]?> Jumlah Belum Diambil : <?=$sisa?><br> <!--- hasil -->
            <?php
			  }
            }    
		}

endif;

if (isset($_GET['ambil_data_stok'])) :


$kode_barang = $_GET['kode_barang'];
$id_gudang = $_GET['id_gudang'];

$stok_booking=$conn->query("SELECT * FROM alokasi_booking  WHERE kode_barang = '$kode_barang' AND id_gudang='$id_gudang'  AND jumlah > 0 ORDER by jumlah DESC");
$jumlah_booking=$stok_booking->num_rows;
$stok=$conn->query("SELECT * FROM alokasi_stok  WHERE kode_barang = '$kode_barang' AND id_gudang='$id_gudang' AND jumlah > 0 ORDER by jumlah DESC");
$jumlah=$stok->num_rows;

if ($jumlah_booking > 0) {
echo '<select class="form-control show-tick" name="pintu_gudang" data-show-subtext="true">';
while ($s=$stok_booking->fetch_array()) :
echo '<option value="'.$s['jumlah'].'#'.$s['pintu_gudang'].'#1">'.$s['pintu_gudang'].' Jumlah Stok Booking '.$s['jumlah'].'</option>';
endwhile;
echo '</select>';

} else if ($jumlah > 0) {
echo '<select class="form-control show-tick" name="pintu_gudang" data-show-subtext="true">';
while ($s=$stok->fetch_array()) :
echo '<option value="'.$s['jumlah'].'#'.$s['pintu_gudang'].'#0">'.$s['pintu_gudang'].' Jumlah Stok '.$s['jumlah'].'</option>';
endwhile;

echo '</select>';

} else {
echo 'gILA';
}

endif;

?>