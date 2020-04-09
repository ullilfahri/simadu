<?php //Header-->
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] > 1) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
	endif; 
?>	
<!--End Header-->

<?php include DOT.'partial/theme.php';?>
    <!-- Page Loader -->
<?php include DOT.'partial/preloader.php';?>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
<?php include DOT.'partial/overlay.php';?>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
<?php include DOT.'partial/top_bar.php';?>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
<?php include DOT.'partial/left_sidebar.php';

?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>
<?php
	$path=SB."bin/win/";

//GET SETTING VALUE
			$handle = @fopen($path."smsdrc", "r");
			$handle2 = @fopen($path."smsdrc2", "r");
			$handle3 = @fopen($path."smsdrc3", "r");
			if ($handle) 
			{
				while (!feof($handle)) 
				{
					$buffer = fgets($handle);
					if (substr_count($buffer, 'port = ') > 0)
					{
						$split = explode("port = ", $buffer);
						$setting['port'] = trim($split[1]);
					}
					if (substr_count($buffer, 'connection = ') > 0)
					{
						$split = explode("connection = ", $buffer);
						$setting['conn'] = trim($split[1]);
					}
				}
			
			}
			
			else{
    echo "<script>window.alert('File Konfigurasi Modem #1 Tidak Diketemukan...!')</script>";
 
			}
			
			 if ($handle2) 
			{
				while (!feof($handle2)) 
				{
					$buffer2 = fgets($handle2);
					if (substr_count($buffer2, 'port = ') > 0)
					{
						$split2 = explode("port = ", $buffer2);
						$setting2['port'] = trim($split2[1]);
					}
					if (substr_count($buffer2, 'connection = ') > 0)
					{
						$split2 = explode("connection = ", $buffer2);
						$setting2['conn'] = trim($split2[1]);
					}
				}
			}
			
			else{
    echo "<script>window.alert('File Konfigurasi Modem #2 Tidak Diketemukan...!')</script>";
 
			}

			 if ($handle3) 
			{
				while (!feof($handle3)) 
				{
					$buffer3 = fgets($handle3);
					if (substr_count($buffer3, 'port = ') > 0)
					{
						$split3 = explode("port = ", $buffer3);
						$setting3['port'] = trim($split3[1]);
					}
					if (substr_count($buffer3, 'connection = ') > 0)
					{
						$split3 = explode("connection = ", $buffer3);
						$setting3['conn'] = trim($split3[1]);
					}
				}
			}
			
			else{
    echo "<script>window.alert('File Konfigurasi Modem #3 Tidak Diketemukan...!')</script>";
 
			}
			
if (isset($_POST['updateData'])) {
//MODEM 1	
 @unlink($path."smsdrc"); 
 $file2 = $path.'smsdrc'; 
 $smsdrc2 = fopen($file2 , 'w') or die('error reading '.$file2 ); 
 $content = "[gammu]"."\n";
 $content.= "port = com".trim($_POST['port'])."\n";
 $content.= "connection = ".trim($_POST['conn'])."\n";
 $content.= "[smsd]"."\n";
 $content.= "service = SQL"."\n";
 $content.= "Driver = native_mysql"."\n";
 $content.= "logfile = ".$dir.$path."logsmsdrc"."\n";
 $content.= "debuglevel = 1"."\n";
 $content.= "phoneid = Modem_1"."\n";
 $content.= "commtimeout = 15"."\n";
 $content.= "sendtimeout = 30"."\n";
 $content.= "ReceiveFrequency = 15"."\n";
 $content.= "send = yes"."\n";
 $content.= "receive = yes"."\n";
 $content.= "checksecurity = 0"."\n";
 $content.= "RunOnReceive = ".$dir.$path."daemon.bat\n";
 $content.= "pc = localhost"."\n";
 $content.= "user = root"."\n";
 $content.= "password = siako"."\n";
 $content.= "database = siako"."\n";

fwrite($smsdrc2, $content); 
fclose($smsdrc2);

//MODEM 2
 @unlink($path."smsdrc2"); 
 $file2_b = $path.'smsdrc2'; 
 $smsdrc2_b = fopen($file2_b , 'w') or die('error reading '.$file2_b ); 
 $content_b = "[gammu]"."\n";
 $content_b.= "port = com".trim($_POST['port2'])."\n";
 $content_b.= "connection = ".trim($_POST['conn2'])."\n";
 $content_b.= "[smsd]"."\n";
 $content_b.= "service = SQL"."\n";
 $content_b.= "Driver = native_mysql"."\n";
 $content_b.= "logfile = ".$dir.$path."logsmsdrc2"."\n";
 $content_b.= "debuglevel = 1"."\n";
 $content_b.= "phoneid = Modem_2"."\n";
 $content_b.= "commtimeout = 15"."\n";
 $content_b.= "sendtimeout = 30"."\n";
 $content_b.= "ReceiveFrequency = 15"."\n";
 $content_b.= "send = yes"."\n";
 $content_b.= "receive = yes"."\n";
 $content_b.= "checksecurity = 0"."\n";
 $content_b.= "RunOnReceive = ".$dir.$path."daemon.bat\n";
 $content_b.= "pc = localhost"."\n";
 $content_b.= "user = root"."\n";
 $content_b.= "password = siako"."\n";
 $content_b.= "database = siako"."\n";

 fwrite($smsdrc2_b, $content_b); 
 fclose($smsdrc2_b);

//MODEM 3
 @unlink($path."smsdrc3"); 
 $file2_c = $path.'smsdrc3'; 
 $smsdrc2_c = fopen($file2_c , 'w') or die('error reading '.$file2_c ); 
 $content_c = "[gammu]"."\n";
 $content_c.= "port = com".trim($_POST['port3'])."\n";
 $content_c.= "connection = ".trim($_POST['conn3'])."\n";
 $content_c.= "[smsd]"."\n";
 $content_c.= "service = SQL"."\n";
 $content_c.= "Driver = native_mysql"."\n";
 $content_c.= "logfile = ".$dir.$path."logsmsdrc3"."\n";
 $content_c.= "debuglevel = 1"."\n";
 $content_c.= "phoneid = Modem_3"."\n";
 $content_c.= "commtimeout = 15"."\n";
 $content_c.= "sendtimeout = 30"."\n";
 $content_c.= "ReceiveFrequency = 15"."\n";
 $content_c.= "send = yes"."\n";
 $content_c.= "receive = yes"."\n";
 $content_c.= "checksecurity = 0"."\n";
 $content_c.= "RunOnReceive = ".$dir.$path."daemon.bat\n";
 $content_c.= "pc = localhost"."\n";
 $content_c.= "user = root"."\n";
 $content_c.= "password = siako"."\n";
 $content_c.= "database = siako"."\n";

fwrite($smsdrc2_c, $content_c); 
fclose($smsdrc2_c);


@unlink($path."gammurc");
$gammurc = @fopen($path."gammurc", "w");
$string = "[gammu]\nport = com".trim($_POST['port'])."\nconnection = ".trim($_POST['conn'])."\n"
		 ."[gammu1]\nport = com".trim($_POST['port2'])."\nconnection = ".trim($_POST['conn2'])."\n"
		 ."[gammu2]\nport = com".trim($_POST['port3'])."\nconnection = ".trim($_POST['conn3'])."\n"
		 ."[gammu3]\nport = com".trim($_POST['port']+1)."\nconnection = ".trim($_POST['conn'])."\n"
		 ."[gammu4]\nport = com".trim($_POST['port2']+1)."\nconnection = ".trim($_POST['conn2'])."\n"
		 ."[gammu5]\nport = com".trim($_POST['port3']+1)."\nconnection = ".trim($_POST['conn3'])."\n";
fwrite($gammurc, $string);
fclose($gammurc);

@unlink($path."daemon.bat");
$dir_php=realpath($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . '..').DS;
$daemon = @fopen($path."daemon.bat", "w");
$bat 	= ":: Configure this (use absolute path)\n:: php cli path\nset PHP=".$dir_php."php/php.exe\n:: daemon.php path"
		 ."\nset DAEMON=".SB."daemon.php\n:: Execute"
		 ."\n%PHP% %DAEMON%";
fwrite($daemon, $bat);
fclose($daemon);


echo "<script>window.alert('Setting Modem Tersimpan...!')
    		window.location='set_modem.php'</script>";

}

?>
<!--JUDUL-->
    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-phone fa-lg"></i> SMS Gateway</a></li>
            </ol>
      
<!-- JUDUL -->
             <!-- Tabs With Only Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SETTING MODEM
                            </h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#umum" data-toggle="tab">
                                        <i class="fa fa-phone fa-1.5x"></i> Setting Umum
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#analisa" data-toggle="tab">
                                        <i class="fa fa-search fa-1.5x"></i> Setting Respon
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="umum">
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               MODEM # 1
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-horizontal" method="post" action="" autocomplete="off">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>PORT</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" name="port" class="form-control" value="<?php echo substr($setting['port'],3,3);?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>CONNECTION</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="conn" class="form-control" value="<?php echo $setting['conn'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               MODEM # 2
                            </h2>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>PORT</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" name="port2" class="form-control" value="<?php echo substr($setting2['port'],3,3);?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>CONNECTION</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <input type="text" name="conn2" class="form-control" value="<?php echo $setting2['conn'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               MODEM # 3
                            </h2>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>PORT</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" name="port3" class="form-control" value="<?php echo substr($setting3['port'],3,3);?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>CONNECTION</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="conn3" class="form-control" value="<?php echo $setting3['conn'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       </div>
                    </div>
                </div>
            </div>
                                <button type="submit" name="updateData" class="btn btn-block btn-lg btn-success waves-effect">
                               	<i class="fa fa-save fa-2x"></i>
                                    <span>UPDATE DATA</span></button>
                            </form>
            <!-- #END# Horizontal Layout -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="analisa">
            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                        <?php
                        $sa=$conn->query("select * from mst_modem where id='1'")->fetch_array();
						if ($sa['set']==1) {$aktif='On';} else {$aktif='Off';}
						?>
                            <form class="form-horizontal" method="post" action="form_crud.php" autocomplete="off">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label><?=$sa['keyword']?></label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                                <div class="switch">
                                    			<label>OFF<input type="checkbox" name="set" <?php if ($sa['set']=='1'):?>  value="1" checked<?php endif;?>><span class="lever"></span>ON</label>
                                            	</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                <?php
                                $sb=$conn->query("SHOW VARIABLES like 'event_scheduler'")->fetch_array();
								?>
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label>Pengingat Jatuh Tempo</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                                <!--<select class='form-control show-tick' name='value' required>
                                                <option value='<?=$sb['Value']?>'><?=$sb['Value']?></option>
                                                <option value='ON'>ON</option>
                                                <option value='OFF'>OFF</option>
                                                </select>-->
                                                <div class="switch">
                                    			<label>OFF<input type="checkbox" name="value" <?php if ($sb['Value']=='ON'):?>  value="ON" checked<?php endif;?>><span class="lever"></span>ON</label>
                                            	</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                     <button type="submit" name="update_notifikasi" class="btn btn-lg btn-warning waves-effect"><i class="fa fa-save fa-2x"></i><span>UPDATE</span></button>
                                    </div>
                                </div> 
                            </form>
                       </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->
            
            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Only Icon Title -->
        </div>
    </section>
    <!-- Jquery Core Js -->
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?=PLG?>bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>

    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
</body>
</html>