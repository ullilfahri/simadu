<?php
$dev=$_GET['dev'];
$text1=substr($_GET['command1'], 0, -1);
$text2=$_GET['command2'];
$pagar="%23";
$text=$text1."*".$text2.$pagar;
header("location: bin/win/cek_pulsa.php?kirim=PpuhWQ2917&dev=$dev&command=$text");
?>