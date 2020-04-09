<?php
$dir=$_GET['dir'];
$file=$_GET['file'];

if (isset($_GET['penjualan'])) {
$tombol='<div class="button-place btn-blue"><a href="../kasir/index.php?Jnjhg" class="btn btn-default btn-lg waves-effect">Kembali Ke Penjualan</a></div>';

} else if (isset($_GET['pengambilan'])) {
$tombol='<div class="button-place btn-blue"><a href="../gudang/ambil_barang.php?WffEFGHH" class="btn btn-default btn-lg waves-effect">Kembali Ke Form Pengambilan Barang</a></div>';

} else if (isset($_GET['retur_barang'])) {
$tombol='<div class="button-place btn-blue"><a href="../transfer_retur/" class="btn btn-default btn-lg waves-effect">Kembali Ke Form Retur Barang</a></div>';

} else if (isset($_GET['transfer_barang'])) {
$tombol='<div class="button-place btn-blue"><a href="../transfer_retur/summary_data.php?data=data_retur" class="btn btn-default btn-lg waves-effect">Kembali Ke Summary Transfer Barang</a></div>';

} else {
$tombol='';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pdf Reader</title>
    <style>
.custom1 {
   margin-left: auto !important;
   margin-right: auto !important;
   margin: 20px;
   padding: 20px;
}
.custom2 {
  position: relative;
  height: 0;
  overflow: hidden;
  padding-bottom: 90%;
}
.custom2 iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
}
#tutorial-pdf-responsive {
  max-width: 900px;
  max-height: 700px;
  overflow: hidden;
}

.tombol {
   padding: 20px 30px;
   background: #ff3e3e;
   display: table;
}
</style>

    <!-- Bootstrap Core Css -->
    <link href="../../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../../../css/style.css" rel="stylesheet">
    
   <script src="pdfobject.min.js"></script>
</head>
<body class="five-zero-zero">
    <div class="five-zero-zero-container">
        <?=$tombol?>
    </div>
        

<?php if (isset($_GET['no_faktur'])) {
$file1=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'-TSNB.PDF';
$file2=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'-SRYA.PDF';
$file3=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'-INDV.PDF';
?>

<?php if (file_exists($file1)) : ?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'-TSNB.PDF'?>"></iframe>
  </div>
</div>
<?php endif; ?>

<?php if (file_exists($file2)) : ?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'-SRYA.PDF'?>"></iframe>
  </div>
</div>
<?php endif; ?>

<?php if (file_exists($file3)) : ?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/no_faktur/".$_GET['no_faktur'].'-INDV.PDF'?>"></iframe>
  </div>
</div>
<?php endif; ?>

<?php } else if (isset($_GET['id_pengambilan'])) {

$file1=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$_GET['id_pengambilan'].'-TSNB.PDF';
$file2=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$_GET['id_pengambilan'].'-SRYA.PDF';
$file3=$_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$_GET['id_pengambilan'].'-INDV.PDF';
?>

<?php if (file_exists($file1)) : ?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/surat_jalan/".$_GET['id_pengambilan'].'-TSNB.PDF'?>"></iframe>
  </div>
</div>
<?php endif; ?>

<?php if (file_exists($file2)) : ?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/surat_jalan/".$_GET['id_pengambilan'].'-SRYA.PDF'?>"></iframe>
  </div>
</div>
<?php endif; ?>

<?php if (file_exists($file3)) : ?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/surat_jalan/".$_GET['id_pengambilan'].'-INDV.PDF'?>"></iframe>
  </div>
</div>
<?php endif; ?>




<?php } else {?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/".$dir."/".$_GET['file']?>"></iframe>
  </div>
</div>
<?php } ?>

<?php
if (isset($_GET['file_ambil'])) :
?>
<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/file_cetak/bukti_ambil/".$_GET['file_ambil']?>"></iframe>
  </div>
</div>
<?php endif;?>


    <!-- Jquery Core Js -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../../plugins/node-waves/waves.js"></script>
    
    
        
</body>
</html>
