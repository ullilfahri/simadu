<?php
include '../../../sysconfig.php';
$no_faktur=$_GET['no_faktur'];
$cst=$conn->query(" SELECT a.customer, b.level_diskon FROM tabel_faktur AS a LEFT JOIN tabel_customer AS b ON a.customer=b.id where a.no_faktur = '$no_faktur' ")->fetch_array();
if ($cst[0] > 0) {
	$lvl='
	<select id="ambil_potongan" class="form-control" onchange="fungsi_diskon()">
	<option value="0">TANPA POTONGAN</option>
	<option id="'.$cst[1].'">'.strtoupper(str_replace('_',' ',$cst[1])).'</option>
	<input type="hidden" id="level_1">
	<input type="hidden" id="level_2">
	<input type="hidden" id="level_3">
	</select>
	';
	} else {
	$lvl='
	<select id="ambil_potongan" class="form-control" onchange="fungsi_diskon()">
	<option value="0">TANPA POTONGAN</option>
	<option id="level_1">LEVEL 1</option>
	<option id="level_2">LEVEL 2</option>
	<option id="level_3">LEVEL 3</option>
	</select>
	';
	}
?>           
           
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                 <i class="fa fa-cart-arrow-down fa-2x"></i> ENTRY KERANJANG BELANJA <?=$no_faktur?>
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" class="form-horizontal form-input" id="form" name="form_entry" autocomplete="off">
                            <input type="hidden" name="no_faktur" value="<?=$no_faktur?>">
                            <input type="hidden" name="satuan" id="satuan">
                            <input type="hidden" id="harga_dasar" name="harga_dasar">
                            <input type="hidden" name="id_gudang" id="id_gudang">
                            <input type="hidden" class="stok_gudang" id="stok_gudang2">
                            <input type="hidden" class="sisa_stok" id="sisa_stok2">
                            <input type="hidden" id="id_alokasi" name="id_alokasi">
                            <input type="hidden" name="distributor" id="distributor">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label class="col-red">Kode/Nama Barang *</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="inputan" class="form-control" onkeyup='autoComplete();' autofocus/>
                                            </div>
                                            <div id='hasil'></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label class="col-red">Harga Barang (Opsional Mark Up *)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="harga_barang" name="harga_barang" class="form-control" onkeydown="return numbersonly(this, event);">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label class="col-red">QTY *</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control a2" name="jumlah" onkeyup="hitung2();" id="jumlah_barang" onkeydown="return numbersonly(this, event);"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label class="col-red">Keterangan (Opsional*)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea rows="1" class="form-control no-resize auto-growth" id="keterangan" name="keterangan" placeholder="Masukan Keterangan (Opsional)"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="field_potongan" style="display:none">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label class="col-red">Potongan (Pilih Level Diskon)*</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?=$lvl?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label>Potongan (Rp.)/barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="potongan"  id="potongan" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label>Kode Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="kode_barang" name="kode_barang" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label>Nama Barang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="nama_barang" name="nama_barang" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label>Total Stok</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="sisa_stok" name="sisa_stok" class="form-control c2" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label>Pengambilan Dari Stok</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="nama_gudang" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label>Sisa Stok Gudang</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="stok_gudang" name="stok_gudang" onkeyup="hitung2();" class="form-control b2" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
										<button type="button" class="btn btn-primary m-t-15 waves-effect" id="tombol_simpan" onclick="return simpan();">Entry</button>
                                    	<button type="reset" onclick="reset_form()" class="btn btn-warning m-t-15 waves-effect">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->
            
                                  
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <i class="fa fa-shopping-cart fa-2x"></i> DAFTAR KERANJANG BELANJA
                            </h2>
                        </div>
                        <div class="body">
							<div class="list-data"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->   
            
<script>
function hilang_titik(string) {
            return string.split('.').join('');
        }

</script>    
<!-- Kalkulator -->
<script>
function hitung2() {
    var a = hilang_titik($(".a2").val());
    var stok_gudang = $(".stok_gudang").val();
    var sisa_stok = $(".sisa_stok").val();
    c = stok_gudang - a ; //a kali b
	d = sisa_stok - a ; //a kali b
    $(".b2").val(c);
	$(".c2").val(d);
}
</script> 
<!-- END Kalkulator -->
    

<script type="text/javascript">
		$(".list-data").load("data.php?no_faktur=<?=$no_faktur?>");
    function simpan() {
		var harga_barang = document.getElementById("harga_barang");
		mark_up = hilang_titik(harga_barang.value);
		//var harga_dasar = document.getElementById( hilang_titik("harga_dasar") );
		//var harga_barang = hilang_titik(document.form_entry.harga_barang.value);
		harga_dasar = hilang_titik(document.form_entry.harga_dasar.value);
		var jumlah_barang = document.getElementById( hilang_titik("jumlah_barang") );
		var sisa_stok = document.getElementById( "sisa_stok" );
		var stok_gudang = document.getElementById( "stok_gudang" );
		var harga_barang = document.getElementById( "harga_barang" );
		if( harga_barang.value ==  0)	{
    		swal("Gagal!", "Tidak Ada Data Entry!", "error");
			return false;
			
			} else if( jumlah_barang.value == "" || jumlah_barang.value <  1)	{
    		swal("Gagal!", "Jumlah Barang Tidak Boleh Kosong atau bernilai negatif! ", "error");
			return false; 

			} else if( sisa_stok.value < 0)	{
    		swal("Gagal!", "Entry Jumlah Barang tidak mencukupi data Stok!", "error");
			return false; 


			} else if( eval(harga_dasar) > eval(mark_up) )	{
    		swal("Gagal!", "Mark Up harga kurang dari harga dasar ", "error");
			return false; 

			} else if( stok_gudang.value < 0)	{
    		swal("Gagal!", "Jumlah Stok tidak mencukupi di Gudang!", "error");
			return false; 


			} else {

			var data=$(".form-input").serialize();
			$.ajax({
				type:'POST',
				url:'simpan.php',
				data:data,
				success:function(){
					$(".list-data").load("data.php?no_faktur=<?=$no_faktur?>");
					document.getElementById('inputan').value = "";
				} 
			});
			document.getElementById("form").reset();
			$.notify({icon: 'glyphicon glyphicon-thumbs-up',title: '<strong>Success..!</strong>',message: 'Data Dientry..'},{type: 'success'});
			document.getElementById('inputan').readOnly = false;
			document.getElementById("field_potongan").style.display = "none";
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
    function autoComplete() { //fungsi menangkap input search dan menampilkan hasil search
        getAjax();
        input = document.getElementById('inputan').value;if (input == "") {
            document.getElementById("hasil").innerHTML = "";
        }
        else {
            ajaxRequest.open("GET","proses_ajax.php?input="+input);
            ajaxRequest.onreadystatechange = function() {
                document.getElementById("hasil").innerHTML = ajaxRequest.responseText;
            }
            ajaxRequest.send(null);
        }
    }
    function autoInsert(id, kode_barang, nama_barang, harga_barang, sisa_stok, id_gudang, stok_gudang, nama_gudang, satuan, distributor, pintu_gudang, level_1, level_2, level_3) { //fungsi mengisi input text dengan hasil pencarian yang dipilih
        document.getElementById("inputan").value = nama_barang;
        document.getElementById("kode_barang").value = kode_barang;
        document.getElementById("nama_barang").value = nama_barang;
        document.getElementById("harga_barang").value = harga_barang;
        document.getElementById("harga_dasar").value = harga_barang;
        document.getElementById("sisa_stok").value = sisa_stok;
        document.getElementById("id_gudang").value = id_gudang;
        document.getElementById("stok_gudang").value = stok_gudang;
        document.getElementById("nama_gudang").value = nama_gudang;
        document.getElementById("satuan").value = satuan;
        document.getElementById("stok_gudang2").value = stok_gudang;
        document.getElementById("sisa_stok2").value = sisa_stok;
        document.getElementById("distributor").value = distributor;
        document.getElementById("id_alokasi").value = id;
        document.getElementById("level_1").value = level_1;
        document.getElementById("level_2").value = level_2;
        document.getElementById("level_3").value = level_3;
        document.getElementById("hasil").innerHTML = "";
        document.getElementById("inputan").readOnly = true;
		document.getElementById("field_potongan").style.display = "block";
    }
</script>    
<!---AKHIR JS AUTOCOMPLE-->  

<script>
function reset_form() {
        document.getElementById('inputan').value = "";
        document.getElementById('inputan').readOnly = false;
}
</script>

<script src="<?=PLG?>jmask/jquery.mask.min.js"></script>                           
<script type="text/javascript">
            $(document).ready(function(){

                // Format mata uang.
                $( '.uang' ).mask('000.000.000', {reverse: true});

            })
</script>

<script>
function fungsi_diskon() {
    var x = document.getElementById("ambil_potongan").value;
    document.getElementById("potongan").value = x;
}
</script>