<!DOCTYPE html>
<html>
<head>
	<title>SIMPADA</title>
    <!-- Custom Css -->
    <link href="style.css" rel="stylesheet">
    <!-- Bootstrap Core Css -->
    <link href="../../../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../../../../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../../../../css/style.css" rel="stylesheet">
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
	<!--<center>		
		<h1>INFORMASI MODEM</h1>	
	</center>
	<!--<div class="loader">Loading..</div>

	<div class="loader2">Loading..</div>

	<!--<div class="loader3">Loading..</div>-->
<?php
	require "../../dir.php";
	/*$kata=exec(SB.'bin\win\gammu '.$_GET['dev'].' identify'); 
	echo '<div id="tampil_modal">
    <div id="modal">
      <div id="modal_atas">Informasi USSD</div>
      <pre>'.$kata.'</pre>
	  <a href="../../cek_modem.php?AmdCPp&CmRwxxS"><button class="btn btn-success">Oke</button></a>
    </div></div>';*/
	/*unlink("identify.bat");
	$run = @fopen("identify.bat", "w");
	$string = "gammu ".$_GET['dev']." identify";
	fwrite($run, $string);
	fclose($run);*/
	

	
?>
<div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="defaultModalLabel">INFORMASI MODEM</h4>
         </div>
           <div class="modal-body">
             <pre><?php passthru(SB.'bin/win/gammu '.$_GET['dev'].' identify');?></pre>
            </div>
            <div class="modal-footer">
            <a href="../../cek_modem.php?AmdCPp&CmRwxxS"><button class="btn btn-success">TUTUP</button></a>
            </div>
          </div>
        </div>
</body>
</html>