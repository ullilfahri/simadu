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
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>SIMPADA | Sistem Informasi Manajemen PilkADA</title>

    <!-- Favicon-->
    <link rel="icon" href="../../../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="../../../../css/css.css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="../../../../css/icon.css?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../../../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../../../../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Colorpicker Css -->
    <link href="../../../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="../../../../plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="../../../../plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="../../../../plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="../../../../plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="../../../../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- noUISlider Css -->
    <link href="../../../../plugins/nouislider/nouislider.min.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../../../../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../../../../css/themes/all-themes.css" rel="stylesheet" />
</head>
<?php //Header-->
include "../../../../partial/simpada_kpu_db.php";?>
<!--End Header-->

    <!-- Page Loader -->
    <?php //include "../../../../partial/page_loader.php";?>
    <!-- #END# Page Loader -->
    
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <?php //include "../../../../partial/top_bar.php";?>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
         <?php 
		 //include "../../../../partial/left_siderbar.php";?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>
<?php
require "../../dir.php";
$path=$_SERVER['DOCUMENT_ROOT'];
function decode_string($str){
    //split the reply in chunks of 4 characters (each 4 character is hex encoded), use | as separator
    $str = str_replace(" ", "", $str); // remove normal space, you might have better ways of doing this
    $chunk = chunk_split($str, 4, '|');
    $coded_array = explode('|', $chunk);
    $n = count($coded_array);
    $decoded = '';
    for($i = 0; $i < $n; $i++){
        $decoded .= chr(hexdec($coded_array[$i]));
    }
    return $decoded;
}
?>
<!--JUDUL-->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>FITUR KIRIM USSD</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                FITUR KIRIM USSD
                            </h2>
                        </div>
                        <div class="body">
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               FITUR KIRIM USSD<?php echo SB;?>
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-horizontal" method="get" action="">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>PILIH MODEM</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="dev" class="form-control" required>
                                                <option value="">==PILIH MODEM==</option>
                                                <option value="0">MODEM # 1</option>
                                                <option value="1">MODEM # 2</option>
                                                <option value="2">MODEM # 3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>KODE USSD</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="command" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       </div>
                    </div>
                </div>
            </div>
                                <button type="submit" name="kirim" class="btn btn-block btn-lg btn-success waves-effect">
                                <i class="material-icons">send</i>
                                    <span>KIRIM</span></button>
                            </form>
            <!-- #END# Horizontal Layout -->
       
            <!-- HASILNYA -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="card">
                   <div class="body">
<?php
    if (isset($_GET['kirim'])) { ?>

<p>
<div class="alert alert-success alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
</button>
<?php
	
	
// jalankan perintah cek pulsa via gammu
exec(SB.'bin\win\gammu '.$_GET['dev'].' getussd '.trim($_GET['command']), $hasil);
 
// proses filter hasil output
for ($i=0; $i<=count($hasil)-1; $i++)
{
   if (substr_count($hasil[$i], 'Service reply') > 0) $index = $i;
}
 
// menampilkan sisa pulsa
$tampil= $hasil[$index];
if (preg_match('/Service reply/',$tampil)) {$kata=$tampil;} else {$kata="Kode USSD ".$_GET['command']." sedang error..! <a href='javascript:location.reload(true)'><button class='btn btn-success'>Kirim Ulang</button></a>";}
if (strlen($kata)>300) {
	$pecah = explode('"',$tampil);
	$kalimat=decode_string($pecah[1]);
	echo '<div id="tampil_modal">
    <div id="modal">
      <div id="modal_atas">Informasi</div>
      <pre>'.$kalimat.'</pre>
	  <form class="form-horizontal form-label-left input_mask" method="get" action="../../output.php" autocomplete="off">
	  <input type="hidden" name="dev" value='.$_GET['dev'].'>
	  <input type="hidden" name="command1" value='.$_GET['command'].'>
	  <input type="text" name="command2" class="form-control has-feedback-left" placeholder="Masukan Balasan" required>
	  <button type="submit"  class="btn btn-info">Kirim</button>
	  </form>
	  <a href="../../kode_ussd.php?bLdeWt&CmRwxxS"><button class="btn btn-success">Batal</button></a>
    </div></div>';
	
	} else {
	
	echo '<div id="tampil_modal">
    <div id="modal">
      <div id="modal_atas">Informasi</div>
      <pre>'.$kata.'</pre>
	  <form class="form-horizontal form-label-left input_mask" method="get" action="../../tampil.php" autocomplete="off">
	  <input type="hidden" name="dev" value='.$_GET['dev'].'>
	  <input type="hidden" name="command1" value='.$_GET['command'].'>
	  <input type="text" name="command2" class="form-control has-feedback-left" placeholder="Masukan Balasan" required>
	  <button type="submit"  class="btn btn-info">Kirim</button>
	  </form>
	  <a href="../../kode_ussd.php?bLdeWt&CmRwxxS"><button class="btn btn-success">Batal</button></a>
    </div></div>';
	}
}
?>
            <!-- #END# Horizontal Layout -->
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- Jquery Core Js -->
    <script src="../../../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../../../../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../../../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../../../plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="../../../../js/admin.js"></script>

    <!-- Demo Js -->
    <script src="../../../../js/demo.js"></script>
</body>
</html>