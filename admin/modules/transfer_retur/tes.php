<?php
if (isset($_POST['cetak'])) :

if (!empty($_POST['biaya_administrasi'])) : echo $_POST['biaya_administrasi'].'<br>'; endif;
if (!empty($_POST['biaya_kembali'])) : echo $_POST['biaya_kembali'].'<br>'; endif;
echo $_POST['id_trx'].'<br>';
echo $_POST['tabel_biaya_administrasi'].'<br>';
echo $_POST['tabel_biaya_kembali'].'<br>';
endif;
?>