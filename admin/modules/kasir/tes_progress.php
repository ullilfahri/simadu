<?php
$input=$_GET['input'];
$file='print/'.$input.'.pdf';

if (!file_exists($file)) {
echo 'Harap tunggu sejenak, sedang menyiapkan file<br>';
echo '<img src="loader.gif"></img><br>';
echo '<iframe src="print/1542440510a.pdf"></iframe>';
exit();
} else {
echo '<iframe src="'.$file.'"></iframe>';
}

?>

