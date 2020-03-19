<?php
include '../../../sysconfig.php';

if (isset($_GET['reset_login'])) :
$id=$_GET['modal_id'];
//echo $id;

$conn->query("UPDATE user set limit_sesi=0 where id='$id'");

        echo "<script>window.alert('User Reset..!') 
		window.location='../reset_login/'</script>";


endif;



?>