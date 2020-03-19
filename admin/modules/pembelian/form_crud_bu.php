<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['modal'])) :
$id_pembelian = $_POST['rowid'];
$total=$conn->query("select SUM(sub_total), distributor from pembelian_sementara where id_pembelian='$id_pembelian'")->fetch_array();
?>

                            <form method="post" action="simpan_final_beli.php" autocomplete="off" target="_blank">
                            <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>" />
                            <input type="hidden" name="id_owner" value="<?=$_GET['id_owner']?>" />
                            <input type="hidden" name="distributor" value="<?=$total[1]?>" />
                            <input type="hidden" name="finalisasi" />
                            <input type="hidden" name="supplier" id="id_supplier"/>
                            
                            <label for="email_address">Supplier</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="supplier" class="form-control" onkeyup='auto_supplier();' required>
                                    </div>
                                    <div id='hasil_supplier'></div>
                                </div>
                                
                            <label for="email_address">Nomor & Tanggal Invoice</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="no_faktur" class="form-control" placeholder="Nomor Invoice" required><input type="date" name="tgl_nota" class="form-control" placeholder="Tanggal Invoice" required />
                                    </div>
                                </div>
                                
                            <label for="email_address">No Faktur Pajak (Opsional)</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="file_pajak" class="form-control">
                                    </div>
                                </div>
                                
                           
                            <label for="email_address">Total Pembelian</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="harga" class="form-control" value="<?=angka($total[0])?>" readonly>
                                        <input type="hidden" name="jenis_input[0]" value="ga_penting"/>
                                        <input type="hidden" name="jumlah_input[0]" value="0"/>
                                    </div>
                                </div>
                                
                            <label for="email_address">Biaya Lainnya, Klik Tombol Jika Ada Biaya-Biaya &nbsp;&nbsp;&nbsp;
                            	<button type="button" class="btn btn-success btn-xs" onclick="additem();"><i class="fa fa-plus fa-xs"></i></button>
                            </label>
                            <!--<div id="biaya_operasional" style="display:none">-->
                                <div class="form-group">
                                    <div class="form-line">
                    				<table class="table table-condensed">
                        			  <thead>
                            			<tr>
                                			<th width="50%">Jenis Biaya</th>
                                			<th width="30%">Jumlah Biaya (Rp)</th>
                                			<th width="20%">Aksi</th>
                            			</tr>
                        			  </thead>
                        			  <!--elemet sebagai target append-->
                        			  <tbody id="itemlist">
                            			<!--<tr>
                                			<td><input type="hidden" name="jenis_input[0]" value="ga_penting"/></td>
                                			<td><input type="hidden" name="jumlah_input[0]" value="0"/></td>
                                			<td>
                                			</td>
                            			</tr>-->
                        			  </tbody>
                    				</table>
                                    </div>
                                </div>
                             <!--</div> --> 
                             <br> 
                                
                                
                            <label for="email_address">Total Invoice</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="totBayar" name="total" class="form-control" readonly>
                                        <input type="hidden" id="tot_awal" class="form-control">
                                    </div>
                                </div>

                                <div class="demo-checkbox">
                            			<input type="checkbox" id="include_pajak" name="include_pajak" value="1" />
                                        <label for="include_pajak">Include PPn (Beri centang Jika Sudah Masuk PPn)</label>
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
                                
                            <label for="email_address">Total Hutang</label>
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

<script>
function hilang_titik(string) {
            return string.split('.').join('');
        }
		
function angka (num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
}

</script> 



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
$("#biaya").keyup(function(){
        var biaya  = parseInt(hilang_titik($("#biaya").val())); 
        var harga  = parseInt(hilang_titik($("#harga").val())); 
		var total = harga + biaya;
        $("#tot_awal").val(angka(total));
      });
	  
$("#diskon").keyup(function(){
        var tot_awal  = hilang_titik($("#tot_awal").val()); 
        var diskon  = hilang_titik($("#diskon").val()); 
		var tot = tot_awal - diskon;
        $("#totBayar").val(angka(tot));
      });
	  
</script> 
<!-- END Kalkulator -->
<!-- Kalkulator -->
<script type="text/javascript">
$("#uang_muka").keyup(function(){
        var uang_muka  = hilang_titik($("#uang_muka").val()); 
        var totBayar  = hilang_titik($("#totBayar").val());  
		var jumlah_hutang = totBayar - uang_muka;
        $("#jumlah_hutang").val(angka(jumlah_hutang));
      });
</script> -->
<!-- END Kalkulator -->


<!---JS SUPPLIER AUTOCOMPLE-->
<script language="JavaScript">
    var ajaxRequest;
    function getAjax() { //fungsi untuk mengecek AJAX pada browser
        try {
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
    }

    function auto_supplier() { //fungsi menangkap input search dan menampilkan hasil search
        getAjax();
        input_supplier = document.getElementById('supplier').value;if (input_supplier == "") {
            document.getElementById("hasil_supplier").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","proses_ajax.php?cari_supplier&input="+input_supplier);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil_supplier").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert_supplier(id_supplier, nama_supplier) { //fungsi mengisi input text dengan hasil pencarian yang dipilih
        document.getElementById("supplier").value = nama_supplier;
        document.getElementById("id_supplier").value = id_supplier;
        document.getElementById("hasil_supplier").innerHTML = "";
    }

</script>    
<!---AKHIR JS SUPPLIER AUTOCOMPLE


<script>
function buka_form() {
    var biaya_operasional = document.getElementById('biaya_operasional');
    var tombol_buka = document.getElementById('tombol_buka');
    var tombol_tutup = document.getElementById('tombol_tutup');
    if (biaya_operasional.style.display === 'none') {
        biaya_operasional.style.display = 'block';
		tombol_tutup.style.display = 'block';
		tombol_buka.style.display = 'none';
		
    } else {
        biaya_operasional.style.display = 'none';
		tombol_tutup.style.display = 'none';
		tombol_buka.style.display = 'block';
    }
}
</script>-->

        <script>
            var i = 1;
            function additem() {
    			//document.getElementById('biaya_operasional').style.display = 'block';
                var itemlist = document.getElementById('itemlist');
                
//                membuat element
                var row = document.createElement('tr');
                var jenis = document.createElement('td');
                var jumlah = document.createElement('td');
                var aksi = document.createElement('td');

//                meng append element
                itemlist.appendChild(row);
                row.appendChild(jenis);
                row.appendChild(jumlah);
                row.appendChild(aksi);

//                membuat element input
                var jenis_input = document.createElement('input');
                jenis_input.setAttribute('name', 'jenis_input[' + i + ']');
                jenis_input.setAttribute('class', 'input-block-level');

                var jumlah_input = document.createElement('input');
                jumlah_input.setAttribute('name', 'jumlah_input[' + i + ']');
                jumlah_input.setAttribute('class', 'input-block-level');
                jumlah_input.setAttribute('onkeydown', 'return numbersonly(this, event);');
                jumlah_input.setAttribute('onkeyup', 'javascript:tandaPemisahTitik(this);');
                jumlah_input.setAttribute('required', 'true');

                var hapus = document.createElement('span');

//                meng append element input
                jenis.appendChild(jenis_input);
                jumlah.appendChild(jumlah_input);
                aksi.appendChild(hapus);

                hapus.innerHTML = '<button class="btn btn-danger btn-xs"><i class="fa fa-minus fa-xs"></button>';
//                membuat aksi delete element
                hapus.onclick = function () {
                    row.parentNode.removeChild(row);
                };

                i++;
            }
        </script>

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
$file_pajak = $_POST['file_pajak'];
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


$update=$conn->query("UPDATE `tabel_pembelian` SET `biaya`='$biaya', `potongan`='$potongan',  `total`='$total', `is_final`='1', `id_owner`='$id_owner', `metode_bayar`='$metode_bayar', `jatuh_tempo`='$jatuh_tempo', `supplier`='$supplier', `no_faktur`='$no_faktur', tgl_nota='$tgl_nota', distributor='$distributor', jumlah_hutang='$jumlah_hutang', file_pajak='$file_pajak' WHERE id_pembelian='$id_pembelian'");

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
                            <input type="hidden" name="no_faktur" value="<?=$file_lama[1]?>" />
                            <input type="hidden" name="distributor" value="<?=$file_lama[2]?>" />
                            <input type="hidden" name="proses_upload"/>
                            <label for="email_address">Jenis File</label>
                                <div class="form-group">
                                    <div class="form-line">
                                    <select class="form-control show-tick" name="jenis" required>
                                        <option value="">-- PILIH JENIS FILE --</option>
                                        <option value="4">INVOICE PEMBELIAN</option>
                                        <option value="5">SURAT JALAN PEMBELIAN</option>
                                        <option value="6">PAJAK PEMBELIAN</option>
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
$nama_baru=strtotime(date('Y-m-d H:i:s')).'-'.$_POST['id_pembelian'].'-'.$jenis.'-';

$file = $_FILES['gambar']['name'];
$nama_file=$nama_baru.$file;
$ukuran_file = $_FILES['gambar']['size'];
$tipe_file = $_FILES['gambar']['type'];
$tmp_file = $_FILES['gambar']['tmp_name'];

$path = $_SERVER['DOCUMENT_ROOT']."/folder_upload/pembelian/".$nama_file;
$path_sql = "/folder_upload/pembelian/".$nama_file;
$tgl_1=date("l d F Y - H:i", $_POST['id_pembelian']);
$tgl_2=date("l d F Y - H:i", $_POST['id_pembelian']);

$ada=$conn->query("SELECT COUNT(*), file FROM tabel_arsip where id_trx='$id_pembelian' AND id_jenis='$jenis' AND distributor='$distributor'")->fetch_array();

if (isset($_GET['dari_klien'])) {
$url=$_GET['dari_klien'];
} else {
$url='summary_pembelian.php?tampi_upload';
}


if($tipe_file == "image/jpeg" || $tipe_file == "image/png" || $tipe_file == "application/pdf"){ 

  if($ukuran_file <= 1000000){ 
    if(move_uploaded_file($tmp_file, $path)){ 
	  if ($ada[0]==0) {	
      $sql = $conn->query("INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES('$jenis', '$no_faktur', '$id_pembelian', '$distributor', '$path_sql')");
	  } else {
	  $gambar_lama=$_SERVER['DOCUMENT_ROOT'].$ada[1];
	  $sql = $conn->query("UPDATE `tabel_arsip` SET file = '$path_sql' where id_trx='$id_pembelian' AND id_jenis='$jenis' AND distributor='$distributor'");
	  unlink($gambar_lama);
	  }
      
      if($sql){
        echo "<script>window.alert('File Diupload') 
		window.location='".$url."&tanggal=$id_pembelian'</script>";
		
      }else{
        echo "<script>window.alert('Foto Gagal Diupload') 
		window.location='".$url."&tanggal=$id_pembelian'</script>";
      }
    }else{
        echo "<script>window.alert('Foto Gagal Diupload') 
		window.location='".$url."&tanggal=$id_pembelian'</script>";
    }
  }else{
        echo "<script>window.alert('Ukuran Terlalu Besar') 
		window.location='".$url."&tanggal=$id_pembelian'</script>";
  }
}else{
        echo "<script>window.alert('Hanya JPG, PNG dan PDF yang diperbolehkan') 
		window.location='".$url."&tanggal=$id_pembelian'</script>";
}
endif;


if (isset($_GET['rinci_beli'])) :
$pecah=explode('#',$_POST['rowid']);
$trx=$conn->query("SELECT * FROM `pembelian_sementara` WHERE id_pembelian = '".$pecah[0]."' AND distributor = '".$pecah[1]."' ");
$total=$conn->query("SELECT SUM(sub_total) FROM `pembelian_sementara` WHERE id_pembelian = '".$pecah[0]."' AND distributor = '".$pecah[1]."' ");
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-rinci">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>QTY</th>
                                            <th>Harga Satuan</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th>jumlah</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($x['sub_total'])?></td>
                                        </tr>
                                   <?php endwhile;?>     
                                   </tbody>
                               </table>         

                            </div>

<script language="javascript">
$(function () {
    //Exportable table
    $('.js-rinci').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'excel', 'print'
        ]
    });
});
</script>                            

<?php
endif;

if (isset($_GET['hapus_pembelian'])) :

echo $_GET['modal_id'];

endif;


?>