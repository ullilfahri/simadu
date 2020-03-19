<?php 
include '../../../../sysconfig.php';


if (isset($_GET['manual'])) :
//$nama = $_POST['rowid'];
$nama = explode("#",$_POST['rowid']);
?>
                            <form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                            <input type="hidden" name="nama" value="<?=$nama[0]?>" />
                            <input type="hidden" name="id_trx" value="<?=$nama[1]?>" />
                            <input type="hidden" name="id_jenis" value="<?=$nama[2]?>" />
                            <input type="hidden" name="url" value="<?=$nama[3]?>" />
                            <input type="hidden" name="distributor" value="<?=$nama[4]?>" />
                            <input type="hidden" name="no_faktur" value="<?=$nama[5]?>" />
                            
                            
                            <input type="hidden" name="proses_upload"/>
                            <label for="email_address">Upload File</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="gambar" required>
                                    </div>
                                </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning waves-effect">SIMPAN</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>

<?php
endif;


if (isset($_POST['proses_upload'])) :
$name = $_FILES["gambar"]["name"];
$ext = strtolower(end(explode(".", $name)));

$id_trx = $_POST['id_trx'];
$id_jenis = $_POST['id_jenis'];
$url = $_POST['url'];
$distributor = $_POST['distributor'];
$no_faktur = $_POST['no_faktur'];
$nama_baru=$_POST['nama'].'-'.$url;
$file = $_FILES['gambar']['name'];
$ukuran_file = $_FILES['gambar']['size'];
$tipe_file = $_FILES['gambar']['type'];
$tmp_file = $_FILES['gambar']['tmp_name'];
$nama_file=$nama_baru.$ext;
$ada=$conn->query("select COUNT(*), file, id from tabel_arsip where id_jenis='$id_jenis' and id_trx='$id_trx' and distributor='$distributor' and no_faktur='$no_faktur'")->fetch_array();


$path = $nama_file;
$file_sql='upload/'.$path;

if($tipe_file == "image/jpeg" || $tipe_file == "image/jpg" || $tipe_file == "image/png" || $tipe_file == "application/pdf"){ 

  if($ukuran_file <= 1000000){ 
    if(move_uploaded_file($tmp_file, $path)){
	  if ($ada[0]==0) {
      $sql = $conn->query("INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES ('$id_jenis', '$no_faktur', '$id_trx', '$distributor', '$file_sql') ");
	  } else {
	  unlink($ada[1]);
	  $sql = $conn->query("UPDATE `tabel_arsip` SET file = '$file_sql' where id='".$ada[2]."' ");
	  }
      
      if($sql){
        echo "<script>window.alert('File Diupload') 
		window.location='../index.php?$url'</script>";		
      }else{
        echo "<script>window.alert('File Gagal Diupload') 
		window.location='../index.php?$url'</script>";		
      }
    }else{
        echo "<script>window.alert('File Gagal Diupload') 
		window.location='../index.php?$url'</script>";		
    }
  }else{
        echo "<script>window.alert('File Terlalu Besar') 
		window.location='../index.php?$url'</script>";		
  }
}else{
        echo "<script>window.alert('Hanya JPG, PNG dan PDF yang diperbolehkan') 
		window.location='../index.php?$url'</script>";		
}
endif;
	
?>