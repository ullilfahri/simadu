<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['modal'])) :
$id_pembelian = $_POST['rowid'];
$total=$conn->query("select SUM(sub_total), distributor from pembelian_sementara where id_pembelian='$id_pembelian'")->fetch_array();
?>

                            <form method="post" action="form_crud.php" autocomplete="off">
                            <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>" />
                            <input type="hidden" name="id_owner" value="<?=$_GET['id_owner']?>" />
                            <input type="hidden" name="distributor" value="<?=$total[1]?>" />
                            <input type="hidden" name="finalisasi" />
                            
                            <label for="email_address">Supplier</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="supplier" class="form-control" required>
                                    </div>
                                </div>
                                
                            <label for="email_address">Nomor & Tanggal Invoice</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="no_faktur" class="form-control" placeholder="Nomor Invoice" required><input type="date" name="tgl_nota" class="form-control" placeholder="Tanggal Invoice" required />
                                    </div>
                                </div>
                                
                                
                           
                            <label for="email_address">Total Pembelian</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="harga" class="form-control" value="<?=angka($total[0])?>" readonly>
                                    </div>
                                </div>
                                
                            <label for="email_address">Biaya Lainnya (Ongkos Angkut dll)</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="biaya" class="form-control" id="biaya" value="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required/>
                                    </div>
                                </div>
                                
                            <label for="email_address">Potongan (Rp)</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="diskon" name="potongan" class="form-control" value="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required/>
                                    </div>
                                </div>
                                
                                
                            <label for="email_address">Total Bayar</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="totBayar" name="total" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="demo-checkbox">
                            			<input type="checkbox" id="chkPassport" name="metode_bayar" value="1"  onclick="EnableDisableTextBox(this)" />
                                        <label for="chkPassport">Pembayaran Mundur</label>
                                </div>
                            
                            <label for="email_address">Tanggal Jatuh Tempo</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="txtPassportNumber" name="jatuh_tempo" class="form-control date" disabled="disabled" />
                                    </div>
                                </div>
                                
                            <label for="email_address">Uang Muka</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="txt" id="uang_muka" name="uang_muka" class="form-control date" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" disabled="disabled" />
                                    </div>
                                </div>
                                
                            <label for="email_address">Jumlah Hutang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="txt" id="jumlah_hutang" name="jumlah_hutang" class="form-control" readonly/>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect" onclick="return validasi2();">FINALISASI</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>



<script type="text/javascript">
    function EnableDisableTextBox(chkPassport) {
        var txtPassportNumber = document.getElementById("txtPassportNumber");
        txtPassportNumber.disabled = chkPassport.checked ? false : true;
		uang_muka.disabled = chkPassport.checked ? false : true;
        if (!txtPassportNumber.disabled) {
            txtPassportNumber.focus();
			uang_muka.focus();
		document.getElementById('uang_muka').required = true;
		document.getElementById('txtPassportNumber').required = true;
        }
    }
</script>	

<!-- Kalkulator -->
<script type="text/javascript">
$("#diskon").keyup(function(){
        var harga  = hilang_titik($("#harga").val()); 
        var diskon  = hilang_titik($("#diskon").val()); 
        var total = harga - diskon;
        $("#totBayar").val(tandaPemisahTitik(total));
      });
</script> 
<!-- END Kalkulator -->
<!-- Kalkulator -->
<script type="text/javascript">
$("#uang_muka").keyup(function(){
        var uang_muka  = hilang_titik($("#uang_muka").val()); 
        var totBayar  = hilang_titik($("#totBayar").val());  
		var jumlah_hutang = totBayar - uang_muka;
        $("#jumlah_hutang").val(tandaPemisahTitik(jumlah_hutang));
      });
</script> 
<!-- END Kalkulator -->


<?php
endif;

if (isset($_POST['tambah_pintu_gudang'])) :

$id_gudang = $_POST['id_gudang'];
$nama_pintu = $_POST['nama_pintu'];


$tambah=$conn->query("INSERT INTO `pintu_gudang`(`id_gudang`, `nama_pintu`) VALUES('$id_gudang', '$nama_pintu')   ");

        echo "<script>window.alert('Detail Gudang Tersimpan..!') 
		window.location='alokasi_stok.php'</script>";


endif;


if (isset($_POST['finalisasi'])) :

$id_pembelian = $_POST['id_pembelian'];
$biaya = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['biaya']);
$potongan = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['potongan']);
$total = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['total']);
$distributor = $_POST['distributor'];
if (!empty($_POST['metode_bayar'])) { $metode_bayar = $_POST['metode_bayar']; } else { $metode_bayar='0'; }
if (!empty($_POST['jatuh_tempo'])) { $jatuh_tempo = $_POST['jatuh_tempo']; } else { $jatuh_tempo='0000-00-00'; }
if (!empty($_POST['jumlah_hutang'])) { $jumlah_hutang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_hutang']); } else { $jumlah_hutang=''; }
$supplier = $_POST['supplier'];
$no_faktur = $_POST['no_faktur'];
$tgl_nota = $_POST['tgl_nota'];
$id_owner = $_POST['id_owner'];


$update=$conn->query("UPDATE `tabel_pembelian` SET `biaya`='$biaya', `potongan`='$potongan',  `total`='$total', `is_final`='1', `id_owner`='$id_owner', `metode_bayar`='$metode_bayar', `jatuh_tempo`='$jatuh_tempo', `supplier`='$supplier', `no_faktur`='$no_faktur', tgl_nota='$tgl_nota', distributor='$distributor', jumlah_hutang='$jumlah_hutang' WHERE id_pembelian='$id_pembelian'");

$stok=$conn->query("select * from pembelian_sementara where id_pembelian='$id_pembelian'");
while ($x=$stok->fetch_array()) :
$sisa=$conn->query("select sisa_stok from stok_barang where kode_barang = '".$x['kode_barang']."'")->fetch_array();
$tambah=$sisa[0]+$x['jumlah'];
$update_stok=$conn->query("update stok_barang set sisa_stok='".$tambah."' where kode_barang='".$x['kode_barang']."'");
endwhile;

//$update=$conn->query("DELETE FROM `pembelian_sementara` WHERE id_pembelian='$id_pembelian'");

        echo "<script>window.alert('Pembelian Tersimpan, Stok Bertambah') 
		window.location='../gudang/index.php?VBgfTGG'</script>";

endif;

if (isset($_POST['tambah_kode'])) :

$kode_barang = $_POST['kode_barang'];
$distributor = $_POST['distributor'];
$satuan = $_POST['satuan'];
$nama_barang = $_POST['nama_barang'];
$harga_barang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['harga_barang']);
$harga_barang = preg_replace("/[^0-9.]/", '', $harga_barang);
$ada=$conn->query("select * from stok_barang where kode_barang='$kode_barang'")->num_rows;

if ($ada > 0) {
echo "<script>window.alert('Barang dengan kode $kode_barang sudah ada, silahkan ganti dengan kode baru') 
		window.location='tambah_kode.php'</script>";
} else {
$masuk=$conn->query("insert into stok_barang(kode_barang, nama_barang, harga_barang, sisa_stok, satuan, distributor) VALUES('$kode_barang', '$nama_barang','$harga_barang','0', '$satuan', '$distributor')");
/*echo "<script>window.alert('Tambah Data Kode Barang Tersimpan') 
		window.location='index.php?OKhghh&input=$nama_barang&kode=$kode_barang'</script>";*/

echo '<script language="javascript">
				swal({
        		title: "Sukses",
				text: "Tambah Data Kode Barang Tersimpan",
        		imageUrl: "../../../images/thumbs-up.png",
				timer: 3000,
				showConfirmButton: false
    			});
	  window.location="index.php?OKhghh&input=$nama_barang&kode=$kode_barang"		
	  </script>';
		
}

endif;

if (isset($_GET['cari_kode'])) :
$input=$_GET['input'];
$data=$conn->query("select COUNT(id), kode_barang, nama_barang from stok_barang where kode_barang='$input'")->fetch_array();

if (strlen($input)<5) {
			echo " <i class='glyphicon glyphicon-remove'></i> Kode Minimal 5 Digit";
} else if ($data[0]>0) {	
			echo " <i class='glyphicon glyphicon-remove'></i> Kode $input Sudah Ada Yaitu : ".$data[2];		
} else {
			echo "<i class='fa fa-check fa-lg' style='color:green;'></i> Kode $input belum ada di database";
}			

endif;


if (isset($_GET['live_edit'])) :
$kolom=$_POST['column'];
if ($kolom=='harga_barang') {
$value=preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['editval']);
$value = preg_replace("/[^0-9.]/", '', $value);
} else {
$value=$_POST['editval'];
}
$id=$_POST['id'];

$update=$conn->query("update stok_barang SET $kolom = '$value' where id = '$id'");

endif;


if (isset($_POST['simpan_koordinat'])) :

$nama = $_POST['nama'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$alamat = $_POST['alamat'];

$masuk=$conn->query("INSERT INTO lokasi(nama,lat,lng,alamat) VALUES('$nama','$lat','$lng','$alamat')");

echo "<script>window.alert('Lokasi $nama Tersimpan') 
		window.location='data_gudang.php'</script>";


endif;

if (isset($_POST['alokasi_stok'])) :

$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$id_gudang = $_POST['id_gudang'];
$pintu_gudang = $_POST['pintu_gudang'];
$jumlah = $_POST['jumlah'];
$distributor = $_POST['distributor'];

$ada=$conn->query("select COUNT(*), SUM(jumlah) from alokasi_stok where kode_barang='$kode_barang' and id_gudang='$id_gudang' and pintu_gudang='$pintu_gudang' and distributor='$distributor' ")->fetch_array();
if ($ada[0] > 0) {
$sisa=$jumlah+$ada[1];
$masuk=$conn->query("update alokasi_stok set jumlah='$sisa' where kode_barang='$kode_barang' and id_gudang='$id_gudang' and pintu_gudang='$pintu_gudang' and distributor='$distributor'");
} else {
$masuk=$conn->query("INSERT INTO `alokasi_stok`(`id_gudang`, `nama_barang`, `kode_barang`, `jumlah`, `pintu_gudang`, `distributor`) VALUES('$id_gudang', '$nama_barang', '$kode_barang', '$jumlah', '$pintu_gudang', '$distributor') ");
}

echo "<script>window.alert('Alokasi Stok Gudang Tersimpan') 
		window.location='alokasi_stok.php'</script>";


endif;

if (isset($_GET['upload'])) :
$id_pembelian = $_POST['rowid'];
$file_lama=$conn->query("select file, no_faktur, distributor from tabel_pembelian where id_pembelian='$id_pembelian'")->fetch_array();
?>
                            <form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>" />
                            <input type="hidden" name="gambar_lama" value="<?=$file_lama[0]?>" />
                            <input type="hidden" name="no_faktur" value="<?=$file_lama[1]?>" />
                            <input type="hidden" name="distributor" value="<?=$file_lama[2]?>" />
                            <input type="hidden" name="proses_upload"/>
                            <label for="email_address">Jenis File</label>
                                <div class="form-group">
                                    <div class="form-line">
                                    <select class="form-control show-tick" name="jenis" required>
                                        <option value="">-- PILIH JENIS FILE --</option>
                                        <option value="4">INVOICE PEMBELIAN</option>
                                        <option value="5">NOTA PEMBELIAN</option>
                                    </select>
                                    </div>
                                </div>
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
$id_pembelian=$_POST['id_pembelian'];
$jenis=$_POST['jenis'];
$distributor=$_POST['distributor'];
$no_faktur=$_POST['no_faktur'];
$gambar_lama=$_POST['gambar_lama'];
$nama_baru=strtotime(date('Y-m-d H:i:s')).'-'.$_POST['id_pembelian'].'-'.$jenis.'-';

$file = $_FILES['gambar']['name'];
$nama_file=$nama_baru.$file;
$ukuran_file = $_FILES['gambar']['size'];
$tipe_file = $_FILES['gambar']['type'];
$tmp_file = $_FILES['gambar']['tmp_name'];

$path = "upload/".$nama_file;

$tgl_1=date("l d F Y - H:i", $_POST['id_pembelian']);
$tgl_2=date("l d F Y - H:i", $_POST['id_pembelian']);


if($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "application/pdf"){ 

  if($ukuran_file <= 1000000){ 
    if(move_uploaded_file($tmp_file, $path)){ 
      $sql = $conn->query("INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES('$jenis', '$no_faktur', '$id_pembelian', '$distributor', '$path')");
      
      if($sql){
	  	if (file_exists($gambar_lama)) : unlink($gambar_lama); endif;
        echo "<script>window.alert('File Diupload') 
		window.location='catatan_pembelian.php?tampil=upload&tgl_1=$tgl_1&tgl_2=$tgl_2&id_pembelian=$id_pembelian'</script>";
		
      }else{
        echo "<script>window.alert('Foto Gagal Diupload') 
		window.location='catatan_pembelian.php?tampil=upload&tgl_1=$tgl_1&tgl_2=$tgl_2&id_pembelian=$id_pembelian'</script>";
      }
    }else{
        echo "<script>window.alert('Foto Gagal Diupload') 
		window.location='catatan_pembelian.php?tampil=upload&tgl_1=$tgl_1&tgl_2=$tgl_2&id_pembelian=$id_pembelian'</script>";
    }
  }else{
        echo "<script>window.alert('Ukuran Terlalu Besar') 
		window.location='catatan_pembelian.php?tampil=upload&tgl_1=$tgl_1&tgl_2=$tgl_2&id_pembelian=$id_pembelian'</script>";
  }
}else{
        echo "<script>window.alert('Hanya JPG, PNG dan PDF yang diperbolehkan') 
		window.location='catatan_pembelian.php?tampil=upload&tgl_1=$tgl_1&tgl_2=$tgl_2&id_pembelian=$id_pembelian'</script>";
}
endif;


?>