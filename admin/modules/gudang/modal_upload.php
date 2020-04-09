<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['modal_upload'])) :
$pecah = explode('#',$_POST['rowid']);
$id_pengambilan=$pecah[0];
$distributor=$pecah[1];
$url=$pecah[2];
$no_faktur=$pecah[3];
?>
                           <input type="hidden" name="id_toko"  id="id_toko" value="<?=$_SESSION['toko']?>">
                           <input type="hidden" name="distributor"  id="distributor" value="<?=$distributor?>">
                           <input type="text" name="id_pengambilan"  id="id_pengambilan" value="<?=$id_pengambilan?>">
                           <input type="hidden" name="url"  id="url" value="<?=$url?>">
                           <input type="hidden" name="no_faktur"  id="no_faktur" value="<?=$no_faktur?>">
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

<?php
endif;
if (isset($_GET['proses_upload'])) :
$url=str_replace(":","&",$_POST['url']);
$distributor=$_POST['distributor'];
$no_faktur=$_POST['no_faktur'];
$jenis='2';
$id_toko=$_POST['id_toko'];
$id_pengambilan=$_POST['id_pengambilan'];
 $name = $_FILES["image_upload"]["name"];
 $size = $_FILES["image_upload"]["size"];
 $tmp_file = $_FILES['image_upload']['tmp_name'];
 $ext = strtolower(end(explode(".", $name)));
 $allowed_ext = array("png", "jpg", "jpeg", "pdf");
$new_name = $id_pengambilan.'-'.$distributor.'-2.' . $ext;

if(in_array($ext, $allowed_ext) && $size < (1024*1024)) {
	$path = $_SERVER['DOCUMENT_ROOT']."/folder_upload/penjualan/" . $new_name; 
	$eks=move_uploaded_file($tmp_file, $path);
	$ada = $conn->query("SELECT * from tabel_arsip WHERE id_trx='$id_pengambilan' AND distributor='$distributor' AND id_jenis ='2' ")->num_rows;	
	if ($ada == 0) :
	$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_toko`, `id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES ('$id_toko', '2', '$no_faktur', '$id_pengambilan', '$distributor', '$new_name') ");
	endif;
	if ($eks) {
		echo json_encode(array('status' =>true, 'pesan' => 'Entry Berhasil..!', 'url' =>$url ));
		} else {
		echo json_encode(array('error' =>true, 'pesan' => 'Entry Gagal..!', 'url' =>$url ));
		}
}

endif;
