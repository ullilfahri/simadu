<?php
include '../../../sysconfig.php';
$id=$_POST['id'];

$query=$conn->query("delete from pembelian_sementara where id='$id'");
if ($query){
	echo json_encode(array('status' =>true));
}
else
{
	echo json_encode(array('status' =>false));
}
?>