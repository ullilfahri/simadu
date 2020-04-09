<?php
include '../../../sysconfig.php';
if (isset($_GET['input'])) {

        $input = $_GET['input'];

        $query = $conn->query("SELECT `id`, `id_gudang`, `id_gudang`, `nama_barang`, `kode_barang`, `distributor`, SUM(jumlah) FROM `alokasi_stok` WHERE kode_barang LIKE '%$input%' AND jumlah > 0 OR nama_barang LIKE '%$input%' AND jumlah > 0 GROUP BY kode_barang,id_gudang "); //query mencari hasil search

        $hasil = $query->num_rows;
		
		if ($hasil==0) {
		echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Tidak Ada Barang ".$input;
        } else  {

            while ($data = $query->fetch_array()) {
			$lokasi=$conn->query("SELECT nama from lokasi where id_lokasi = '".$data[1]."' ")->fetch_array();
			$stok= $conn->query("SELECT * FROM `stok_barang` WHERE `kode_barang` = '".$data[4]."' AND `distributor` = '".$data[5]."' ")->fetch_array();
			$stok_jual = $conn->query("SELECT SUM(jumlah) FROM `alokasi_stok_jual` WHERE kode_barang = '$data[4]' AND id_gudang = '$data[1]' GROUP BY id_gudang, kode_barang")->fetch_array();
			
			
			$stok_fisik=$conn->query(" SELECT SUM(jumlah) FROM alokasi_stok where kode_barang = '$data[4]'  AND id_gudang = '$data[1]' ")->fetch_array();
			$belum_ambil=$conn->query(" SELECT SUM(`jumlah`)-SUM(`is_ambil`) FROM `barang_keluar` where kode_barang = '$data[4]'  AND id_gudang = '$data[1]' ")->fetch_array();
			$belum_final=$conn->query("SELECT SUM(jumlah) FROM tabel_trx where kode_barang = '$data[4]'  AND id_gudang = '$data[1]' AND no_faktur IN (SELECT no_faktur FROM tabel_faktur WHERE total_trx=0) ")->fetch_array();
			
			
			//$ada_jual=$data[6]-$stok_jual[0];
			$ada_jual=$stok_fisik[0]-$belum_ambil[0]-$belum_final[0];
			$act=$conn->query("SELECT * FROM stok_barang where is_aktif=1 AND kode_barang='".$data[4]."'")->num_rows;
				if ($ada_jual==0){
				echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> ".$data[3]." Tidak Ada Stok di Gudang ".$lokasi[0]."<br>";
				} else {
				$level=$conn->query(" SELECT kode_barang, level_1, level_2, level_3 FROM stok_barang where kode_barang = '".$data[4]."' ")->fetch_array();
			if ($act ==0)	:
            ?>
            <i class='fa fa-check fa-lg' style='color:green;'>  </i><a href="javascript:autoInsert('<?=$data[0]?>','<?=$data[4]?>','<?=htmlspecialchars($data[3])?>','<?=angka($stok['harga_barang'])?>','<?=$stok['sisa_stok']?>','<?=$data[1]?>','<?=$ada_jual?>','<?=$lokasi[0]?>','<?=$stok['satuan']?>','<?=$data[5]?>','<?=$data[2]?>','<?=$level[1]?>','<?=$level[2]?>','<?=$level[3]?>');"><?=$data[4].'-'.$data[3].' '.$lokasi[0].'  Stok Tersedia '.$ada_jual?><br> <!--- hasil
			id, kode_barang, nama_barang, harga_barang, sisa_stok, id_gudang, stok_gudang, nama_gudang, satuan, distributor  -->
            <?php
			endif;
				}	
            }    

        
		
		//} else if ($sisa[4] < 1) {
			//echo " <i class='glyphicon glyphicon-remove'></i> Tidak Ada Stok";
		
		}

    } 


if (isset($_GET['modal'])) :
$input = $_GET['modal'];

        $query = $conn->query(" SELECT nama, limit_kredit, id, non_aktif from tabel_customer where nama LIKE '%$input%'   and id > 0 LIMIT 0 , 5"); 
        $hasil = $query->num_rows;
		if ($hasil==0) {
		echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Tidak Ada Customer Dengan Nama ".$input;
        } else  {
		
            while ($data = $query->fetch_array()) :
			$hutang=$conn->query("select SUM(jumlah_transaksi), SUM(jumlah_bayar) from tabel_bayar where metode_bayar='1' and customer='".$data[2]."'")->fetch_array();
			$limit=$data[1]-($hutang[0]-$hutang[1]);
			if ($limit <= 0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Over Limit ".$data[0];
			} else if ($data[3]==1) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i>Customer ".$data[0].' Non Aktif';
			} else {
			?>
            <i class='fa fa-check fa-lg' style='color:green;'>  </i><a href="javascript:autoInsert3('<?=$data[0].' Limit Rp. '.angka($limit);?>','<?=$limit;?>','<?=$data[2];?>');"><?=$data[0].', Limit Kredit '.angka($limit)?><br> <!--- hasil -->
            <?php
			}
			endwhile;
			}

endif;


if (isset($_GET['diskon'])) :
$input = $_GET['diskon'];
$no_faktur = $_GET['no_faktur'];
        $query = $conn->query("SELECT `kode`, `jumlah_potongan`, `distributor`, `id`, `is_pakai`  FROM `kode_voucher` WHERE BINARY kode = '$input'"); 
        $hasil = $query->num_rows;
		if (strlen($input) != 5) {
		echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Kode Voucher Harus 5 Digit";
		} else if ($hasil==0) {
		echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Tidak Ada Kode Voucher : ".$input.", Kode Voucher Sensitive Case";
        } else  {
            while ($data = $query->fetch_array()) :
			$distributor = $conn->query("SELECT COUNT(*), sub_total, id, potongan FROM tabel_trx WHERE no_faktur = '$no_faktur' AND distributor='".$data[2]."' ")->fetch_array();
			if ($data[4]==1) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Kode Voucher : ".$input.", Sudah diklaim";
			} else if ($distributor[0]==0) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Kode Voucher : ".$input.", Hanya Untuk Produk ".$data[2];
			} else if ($distributor[1] < $data[1]) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Jumlah Potongan : ".angka($data[1]).", pada Produk ".$data[2]. ', Melebihi Sub Total, Mohon Cek Kembali Entry Keranjang Belanja';
			} else {
			$sub_total=$distributor[1]-$data[1];
			$id_trx=$distributor[2];
			$potongan=$distributor[3]+$data[1];
			?>
            <i class='fa fa-check fa-lg' style='color:green;'>  </i><a href="javascript:autoInsert2('<?=$data[0]?>','<?=angka($data[1])?>','<?=$data[2]?>','<?=$data[3]?>','<?=$sub_total?>','<?=$id_trx?>','<?=$potongan?>');"><?=$data[0].', Diskon Sebesar Rp. '.angka($data[1])?>
            <?php
			}
			endwhile;
			}

endif;
	
?>