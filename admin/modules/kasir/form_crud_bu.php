<?php
include '../../../sysconfig.php';
include MDL.'login/session.php';
if (isset($_GET['modal'])) :
$no_faktur = $_POST['rowid'];
$total=$conn->query("select SUM(sub_total), customer, kode_barang from tabel_trx where no_faktur='$no_faktur'")->fetch_array();
$gudang=$conn->query("select a.id_gudang, b.nama, a.jumlah, a.id, a.pintu_gudang from alokasi_stok as a left join lokasi as b on a.id_gudang=b.id_lokasi where a.kode_barang='".$total[2]."'")->fetch_array();
?>

                        <div class="body">
                            <form method="get" action="cetak.php">
                            <input type="hidden" name="id_gudang" value="<?=$gudang[0]?>" />
                            <input type="hidden" name="pintu_gudang" value="<?=$gudang[4]?>" />
                            <input type="hidden" name="no_faktur" value="<?=$no_faktur?>" />
                            <input type="hidden" name="customer" value="<?=$total[1]?>" />
                            <input type="hidden" name="kasir" value="<?=$_SESSION['id']?>" />
                            <input type="hidden" class="total_awal" value="<?=$total[0]?>" />
                            <input type="hidden" class="tot" name="tot"/>
                            
                            <label for="email_address">Customer</label>
                                <div class="form-group">
                                    <div class="form-line">
                                    <select name="customer" class="form-control show-tick" data-live-search="true" required>
                                    <option value="1">UMUM</option>
                                    <?php
                                    $cust=$conn->query("SELECT * FROM `tabel_customer` where id > 1 ORDER BY nama ASC");
									while ($c=$cust->fetch_array()) :
									$hutang=$conn->query("select SUM(hutang) from tabel_faktur where customer='".$c['id']."' and remark='0'")->fetch_array();
									$limit_sisa=$c['limit_kredit'] - $hutang[0];
									?>
                                    <option value="<?=$c['id']?>"><?=$c['nama'].' Limit : Rp. '.angka($limit_sisa)?></option>
                                    <?php endwhile;?>    
                                    </select>
                                    </div>
                                </div>
                                
                                
                                
                            <label for="email_address">Total Transaksi</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="harga" name="total_awal" class="form-control total_tampil" value="<?=$total[0]?>" readonly>
                                    </div>
                                </div>
                                
                            <label for="email_address">Diskon (%) Mohon isi 0 jika tidak ada diskon</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="diskon" name="diskon" class="form-control diskon" value="" onkeyup="hitung2();" required autofocus/>
                                    </div>
                                </div>
                                                               
                                
                            <label for="email_address">Jumlah Diskon (Rp)</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="jumlah_diskon" name="jumlah_diskon" class="form-control jumlah_diskon" readonly>
                                    </div>
                                </div>

                            
                                <div class="tunai">
                            			<input type="checkbox" id="tunai"/>
                                        <label for="tunai">Tunai</label>
                                </div>
                                
                            <label for="input_tunai">Pembayaran Tunai Mohon isi 0 Jika tidak ada Pembayaran Tunai</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="input_tunai" name="tunai" class="form-control input_tunai" value="0" onkeyup="hitung2();" disabled="" type="text"/>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="transfer_dalam">
                            			<input type="checkbox" id="transfer_dalam"/>
                                        <label for="transfer_dalam">Transfer Dalam Bank</label>
                                </div>
                                
                            <label for="input_dalam">Transfer Antar rekening Dalam Bank</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="input_dalam" name="dalam_bank" class="form-control input_dalam" value="0" onkeyup="hitung2();"  disabled="" type="text"/>
                                    </div>
                                </div>
                            
                            
                            
                            
                                <div class="transfer_antar">
                            			<input type="checkbox" id="transfer_antar"/>
                                        <label for="transfer_antar">Transfer Dalam Bank</label>
                                </div>
                                
                            <label for="input_antar">Transfer Antar Bank</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="input_antar" name="antar_bank" class="form-control input_antar"  value="0" onkeyup="hitung2();"  disabled="" type="text"/>
                                    </div>
                                </div>
                            

                            <label for="email_address">Total Hutang</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="totBayar" name="total_akhir" class="form-control total_akhir" readonly>
                                    </div>
                                </div>
                                

                            
                            <label for="email_address">Tanggal Jatuh Tempo</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control date" disabled/>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="cetak_langsung" class="btn btn-danger waves-effect">CETAK</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>
                     </div>      


<script type="text/javascript">
$('#tunai').change(function(){
   $("#input_tunai").prop("disabled", !$(this).is(':checked'));
});
</script>	

<script type="text/javascript">
$('#transfer_dalam').change(function(){
   $("#input_dalam").prop("disabled", !$(this).is(':checked'));
});
</script>	

<script type="text/javascript">
$('#transfer_antar').change(function(){
   $("#input_antar").prop("disabled", !$(this).is(':checked'));
});
</script>	



<script>
function hitung2() {
    var total_tampil = $(".total_tampil").val();
    var total_awal = $(".total_awal").val();
    var diskon = $(".diskon").val();
    var input_tunai = $(".input_tunai").val();
    var input_antar = $(".input_antar").val();
    var input_dalam = $(".input_dalam").val();
	jumlah_diskon = total_tampil*diskon/100;
	belum = total_awal - jumlah_diskon ; //a kali b
	total_akhir = belum - input_tunai - input_antar - input_dalam; //a kali b
    $(".total_akhir").val(total_akhir);
    $(".jumlah_diskon").val(jumlah_diskon);
    $(".tot").val(belum);
}

</script> 


<script type="text/javascript">
function s(){
var i=document.getElementById("totBayar");
if(i.value=="")
    {
    document.getElementById("jatuh_tempo").disabled=true;
    }
else
    document.getElementById("jatuh_tempo").disabled=false;
	}
</script>



<?php
endif;


if (isset($_GET['transaksi'])) :

$no_faktur = $_POST['rowid'];
$trx=$conn->query("SELECT * FROM `tabel_trx` WHERE no_faktur='$no_faktur' ORDER BY id ASC");
$total_trx=$conn->query("SELECT SUM(sub_total) FROM `tabel_trx` WHERE no_faktur='$no_faktur'")->fetch_array();
?>

<small>NO INVOICE : <?=$no_faktur?></small>

<div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>KODE</th>
                                            <th>QTY</th>
                                            <th>NAMA BARANG</th>
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
                                            <td><?=$x['jumlah']?></td>
                                            <td><?=$x['nama_barang']?></td>
                                            <td><?=angka($x['harga_barang'])?></td>
                                            <td><?=angka($diskon)?></td>
                                            <td><?=angka($x['sub_total'])?></td>
                                        </tr>
                                    <?php endwhile; ?>    
                                    </tbody>
                                </table>
</div>


<?php
endif;
?>