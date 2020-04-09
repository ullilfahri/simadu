<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

if (isset($_GET['pendapatan'])) :
$id = $_POST['rowid'];
$data=$conn->query("select * from tabel_bayar where id='$id' ")->fetch_array();
$stok=$conn->query("select SUM(sub_total), SUM(jumlah), SUM(potongan), harga_barang, nama_barang, id_gudang  from tabel_trx where no_faktur='$data[no_faktur]' and distributor='$data[distributor]' GROUP by kode_barang, id_gudang  ");
$total=$conn->query("select SUM(sub_total) from tabel_trx where no_faktur='$data[no_faktur]' and distributor='$data[distributor]'")->fetch_array();

if ($data['metode_bayar']==1) {
$faktur=$conn->query("select * from tabel_faktur where no_faktur='$data[no_faktur]' ")->fetch_array();
$hutang=$data['jumlah_transaksi']-$data['jumlah_bayar'];
$tempo='Piutang, '.rupiah($hutang).', Jatuh Tempo '.tanggal_indo($faktur['jatuh_tempo']);
} else {
$tempo='Tunai';
}
?>

                                <table class="table js-exportable-beli">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga Penjualan</th>
                                            <th>Jumlah Penjualan</th>
                                            <th>Potongan</th>
                                            <th>Sub Total</th>
                                            <th>Asal Stok</th>
                                            <th>Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
                                       		<th colspan="5" align="center">Total</th>
                                            <th colspan="3" align="center"><?=rupiah($total[0])?></th>
                                       </tr>    
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$gudang=$conn->query("select nama from lokasi where id_lokasi='".$x[5]."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x[4]?></td>
                                            <td><?=angka($x[3])?></td>
                                            <td><?=$x[1]?></td>
                                            <td><?=angka($x[2])?></td>
                                            <td><?=angka($x[0])?></td>
                                            <td><?=$gudang[0]?></td>
                                            <td><?=$tempo?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-beli').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           

<?php
endif;
if (isset($_GET['rincian_bayar'])) :
$pecah = explode('#',$_POST['rowid']);
$distributor=$pecah[0];
$no_faktur=$pecah[1];
$id_hutang=$pecah[2];
$data=$conn->query("select * from bayar_hutang where distributor='$distributor' and no_faktur='$no_faktur' and id_hutang='$id_hutang'");
?>

                                <table class="table js-exportable-beli">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Distributor</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal Approve</th>
                                            <th>User Approve</th>
                                            <th>Jumlah Pembayaran</th>
                                            <th>Via Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$data->fetch_array()) :
									$pecah=explode(' ',$x['tgl_transaksi']);
									$tanggal=tanggal_indo($pecah[0]);
									if ($x['user_approv']==0) {
									$user='Sistem SMS';
									} else {
									$user_approve=$conn->query("select nama from user where id='$x[user_approv]'")->fetch_array();
									$user=$user_approve[0];
									}
									$data_distributor=$conn->query("SELECT pengguna FROM `mst_hak_akses` WHERE `kode` = '$distributor'")->fetch_array();

									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$data_distributor[0]?></td>
                                            <td><?=$no_faktur?></td>
                                            <td><?=$tanggal?></td>
                                            <td><?=$user?></td>
                                            <td><?=angka($x['jumlah_bayar'])?></td>
                                            <td><?=$x['via_bayar']?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                 </table>
                                 
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-beli').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

<?php
endif;
if (isset($_GET['modal_bayar'])) :
$pecah = explode('#',$_POST['rowid']);
$id_hutang=$pecah[0];
$via_bayar=$pecah[1];
$data=$conn->query("select * from bayar_hutang where id_hutang='$id_hutang' ");
?>

                                <table class="table js-exportable-beli">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal</th>
                                            <th>User Approve</th>
                                            <th>Jumlah Pembayaran</th>
                                            <th>Via Pembayaran</th>
                                            <th>File Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$data->fetch_array()) :
									$pecah=explode(' ',$x['tgl_transaksi']);
									$tanggal=tanggal_indo($pecah[0]);
									if ($x['user_approv']==0) {
									$user='Sistem SMS';
									} else {
									$user_approve=$conn->query("select nama from user where id='$x[user_approv]'")->fetch_array();
									$user=$user_approve[0];
									}
									
									$file=$conn->query("SELECT COUNT(a.id), a.file, b.php_pdf FROM tabel_arsip AS a LEFT JOIN jenis_arsip AS b ON a.id_jenis=b.id where a.id_trx='".$x['id']."' AND a.no_faktur='".$x['no_faktur']."' AND a.id_jenis=11 AND a.distributor='".$x['distributor']."' ")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['no_faktur']?></td>
                                            <td><?=$tanggal?></td>
                                            <td><?=$user?></td>
                                            <td><?=angka($x['jumlah_bayar'])?></td>
                                            <td><?=$x['via_bayar']?></td>
                                            <td class="align-center"><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_upload" data-id="<?=$x['id']?>" data-distributor="<?=$x['distributor']?>" data-no_faktur="<?=$x['no_faktur']?>">Upload</button>
                <?php if ($file[0] > 0) : ?>
                <a href="<?=$file[2].$file[1]?>" target="_blank"><button type="button" class="btn btn-success btn-xs">Tampil</button></a>
                <?php endif;?>
                </td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                 </table>
                                 
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-beli').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>


<?php
endif;
if (isset($_GET['detail_penjualan'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from tabel_trx where kode_barang='$kode_barang'  GROUP by id_gudang, no_faktur ORDER BY no_faktur DESC");
?>

                                <table class="table js-exportable-jual">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga Penjualan</th>
                                            <th>Jumlah Penjualan</th>
                                            <th>Tanggal Penjualan</th>
                                            <th>Kasir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$det=$conn->query("select a.metode_bayar, b.nama from tabel_faktur as a left join user as b on a.kasir=b.id where a.no_faktur='".$x['no_faktur']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=date("d-m-Y, H:i:s", $x['no_faktur'])?></td>
                                            <td><?=$det[1]?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-jual').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           
<?php
endif;


if (isset($_GET['alokasi_stok'])) :
$kode_barang = $_POST['rowid'];
$stok=$conn->query("select * from alokasi_stok where kode_barang='$kode_barang' order by id_gudang ASC ");
?>

                                <table class="table js-exportable-stok">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Gudang</th>
                                            <th>Jumlah Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$det=$conn->query("select nama from lokasi where id_lokasi='".$x['id_gudang']."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$det[0]?></td>
                                            <td><?=$x['jumlah']?></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-stok').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            
                                                                           
<?php
endif;

if (isset($_GET['detail_surat_jalan'])) :
$no_faktur = $_POST['rowid'];

$stok=$conn->query("select SUM(sub_total), SUM(jumlah), SUM(potongan), harga_barang, nama_barang, id_gudang  from tabel_trx where no_faktur='$no_faktur' GROUP by kode_barang, id_gudang  ");

$total=$conn->query("select SUM(sub_total) from tabel_trx where no_faktur='$no_faktur'")->fetch_array();


?>

                                <table class="table js-exportable-jual">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga Penjualan</th>
                                            <th>Jumlah Penjualan</th>
                                            <th>Potongan</th>
                                            <th>Sub Total</th>
                                            <th>Asal Stok</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
                                       		<th colspan="5" align="center">Total</th>
                                            <th colspan="2" align="center"><?=rupiah($total[0])?></th>
                                       </tr>    
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
                                    while ($x=$stok->fetch_array()) :
									$gudang=$conn->query("select nama from lokasi where id_lokasi='".$x[5]."'")->fetch_array();
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x[4]?></td>
                                            <td><?=angka($x[3])?></td>
                                            <td><?=$x[1]?></td>
                                            <td><?=angka($x[2])?></td>
                                            <td><?=angka($x[0])?></td>
                                            <td><?=$gudang[0]?></td>
                                        </tr>
                                    <?php endwhile;?>
                                    </tbody>
                                 </table>
                             
<script language="javascript">
$(function () {
    //Exportable table
    $('.js-exportable-jual').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>                            

<?php
endif;

if (isset($_GET['pelunasan'])) :
$pecah=explode('#', $_POST['rowid']);
$id_pembelian=$pecah[0];
$tabel=$pecah[1];
$bayar=$conn->query("select * from $tabel where id_pembelian='$id_pembelian'")->fetch_array();
$supplier=$conn->query("select nama from tabel_supplier where id = $bayar[supplier]")->fetch_array();
?>
                            
                            <form method="post" action="detail.php" autocomplete="off">
                            <input type="hidden" name="user_approve" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>" />
                            <input type="hidden" name="tabel" value="<?=$tabel?>" />
                            <input type="hidden" name="no_faktur" value="<?=$bayar['no_faktur']?>" />
                            <input type="hidden" name="distributor" value="<?=$bayar['distributor']?>" />
                            <input type="hidden" name="bayar_lunas" />
                            
                            <label for="email_address">Supplier</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="supplier" class="form-control" value="<?=$supplier[0]?>" readonly>
                                    </div>
                                </div>
                            <label for="email_address">Jumlah Hutang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="hutang" value="<?=angka($bayar['jumlah_hutang'])?>" readonly>
                                    </div>
                                </div>
                            <label for="email_address">Pembayaran Sekarang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="bayar_sekarang" name="jumlah_bayar" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" autofocus required/>
                                    </div>
                                </div>
                                
                            <label for="email_address">Sisa Hutang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="jumlah_hutang" name="jumlah_hutang" readonly>
                                    </div>
                                </div>
                                
                            <label for="email_address">Transfer Via :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                    		<select name="jenis" class="form-control" onchange="open_bank()" id="akun_bank" required>
                                        	<option value="">-- PILIH JENIS --</option>
                                        	<option value="0">TUNAI</option>
                                        	<option value="2">TRANSFER DARI AKUN BANK</option>
                                    		</select>                                            
                                    </div>
                                </div>
                            
                            <div id="field_bank" style="display:none">    
                            <label for="email_address">Pembayaran Via :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                    		<select class="form-control show-tick" id="id_bank" name="id_bank">
                                            <option value="">-- PILIH AKUN BANK --</option>
                           <?php
						   $id_bank=$conn->query("select id, no_rek, bank, id_toko, distributor from rekening_bank WHERE distributor = '".$_SESSION['distributor']."' AND is_aktif=1 AND id_toko = 0");
						   while ($data=$id_bank->fetch_array()) : 
							?>
                                        <option value="<?=$data[0]?>"><?=$data[2]?>, <small>No Rek <?=$data[1]?></small></option>
						   <?php endwhile; ?>
                                    	</select>
                                    </div>
                                </div>
                            </div>    
                                
                            <button type="submit" class="btn btn-success waves-effect" onclick="return validasi();">Simpan</button>   
                            
                             
<script>
function hilang_titik(string) {
            return string.split('.').join('');
        }
		

</script> 

<!-- Kalkulator -->
<script type="text/javascript">
$("#bayar_sekarang").keyup(function(){
        var bayar_sekarang  = hilang_titik($("#bayar_sekarang").val());
        var hutang  = hilang_titik($("#hutang").val());
        var jumlah_hutang = hutang - bayar_sekarang;
        $("#jumlah_hutang").val(tandaPemisahTitik(jumlah_hutang));
      });
</script> 
<!-- END Kalkulator -->


<script type="text/javascript">
    function validasi() {
        var hutang  = hilang_titik($("#hutang").val());
        var bayar_sekarang  = hilang_titik($("#bayar_sekarang").val());
        var jumlah_hutang  = hilang_titik($("#jumlah_hutang").val());
		if( bayar_sekarang ==  "")	{
    		swal("Gagal!", "Pembayaran harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if( bayar_sekarang <  '1' )	{
    		swal("Gagal!", "Tidak Ada yang dibayar itu..", "error");
			return false; 
			
			} else if(hutang < '0')	{
    		swal("Gagal!", "Pembayaran melebihi jumlah hutang", "error");
			return false; 
			
			} else if(jumlah_hutang < '0')	{
    		swal("Gagal!", "Over Pay itu..", "error");
			return false; 
			
			} else {
				return true;
			}
    }
</script>

<script>
function open_bank() {
    var akun_bank = document.getElementById("akun_bank");
    if (akun_bank.value=="" || akun_bank.value=="0") {
		document.getElementById('field_bank').style.display = 'none';
		document.getElementById('id_bank').disabled = true;
    } else {
		document.getElementById('field_bank').style.display = 'block';
		document.getElementById('field_bank').style.visibility = 'visible';
		document.getElementById('id_bank').disabled = false;
		document.getElementById('id_bank').required = true;
	}
}
</script>



<?php
endif;

if (isset($_POST['bayar_lunas'])) :

$id_pembelian = $_POST['id_pembelian'];
$tabel = $_POST['tabel'];
$jumlah_hutang =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_hutang']);
$remark=date("Y-m-d");
$jenis = $_POST['jenis'];
$supplier = $_POST['supplier'];
$no_faktur = $_POST['no_faktur'];
$distributor = $_POST['distributor'];
$user_approve = $_POST['user_approve'];
$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);
$supplier = $_POST['supplier'];
$keterangan='Pembayaran Hutang Kepada '.$supplier;

if ($jenis==2) {
$id_bank = $_POST['id_bank'];
$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `jenis`, id_bank) VALUES('$user_approve', '".date('Y-m-d H:i:s')."', '$id_pembelian', '$no_faktur', '$jumlah_bayar', '$keterangan', '$distributor', '2', '$id_bank') ");
} else {
$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `tgl_approve`, `id_bayar`, `no_faktur`, `jumlah_bayar`, `keterangan`, `distributor`, `jenis`) VALUES('$user_approve', '".date('Y-m-d H:i:s')."', '$id_pembelian', '$no_faktur', '$jumlah_bayar', '$keterangan', '$distributor', '2') ");
}


if ($jumlah_hutang==0) {
$is_lunas='1';
} else {
$is_lunas='0';
}

$conn->query("update $tabel set jumlah_hutang='$jumlah_hutang', is_lunas='$is_lunas', remark='$remark' where id_pembelian='$id_pembelian'");

        echo "<script>window.alert('Pembayaran Tersimpan') 
		window.location='hutang.php?KjnHTG'</script>";


endif;

if (isset($_GET['modal_upload_bayar'])) :
$id = $_POST['id'];
$distributor = $_POST['distributor'];
$no_faktur = $_POST['no_faktur'];
?>

							<form class="form-horizontal" name="form_modal" id="uploadForm" method="post" action="">
                            <input type="hidden" name="id" value="<?=$id?>" />
                            <input type="hidden" name="distributor" value="<?=$distributor?>" />
                            <input type="hidden" name="no_faktur" value="<?=$no_faktur?>" />

                            <label for="email_address">Upload File</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" id="media" name="media" required>
                                    </div>
                                </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning waves-effect">UPLOAD</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>

<script type="application/javascript">
$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "detail.php?proses_upload",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result){
			var response = JSON.parse(result);
			if (response.status){
				$('#modal_upload').modal('hide');
				$('.modal_bayar').modal('hide');
				alert(response.pesan);
				}  else if (response.error) {
				alert(response.pesan);
				} 
		    },
	   });
	}));
});
</script>

<?php
endif;

if (isset($_GET['proses_upload'])) :
$id_trx=$_POST['id'];
$distributor=$_POST['distributor'];
$jenis='11';
$no_faktur=$_POST['no_faktur'];
$name = $_FILES["media"]["name"];
$size = $_FILES["media"]["size"];
$maks = 1024*1024;
$ext = strtolower(end(explode(".", $name)));
if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['media']['tmp_name'])) {
		$sourcePath = $_FILES['media']['tmp_name'];
		$new_name=$id_trx.'-'.$distributor.'-'.$jenis.'.'.$ext;
		$targetPath = $_SERVER['DOCUMENT_ROOT']."/folder_upload/bukti_bayar/".$new_name;
		if ($ext=='pdf' && $size <= $maks) {
		$sukses=move_uploaded_file($sourcePath,$targetPath);
		$ada = $conn->query("SELECT * from tabel_arsip WHERE id_trx='$id_trx' AND distributor='$distributor' AND id_jenis ='$jenis' AND no_faktur='$no_faktur'")->num_rows;
		if ($ada==0) {
			$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES ('$jenis', '$no_faktur', '$id_trx', '$distributor', '$new_name') ");
			} else {
			$masuk=$conn->query(" UPDATE tabel_arsip SET file='$new_name'  WHERE id_trx = '$id_trx' AND distributor ='$distributor' AND id_jenis='$jenis' AND no_faktur='$no_faktur'");
			}
		$ket='kopi';
		} else {
		$ket='gagal';
		}
	}
}

if ($ket=='kopi') {
echo json_encode(array('status' =>true, 'pesan' => 'Upload Berhasil'));
} else if ($ket=='gagal'){
echo json_encode(array('error' =>true, 'pesan' => 'Upload Gagal, Hanya File pdf yang diijinkan Dan Ukuran Maksimal 1 mb'));
} else if ($size > $maks || $ext != 'pdf'){
echo json_encode(array('error' =>true, 'pesan' => 'Upload Gagal, Hanya File pdf yang diijinkan Dan Ukuran Maksimal 1 mb'));
}
endif;


?>

