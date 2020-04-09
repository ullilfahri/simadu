<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_POST['proses_upload'])) :

if(isset($_FILES["image_upload"]["name"])) {
$distributor=$_POST['distributor'];
$url_pecah=explode('-',$_POST['url']);
$awal=$url_pecah[0];
$akhir=$url_pecah[1];
$no_faktur=$_POST['no_faktur'];
$id=$_POST['id'];
$jenis=$_POST['jenis'];
$id_trx=$_POST['id_trx'];
 $name = $_FILES["image_upload"]["name"];
 $size = $_FILES["image_upload"]["size"];
 $tmp_file = $_FILES['image_upload']['tmp_name'];
 $ext = strtolower(end(explode(".", $name)));
 $allowed_ext = array("png", "jpg", "jpeg", "pdf");
 if(in_array($ext, $allowed_ext)) {
  if($size < (1024*1024)) {
   		
$new_name = $id_trx.'-'.$distributor.'-'.$jenis.'.' . $ext;

   $path = $_SERVER['DOCUMENT_ROOT']."/folder_upload/pajak_penjualan/" . $new_name;  
	move_uploaded_file($tmp_file, $path);
	$ada = $conn->query("SELECT * from tabel_arsip WHERE id_trx='$id_trx' AND distributor='$distributor' AND id_jenis ='$jenis' ")->num_rows;	
	if ($ada == 0) :
	$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES( '$jenis', '$no_faktur', '$id_trx', '$distributor', '$new_name') ");
	endif;
	
	echo "<script>window.alert('Berhasil, File Diupload..!')
    		window.location='pajak_penjualan.php?sukses_upload=ungh_dokumen&awal=$awal&akhir=$akhir'</script>";
			
			
   
  } else {
   echo "<script>window.alert('Gagal, File Gambar Maksimal 1 MB')
    		window.location='unggah_dokumen.php?no_faktur=$no_faktur&sukses_upload=ungh_dokumen'</script>";
  }
 }
 else
 {
  echo "<script>window.alert('Gagal, Ekstensi File Tidak Diizinkan')
    		window.location='unggah_dokumen.php?no_faktur=$no_faktur&sukses_upload=ungh_dokumen'</script>";
 }
}
else
{
 echo "<script>window.alert('Gagal, Anda belum memilih File')
    		window.location='unggah_dokumen.php?no_faktur=$no_faktur&sukses_upload=ungh_dokumen'</script>";
 
}

endif;

if (isset($_GET['modal_upload'])) :

$pecah = explode('#',$_POST['rowid']);
$id_trx=$pecah[0];
$distributor=$pecah[1];
$id=$pecah[2];
$no_faktur=$pecah[3];
$url=$pecah[4];
?>
                           <form class="form-horizontal" enctype="multipart/form-data" method="post" id="upload_image" action="upload.php">
                           <input type="hidden" name="distributor"  id="distributor" value="<?=$distributor?>">
                           <input type="hidden" name="id_trx"  id="id_trx" value="<?=$id_trx?>">
                           <input type="hidden" name="id"  id="id" value="<?=$id?>">
                           <input type="hidden" name="no_faktur"  id="no_faktur" value="<?=$no_faktur?>">
                           <input type="hidden" name="url"  id="url" value="<?=$url?>">
                           <?=$url?>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                    <label for="File">Konfirmasi Jenis Dokumen</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                        	<div class="form-line">
                                                <select name="jenis" id="jenis" class="form-control jenis_mdl" onChange="ubah_surat_jalan();" required>
                                                <option value="">--Pilih Jenis Dokumen--</option>
                                                <option value="7">Pajak Penjualan</option>
                                                </select>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                    <label for="File2">Pilih File</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                        	<div class="form-line">
                                                <input type="file" name="image_upload" id="image_upload" accept=".jpg, .png, .pdf" required>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <button type="submit" name="proses_upload" class="btn bg-blue waves-effect">
                        		 <i class="fa fa-check"></i><span>Upload</span>
                          		 </button>
                            </form>    



<?php
endif;
?>