<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_POST['proses_upload'])) :
$uri=$_POST['uri'];
$uri=str_replace(":","&",$uri);
if(isset($_FILES["image_upload"]["name"])) {
$distributor=$_POST['distributor'];
$no_faktur=$_POST['no_faktur'];
$jenis=$_POST['jenis'];
$id_toko=$_POST['id_toko'];
$id_pengambilan=$_POST['id_pengambilan'];
if (!empty($_POST['id_trx'])) : $id_trx=$_POST['id_trx']; endif;
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
	$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_toko`, `id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES ('$id_toko', '$jenis', '$no_faktur', '$id_trx', '$distributor', '$new_name') ");
	} else {
	$masuk=$conn->query(" UPDATE tabel_arsip SET file='$new_name'  WHERE id_trx = '$id_trx' AND distributor ='$distributor' AND id_jenis='$jenis' AND no_faktur = '$no_faktur'");
	}
	echo "<script>window.alert('Berhasil, File Diupload..!')
    		window.location='unggah_dokumen.php?menu=$uri'</script>";
			
			
   
  } else {
   echo "<script>window.alert('Gagal, File Gambar Maksimal 1 MB')
    		window.location='unggah_dokumen.php?menu=$uri'</script>";
  }
 }
 else
 {
  echo "<script>window.alert('Gagal, Ekstensi File Tidak Diizinkan')
    		window.location='unggah_dokumen.php?menu=$uri'</script>";
 }
}
else
{
 echo "<script>window.alert('Gagal, Anda belum memilih File')
    		window.location='unggah_dokumen.php?menu=$uri'</script>";
 
}

endif;


if (isset($_GET['transaksi'])) :

$pecah = explode('#',$_POST['rowid']);
$no_faktur=$pecah[0];
$distributor=$pecah[1];
$trx=$conn->query("SELECT * FROM `ambil_barang` WHERE id_barang_keluar IN (SELECT id from barang_keluar  WHERE no_faktur='$no_faktur' AND distributor = '$distributor') AND id_gudang LIKE '%".$_SESSION['gudang']."%' AND is_final=1 ORDER BY id_pengambilan ASC");
?>


<div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>KODE</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY AMBIL</th>
                                            <th>TANGGAL AMBIL</th>
                                            <th>PINTU/RAK/RUANG</th>
                                            <th>NO SURAT JALAN</th>
                                            <th>STATUS UPLOAD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$trx->fetch_array()) :
									$y=$conn->query(" SELECT * from barang_keluar where id = '".$x['id_barang_keluar']."' ")->fetch_array();
									$status_sql=$conn->query("SELECT * FROM tabel_arsip where id_trx = '".$x['id_pengambilan']."' ")->num_rows;
									if ($status_sql > 0) {
									$status='<i class="glyphicon glyphicon-ok"></i>';
									} else {
									$status='<i class="glyphicon glyphicon-remove"></i>';
									}
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$y['kode_barang']?></td>
                                            <td><?=$y['nama_barang']?></td>
                                            <td><?=$x['jumlah_ambil'].' '.$y['satuan']?></td>
                                            <td><?=tanggal_indo(date('Y-m-d' ,$x['id_pengambilan']))?></td>
                                            <td><?=$x['pintu_gudang']?></td>
                                            <td><?=$y['no_faktur'].'-'.surat_jalan($x['partial'])?></td>
                                            <td class="align-center"><?=$status?></td>
                                        </tr>
                                    <?php endwhile; ?>    
                                    </tbody>
                                </table>
</div>


<?php
endif;

if (isset($_GET['modal_upload'])) :

$pecah = explode('#',$_POST['rowid']);
$uri=$_GET['uri'];
$no_faktur=$pecah[0];
$distributor=$pecah[1];
$id_pengambilan=$pecah[2];
$retur_barang=$conn->query(" SELECT * FROM tabel_retur WHERE kode=1 AND no_faktur = '$no_faktur' AND distributor = '$distributor' AND id_toko = '".$_SESSION['toko']."' ");
$ada_retur=$retur_barang->num_rows;
	if ($ada_retur==0) {
	$opsi_retur='';
	} else {
	$opsi_retur='';
	}
?>
                           <form class="form-horizontal" enctype="multipart/form-data" method="post" id="upload_image" action="upload.php">
                           <input type="hidden" name="id_toko"  id="id_toko" value="<?=$_SESSION['toko']?>">
                           <input type="hidden" name="distributor"  id="distributor" value="<?=$distributor?>">
                           <input type="hidden" name="no_faktur"  id="no_faktur" value="<?=$no_faktur?>">
                           <input type="hidden" name="uri"  id="uri" value="<?=$uri?>">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                    <label for="File">Konfirmasi Jenis Dokumen</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                        	<div class="form-line">
                                                <select name="jenis" id="jenis" class="form-control jenis_mdl" onChange="ubah_surat_jalan();" required>
                                                <option value="">--Pilih Jenis Dokumen--</option>
                                                <option value="2">SURAT JALAN</option>
                                                <?=$opsi_retur?>
                                                </select>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="field_surat_jalan" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                    <label for="File">Pilih Surat Jalan Dari Pengambilan Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                        	<div class="form-line">
                                                <select name="id_pengambilan" id="id_pengambilan" class="form-control">
                                    <?php
                                    $barang=$conn->query(" SELECT id_gudang, id_pengambilan, partial, SUM(jumlah_ambil) FROM ambil_barang where id_barang_keluar IN (SELECT id FROM barang_keluar where no_faktur='$no_faktur' AND distributor = '$distributor') AND id_pengambilan='$id_pengambilan' GROUP BY id_pengambilan");
									$ada=$barang->num_rows;
									if ($ada == 0) {
									echo '<option value="">Tidak Ada Dokumen Surat Jalan (Belum Ada Pengambilan) Pada No Faktur '.$no_faktur.' Dstributor '.$distributor.'</option>';
										} else {
										while ($x=$barang->fetch_array()) :
										$gd=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x[0]."'")->fetch_array();
									?>            
                                                <option value="<?=$x[1]?>">No Surat Jalan <?=$no_faktur.'-'.surat_jalan($x['partial'])?>, QTY Ambil <?=$x[3]?> Dari Gudang : <?=$gd[0]?></option>
                                        <?php endwhile; } ?>        
                                                </select>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                <div id="field_retur_barang" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                    <label for="File">Pilih Detail Retur</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                        	<div class="form-line">
                                                <select name="id_trx" id="id_trx" class="form-control">
                                    <?php
										while ($y=$retur_barang->fetch_array()) :
									?>            
                                                <option value="<?=$y['id_trx']?>">Tanggal Retur <?=tanggal_indo(date('Y-m-d',$y['id_trx']))?>, <?=$y['nama_barang'].' '.$y['jumlah_barang'].' '.$y['satuan']?></option>
                                        <?php endwhile;  ?>        
                                                </select>
                                            </div>    
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
<script>
function ubah_surat_jalan() {
    var jenis = document.getElementById('jenis').value;
    var field_surat_jalan = document.getElementById('field_surat_jalan');
    var field_retur_barang = document.getElementById('field_retur_barang');
    if (jenis == '2') {
        field_surat_jalan.style.display = 'block';
		document.getElementById('id_pengambilan').required=true;
        field_retur_barang.style.display = 'none';
		document.getElementById('id_trx').required=false;
    
    } else if (jenis == '3') {
        field_retur_barang.style.display = 'block';
		document.getElementById('id_trx').required=true;
        field_surat_jalan.style.display = 'none';
		document.getElementById('id_pengambilan').required=false;
	
	} else {
        field_surat_jalan.style.display = 'none';
		document.getElementById('id_pengambilan').required=false;
        field_retur_barang.style.display = 'none';
		document.getElementById('id_trx').required=false;
    }
}
</script>


<?php
endif;
?>