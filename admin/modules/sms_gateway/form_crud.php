<?php
include '../../../sysconfig.php';

if (isset($_POST['update_notifikasi'])) :

if (!empty($_POST['value'])) {
$conn->query("SET GLOBAL event_scheduler='ON'");

} else {
$conn->query("SET GLOBAL event_scheduler='OFF'");
}

if (!empty($_POST['set'])) {
$conn->query("update mst_modem set `set`='1' where id='1'");
} else {
$conn->query("update mst_modem set `set`='0' where id='1'");
}




echo "<script>window.alert('Setting Modem Tersimpan...!')
    		window.location='set_modem.php'</script>";

endif;


?>