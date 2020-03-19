<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['entry_pembelian'])) :

        $input = $_GET['input'];

        $query = $conn->query("SELECT id, kode_barang, nama_barang FROM stok_barang WHERE nama_barang like '%$input%' and distributor like '%".$_SESSION['distributor']."%' LIMIT 0 , 5"); //query mencari hasil search
		
        $ganda = $conn->query("SELECT COUNT(a.id), b.pengguna, b.kode FROM stok_barang as a left join mst_hak_akses as b ON a.distributor = b.kode WHERE a.nama_barang like '%$input%' and a.distributor NOT LIKE '%".$_SESSION['distributor']."%'")->fetch_array(); 

        $hasil = $query->num_rows;
		
		 if (strlen($input) < 4) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Karakter Minimal 4 Digit";

		 } else if ($ganda[0]>0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$input." Distributor ".$ganda[1]." <a href='tambah_kode.php?input=$input&distributor=$ganda[2]'>Klik Disini</a> untuk Tambah Barang";
		
		} else if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$input." Belum Ada di Database <a href='tambah_kode.php?input=$input'>Klik Disini</a> untuk Tambah Barang";
        } else {

            while ($data = $query->fetch_array()) {
            ?>

            <i class='fa fa-check fa-lg' style='color:green;'>  </i><a href="javascript:autoInsert('<?=$data[0]?>','<?=$data[1]?>','<?=htmlspecialchars($data[2])?>');"><?=$data[2].' ['.$data[1].'}'?><br> <!--- hasil -->

            <?php
            }    
		}

endif;


if (isset($_GET['alokasi_stok'])) :

        $input = $_GET['input'];

        $query = $conn->query("SELECT sisa_stok, nama_barang, kode_barang, distributor FROM stok_barang WHERE nama_barang like '%$input%' and distributor like '%".$_SESSION['distributor']."%' LIMIT 0 , 5"); //query mencari hasil search

        $hasil = $query->num_rows;
		
		if ($hasil==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$input." Tidak Ada di Database<br>";
        } else {
            while ($data = $query->fetch_array()) {
			$stok=$conn->query("select SUM(jumlah) from alokasi_stok where kode_barang='".$data[2]."'")->fetch_array();
			$sisa=$data[0]-$stok[0];
            if ($sisa < 1) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Barang ".$data[1]." Tidak ada stok<br>";
			} else {
			?>
            <i class='fa fa-check fa-lg' style='color:green;'> </i><a href="javascript:autoInsert('<?=$sisa?>','<?=htmlspecialchars($data[1])?>','<?=$data[2]?>','<?=$data[3]?>');"><?=$data[1].' Stok : '.$sisa?><br> <!--- hasil -->
            <?php
			  }
            }    
		}

endif;

?>