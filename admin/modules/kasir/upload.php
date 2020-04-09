<?php
include '../../../sysconfig.php';

if(isset($_FILES["image_upload"]["name"])) {

$distributor=$_POST['distributor'];
$url=$_POST['url'];
$url=str_replace(":","&",$url);
$no_faktur=$_POST['no_faktur'];
$jenis=$_POST['jenis'];
$id_toko=$_POST['id_toko'];
$id_pengambilan=$_POST['id_pengambilan'];
	if (!empty($_POST['id_trx'])) {
	$id_trx=$_POST['id_trx'];
	} else {
	$id_trx=$_POST['no_faktur'];
	}
 $name = $_FILES["image_upload"]["name"];
 $size = $_FILES["image_upload"]["size"];
 $tmp_file = $_FILES['image_upload']['tmp_name'];
 $ext = strtolower(end(explode(".", $name)));
 $allowed_ext = array("png", "jpg", "jpeg", "pdf");
 if(in_array($ext, $allowed_ext)) {
  if($size < (1024*1024)) {
   		
		if ($jenis==2) {
		$new_name = $id_pengambilan.'-'.$distributor.'-'.$jenis.'.' . $ext;
		$id_trx=$id_pengambilan;
		} else if ($jenis==3) {
		$new_name = $id_trx.'-'.$distributor.'-'.$jenis.'.' . $ext;
		$id_trx=$id_trx;
		} else {
   		$new_name = $no_faktur.'-'.$distributor.'-'.$jenis.'.' . $ext; 
		$id_trx=$no_faktur;
		}  

   $path = $_SERVER['DOCUMENT_ROOT']."/folder_upload/penjualan/" . $new_name;  
	move_uploaded_file($tmp_file, $path);
	$ada = $conn->query("SELECT * from tabel_arsip WHERE id_trx='$id_trx' AND distributor='$distributor' AND id_jenis ='$jenis' ")->num_rows;	
	if ($ada == 0) {
	$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_toko`, `id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) SELECT '$id_toko', '$jenis', no_faktur, '$id_trx', distributor, '$new_name' FROM tabel_trx WHERE no_faktur='$no_faktur' AND distributor='$distributor' ");
	} else {
	$masuk=$conn->query(" UPDATE `tabel_arsip` SET file =  '$new_name' WHERE id_trx='$id_trx' AND distributor='$distributor' AND id_jenis ='$jenis' ");
	}
	echo json_encode(array('status' =>true, 'pesan' => 'Upload Berhasil'));
   
  } else {
   echo json_encode(array('error' =>true, 'pesan' => 'File Maksimal 1 MB'));
  }
 }
 else
 {
  echo json_encode(array('error' =>true, 'pesan' => 'Ekstensi File Tidak Diizinkan'));			
 }
}
else
{
			
  echo json_encode(array('error' =>true, 'pesan' => 'Anda belum memilih File'));			
 
}
?>