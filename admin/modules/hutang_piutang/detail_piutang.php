<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['entry_bayar'])) :
$pecah = explode('#',$_POST['rowid']);
$no_faktur=$pecah[0];
$distributor=$pecah[1];
$bayar=$conn->query("select * from tabel_bayar where no_faktur = '$no_faktur' AND distributor = '$distributor' AND metode_bayar=1")->fetch_array();
$nama_customer=$conn->query("SELECT nama from tabel_customer where id='$bayar[customer]'")->fetch_array();
if ($bayar['remark']==0) {
?>
                            <form method="post" action="detail_piutang.php" autocomplete="off">
                            <input type="hidden" name="id_hutang" value="<?=$bayar['id']?>" />
                            <input type="hidden" name="distributor" value="<?=$bayar['distributor']?>" />
                            <input type="hidden" name="no_faktur" value="<?=$bayar['no_faktur']?>" />
                            <input type="hidden" name="user_approv" value="<?=$_SESSION['id']?>" />                           
                            <input type="hidden" id="jumlah_transaksi" value="<?=$bayar['jumlah_transaksi']?>" />
                            <input type="hidden" name="pembayaran_hutang" />
                            <input type="hidden" name="nama_customer" value="<?=$nama_customer[0]?>" />
                            
                            <label for="email_address">Jumlah Transaksi</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="<?=angka($bayar['jumlah_transaksi'])?>" readonly>
                                    </div>
                                </div>
                            <label for="email_address">Terbayar</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="jumlah_hutang" name="jumlah_hutang" value="<?=angka($bayar['jumlah_bayar'])?>" readonly>
                                    </div>
                                </div>
                            <label for="email_address">Pembayaran</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="jumlah_bayar"  name="jumlah_bayar" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" autofocus required/>
                                    </div>
                                </div>
                            <label for="email_address">Sisa Hutang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="sisa_hutang" name="sisa" readonly>
                                    </div>
                                </div>
                            <label for="email_address">Transaksi</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="via_bayar" id="via_bayar" class="form-control" onchange="open_bank()" required>
                                        <option value="">--Metode Pambayaran--</option>
                                        <option value="tunai">TUNAI</option>
                                        <option value="transfer">TRANSFER</option>
                                        </select>
                                    </div>
                                </div>
                                
                            <div id="field_bank" style="display:none">
                            <label for="id_bank">Pembayaran Via Transfer</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="id_bank" id="id_bank" class="form-control" >
                                        <option value="">--PILIH REKENING--</option>
                             <?php
                             $rek_bank=$conn->query("SELECT * FROM rekening_bank where distributor = '".$bayar['distributor']."' AND is_aktif = 1  ");
							 while ($b=$rek_bank->fetch_array()) : 
							 ?>           
                                       <option value="<?=$b['id']?>"><?=$b['bank'].' No Rek '.$b['no_rek']?></option>
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
$("#jumlah_bayar").keyup(function(){
        var jumlah_bayar  = hilang_titik($("#jumlah_bayar").val());
        var jumlah_transaksi  = hilang_titik($("#jumlah_transaksi").val());
        var jumlah_hutang  = hilang_titik($("#jumlah_hutang").val());
        var sisa_hutang = jumlah_transaksi - jumlah_hutang - jumlah_bayar; 
        $("#sisa_hutang").val(tandaPemisahTitik(sisa_hutang));
      });
</script> 
<!-- END Kalkulator -->


<script type="text/javascript">
    function validasi() {
		var error="";
		var sisa_hutang = document.getElementById( hilang_titik("sisa_hutang") );
		var jumlah_bayar = document.getElementById( hilang_titik("jumlah_bayar") );
		if( jumlah_bayar.value ==  "" || jumlah_bayar.value <  1 )	{
    		swal("Gagal!", "Pembayaran harus bilangan Bulat Positif!", "error");
			return false;
			
			} else if( sisa_hutang.value < '0' )	{
    		swal("Gagal!", "Pembayaran Tidak Boleh melebihi Jumlah Hutang", "error");
			return false; 
			

			} else {
				return true;
			}
    }
</script>

<script>
function open_bank() {
    var via_bayar = document.getElementById("via_bayar");
    if (via_bayar.value=="tunai") {
		document.getElementById('field_bank').style.display = 'none';
		document.getElementById('id_bank').disabled = true;
    } else {
		document.getElementById('field_bank').style.display = 'block';
		document.getElementById('id_bank').disabled = false;
		document.getElementById('id_bank').required = true;
	}
}
</script>


<?php
} else {
$data=$conn->query("select * from bayar_hutang where id_hutang='".$bayar['id']."'");

ob_start();
while ($y=$data->fetch_array()) :
$pecah=explode(' ',$y['tgl_transaksi']);
echo rupiah($y['jumlah_bayar']).', '.tanggal_indo($pecah[0]).' '.$pecah[1].'<br>';
endwhile;
$trx=ob_get_contents();
ob_end_clean();

echo '<script language="javascript">
				swal({
        		title: "Lunas..!",
				text: "'.$trx.'",
        		imageUrl: "../../../images/thumbs-up.png",
				html: true
    			});
	  </script>';

} 
endif;

if (isset($_POST['pembayaran_hutang'])) :

$jumlah_bayar =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_bayar']);
$via_bayar = $_POST['via_bayar'];
$id_hutang = $_POST['id_hutang'];
$distributor = $_POST['distributor'];
$no_faktur = $_POST['no_faktur'];
$nama_customer = $_POST['nama_customer'];
$user_approv = $_POST['user_approv'];
$sisa_hutang =  preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['jumlah_hutang'])+$jumlah_bayar;
if (preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['sisa'])==0) {
$remark='1';
} else {
$remark='0';
}

if ($_SESSION['level']==3) {
	$id_toko='id_toko';
	} else {
	$id_toko='0';
	}

$keterangan='Pembayaran Piutang A.N '.$nama_customer;

$update=$conn->query("update tabel_bayar set jumlah_bayar='$sisa_hutang', remark='$remark' where id='$id_hutang'");

$masuk=$conn->query("INSERT INTO `bayar_hutang`(`id_hutang`, `distributor`, `no_faktur`, `jumlah_bayar`,  `user_approv`, `via_bayar`) VALUES('$id_hutang', '$distributor', '$no_faktur', '$jumlah_bayar',  '$user_approv',  '$via_bayar') ");

if ($via_bayar != 'tunai') {
$id_bank = $_POST['id_bank'];
$masuk=$conn->query("INSERT INTO `konfirmasi_bank`(`user_approve`, `id_bayar`, `jumlah_bayar`, `no_faktur`, `keterangan`, `distributor`, jenis, id_bank, id_toko) SELECT '".$_SESSION['id']."', id, '$jumlah_bayar', no_faktur, '$keterangan', distributor, '1', '$id_bank', $id_toko FROM tabel_bayar where id='$id_hutang'");
} else {
$masuk=$conn->query("INSERT INTO `konfirmasi_tunai`(`user_approve`, `id_bayar`, `jumlah_bayar`, `no_faktur`, `keterangan`, `distributor`, jenis, id_toko) SELECT '".$_SESSION['id']."', id, '$jumlah_bayar', no_faktur, '$keterangan', distributor, '1', $id_toko FROM tabel_bayar where id='$id_hutang'");
}


        echo "<script>window.alert('Pembayaran Tersimpan') 
		window.location='piutang.php?LmngTGVf'</script>";


endif;

if (isset($_GET['kode_voucher'])) :

$kode = $_GET['kode_voucher'];
$distributor = $_GET['distributor'];
$jumlah_potongan = preg_replace('/\D/', '', $_GET['jumlah_potongan']);

$masuk=$conn->query("INSERT INTO `kode_voucher`(`kode`, `distributor`, `jumlah_potongan`) VALUES('$kode', '$distributor', '$jumlah_potongan')");

header ("location: ../kasir/generate_voucher.php");

endif;

if (isset($_GET['hapus_voucher'])) :
$id=$_GET['modal_id'];
$conn->query("DELETE FROM `kode_voucher` WHERE `id` = '$id'");

        echo "<script>window.alert('Kode Dihapus') 
		window.location='../kasir/generate_voucher.php?Hnnasdh'</script>";


endif;
?>

