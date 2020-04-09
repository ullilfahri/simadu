<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';

#----------ambil_data_jenis----------#
if (isset($_GET['ambil_data_jenis'])) :
$jenis=$_GET['input'];
$qry=$conn->query("SELECT * FROM `jenis_pengeluaran` WHERE `jenis` like '%$jenis%' LIMIT 0,1");
$ada=$qry->num_rows;
	if ($ada==0) {
		?>
		<i class='fa fa-ban fa-lg' style='color:red;'></i><a href="javascript:autoInsert('0','<?=strtoupper($jenis)?>');"> Belum ada Data, Klik Untuk Tambah Jenis Pengeluaran</a>
		<?php
		} else {
		while ($x=$qry->fetch_array()) :
		?>
        <i class='fa fa-check fa-lg' style='color:green;'></i><a href="javascript:autoInsert('<?=$x['kode']?>','<?=$x['jenis']?>');"> Jenis Pengeluaran : <?=$x['jenis']?>, Kode : <?=$x['kode']?></a>
        <?php
		endwhile;
		}

endif;
#----------ambil_data_jenis----------#

#----------live_edit----------#
if (isset($_GET['live_edit'])) :

$id = $_POST['pk'];
$kolom = $_POST['name'];
if ($kolom=='keterangan') {
	$value = $_POST['value'];
	} else {
	$value = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['value']);
	}
$awal=$conn->query("SELECT jumlah, harga_barang, sub_total FROM pengeluaran_sementara WHERE id='$id'")->fetch_array();
$jumlah=$awal[0];
$harga_barang=$awal[1];
if ($kolom=='jumlah') {
	$sub_total=$value*$harga_barang;
	} else if ($kolom=='harga_barang') {
	$sub_total=$value*$jumlah;
	} else {
	$sub_total=$awal[2];
	}
$update=$conn->query("UPDATE pengeluaran_sementara SET $kolom='$value', sub_total='$sub_total' WHERE id='$id'");
echo json_encode(array('status' =>true, 'pesan' =>'Update Berhasil' ));


endif;
#----------live_edit----------#

#----------hapus_daftar_pengeluaran----------#
if (isset($_GET['hapus_daftar_pengeluaran'])) :

$id=$_POST['id'];

$query=$conn->query("delete from pengeluaran_sementara where id='$id'");
if ($query){
	echo json_encode(array('status' =>true));
	} else {
	echo json_encode(array('status' =>false));
	}

endif;
#----------hapus_daftar_pengeluaran----------#

#----------simpan_kode----------#
if (isset($_GET['simpan_kode'])) :
$jenis=$_POST['jenis'];
$cari=$conn->query(" SELECT * FROM jenis_pengeluaran ")->num_rows;
$digit=$cari+1;
$digit = str_pad($digit, 4, '0', STR_PAD_LEFT);
$kode='OP'.$digit;
$masuk_kode=$conn->query(" INSERT INTO `jenis_pengeluaran`(`kode`, `jenis`) VALUES('$kode', '$jenis') ");
if ($masuk){
	echo json_encode(array('status' =>true));
	} 
endif;
#----------simpan_kode----------#


if (isset($_GET['finalisasi_data'])) :

$id_pembelian=$_POST['rowid'];
$total=$conn->query(" SELECT SUM(sub_total) FROM pengeluaran_sementara WHERE id_pembelian='$id_pembelian' ")->fetch_array();
?>
                                <input type="hidden" name="id_owner" value="<?=$_SESSION['id']?>"/>
                                <input type="hidden" name="id_pembelian" value="<?=$id_pembelian?>"/>
                                <input type="hidden" name="distributor" value="<?=$_SESSION['distributor']?>"/>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Total Pembelian</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="text" name="total_awal" class="form-control" value="<?=angka($total[0])?>" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Potongan Global Sesuai Nota</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="text" name="potongan" class="form-control uang" onFocus="startCalc();" onBlur="stopCalc();" placeholder="Masukan Jumlah Potongan Global Isi 0 Jika Tidak Ada Potongan" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Total Invoice</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="text" name="total" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Include Pajak</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="checkbox" id="include_pajak" name="include_pajak" value="1"/>
                                                <label for="include_pajak">Beri Tanda &#10004; Jika Include Pajak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Pembayaran Mundur</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="checkbox" id="metode_bayar" name="metode_bayar" value="1"/>
                                                <label for="metode_bayar">Beri Tanda &#10004; Jika Pembayaran Mundur</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="form_hutang" style="display:none">
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Uang Muka</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="text" name="uang_muka" id="uang_muka" class="form-control uang" placeholder="Masukan Jumlah Uang Muka, Isi 0 Jika Tidak Ada" onFocus="startCalc();" onBlur="stopCalc();"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Tanggal Jatuh Tempo</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="text" name="jatuh_tempo" id="jatuh_tempo" class="pickermodal form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-control-label">
                                        <label for="email_address_2">Jumlah Hutang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="text" name="jumlah_hutang" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                </div>

                        		<div class="modal-footer">
                            	<button type="submit" onclick="return validasi2();" name="simpan_finalisasi" class="btn btn-warning waves-effect">Simpan</button>
                            	<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Batal</button>
                        		</div>
                            </form>
                            
<script src="<?=PLG?>jmask/jquery.mask.min.js"></script>                           
<script type="text/javascript">
            $(document).ready(function(){
                $( '.uang' ).mask('000.000.000', {reverse: true});
            })
</script>

<script type="application/javascript">
    $('.pickermodal').bootstrapMaterialDatePicker({
        format: 'DD-MM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });
</script>

<script>
    function startCalc(){
    		interval = setInterval("calc()",1);
    }
    function calc(){
	    total_awal = hilang_titik(document.form_pengeluaran.total_awal.value);
	    potongan = hilang_titik(document.form_pengeluaran.potongan.value);
	    uang_muka = hilang_titik(document.form_pengeluaran.uang_muka.value);
		
		if (potongan == '') {
		potongan=0;
		}
		if (uang_muka == '') {
		uang_muka=0;
		}
		
	    total_awal = total_awal - potongan;
	    hutang = total_awal - uang_muka;
		document.form_pengeluaran.total.value = tandaPemisahTitik(total_awal);
		document.form_pengeluaran.jumlah_hutang.value = tandaPemisahTitik(hutang);
		

	}
    function stopCalc(){
    	clearInterval(interval);
    }
</script> <!-- Menghitung otomatis -->

<script>
$(document).ready(function () {
    var metode_bayar = $('#metode_bayar');
    var form_hutang = document.getElementById("form_hutang");
    $('input').on('click',function () {
        if (metode_bayar.is(':checked')) {
            form_hutang.style.display = "block";
			document.getElementById('uang_muka').required = true;
			document.getElementById('jatuh_tempo').required = true;
        } else {
            form_hutang.style.display = "none";
			document.getElementById('uang_muka').required = false;
			document.form_pengeluaran.uang_muka.value='';
			document.form_pengeluaran.jumlah_hutang.value='';
			document.form_pengeluaran.jatuh_tempo.value='';
			document.getElementById('jatuh_tempo').required = false;
        }
    });
});

</script>

<script type="text/javascript">
    function validasi2() {
		total = hilang_titik(document.form_pengeluaran.total.value);
		jumlah_hutang = hilang_titik(document.form_pengeluaran.jumlah_hutang.value);
		potongan = hilang_titik(document.form_pengeluaran.potongan.value);

		if( potongan >  total)	{
    		swal("Gagal!", "Jumlah Potongan Tidak Boleh Melebihi Dari Harga Pembelian!", "error");
			return false;
			
			} else if( jumlah_hutang < 0 )	{
    		swal("Gagal!", "Jumlah Terhutang Tidak Boleh Negatif", "error");
			return false; 


			} else {
				return true;
			}
    }
</script>


<?php
endif;

if (isset($_POST['simpan_finalisasi'])) :

$supplier = $_POST['supplier'];
$no_faktur = $_POST['no_faktur'];
$tgl_nota = date_create_from_format('d-m-Y', $_POST['tgl_nota']);
$tgl_nota = date_format($tgl_nota,"Y-m-d");
$file_pajak = $_POST['file_pajak'];
$id_owner = $_POST['id_owner'];
$id_pembelian = $_POST['id_pembelian'];
$distributor = $_POST['distributor'];
$potongan = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['potongan']);
$total =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['total']);
if (!empty($_POST['metode_bayar'])) {
	$metode_bayar = $_POST['metode_bayar'];
	$uang_muka = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['uang_muka']);
	$jatuh_tempo = date_create_from_format('d-m-Y', $_POST['jatuh_tempo']);
	$jatuh_tempo = date_format($jatuh_tempo,"Y-m-d");
	$jumlah_hutang = preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_hutang']);
	} else {
	$metode_bayar = '0';
	$uang_muka = '0';
	$jatuh_tempo = '';
	$jumlah_hutang = '0';
	}
if (!empty($_POST['include_pajak'])) {
	$include_pajak = $_POST['include_pajak'];
	} else {
	$include_pajak = '0';
	}

$update=$conn->query(" UPDATE `tabel_pengeluaran` SET `potongan`='$potongan', `total`='$total', `is_final`='1',  `metode_bayar`='$metode_bayar',`jumlah_hutang`='$jumlah_hutang',`jatuh_tempo`='$jatuh_tempo',`supplier`='$supplier',`no_faktur`='$no_faktur',`tgl_nota`='$tgl_nota', `file_pajak`='$file_pajak',`distributor`='$distributor', `include_pajak`='$include_pajak' WHERE `id_pembelian` = '$id_pembelian' ");

        echo "<script>window.alert('Data Tersimpan') 
		window.location='summary_pengeluaran.php'</script>";

endif;

if (isset($_GET['rinci_beli'])) :
$pecah=explode('#',$_POST['rowid']);
$trx=$conn->query("SELECT * FROM `pengeluaran_sementara` WHERE id_pembelian = '".$pecah[0]."' AND distributor = '".$pecah[1]."' ");
$total=$conn->query("SELECT SUM(sub_total) FROM `pengeluaran_sementara` WHERE id_pembelian = '".$pecah[0]."' AND distributor = '".$pecah[1]."' ")->fetch_array();
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-rinci">
                                    <thead>
                                        <tr>
                                            <th class="align-center">No</th>
                                            <th class="align-center">Nama Barang</th>
                                            <th class="align-center">QTY</th>
                                            <th class="align-center">Harga Satuan</th>
                                            <th class="align-center">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th  class="align-right"><?=angka($total[0])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$trx->fetch_array()) :
									?>
                                        <tr>
                                            <td class="align-center"><?=$no++?></td>
                                            <td  class="align-left"><?=$x['nama_barang']?></td>
                                            <td  class="align-center"><?=$x['jumlah']?></td>
                                            <td class="align-right"><?=angka($x['harga_barang'])?></td>
                                            <td class="align-right"><?=angka($x['sub_total'])?></td>
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

if (isset($_GET['modal_upload'])) :
$id_pembelian=$_POST['id_pembelian'];
$distributor=$_POST['distributor'];
$awal=$_POST['awal'];
$akhir=$_POST['akhir'];
?>

                            <form class="form-horizontal" name="form_modal" id="uploadForm" method="post" action="">
                            <input type="hidden" name="id_pembelian" id="id_pembelian" value="<?=$id_pembelian?>">
                            <input type="hidden" name="distributor" id="distributor" value="<?=$distributor?>">
                            <input type="hidden" name="awal" id="distributor" value="<?=$awal?>">
                            <input type="hidden" name="akhir" id="distributor" value="<?=$akhir?>">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="id_jenis">Jenis File</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="id_jenis" id="id_jenis" class="form-control show-tick" required>
                                                <option value="">-- Pilih Jenis File --</option>
                                                <option value="8">FAKTUR PENGELUARAN</option>
                                                <option value="9">SURAT JALAN PENGELUARAN</option>
                                                <option value="10">PAJAK PENGELUARAN</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                  </div>  
                                    
                                    
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="file">File</label>
                                    </div>                                    
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" id="media" name="media" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Upload</button>
                                    </div>
                                </div>
                                                                
                            </form>
                                
                                

<script type="application/javascript">
$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "form_crud.php?proses_upload",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result){
			var response = JSON.parse(result);
			if (response.status){
				$(".data_paginasi").load("paginasi_pengeluaran.php?metode=sortir&awal=<?=$awal?>&akhir=<?=$akhir?>");
				$('#ModalUpload').modal('hide');
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
$id_trx=$_POST['id_pembelian'];
$distributor=$_POST['distributor'];
$jenis=$_POST['id_jenis'];
$name = $_FILES["media"]["name"];
$size = $_FILES["media"]["size"];
$maks = 1024*1024;
$ext = strtolower(end(explode(".", $name)));
if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['media']['tmp_name'])) {
		$sourcePath = $_FILES['media']['tmp_name'];
		$new_name=$id_trx.'-'.$distributor.'-'.$jenis.'.'.$ext;
		$targetPath = $_SERVER['DOCUMENT_ROOT']."/folder_upload/pengeluaran/".$new_name;
		if ($ext=='pdf' && $size <= $maks) {
		$sukses=move_uploaded_file($sourcePath,$targetPath);
		$ada = $conn->query("SELECT * from tabel_arsip WHERE id_trx='$id_trx' AND distributor='$distributor' AND id_jenis ='$jenis' ")->num_rows;
		if ($ada==0) {
			$masuk=$conn->query(" INSERT INTO `tabel_arsip`(`id_jenis`, `no_faktur`, `id_trx`, `distributor`, `file`) VALUES ('$jenis', '$id_trx', '$id_trx', '$distributor', '$new_name') ");
			} else {
			$masuk=$conn->query(" UPDATE tabel_arsip SET file='$new_name'  WHERE id_trx = '$id_trx' AND distributor ='$distributor' AND id_jenis='$jenis'");
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
