<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>


<?php


if (isset($_POST['simpan_konfirmasi'])) :
$bank_asal = $_POST['bank_asal'];
$bank_tujuan = $_POST['bank_tujuan'];

if ($bank_asal==$bank_tujuan) {
        echo "<script>window.alert('GAGAL..Rekening Bank Asal Tidak Boleh Sama dengan Rekening Bank Transfer Tujuan') 
		window.location='entry_bank_baru.php?transfer_bank'</script>";

} else {

$distributor = $_POST['distributor'];
$user_approve = $_POST['user_approve'];
$bukti_bayar = $_POST['bukti_bayar'];
$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);
$ket = $_POST['keterangan'];
$keterangan=$ket.' No. transfer : '.$bukti_bayar;


$masuk = $conn->query(" INSERT INTO `konfirmasi_bank`(`user_approve`, `jumlah_bayar`, `keterangan`, `distributor`, jenis, `id_bank`) VALUES('$user_approve', '$jumlah_bayar', '$keterangan', '$distributor', '3', '$bank_tujuan') ");
$masuk = $conn->query(" INSERT INTO `konfirmasi_bank`(`user_approve`, `jumlah_bayar`, `keterangan`, `distributor`, jenis, `id_bank`) VALUES('$user_approve', '$jumlah_bayar', '$keterangan', '$distributor', '4', '$bank_asal') ");

			if ($masuk) { 
				echo "<script>window.alert('Data Tersimpan') 
		window.location='entry_bank_baru.php?transfer_bank'</script>";
				} else {
				echo "<script>window.alert('Data Gagal Tersimpan') 
		window.location='entry_bank_baru.php?transfer_bank'</script>";
				}

}
endif;
?>