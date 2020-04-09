        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                	<?php if (empty($_SESSION['img'])) {?>
                    <img src="<?=DOT?>images/user.png" width="48" height="48" alt="User" />
                    <?php } else {?>
                    <img src="<?=MDL.'dashboard/images/'.$_SESSION['img']?>" width="48" height="48" alt="User" />
                    <?php }?>
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$_SESSION['adminUsername']?></div>
                    <div class="email"><?=$_SESSION['nama']?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="fa fa-arrow-down" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>
                        <ul class="dropdown-menu pull-right">
                        	<li><a href="<?=MDL.'dashboard/profil.php'?>"><i class="fa fa-user"></i> Profil</a></li>
                        	<li role="separator" class="divider"></li>
                        	<li><a href="<?=MDL.'dashboard/setting.php'?>"><i class="fa fa-wrench"></i> Setting</a></li>
                        	<li role="separator" class="divider"></li>
                        	<li><a href="<?=MDL.'dashboard/customer.php'?>"><i class="fa fa-users"></i> Customer</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=MDL.'dashboard/pesan.php'?>"><i class="fa fa-envelope"></i> Pesan</a></li>
                        	<li role="separator" class="divider"></li>
                            <li><a href="<?=MDL.'login/logout.php'?>"><i class="fa fa-sign-out"></i> Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
					<?php if (preg_match("/dashboard/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="../dashboard">
                            <i class="fa fa-home fa-2x"></i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
<?php 
if ($_SESSION['level']==1 || $_SESSION['level']==2) {
	include PRT.'menu_utama.php';
	} else if ($_SESSION['level']==3) {
	include PRT.'menu_kasir.php';
	} else if ($_SESSION['level']==4) {
	include PRT.'menu_gudang.php';
	} else if ($_SESSION['level']==6) {
	include PRT.'menu_supervisor.php';
	} else {
	include PRT.'menu_pajak.php';
}	
?>            
                    <li class="header">UTILITY</li>
                    <?php if (preg_match("/changelogs/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="../changelogs/">
                            <i class="fa fa-hourglass-half fa-2x"></i>
                            <span>Changelogs</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2018 <a href="javascript:void(0);">SIMADU</a>, &reg; <a href="javascript:void(0);">Sinar Group Ketapang</a>
                </div>
                <div class="version">
                    <b>Version: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>

