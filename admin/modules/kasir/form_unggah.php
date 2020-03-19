<?php 
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['entry_no_faktur'])) :

        $input = $_GET['input'];
		$toko=$conn->query("select nama from lokasi where id_lokasi = '".$_SESSION['toko']."'")->fetch_array();
        $query = $conn->query("SELECT id, no_faktur, distributor FROM tabel_trx WHERE no_faktur = '$input' and distributor NOT LIKE '%INDV%' and id_toko = '".$_SESSION['toko']."'"); //query mencari hasil search
		
        $hasil = $query->num_rows;
		
		 if (strlen($input) <> 10) {
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Karakter Harus 10 Digit";

        	} else if ( $hasil==0 ){
			echo " <i class='fa fa-ban fa-lg' style='color:red;'></i> Tidak Ada Invoice dengan Nomor ".$input. " Toko ".$toko[0];
			} else {

            while ($data = $query->fetch_array()) {
            ?>

            <i class='fa fa-check fa-lg' style='color:green;'>  </i><a href="javascript:autoInsert('<?=$data[0]?>','<?=$data[1]?>','<?=$data[2]?>');"><?=$data[1].' Distributor : '.$data[2]?><br> <!--- hasil -->

            <?php
            }    
		}

endif;

if (isset($_GET['scan'])):
$id_trx= $_GET['id_trx'];
$jenis= $_GET['jenis'];
$data=$conn->query("select * from tabel_trx where id = '$id_trx'")->fetch_array();
$ada=$conn->query("SELECT * FROM `tabel_arsip` WHERE `id_toko`='".$_SESSION['toko']."' and `id_jenis`='$jenis' and `no_faktur`='".$data['no_faktur']."' and `id_trx`='$id_trx' and `distributor`='".$data['distributor']."'")->num_rows;
$nama_baru=$data['no_faktur'].'-'.$data['distributor'].'-'.$jenis; 
$file = $_FILES['asprise_scans']['name'];
$nama_file=$nama_baru.$file;
$ukuran_file = $_FILES['asprise_scans']['size'];
$tipe_file = $_FILES['asprise_scans']['type'];
$tmp_file = $_FILES['asprise_scans']['tmp_name'];
$path = "../stok/upload/".$nama_file;

$terupload = move_uploaded_file($tmp_file, $path);


if ($terupload && $ada==0) {
$path_baru='../stok/upload/'.$nama_baru.'.pdf';
$real_path='../stok/upload/'.$nama_baru.'.pdf';
$conn->query("INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `file`, `distributor`, `id_toko`) VALUES ('$jenis', '".$data['no_faktur']."', '$id_trx', '$real_path', '".$data['distributor']."', '".$_SESSION['toko']."')");
rename($path, $path_baru);

		  	switch ($jenis) {
			case '1':
			$direct='fktr_penjualan';
			break;
			case '2':
			$direct='srt_jalan';
			break;
			case '3':
			$direct='bkt_ambil';
			break;
			default:
			$direct='ungh_dokumen';
			break;
			}	
echo '{"ket":"success", "url":"tampil_arsip='.$direct.'", "txt":"Scan Sukses..!"}';

} else {
echo '{"ket":"error", "url":"ungh_dokumen", "txt":"File Update..!"}';
}

endif;

if (isset($_POST['proses_upload'])) :
$id_trx= $_POST['id_trx'];
$jenis= $_GET['jenis'];
$data=$conn->query("select * from tabel_trx where id = '$id_trx'")->fetch_array();
$nama_baru='../stok/upload/'.$data['no_faktur'].'-'.$data['distributor'].'-'.$jenis; 
$file = $_FILES['gambar']['name'];
$nama_file=$nama_baru.$file;
$ukuran_file = $_FILES['gambar']['size'];
$tipe_file = $_FILES['gambar']['type'];
$tmp_file = $_FILES['gambar']['tmp_name'];

		  	switch ($jenis) {
			case '1':
			$direct='fktr_penjualan';
			break;
			case '2':
			$direct='srt_jalan';
			break;
			case '3':
			$direct='bkt_ambil';
			break;
			default:
			$direct='ungh_dokumen';
			break;
			}	



$path = $nama_file;

if($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "application/pdf"){ 

  if($ukuran_file <= 1000000){ 
    if(move_uploaded_file($tmp_file, $path)){
      $conn->query("INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `file`, `distributor`, `id_toko`) VALUES ('$jenis', '".$data['no_faktur']."', '$id_trx', '$path', '".$data['distributor']."', '".$_SESSION['toko']."')");

      
      if($sql){
        echo "<script>window.alert('File Diupload') 
		window.location='unggah_dokumen.php?tampil_arsip=$direct'</script>";		
      }else{
        echo "<script>window.alert('File Gagal Diupload') 
		window.location='unggah_dokumen.php?tampil_arsip=$direct'</script>";		
      }
    }else{
        echo "<script>window.alert('File Gagal Diupload') 
		window.location='unggah_dokumen.php?tampil_arsip=$direct'</script>";		
    }
  }else{
        echo "<script>window.alert('File Terlalu Besar') 
		window.location='unggah_dokumen.php?tampil_arsip=$direct'</script>";		
  }
}else{
        echo "<script>window.alert('Hanya JPG, PNG dan PDF yang diperbolehkan') 
		window.location='unggah_dokumen.php?tampil_arsip=$direct'</script>";		
}
endif;


if (isset($_GET['update_customer'])) :

$tipe_pelanggan = $_POST['tipe_pelanggan'];
$no_faktur = $_POST['no_faktur'];

	if ($tipe_pelanggan==0) {
		$array = Array (
				"umum" => Array (
        		"nama" => $_POST['nama_umum'],
        		"alamat" =>  $_POST['alamat_umum'],
        		"kota" =>  $_POST['kota_umum'],
				"hp" =>  $_POST['hp_umum'],
				));
		$cus_umum = json_encode($array);
		$update=$conn->query(" UPDATE tabel_faktur SET cus_umum='$cus_umum' WHERE no_faktur = '$no_faktur' ");
		} else {
		$customer=$_POST['customer'];
		$update=$conn->query(" UPDATE tabel_faktur SET customer='$customer' WHERE no_faktur = '$no_faktur' ");
		}	

endif;

?>