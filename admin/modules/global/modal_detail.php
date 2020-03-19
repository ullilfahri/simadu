<?php
include '../../../sysconfig.php';

if (isset($_GET['tampil_modal'])) :
$tabel=$_GET['tabel'];
$jenis_id=$_GET['jenis_id'];
$id=$_POST['rowid'];
$trx=$conn->query("SELECT * from biaya_operasional where id_pembelian=$id");
$tot_biaya=$conn->query("SELECT SUM(jumlah_biaya) from biaya_operasional where id_pembelian=$id")->fetch_array();
$total=$tot_biaya[0];
?>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-biaya">
		<thead>
			<tr>
				<th>No</th>
				<th>Jenis Biaya</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="2">Total</th>
				<th class="align-right"><?=angka($total)?></th>
			</tr>
		</tfoot>
		<tbody>
<?php
$no=1;
while ($x=$trx->fetch_array()) :
?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$x['jenis_biaya']?></td>
				<td class="align-right"><?=angka($x['jumlah_biaya'])?></td>
			</tr>
<?php endwhile;?>     
		</tbody>
	</table>         
</div>

<script language="javascript">
$(function () {
    //Exportable table
    $('.js-biaya').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'excel'
        ]
    });
});
</script>                            
<?php endif; ?>

<?php
if (isset($_GET['rincian_bayar'])) :
$pecah=explode('#', $_POST['rowid']);
$id=$pecah[0];
$tabel=$pecah[1];
$bank=$conn->query("SELECT user_approve, tgl_approve, jumlah_bayar, id_bank, id, file from konfirmasi_bank where id_bayar=$id ORDER BY tgl_approve DESC");
$tot_bank=$conn->query("SELECT SUM(jumlah_bayar) from konfirmasi_bank where id_bayar=$id")->fetch_array();
$tunai=$conn->query("SELECT user_approve, tgl_approve, jumlah_bayar, user_approve, id, file from konfirmasi_tunai where id_bayar=$id ORDER BY tgl_approve DESC");
$tot_tunai=$conn->query("SELECT SUM(jumlah_bayar) from konfirmasi_tunai where id_bayar=$id")->fetch_array();
$total=$tot_bank[0]+$tot_tunai[0];
if ($_GET['rincian_bayar']=='laporan') {
$dis='disabled';
} else {
$dis='';
}
?>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-biaya">
		<thead>
			<tr>
				<th class="align-center">No</th>
				<th class="align-center">User</th>
				<th class="align-center">Jenis Biaya</th>
				<th class="align-center">Jumlah</th>
				<th class="align-center">Keterangan</th>
				<th class="align-center">File</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="2">Total</th>
				<th colspan="2" class="align-right"><?=angka($total)?></th>
				<th  colspan="2"></th>
			</tr>
		</tfoot>
		<tbody>
<?php
$no=1;
while ($x=$bank->fetch_array()) :
$tgl=explode(' ',$x[1]);
$tgl=tanggal_indo($tgl[0]);
$user=$conn->query("SELECT nama from user where id = '$x[0]'")->fetch_array();
$det_bank=$conn->query("SELECT bank, no_rek FROM rekening_bank where id='$x[3]'")->fetch_array();
?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$user[0]?></td>
				<td><?=$tgl?></td>
				<td class="align-right"><?=angka($x[2])?></td>
				<td class="align-left">Transfer Dari <?=$det_bank[0].' No Rek. '.$det_bank[1]?></td>
				<td class="align-center"><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_upload" data-id="<?=$x[4].'#'.$id.'#konfirmasi_bank'.'#'.$x[5]?>" <?=$dis?>>Upload</button>
                <?php if ($x[5] !='') : ?>
                <br><br><br><a href="../pdf_viewer/tampil_file.php?dir=bukti_bayar&file=<?=$x[5]?>" target="_blank"><button type="button" class="btn btn-success btn-xs">Tampil</button></a>
                <?php endif;?>
                </td>
			</tr>
            
            
<?php endwhile;?> 
<?php
$ny=$no;
while ($y=$tunai->fetch_array()) :
$tgl_y=explode(' ',$y[1]);
$tgl_y=tanggal_indo($tgl_y[0]);
$user_2=$conn->query("SELECT nama from user where id = '$y[0]'")->fetch_array();
?>
			<tr>
				<td><?=$ny++?></td>
				<td><?=$user_2[0]?></td>
				<td><?=$tgl_y?></td>
				<td class="align-right"><?=angka($y[2])?></td>
				<td class="align-left">Pembayaran Tunai</td>
				<td class="align-center"><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_upload" data-id="<?=$y[4].'#'.$id.'#konfirmasi_tunai'.'#'.$y[5]?>" <?=$dis?>>Upload</button>
                <?php if ($y[5] !='') : ?>
                <br><br><br><a href="../pdf_viewer/tampil_file.php?dir=bukti_bayar&file=<?=$y[5]?>" target="_blank"><button type="button" class="btn btn-success btn-xs">Tampil</button></a>
                <?php endif;?>
                </td>
			</tr>
<?php endwhile;?> 
    
		</tbody>
	</table>         
</div>

<script language="javascript">
$(function () {
    //Exportable table
    $('.js-biaya').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy'
        ]
    });
});
</script>                            
<?php endif; ?>

<?php
if (isset($_GET['modal_upload_bayar'])) :

$pecah = explode('#', $_POST['rowid']);
$id=$pecah[0];
$id_pembelian=$pecah[1];
$tabel=$pecah[2];
$file_lama=$pecah[3];

?>

							<form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?=$id?>" />
                            <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>" />
                            <input type="hidden" name="tabel" value="<?=$tabel?>" />
                            <input type="hidden" name="file_lama" value="<?=$file_lama?>" />

                            <label for="email_address">Upload File</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="gambar" required>
                                    </div>
                                </div>
                        <div class="modal-footer">
                            <button type="submit" name="upload_bukti_bayar" class="btn btn-warning waves-effect">SIMPAN</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>

<?php
endif;

if (isset($_POST['upload_bukti_bayar'])) :
$id_pembelian=$_POST['id_pembelian'];
$id=$_POST['id'];
$tabel=$_POST['tabel'];
$nama_baru=$_POST['id_pembelian'].'-'.$id.'-'.$tabel;

$file = $_FILES['gambar']['name'];
$ukuran_file = $_FILES['gambar']['size'];
$tipe_file = $_FILES['gambar']['type'];
$tmp_file = $_FILES['gambar']['tmp_name'];
$nama_file=$nama_baru.$file;

$path = $_SERVER['DOCUMENT_ROOT']."/folder_upload/bukti_bayar/".$nama_file;
$file_lama=$_SERVER['DOCUMENT_ROOT']."/folder_upload/bukti_bayar/".$_POST['file_lama'];

if($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "application/pdf"){ 

  if($ukuran_file <= 1000000){ 
    if(move_uploaded_file($tmp_file, $path)){ 
      $sql = $conn->query("UPDATE $tabel set file='$nama_file' where id='$id'");
      
      if($sql){
	  	if (file_exists($file_lama)) : unlink($file_lama); endif;
        echo "<script>window.alert('File Diupload') 
		window.location='../hutang_piutang/hutang.php?KjnHTG'</script>";
		
      }else{
        echo "<script>window.alert('File Gagal Diupload') 
		window.location='../hutang_piutang/hutang.php?KjnHTG'</script>";
      }
    }else{
        echo "<script>window.alert('File Gagal Diupload') 
		window.location='../hutang_piutang/hutang.php?KjnHTG'</script>";
    }
  }else{
        echo "<script>window.alert('Ukuran Terlalu Besar') 
		window.location='../hutang_piutang/hutang.php?KjnHTG'</script>";
  }
}else{
        echo "<script>window.alert('Hanya JPG, PNG dan PDF yang diperbolehkan') 
		window.location='../hutang_piutang/hutang.php?KjnHTG'</script>";
}
endif;
