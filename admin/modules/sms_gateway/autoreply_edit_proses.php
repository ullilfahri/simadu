                    <!-- Amun updtae -->
<?php
include "../../partial/simpada_kpu_db.php";
if (isset($_POST['format_sms'])) {
$id=$_POST['id'];
$set=$_POST['set']; 
$keyword=$_POST['keyword']; 
$format=$_POST['format']; 
$keterangan=$_POST['keterangan']; 
$conn->query("UPDATE `mst_setting` SET `keyword`='$keyword',`set`='$set',`keterangan`='$keterangan',`format`='$format' WHERE id='$id'");                 
                 
                 
                 
	  $n1 = $conn->query("select * from mst_setting where id='1'")->fetch_array();
	  $n2 = $conn->query("select * from mst_setting where id='2'")->fetch_array();
	  $n3 = $conn->query("select * from mst_setting where id='3'")->fetch_array();
	  $n4 = $conn->query("select * from mst_setting where id='4'")->fetch_array();
	  $n5 = $conn->query("select * from mst_setting where id='5'")->fetch_array();
	  $n6 = $conn->query("select * from mst_setting where id='6'")->fetch_array();
	  $n7 = $conn->query("select * from mst_setting where id='7'")->fetch_array();

	  $m = array($n1['keyword'] => $n1['set'], $n2['keyword'] => $n2['set'], $n3['keyword'] => $n3['set'], $n4['keyword'] => $n4['set'], $n5['keyword'] => $n5['set'], $n6['keyword'] => $n6['set'], $n7['keyword'] => $n7['set']);
	  $z= serialize($m);
	  
	  $conn->query("update setting set setting_value='$z' where setting_id='1'");
	  
	  echo "<script>window.alert('Konfigurasi Balas Otomatis Tersimpan...!')
    		window.location='autoreply.php?yRtwqO12&HtwpPy'</script>";
}

if (isset($_POST['reply_modem'])) {
$id=$_POST['id'];
$set=$_POST['set']; 
$keterangan=$_POST['keterangan']; 
$reply=$conn->query("UPDATE `mst_setting` SET `set`='$set',`keterangan`='$keterangan' WHERE id='$id'");

if ($reply==true) {
	  echo "<script>window.alert('Reply Modem Tersimpan...!')
    		window.location='autoreply.php?yRtwqO12&HtwpPy'</script>";
}
else {
	echo "<script>window.alert('Reply Modem Gagal Tersimpan...!')
    		window.location='autoreply.php?yRtwqO12&HtwpPy'</script>";
                 
}
}
?>