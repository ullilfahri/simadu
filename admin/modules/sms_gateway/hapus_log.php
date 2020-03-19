<?php
require "dir.php";
if (isset($_GET['status'])) {
$log1 = SB.'bin/win/'.$_GET['modal_id'];
$status=$_GET['status'];
$handle = fopen($log1, 'w') or die('Cannot open file:  '.$log1);
$data = '<center><h4>SIMPADA SMS AUTOMATION SYSTEM</h4></center>';
fwrite($handle, $data);
	echo "<script>window.alert('LOG Terhapus')
    		window.location='index.php?$status=CrnW6qwI'</script>";
	
}

if (isset($_GET['log_modem'])) {
$log1 = SB.'bin/win/'.$_GET['modal_id'];
$alamat=$_GET['log_modem'];
$handle = fopen($log1, 'w') or die('Cannot open file:  '.$log1);
$data = '<center><h4>SIMPADA SMS AUTOMATION SYSTEM</h4></center>';
fwrite($handle, $data);
	echo "<script>window.alert('LOG Terhapus')
    		window.location='$alamat.php?LogR43&CmRwxxS'</script>";
	
}


?>