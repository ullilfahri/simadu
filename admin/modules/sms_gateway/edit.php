<?php
include "../../partial/simpada_kpu_db.php";
$id = $_POST['rowid'];
if ($id<11) {
$r=$conn->query("SELECT * FROM mst_setting WHERE id='$id'")->fetch_array();
$st=$r['set'];
if ($st==true) {$set="ON";}else{$set="OFF";}
	
		?>
        	<form action="autoreply_edit_proses.php" method="post">
            <input type="hidden" name="id"  class="form-control" value="<?php echo $r['id']; ?>" />
            <table class="table">
                <tr>
                    <td>KEYWORD</td>
                    <td>:</td>
                    <td><input type="text" name="keyword" class="form-control" value="<?php echo $r['keyword']; ?>" readonly/></td>
                </tr>
                <tr>
                    <td>FORMAT SMS</td>
                    <td>:</td>
                    <td><input type="text" name="format" class="form-control" value="<?php echo $r['format'];?>" /></td>
                </tr>
                <tr>
                    <td>KETERANGAN</td>
                    <td>:</td>
                    <td><textarea name="keterangan" class="form-control"><?php echo $r['keterangan'];?></textarea></td>
                </tr>
                <tr>
                    <td>SET ON/OFF</td>
                    <td>:</td>
                    <td>
                    <select class="form-control" name="set">
            		<option value="<?php echo $r['set'];?>"><?php echo $set;?></option>
           	 		<option value="1">ON</option>
            		<option title="0">OFF</option>
        			</select>
                    </td>
                </tr>
                
                <tr>
                    <td><button type="submit" class="btn btn-primary m-t-15 waves-effect" name="format_sms">SIMPAN</button></td>
                </tr>
            </table>
	</form>
<?php
} else {
$x=$conn->query("select * from mst_setting where id='$id'")->fetch_array();
if ($x['set']==1) {$set="TIDAK"; $modem=str_replace("_"," # ",$x['keterangan']);} else {$set="YA"; $modem="-";}
?>
        	<form action="autoreply_edit_proses.php" method="post">
            <input type="hidden" name="id" value="<?php echo $x['id']; ?>"/>
            <table class="table">
                <tr>
                    <td>Balas Dari Modem Yang Sama ?</td>
                    <td>:</td>
                    <td>
                    <select id="set" name="set"  class="form-control" onchange="javascript:rubah(this)" required>
                    <option value="<?php echo $x['set'];?>"><?php echo $set;?></option>
                    <option value="1">TIDAK</option>
                    <option value="2">BALAS DARI PROVIDER SAMA</option>
                    <option value="0">YA</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>PILIH MODEM</td>
                    <td>:</td>
                    <td>
                    <select id="modem" name="keterangan" class="form-control" onchange="javascript:rubah(this)" required>
                    <option value="<?php echo $x['keterangan'];?>"><?php echo $modem;?></option>
            		<option id ="modem" class="0" value="-">-</option>
                    <option id ="modem" class="2" value="-">MODEM DENGAN PROVIDER YANG SAMA</option>
            		<option id ="modem" class="1" value="Modem_1">MODEM # 1</option>
            		<option id ="modem" class="1" value="Modem_2">MODEM # 2</option>
            		<option id ="modem" class="1" value="Modem_3">MODEM # 3</option>
					</select>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit" class="btn btn-primary m-t-15 waves-effect" name="reply_modem">SIMPAN</button></td>
                </tr>
            </table>
		</form>
	<script src="../../js/jquery.chained2.min.js"></script>
   <script>
            $("#modem").chained("#set");
   </script>

<?php
}
