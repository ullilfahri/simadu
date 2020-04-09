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
<?php //Header-->
include "../../partial/header.php";?>
<!--End Header-->

    <!-- Page Loader -->
    <?php include "../../partial/page_loader.php";?>
    <!-- #END# Page Loader -->
    
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <?php include "../../partial/top_bar.php";?>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
         <?php 
		 include "../../partial/left_siderbar.php";?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>
<?php
require "dir.php";
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
            <ol class="breadcrumb breadcrumb-bg-indigo">
            <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
            <li><a href="javascript:void(0);"><i class="material-icons">local_phone</i> Modem</a></li>
            <li class="active"><i class="material-icons">tablet_android</i> Cek Modem</li>
            </ol>
      
<!-- JUDUL -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                FITUR CEK MODEM
                            </h2>
                        </div>
                        <div class="body">
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               FITUR KIRIM USSD
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-horizontal" method="get" action="bin/win/cek.php">
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
                       </div>
                    </div>
                </div>
            </div>
            
                                <button type="submit" name="kirim" class="btn btn-block btn-lg btn-success waves-effect" 
                                data-type="with-custom-icon">
                                <i class="material-icons">send</i>
                                    <span>KIRIM</span></button>
                            </form>
            <!-- #END# Horizontal Layout -->
            <!-- #END# Horizontal Layout -->
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
    
    <!-- Bootstrap Notify Plugin Js -->
    <script src="../../plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/ui/dialogs.js"></script>

    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
</body>
</html>