<?php include "../../../../partial/sinden_db.php";
require "../../dir.php";
$path=$_SERVER['DOCUMENT_ROOT'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MODEM | SIMPADA</title>

    <!-- Bootstrap -->
    <link href="../../../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../../../../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../../../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../../../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../../../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../../../../vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../../../../build/css/custom.min.css" rel="stylesheet">
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

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="../../../../../simpada" class="site_title"><i class="fa fa-paw"></i> <span>SIMPADA!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
<?php include "../../../../partial/sidebar2.php";?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
<?php include "../../../../partial/menu_footer.php";?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
<?php //include "../../../../partial/top_navigasi.php";?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            </div>
<!---Tambah Saksi-->
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>CEK KETERSEDIAAN MODEM </small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="">
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">PILIH MODEM<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="modem" class="form-control col-md-7 col-xs-12" required>
                          <option value="">--PILIH MODEM--</option>
                          <option value="0">MODEM #1</option>
                          <option value="1">MODEM #2</option>
                          <option value="2">MODEM #3</option>
                          </select>
                        </div>
                      </div>
                    
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-info" name="kirim">KIRIM</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
<!---end Tambah Saksi-->
<?php
    if (isset($_POST['kirim'])) { ?>
<p><div class="alert alert-success alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
</button>
<?php
	unlink("identify.bat");
	$run = @fopen("identify.bat", "w");
	$string = "gammu ".$_POST['modem']." identify";
	fwrite($run, $string);
	fclose($run);
	passthru(SB.'bin\win\identify.bat');
?>			
</p>
</div>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
<strong>PERHATIAN...!</strong> Jika Keterangan muncul  berupa informasi Device, Manufacturer, Model, Firmware, IMEI & SIM IMSI, Cek Modem Sukses. Jika yang muncul adalah "Error opening device, it doesn't exist.", artinya, Modem Tidak Tersedia.
</div>
<?php
}
?>		
		
			
        <!-- /page content -->

        <!-- footer content -->
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../../../../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../../../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../../../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../../../../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../../../../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../../../../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../../../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../../../../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../../../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../../../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../../../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../../../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../../../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../../../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../../../../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../../../../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../../../../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../../../../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- starrr -->
    <script src="../../../../vendors/starrr/dist/starrr.js"></script>
    <!-- jquery.inputmask -->
    <script src="../../../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../../../../build/js/custom.min.js"></script>
  </body>
</html>