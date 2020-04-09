<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['retur_barang'])) :

        $input = $_GET['input'];
        $id_trx = $_GET['id_trx'];
        $query = $conn->query("SELECT a.id, b.no_faktur, b.nama_barang, b.satuan, b.kode_barang, a.jumlah_ambil, a.distributor, a.remark, a.id_barang_keluar, c.pengguna, a.partial, b.is_ambil from ambil_barang  as a left join barang_keluar as b ON a.id_barang_keluar = b.id LEFT JOIN mst_hak_akses as c ON a.distributor=c.kode WHERE b.no_faktur='$input' AND a.jumlah_ambil > 0 AND c.id_akses=2"); //query mencari hasil search
        $hasil = $query->num_rows;
		
		$ada=$conn->query("SELECT * FROM tabel_retur WHERE no_faktur='$input' AND kode=1 AND jumlah_barang-is_alokasi > 0 AND id_trx != '".$id_trx."'")->num_rows;
		
		if (strlen($input) < 10 || strlen($input) > 10 ) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Nomor Faktur Harus 10 Digit";
		} else if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> No Faktur ".$input." Tidak Ada di Daftar Pengambilan Barang";
		} else if ($ada > 0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> No Faktur ".$input." Terdapat Retur Barang yang Belum Dialokasikan ke Stok, Lakukan Alokasi Stok Terlebih Dahulu";
        } else {
		while ($data = $query->fetch_array()) :
		$toleransi=$conn->query("SELECT lama_toleransi, status from mst_setting where distributor = '$data[6]' ")->fetch_array();
		$tgl_ambil=strtotime($data[7]);
		$tgl_sekarang=strtotime('Y-m-d H:i:s');
		$selisih = $tgl_sekarang - $tgl_ambil;
		$boleh=$toleransi[0]*86400;
		$retur=$conn->query("SELECT SUM(jumlah_barang) FROM tabel_retur where no_faktur='".$data['1']."' AND kode_barang='".$data[4]."'")->fetch_array();
		$jumlah=$data[5]-$retur[0];
		$qty_retur=$retur[0];
			if ($toleransi[1]==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Retur Barang Tidak diijinkan oleh Distributor dimaksud";
			} else if ( $selisih > $boleh  ) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Retur Barang Melebihi Batas Yang ditentukan oleh Distributor dimaksud";
			} else {
            ?> <i class="fa fa-check fa-lg" style="color:green;"> </i><a href="javascript:autoInsert('<?=$data[0]?>','<?=$data[1]?>','<?=htmlspecialchars($data[2])?>','<?=$data[3]?>','<?=$data[4]?>','<?=$data[5]?>','<?=$data[6]?>','<?=$data[9]?>', '<?=$data[11]-$retur[0]?>');"><?=$data[1].'-'.surat_jalan($data[10])?>, Barang : <?=$data[2]?>, Jumlah Pengambilan : <?=$data[5]?>, Jumlah yang sudah diretur : <?=$qty_retur?> Maksimal Retur : <?=$data[11]-$retur[0]?><br>
            <?php
			}  
            endwhile;
		}

endif;


if (isset($_GET['transfer_barang'])) :

 $input = $_GET['input'];
 $id_gudang = $_GET['id_gudang'];

 //$jual=$conn->query("SELECT SUM(jumlah), kode_barang, nama_barang FROM alokasi_stok_jual WHERE nama_barang LIKE '%$input%' AND id_gudang='$id_gudang' AND kode_barang IN (SELECT kode_barang FROM stok_barang WHERE is_aktif = 0) ")->fetch_array(); 
$jual=$conn->query(" SELECT SUM(`jumlah`)-SUM(`is_ambil`), kode_barang, nama_barang FROM `barang_keluar` WHERE nama_barang LIKE '%$input%' AND id_gudang='$id_gudang' AND kode_barang IN (SELECT kode_barang FROM stok_barang WHERE is_aktif = 0) ")->fetch_array(); 

 $booking=$conn->query("SELECT SUM(jumlah) FROM alokasi_booking WHERE kode_barang = '$jual[1]' AND id_gudang='$id_gudang'")->fetch_array(); 

 if (strlen($input) < 3 ) {
 echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Input Nama Barang Minimal 3 Digit";
 
 } else if ($jual[0]-$booking[0] > 0) {
 
 $jumlah_data=$jual[0]-$booking[0];
 echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Nama Barang ".$jual[2]." [".$jual[1]."] Terdapat ".$jumlah_data." yang harus dilakukan Booking, <a href='booking.php?jumlah=$jumlah_data&kode_barang=$jual[1]&id_gudang=$id_gudang&nama_barang=$jual[2]'>KLIK DISINI</a> Untuk Melakukan Booking<br>";
 
 } else {
 
  	$query = $conn->query("SELECT a.id, a.jumlah, a.nama_barang, a.kode_barang, a.pintu_gudang, b.sisa_stok, b.satuan  from alokasi_stok AS a LEFT JOIN stok_barang AS b ON a.kode_barang = b.kode_barang where a.id_gudang = '$id_gudang' AND a.nama_barang like '%$input%' AND b.is_aktif = 0 AND a.jumlah > 0 "); 
	$hasil = $query->num_rows;
	
		if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Nama Barang ".$input." Tidak Ada di Daftar Stok<br>";
			} else {
			while ($x = $query->fetch_array()) :
			$sisa_sql=$conn->query("SELECT SUM(jumlah) FROM alokasi_booking WHERE id_gudang='$id_gudang' AND pintu_gudang='$x[4]' AND kode_barang='$x[3]'")->fetch_array();
				if ($x[1]-$sisa_sql[0] > 0) : 
				$sisa=$x[1]-$sisa_sql[0];
				?>
                <i class="fa fa-check fa-lg" style="color:green;"> </i><a href="javascript:autoInsert('<?=$x[0]?>','<?=$sisa?>','<?=htmlspecialchars($x[2])?>','<?=$x[3]?>','<?=$x[4]?>');"><?=$x[2]?> [<?=$x[3]?>], Maksimal Transfer : <?=$sisa?>, Stok Fisik di Pintu/Ruang Sekat <?=$x[4]?> Sebanyak <?=$x[1]?><br>
                <?php
				endif;
			endwhile;
			}
 
 }


endif;



?>