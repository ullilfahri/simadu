<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['modal_upload'])) :
$id_trx = $_POST['id_trx'];
$no_faktur = $_POST['no_faktur'];
$distributor = $_POST['distributor'];
$uri = $_POST['uri'];

?>
                           <form class="form-horizontal" enctype="multipart/form-data" method="post" id="uploadForm" action="">
                           <input type="hidden" name="id_toko"  id="id_toko" value="<?=$_SESSION['toko']?>">
                           <input type="hidden" name="distributor"  id="distributor" value="<?=$distributor?>">
                           <input type="hidden" name="url"  id="url" value="<?=$uri?>">
                           <input type="hidden" name="id_trx"  id="id_trx" value="<?=$id_trx?>">
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
                                    
                                    <div class="modal-footer">
                                    <button type="submit" class="btn bg-blue waves-effect">
                                    <i class="fa fa-upload"></i><span>Upload</span>
                                    </button>
                                    <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                                    <i class="fa fa-times"></i><span>Tutup</span>
                                    </button>
                                    </div>
                                    
                                </div>
                             </form>   
    <script type="text/javascript">
        $('#image_upload').bind('change', function() {
			var angka = this.files[0].size/1024/1024;
			hasil = angka.toFixed(2);
			var val = $(this).val().toLowerCase(),regex = new RegExp("(.*?)\.(png|jpg|pdf)$");
			if (angka > 1) {
				swal("Gagal..!", "Ukuran Maksimal 1 MB, File ini berukuran : "+hasil+" MB", "error");
				$('.upload').modal('hide');
				} 
				
            if (!(regex.test(val))) {
            	$(this).val('');
            	swal("Gagal..!", "Hanya file pdf, png atau jpg yang diijinkan", "error");
				$('.upload').modal('hide');
        		}
			
        });
    </script>

<script type="application/javascript">
$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload_transfer.php?proses_upload",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result){
			var response = JSON.parse(result);
			if (response.status){
				swal({
  					title: "Status Upload",
  					text: response.pesan,
  					type: "success",
  					timer: 2000,
  					showConfirmButton: false
  					}, function(){
  					window.location.href = 'file_transfer.php?'+response.url;
  					});
				}  else if (response.error) {
				swal("Gagal", response.pesan, "error");
				} 
		    },
	   });
	}));
});
</script>
<?php
endif;


if (isset($_GET['proses_upload'])) :
$url=str_replace(":","&",$_POST['url']);
$distributor=$_POST['distributor'];
$no_faktur=$_POST['no_faktur'];
$jenis='3';
$id_toko=$_POST['id_toko'];
$id_pengambilan=$_POST['id_trx'];
 $name = $_FILES["image_upload"]["name"];
 $size = $_FILES["image_upload"]["size"];
 $tmp_file = $_FILES['image_upload']['tmp_name'];
 $ext = strtolower(end(explode(".", $name)));
 $allowed_ext = array("png", "jpg", "jpeg", "pdf");
$new_name = $id_pengambilan.'-'.$distributor.'-3.' . $ext;

if ($size > 1048576) :
echo json_encode(array('error' =>true, 'pesan' => 'File lebih dari 1 Mb..!'));
endif;

if(in_array($ext, $allowed_ext) && $size <= (1024*1024)) {
	$path = $_SERVER['DOCUMENT_ROOT']."/folder_upload/penjualan/" . $new_name; 
	$eks=move_uploaded_file($tmp_file, $path);
	$ada = $conn->query("SELECT * from tabel_arsip WHERE id_trx='$id_pengambilan' AND distributor='$distributor' AND id_jenis ='3' AND no_faktur='$no_faktur' ")->num_rows;	
	if ($ada == 0) {
	$ket='Simpan';
	$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_toko`, `id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES ('$id_toko', '3', '$no_faktur', '$id_pengambilan', '$distributor', '$new_name') ");
	} else {
	$ket='Update File';
	$masuk=$conn->query(" UPDATE `tabel_arsip` SET file = '$new_name' WHERE id_trx='$id_pengambilan' AND distributor='$distributor' AND id_jenis ='3' AND no_faktur='$no_faktur' ");
	}
	if ($eks) {
		echo json_encode(array('status' =>true, 'pesan' => $ket.' Berhasil..!', 'url' =>$url ));
		} else {
		echo json_encode(array('error' =>true, 'pesan' => 'Upload File Gagal..!', 'url' =>$url ));
		}
} 

endif;

if (isset($_GET['tutup_kunci'])) :

$tabel=$_GET['tabel'];
$jenis_id=$_GET['jenis_id'];
$url=$_GET['url'];
$id=$_POST['id'];

$aksi=$conn->query("UPDATE $tabel SET proses = 1 where $jenis_id = '$id' ");

echo json_encode(array('status' =>true, 'url' =>$url));

endif;

if (isset($_GET['buka_kunci'])) :

$tabel=$_GET['tabel'];
$jenis_id=$_GET['jenis_id'];
$id=$_POST['id'];
$url=$_GET['url'];
$aksi=$conn->query("UPDATE $tabel SET proses = 0 where $jenis_id = '$id' ");
echo json_encode(array('status' =>true, 'url' =>$url));

endif;
?>
