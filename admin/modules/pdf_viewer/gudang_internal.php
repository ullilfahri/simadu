<?php
include '../../../sysconfig.php';
$dir=$_GET['dir'];
$no_faktur=$_GET['no_faktur'];
$id_gudang=$_GET['id_gudang'];
$distributor=$_GET['distributor'];

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
        
<?php
$ambil_file=$conn->query("SELECT * from tabel_arsip where id_jenis=2 and no_faktur = '$no_faktur' and distributor = '$distributor' AND id_trx IN (select id_pengambilan from ambil_barang where id_gudang = '$id_gudang') ");
while ($x=$ambil_file->fetch_array()) :
?>


<div id="tutorial-pdf-responsive" class="custom1">
  <div class="custom2">
     <iframe src="http://<?=$_SERVER['HTTP_HOST']."/folder_upload/".$dir."/".$x['file']?>"></iframe>
  </div>
</div>
<?php endwhile;?>
    <!-- Jquery Core Js -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../../plugins/node-waves/waves.js"></script>
    
    
        
</body>
</html>
