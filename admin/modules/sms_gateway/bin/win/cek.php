<?php
if (isset($_GET['kirim'])) {
$dev=$_GET['dev'];
//header ("location: eksekusi.php?dev=$dev&command=$command"); ?>


<!DOCTYPE html>
<html>
<head>
	<title>SIMPADA</title>
    <!-- Custom Css -->
    <link href="style.css" rel="stylesheet">
    <meta http-equiv="refresh" content="1; url=identify.php?kirim&dev=<?php echo $dev?>">
<style type="text/css">
  #tampil_modal {
    padding-top: 10em;
    background-color: rgba(0,0,0,0.8);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10;
    display: block;
  }
  #modal{
    padding: 15px;
    font-size: 16px;
    background: #e74c3c;
    color: #fff;
    width: 480px;
    border-radius: 15px;
    margin: 0 auto;
    margin-bottom: 20px;
    padding-bottom: 50px;
    z-index: 9;
  }
  #modal_atas{
    width: 100%;
    background:#c0392b;
    padding: 15px;
    margin-left: -15px;
    font-size: 18px;
    margin-top: -15px;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
  }
  #oke {
    background:#c0392b;
    border:none;
    float:right;
    width:80px;
    height:auto;
    color: #fff;
    margin-right: 5px;
    cursor: pointer;
  }
</style>

</head>
<body>
	<center>		
		<h1>Mohon Tunggu Sejenak Sedang Menyiapkan File....!!!</h1><br>
	</center>
	<div class="loader">Loading..</div>		

	<div class="loader2">Loading..</div>

	<div class="loader3">Loading..</div>


<?php }
?>
</body>
</html>

