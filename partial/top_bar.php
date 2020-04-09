<?php
$pesan=$conn->query("SELECT * FROM `kirim_pesan` WHERE `tujuan`='".$_SESSION['id']."' AND is_read=0 ORDER BY tgl_kirim DESC LIMIT 5");
$jml_pesan = $conn->query("SELECT * FROM `kirim_pesan` WHERE `tujuan`='".$_SESSION['id']."' AND is_read=0")->num_rows;
?>    
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="../dashboard">SIMADU | Sistem Informasi & Manajemen Aplikasi terpaDU</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                           <i class="fa fa-bell fa-lg"></i>
                            <span class="label-count" id="jumlah_pesan"><?=$jml_pesan?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">PESAN</li>
                            <li class="body">
                                <ul class="menu">
								<?php 
								while ($x=$pesan->fetch_array()) :
								$pengirim=$conn->query("select nama from user where id = '".$x['pengirim']."'")->fetch_array();
								$isi_pesan=limit_words($x['isi_pesan'], 2).' ...';
								?>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                 <i class="fa fa-envelope fa-lg"></i>
                                            </div>
                                            <div class="menu-info">
                                                <h6><i class="glyphicon glyphicon-user"></i> <?=strtoupper($pengirim[0])?></h6>
                                                <p><i class="glyphicon glyphicon-envelope"></i>	<?=$isi_pesan?>
                                                    <br><i class="glyphicon glyphicon-time"></i> <?=time_since(strtotime($x['tgl_kirim']))?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
								<?php endwhile;?>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?=MDL.'dashboard/pesan.php'?>">Tampilkan Semua Pesan</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->                    <!-- Tasks -->
                    <!-- #END# Tasks -->
                </ul>
            </div>
        </div>
    </nav>
