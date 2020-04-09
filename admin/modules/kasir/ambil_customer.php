<?php

include '../../../sysconfig.php';
$sql = $conn->query("SELECT * FROM tabel_customer WHERE nama LIKE '%".$_GET['query']."%' LIMIT 10"); 

$json = [];

while($row = $sql->fetch_array()){
      $json[] = $row['nama'];
 }

 echo json_encode($json);



?>