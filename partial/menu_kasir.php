					<?php if (preg_match("/YMLjhyt/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-cart-arrow-down fa-2x"></i>
                            <span>PENJUALAN</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/Jnjhg/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/index.php?Jnjhg=YMLjhyt">Penjualan</a>
                            </li>
                            <?php if (preg_match("/transaksi/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/transaksi.php?hari_ini">Summary Penjualan</a>
                            </li>
                            <?php if (preg_match("/summary_pembatalan/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/summary_pembatalan.php?hari_ini">Summary Pembatalan Transaksi</a>
                            </li>
                        </ul>
                    </li> 
                    
                    
					<?php if (preg_match("/hutang_piutang/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-balance-scale fa-2x"></i>
                            <span>ACCOUNTING</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/menu_kasir/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/menu_kasir.php?hari_ini">Summary Transaksi Hari Ini</a>
                            </li>
                            <?php if (preg_match("/LmngTGVf/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/piutang.php?LmngTGVf">Piutang</a>
                            </li>
                            <?php if (preg_match("/fitur_pencarian/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/fitur_pencarian.php">Fitur Cari Data Transaksi</a>
                            </li>
                            <?php if (preg_match("/jatuh_tempo/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/jatuh_tempo.php">Jatuh Tempo Piutang</a>
                            </li>
                        </ul>
                    </li> 
                    
                            
                            
<?php if ($_SESSION['sub_level'] == 4) :?>      

                    <li class="header">ADMINISTRASI TOKO</li>
                        <a href="javascript:void(0);">
                        </a>
                    </li>
                    
					<?php if (preg_match("/transfer_retur/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-recycle fa-2x"></i>
                            <span>RETUR BARANG</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/JmnJUHS/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../transfer_retur/index.php?JmnJUHS">
                                            <span>Entry Retur Barang</span>
                                        </a>
                                    </li>
                                    <li>
                                    <?php if (preg_match("/data_retur/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                        <a href="../transfer_retur/summary_data.php?data=data_retur">
                                            <span>Summary Retur/Transfer Barang</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    
					<?php if (preg_match("/ungh_dokumen/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-edit fa-2x"></i>
                            <span>ARSIP TOKO</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/ungh_dokumen/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/unggah_dokumen.php?hari_ini&ungh_dokumen">
                                            <span>Unggah Dokumen</span>
                                        </a>
                                    </li>
<?php if ($_SESSION['sub_level'] == 4) :?>      
                            <?php if (preg_match("/file_transfer/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/file_transfer.php?menu&uri=hari_ini">
                                            <span>Dokumen Retur Barang</span>
                                        </a>
                                    </li>
<?php endif;?>                                    
                                </ul>
                            </li>
                            
					<?php if (preg_match("/gudang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-folder-open fa-2x"></i>
                            <span>ARSIP GUDANG</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/gudang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/unggah_dokumen.php?menu&uri=hari_ini">
                                            <span>Dokumen Surat Jalan</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    
                    
					<?php if (preg_match("/konfirmasi_bank/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="../kasir/konfirmasi_bank.php">
                            <i class="fa fa-university fa-2x"></i>
                            <span>KONFIRMASI TRANSFER BANK</span>
                        </a>
                    </li>
                    
					<?php if (preg_match("/reset_login/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="../reset_login/">
                            <i class="fa fa-sign-out fa-2x"></i>
                            <span>RESET LOGIN</span>
                        </a>
                    </li>
                    
<?php endif;?>                    

                    <li class="header">REPORT</li>
                    <?php if (preg_match("/report/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-area-chart fa-2x"></i>
                            <span>LAPORAN</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/laporan_harga/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_harga.php">Laporan Perubahan Harga</a>
                            </li>
                            <?php if (preg_match("/laporan_kasir/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_kasir.php">Laporan Transaksi Hari Ini</a>
                            </li>
 <?php if ($_SESSION['sub_level']==4) : ?>                           
                            <?php if (preg_match("/laporan_penjualan/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_penjualan.php?JMJggj">Laporan Penjualan Hari Ini</a>
                            </li>
                            <?php if (preg_match("/laporan_keluar/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_keluar.php?hari_ini">Laporan Transaksi Menurut Pengeluaran Barang Hari Ini</a>
                            </li>
                            <?php if (preg_match("/laporan_transaksi_kasir/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_transaksi_kasir.php">Laporan Transaksi Per Kasir</a>
                            </li>
                            <?php if (preg_match("/laporan_piutang_kasir/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_piutang_kasir.php">Laporan Piutang</a>
                            </li>
 <?php endif; ?>                           
                        </ul>
                    </li> 

