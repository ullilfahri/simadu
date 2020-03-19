<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['modal'])) :
$no_faktur = $_POST['rowid'];
$total=$conn->query("select SUM(sub_total), id_alokasi, kode_barang from tabel_trx where no_faktur='$no_faktur'")->fetch_array();
$gudang=$conn->query("select a.id_gudang, b.nama, a.jumlah, a.id, a.pintu_gudang from alokasi_stok as a left join lokasi as b on a.id_gudang=b.id_lokasi where a.kode_barang='".$total[2]."'")->fetch_array();
$cst_sql=$conn->query(" SELECT a.customer, b.nama, b.limit_kredit FROM tabel_faktur as a LEFT JOIN tabel_customer as b ON a.customer=b.id where a.no_faktur='$no_faktur' ")->fetch_array();
$customer=$cst_sql[0];
$limit_kredit=$cst_sql[2];

?>

                        <div class="body">
                            <form method="get" action="cetak.php" autocomplete="off" name="epen">
                            <input type="hidden" name="id_gudang" value="<?=$gudang[0]?>" />
                            <input type="hidden" name="customer" id="customer" value="<?=$customer?>" />
                            <input type="hidden" name="limit_kredit" id="limit_kredit" value="<?=$limit_kredit?>" />
                            <input type="hidden" name="pintu_gudang" value="<?=$gudang[4]?>" />
                            <input type="hidden" name="no_faktur" id="no_faktur" value="<?=$no_faktur?>" />
                            
                            <input type="hidden" name="kasir" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" class="total_awal" value="<?=$total[0]?>" />
                            <input type="hidden" class="tot" name="tot"/>
                            
                            
                            <div class="row clearfix">
                                    
                                    <div class="col-md-9">
                                        <b style="color:#FF0000">Spesial Diskon, Masukan Kode Voucher</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-percent" style="color:#FF0000"></i>
                                            </span>
                                            <div class="form-line">
                                                <input style="color:#FF0000" type="text" id="diskon" name="diskon" class="form-control" onkeyup='autoComplete2();'/>
                                                <input type="hidden"  id="distributor_diskon" name="distributor_diskon"/>
                                                <input type="hidden"  id="id_diskon" name="id_diskon"/>
                                                <input type="hidden"  id="sub_total" name="sub_total"/>
                                                <input type="hidden"  id="id_trx" name="id_trx"/>
                                                <input type="hidden"  id="spc_diskon" name="spc_diskon"/>
                                            </div>
                                            <div id='hasil_diskon'></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <b style="color:#FF0000">Jatuh Tempo (*)</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar" style="color:#FF0000"></i>
                                            </span>
                                            <div class="form-line">
                                                <select style="color:#FF0000" name="jatuh_tempo" id="jatuh_tempo" class="form-control date jatuh_tempo" disabled>
                                                <option value="">--Pilih Durasi Hari--</option>
                                                <option value="+1 days">1 Hari</option>
                                                <option value="+7 days">7 Hari</option>
                                                <option value="+14 days">14 Hari</option>
                                                <option value="+30 days">30 Hari</option>
                                                <option value="+45 days">45 Hari</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <b>Total Transaksi</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="harga" name="total_awal" class="form-control" value="<?=angka($total[0])?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <b>Jumlah Diskon (Rp)</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="jumlah_diskon" name="jumlah_diskon" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <b>Total Hutang (Rp)</b>
                                        <div class="input-group ">
                                            <span class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="total_akhir" name="total_akhir" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <b style="color:#0000FF">Pembayaran Tunai (Isi 0 Jika Tidak Ada)</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <div class="tunai">
                            					<input type="checkbox" class="filled-in" id="tunai" checked="checked"/>
                                        		<label for="tunai" style="color:#0000FF"><strong>Tunai</strong></label>
                                				</div>
                                            </span>
                                            <div class="form-line">
                                                <input id="input_tunai" name="tunai" class="form-control uang"  onFocus="startCalc();" onBlur="stopCalc();" type="text" required/>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <b style="color:#0000FF">Transfer Antar rekening Dalam Bank</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <div class="transfer_dalam">
                            					<input type="checkbox" class="filled-in" id="transfer_dalam"/>
                                        		<label for="transfer_dalam" style="color:#0000FF"><strong>Jumlah Transfer</strong></label>
                                				</div>
                                            </span>
                                            <div class="form-line">
                                                <input onkeyup="hitung2();" id="input_dalam" name="dalam_bank" class="form-control uang" onFocus="startCalc();" onBlur="stopCalc();" type="text"/>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div><!--<div class="row clearfix">-->
                                
                                <b style="color:#FF0000" id="error_modal" ></b>
                                
                        <div class="modal-footer">
                            <button type="submit" name="cetak_langsung" class="btn btn-danger waves-effect" onclick="return validate();">CETAK</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>
                     </div> 
                     
<script src="<?=PLG?>jmask/jquery.mask.min.js"></script>                           
<script type="text/javascript">
            $(document).ready(function(){

                // Format mata uang.
                $( '.uang' ).mask('000.000.000', {reverse: true});

            })
</script>

<script>
function hilang_titik(string) {
            return string.split('.').join('');
        }

</script> 

<script>
function untuk_umum() {
    var x = document.getElementById("pel_umum");
    var y = document.getElementById("pel_tetap");
    if (x.style.display === "none") {
        x.style.display = "block";
		y.style.display = "none";
		document.getElementById('nama_umum').required = true;
		document.getElementById('alamat_umum').required = true;
    } else {
        x.style.display = "none";
		y.style.display = "block";
		document.getElementById('pel_tetap').style.visibility = 'visible';
		document.getElementById('nama_umum').required = false;
		document.getElementById('nama_umum').value = '';
		document.getElementById('alamat_umum').required = false;
    }
}
</script>


<!---JS AUTOCOMPLE-->

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

    function autoComplete3() { //fungsi menangkap input search dan menampilkan hasil search

        getAjax();

        input = document.getElementById('demo').value;if (input == "") {

            document.getElementById("hasil_modal").innerHTML = "";

        }

        else {

            ajaxRequest.open("GET","proses_ajax.php?modal="+input);

            ajaxRequest.onreadystatechange = function() {

                document.getElementById("hasil_modal").innerHTML = ajaxRequest.responseText;

            }

            ajaxRequest.send(null);

        }
		

    }

    function autoInsert3(nama, limit_kredit, id_customer) { //fungsi mengisi input text dengan hasil pencarian yang dipilih

        document.getElementById("demo").value = nama;

        document.getElementById("limit_kredit").value = limit_kredit;

        document.getElementById("id_customer").value = id_customer;

        document.getElementById("hasil_modal").innerHTML = "";

    }
	
</script>    
<!---AKHIR JS AUTOCOMPLE-->   

<script language="javascript">
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
    function autoComplete2() { //fungsi menangkap input search dan menampilkan hasil search
        getAjax();
        input_diskon = document.getElementById('diskon').value;if (input_diskon == "") {
            document.getElementById("hasil_diskon").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","proses_ajax.php?no_faktur=<?=$no_faktur?>&diskon="+input_diskon);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil_diskon").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert2(kode, jumlah_diskon, distributor_diskon, id_diskon, sub_total, id_trx, spc_diskon) { //fungsi mengisi input text dengan hasil pencarian yang dipilih
        document.getElementById("diskon").value = kode;
        document.getElementById("jumlah_diskon").value = jumlah_diskon;
        document.getElementById("distributor_diskon").value = distributor_diskon;
        document.getElementById("id_diskon").value = id_diskon;
		document.getElementById("sub_total").value = sub_total;
		document.getElementById("id_trx").value = id_trx;
		document.getElementById("spc_diskon").value = spc_diskon;
        document.getElementById("hasil_diskon").innerHTML = "";
    }
</script>

<script type="text/javascript">
    function validate() {
		var error="";
		var pelanggan = document.getElementById( "radio_umum" );
		var umum = document.getElementById( "nama_umum" );
    	var hutang = hilang_titik(document.getElementById( "total_akhir" ).value);
    	var limit_kredit = hilang_titik(document.getElementById( "limit_kredit" ).value);
		var id_customer = document.getElementById( "id_customer" );
		over=limit_kredit - hutang;
		if( umum.value != "" && hutang > 0)	{
			swal("Gagal!", "Bukan Pelanggan Tetap tidak diijinkan Ngutang...!", "error");
			return false;
			
			
			} else if( pelanggan.value != "" && over < 0)	{
			swal("Gagal!", 'Over Kredit, Limit : Rp. '+tandaPemisahTitik(over), "error");
			return false; 
			
			
			} else if( pelanggan.value != "" && hutang < 0)	{
			error = "<i class='fa fa-ban fa-lg' style='color:red;'></i> Hutang Tidak Boleh Negatif";
			document.getElementById( "error_modal" ).innerHTML = error;
			return false; 
			} else if( pelanggan.value == "1" && hutang < 0)	{
			error = "<i class='fa fa-ban fa-lg' style='color:red;'></i> Hutang Tidak Boleh Negatif";
			document.getElementById( "error_modal" ).innerHTML = error;
			return false; 
			} else if( id_customer.value == "" && nama_umum.value == "")	{
			swal("Gagal!", "Silahkan Pilih Customer", "error");
			return false; 

			} else {
				return true;
			}
    }
	
</script>

<script language="javascript">
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

    function preview() { //fungsi menangkap input search dan menampilkan hasil search
        getAjax();
        input = document.getElementById('no_faktur').value;if (input == "") {
             swal("Here's a message!");
        }
        else {
            ajaxRequest.open("GET","tes_progress.php?input="+input);
            ajaxRequest.onreadystatechange = function() {
				swal({title: "Generate File", text: ajaxRequest.responseText, html: true });
				
            }
            ajaxRequest.send(null);
        }
    }

</script>

<script type="application/javascript">
    function startCalc(){
    		interval = setInterval("calc()",1);
    }
    function calc(){
	    total_awal = hilang_titik(document.epen.total_awal.value);
	    jumlah_diskon = hilang_titik(document.epen.jumlah_diskon.value);
	    dalam_bank = hilang_titik(document.epen.dalam_bank.value);
		input_tunai = hilang_titik(document.getElementById("input_tunai").value);
		total=total_awal - dalam_bank - input_tunai - jumlah_diskon;
		document.epen.total_akhir.value = tandaPemisahTitik(total);
				if(total==0) { 
				document.getElementById('jatuh_tempo').disabled = true;
				} else {
				document.getElementById('jatuh_tempo').disabled = false;
				document.getElementById('jatuh_tempo').required = true;
				}

	}
    function stopCalc(){
    	clearInterval(interval);
    }
</script> <!-- Menghitung otomatis -->

<?php
endif;


if (isset($_GET['transaksi'])) :

$pecah = explode('#',$_POST['rowid']);
$no_faktur=$pecah[0];
$distributor=$pecah[1];
$trx=$conn->query("SELECT * FROM `tabel_trx` WHERE no_faktur='$no_faktur' AND distributor = '$distributor' ORDER BY id ASC");
$total_trx=$conn->query("SELECT SUM(sub_total), id_toko FROM `tabel_trx` WHERE no_faktur='$no_faktur' AND distributor = '$distributor' ")->fetch_array();
$toko=$conn->query("select nama from lokasi where id_lokasi='".$total_trx[1]."'")->fetch_array();
?>

<small>NO INVOICE : <?=$no_faktur?> di <?=$toko[0]?></small>

<div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>KODE</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY</th>
                                            <th>HARGA SATUAN</th>
                                            <th>DISKON</th>
                                            <th>SUB TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6">TOTAL</th>
                                            <th><?=angka($total_trx[0])?></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$trx->fetch_array()) :
									$diskon=$x['jumlah']*$x['potongan'];
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah'].' '.$x['satuan']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($x['potongan'])?></td>
                                            <td><?=angka($x['sub_total'])?></td>
                                        </tr>
                                    <?php endwhile; ?>    
                                    </tbody>
                                </table>
</div>


<?php
endif;

if (isset($_GET['konfirmasi'])) :

$id=$_GET['modal_id'];
$konfirmasi=$_GET['konfirmasi'];
$id_bank=$_GET['rek_bank'];
$customer=$_GET['customer'];
$keterangan='Konfirmasi Transfer Piutang A.N '.$customer;

if ($konfirmasi=='success') {
$masuk=$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `id_bayar`, `jumlah_bayar`, `no_faktur`, `keterangan`, `distributor`, `id_toko`, `jenis`, `id_bank`) SELECT '".$_SESSION['id']."', id, jumlah_transaksi, no_faktur, '$keterangan', distributor, id_toko, '1', '$id_bank' FROM tabel_bayar where id='$id'");
$update=$conn->query(" UPDATE  tabel_bayar SET jumlah_bayar=jumlah_transaksi where id = '$id'");
$alert='approve';
} else {
$jumlah_dibayar=$conn->query("SELECT jumlah_bayar FROM konfirmasi_bank WHERE id_bayar='$id'")->fetch_array();
$masuk=$conn->query("DELETE FROM `konfirmasi_bank` WHERE id_bayar='$id'");
$update=$conn->query(" UPDATE  tabel_bayar SET jumlah_bayar='$jumlah_dibayar[0]' where id = '$id'");
$alert='not_approve';
}
        echo "<script>window.alert('Berhasil..!') 
		window.location='konfirmasi_bank.php?$alert'</script>";
endif;

if (isset($_GET['cetak_langsung'])) : 

if (empty($_GET['radio_umum'])) {
		$umum = Array (
				"umum" => Array (
        		"nama" => $_GET['nama_umum'],
        		"alamat" =>  $_GET['alamat_umum'],
        		"kota" =>  $_GET['kota_umum'],
				"hp" =>  $_GET['hp_umum'],
				));
	$json = json_encode($umum);
	$arr = json_decode($json, true);
	echo $json.'<br>';
	echo $arr["umum"]["nama"];
	} else {
	$umum='';
	$json = json_encode($umum);
	$arr = json_decode($json, true);
	echo $json.'<br>';
	echo $arr["umum"]["nama"];
	}	

endif;

if (isset($_GET['rincian_summary_transaksi'])) :

$no_faktur = $_POST['rowid'];
$trx=$conn->query("SELECT * FROM `tabel_trx` WHERE no_faktur='$no_faktur'");
?>
<div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>DISTRIBUTOR</th>
                                            <th>KODE</th>
                                            <th>NAMA BARANG</th>
                                            <th>QTY</th>
                                            <th>HARGA SATUAN</th>
                                            <th>DISKON</th>
                                            <th>KETERANGAN</th>
                                            <th>SUB TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									$no=1;
									while ($x=$trx->fetch_array()) :
									$diskon=$x['jumlah']*$x['potongan'];
									?>
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td><?=$x['distributor']?></td>
                                            <td><?=$x['kode_barang']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=$x['jumlah'].' '.$x['satuan']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($x['potongan'])?></td>
                                            <td><?=$x['keterangan']?></td>
                                            <td><?=angka($x['sub_total'])?></td>
                                        </tr>
                                    <?php endwhile; ?>    
                                    </tbody>
                                </table>
</div>
<?php
endif;

if (isset($_GET['modal_upload'])) :

$pecah = explode('#',$_POST['rowid']);
$no_faktur=$pecah[0];
$distributor=$pecah[1];
$retur_barang=$conn->query(" SELECT * FROM tabel_retur WHERE kode=1 AND no_faktur = '$no_faktur' AND distributor = '$distributor' AND id_toko = '".$_SESSION['toko']."' ");
$ada_retur=$retur_barang->num_rows;
	if ($ada_retur==0) {
	$opsi_retur='';
	} else {
	$opsi_retur='<option value="3">BUKTI RETUR BARANG</option>';
	}
$url=str_replace(':','&',$pecah[2]);	
?>
                           <form class="form-horizontal" enctype="multipart/form-data" method="post" id="uploadForm" action="">
                           <input type="hidden" name="id_toko"  id="id_toko" value="<?=$_SESSION['toko']?>">
                           <input type="hidden" name="distributor"  id="distributor" value="<?=$distributor?>">
                           <input type="hidden" name="no_faktur"  id="no_faktur" value="<?=$no_faktur?>">
                           <input type="hidden" name="url"  id="url" value="<?=$url?>">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                    <label for="File">Konfirmasi Jenis Dokumen</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                        	<div class="form-line">
                                                <select name="jenis" id="jenis" class="form-control jenis_mdl" onChange="ubah_surat_jalan();" required>
                                                <option value="">--Pilih Jenis Dokumen--</option>
                                                <option value="1">INVOICE</option>
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
                                    $barang=$conn->query(" SELECT * FROM ambil_barang where id_barang_keluar IN (SELECT id FROM barang_keluar where no_faktur='$no_faktur' AND distributor = '$distributor') ");
									$ada=$barang->num_rows;
									if ($ada == 0) {
									echo '<option value="">Tidak Ada Dokumen Surat Jalan Pada No Faktur '.$no_faktur.' Dstributor '.$distributor.'</option>';
										} else {
										while ($x=$barang->fetch_array()) :
										$gd=$conn->query("SELECT nama from lokasi where id_lokasi = '".$x['id_gudang']."'")->fetch_array();
									?>            
                                                <option value="<?=$x['id_pengambilan']?>">No Surat Jalan <?=$no_faktur.'-'.surat_jalan($x['partial'])?>, QTY Ambil <?=$x['jumlah_ambil']?> Dari Gudang : <?=$gd[0]?></option>
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
                                 <button type="submit" class="btn bg-blue waves-effect">
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

<script type="application/javascript">
$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result){
			var response = JSON.parse(result);
			if (response.status){
				$(".data_paginasi").load("data_paginasi.php?<?=$url?>");
				$('.upload').modal('hide');
				alert('Upload Berhasil');
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

if (isset($_GET['entry_konfirmasi'])) :
$pecah = explode('#',$_POST['rowid']);
$id=$pecah[0];
$id_toko=$_SESSION['toko'];
$x=$conn->query("SELECT * FROM tabel_bayar where id = '$id'")->fetch_array();
?>
                            <form method="post" action="<?=$_SERVER['PHP_SELF']?>" autocomplete="off">
							<input type="hidden" name="id" value="<?=$id?>" />
							<input type="hidden" name="customer" value="<?=$pecah[1]?>" />
                            <label for="id_bank">Pembayaran Via Transfer</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="id_bank" id="id_bank" class="form-control" >
                                        <option value="">--PILIH REKENING--</option>
                             <?php
                             $rek_bank=$conn->query("SELECT * FROM rekening_bank where distributor = '".$x['distributor']."' AND is_aktif = 1 AND id_toko='$id_toko' ");
							 while ($b=$rek_bank->fetch_array()) : 
							 ?>           
                                       <option value="<?=$b['id']?>"><?=$b['bank'].' No Rek '.$b['no_rek'].' Nama Rek '.$b['nama_akun']?></option>
							<?php endwhile; ?>			
                                        </select>
                                    </div>
                                </div>
                            </div>    
                                
                            <button type="submit" class="btn btn-success waves-effect" name="simpan_konfirmasi">Simpan</button> 
<?php
endif;
if (isset($_POST['simpan_konfirmasi'])) :
$id = $_POST['id'];
$customer = $_POST['customer'];
$id_bank = $_POST['id_bank'];
$keterangan='Konfirmasi Transfer Piutang A.N '.$customer;

$masuk=$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `id_bayar`, `jumlah_bayar`, `no_faktur`, `keterangan`, `distributor`, `id_toko`, `jenis`, `id_bank`) SELECT '".$_SESSION['id']."', id, jumlah_bayar, no_faktur, '$keterangan', distributor, id_toko, '1', '$id_bank' FROM tabel_bayar where id='$id' AND jumlah_bayar > 0");
$masuk=$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `id_bayar`, `jumlah_bayar`, `no_faktur`, `keterangan`, `distributor`, `id_toko`, `jenis`, `id_bank`) SELECT '".$_SESSION['id']."', id, jumlah_transaksi, no_faktur, '$keterangan', distributor, id_toko, '1', '$id_bank' FROM tabel_bayar where id='$id' AND jumlah_bayar = 0");
$update=$conn->query(" UPDATE  tabel_bayar SET jumlah_bayar=jumlah_transaksi where id = '$id' AND jumlah_bayar=0");
$alert='approve';
        echo "<script>window.alert('Berhasil..!') 
		window.location='konfirmasi_bank.php?$alert'</script>";

endif;

if (isset($_GET['pembatalan_transaksi'])) :

$no_faktur=$_POST['no_faktur'];
$customer=$_POST['customer'];
$keterangan_batal=$_POST['keterangan'];
$total_trx=$_POST['total_trx'];
$id_kasir=$_SESSION['id'];
$id_toko=$_SESSION['toko'];
$waktu_batal=strtotime(date('Y-m-d H:i:s'));
$qry=$conn->query("SELECT kode_barang, jumlah, satuan, harga_barang,  potongan, sub_total, distributor FROM tabel_trx WHERE no_faktur='".$no_faktur."'");
while($x = $qry->fetch_array()  ) :
	$data[] = $x;
endwhile;
$keterangan_barang = json_encode($data);

$masuk=$conn->query("INSERT INTO `tabel_batal`(`no_faktur`, `customer`, `id_kasir`, `keterangan_barang`, `keterangan_batal`, id_toko, total_trx, waktu_batal) VALUES('$no_faktur', '$customer', '$id_kasir', '$keterangan_barang', '$keterangan_batal', '$id_toko', '$total_trx', '$waktu_batal')");

$ambil=$conn->query("SELECT no_faktur FROM tabel_faktur WHERE no_faktur='$no_faktur'");
while ($a=$ambil->fetch_array()) :
	$retur=$conn->query("select * from tabel_trx where no_faktur='".$a[0]."'");
	while ($b=$retur->fetch_array()) :
	$sisa_stok=$conn->query("select sisa_stok from stok_barang where kode_barang='".$b['kode_barang']."'")->fetch_array();
	$stok=$b['jumlah']+$sisa_stok[0];
	$update=$conn->query("update stok_barang set sisa_stok='$stok' where kode_barang='".$b['kode_barang']."'");
	endwhile;
	$hapus_trx=$conn->query("delete from tabel_trx where no_faktur='".$a[0]."'");
	$hapus_alokasi_jual=$conn->query("delete from alokasi_stok_jual where no_faktur='".$a[0]."'");
endwhile;


$hapus=$conn->query("DELETE FROM `tabel_faktur` WHERE no_faktur='$no_faktur'");
$hapus=$conn->query("DELETE FROM `barang_keluar` WHERE no_faktur='$no_faktur'");
$hapus=$conn->query("DELETE FROM `tabel_bayar` WHERE no_faktur='$no_faktur'");


echo json_encode(array('status' =>true, 'pesan' =>'Transaksi Berhasil Dibatalkan'));

endif;

if (isset($_GET['tampil_batal'])) :

$id=$_POST['id'];

$qry=$conn->query("SELECT * FROM tabel_batal where id='$id'")->fetch_array();

?>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-biaya">
		<thead>
			<tr>
				<th scope="col">KODE BARANG</th>
				<th scope="col">NAMA BARANG</th>
				<th scope="col">JUMLAH</th>
				<th scope="col">HARGA SATUAN</th>
				<th scope="col">POTONGAN</th>
				<th scope="col">DISTRIBUTOR</th>
				<th scope="col">SUB TOTAL</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="6">Total</th>
				<th class="align-right"><?=angka($qry['total_trx'])?></th>
			</tr>
		</tfoot>
		<tbody>
<?php
$json=json_decode($qry['keterangan_barang']);
 foreach( $json as $data) {
 $nama_barang=$conn->query("SELECT nama_barang FROM stok_barang WHERE kode_barang='".$data->kode_barang."'")->fetch_array();
  echo '
    <tr>
    	<td  class="align-center">'.$data->kode_barang.'</td>
    	<td>'.$nama_barang[0].'</td>
    	<td>'.$data->jumlah.' '.$data->satuan.'</td>
    	<td>'.angka($data->harga_barang).'</td>
    	<td>'.angka($data->potongan).'</td>
    	<td>'.$data->distributor.'</td>
    	<td class="align-right">'.angka($data->sub_total).'</td>
  	</tr>
  ';
 }
?>

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
            'copy', 'print'
        ]
    });
});
</script>                            




<?php
endif;
?>