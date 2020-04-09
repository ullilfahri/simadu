<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="30;" />
<title>SIMPADA | LOG MODEM</title>
</head>

<body>
<?php

require "../../dir.php";
$lines = file($_GET['modem']);
foreach ($lines as $line_num => $line){
	print "<font color=red>SIMPADA #{$line_num}</font> : " . $line . "<br />\n"; 
}
?>

</body>
</html>
