            <!-- Menu -->
<?php if ($_SESSION['level'] <= 2) : ?>                    
					<?php if (preg_match("/lokasi/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="../lokasi">
                            <i class="fa fa-map fa-2x"></i>
                            <span>LOKASI</span>
                        </a>
                    </li>
<?php endif;?>
<?php if ($_SESSION['level'] <= 2 || $_SESSION['level'] == 3) : ?>                    
					<?php if (preg_match("/kasir/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-money fa-2x"></i>
                            <span>KASIR</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/Jnjhg/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/index.php?Jnjhg">Penjualan</a>
                            </li>
                            <?php if (preg_match("/transaksi/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/transaksi.php">Catatan Transaksi</a>
                            </li>
                            <?php if (preg_match("/surat_jalan/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/surat_jalan.php">Cetak Surat Jalan</a>
                            </li>

                            <li>
                            <?php if (preg_match("/unggah_dokumen/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Arsip Toko</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                    <?php if (preg_match("/ungh_dokumen/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                        <a href="../kasir/unggah_dokumen.php?ungh_dokumen">
                                            <span>Unggah Dokumen</span>
                                        </a>
                                    </li>
                                    <li>
                                    <?php if (preg_match("/fktr_penjualan/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                        <a href="../kasir/unggah_dokumen.php?tampil_arsip=fktr_penjualan">
                                            <span>Faktur Penjualan</span>
                                        </a>
                                    </li>
                                    <li>
                                    <?php if (preg_match("/srt_jalan/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                        <a href="../kasir/unggah_dokumen.php?tampil_arsip=srt_jalan">
                                            <span>Surat Jalan</span>
                                        </a>
                                    </li>
                                    <?php if (preg_match("/bkt_ambil/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                        <a href="../kasir/unggah_dokumen.php?tampil_arsip=bkt_ambil">
                                            <span>Bukti Pengambilan</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <?php if (preg_match("/konfirmasi_bank/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/konfirmasi_bank.php">Konfirmasi Transfer Bank</a>
                            </li>
                                                                
                        </ul>
                    </li> 

<?php endif;?>
<?php if ($_SESSION['level'] <= 2) : ?>                    

					<?php if (preg_match("/stok/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-edit fa-2x"></i>
                            <span>MANAJEMEN STOK</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/OKhghh/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../stok/index.php?OKhghh">Entry Pembelian</a>
                            </li>
                            <?php if (preg_match("/data_stok/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../stok/data_stok.php">Data Stok</a>
                            </li>
                            <?php if (preg_match("/catatan_pembelian/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../stok/catatan_pembelian.php">Catatan Pembelian</a>
                            </li>
                            <?php if (preg_match("/catatan_penjualan/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../stok/catatan_penjualan.php">Catatan Penjualan</a>
                            </li>
                        </ul>
                    </li> 
<?php endif;?>
<?php if ($_SESSION['level'] <= 2) : ?>                    
					<?php if (preg_match("/hutang_piutang/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-balance-scale fa-2x"></i>
                            <span>ARUS KAS</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/Ikjnehjkmn/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/index.php?Ikjnehjkmn">Pendapatan</a>
                            </li>
                            <?php if (preg_match("/KjnHTG/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/hutang.php?KjnHTG">Hutang</a>
                            </li>
                            <?php if (preg_match("/LmngTGVf/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/piutang.php?LmngTGVf">Piutang</a>
                            </li>
                            <?php if (preg_match("/Hnnasdh/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/generate_voucher.php?Hnnasdh">Generate Voucher</a>
                            </li>
                            <?php if (preg_match("/Jnnfgb/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Bank</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                            		<?php if (preg_match("/kas_bank/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                               		 <a href="../hutang_piutang/kas_bank.php?Jnnfgb">
                                     		<span>Kas Bank</span>
                                     </a>
                            		</li>
                                    <?php if (preg_match("/entry_bank_baru/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                               		 <a href="../hutang_piutang/entry_bank_baru.php?Jnnfgb">
                                            <span>Entry Bank</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> 
<?php endif;?> 
<?php if ($_SESSION['level'] <= 2 || $_SESSION['level'] == 4) : ?>                    
					<?php if (preg_match("/gudang/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-archive fa-2x"></i>
                            <span>GUDANG</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/VBgfTGG/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/index.php?VBgfTGG">Alokasi Stok</a>
                            </li>
                            <?php if (preg_match("/WffEFGHH/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/ambil_barang.php?WffEFGHH">Entry Pengambilan Barang</a>
                            </li>
                            <?php if (preg_match("/barang_keluar/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/barang_keluar.php?JMJggj">Catatan Barang Keluar</a>
                            </li>
                            <?php if (preg_match("/barang_masuk/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/barang_masuk.php?KHhdhydv">Catatan Barang Masuk</a>
                            </li>
                        </ul>
                    </li> 
<?php endif;?> 

<?php if ($_SESSION['level'] <= 2 || $_SESSION['level'] == 5) : ?>  
					<?php if (preg_match("/pajak/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-folder-open fa-2x"></i>
                            <span>PAJAK</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/pjk_jual/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pajak/index.php?pjk_jual">Pajak Penjualan</a>
                            </li>
                            <?php if (preg_match("/pjk_beli/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pajak/index.php?pjk_beli">Pajak Pembelian</a>
                            </li>
                        </ul>
                    </li> 
<?php endif;?>

<?php if ($_SESSION['level'] == 1) : ?>                    
					<?php if (preg_match("/sms_gateway/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-phone fa-2x"></i>
                            <span>SMS GATEWAY</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/JmnHTE/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../sms_gateway/index.php?JmnHTE">Status Modem</a>
                            </li>
                            <?php if (preg_match("/set_modem/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../sms_gateway/set_modem.php">Setting Modem</a>
                            </li>
                        </ul>
                    </li> 
<?php endif;?> 

                    <li class="header">UTILITY</li>
                    <?php if (preg_match("/changelogs/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="../changelogs/">
                            <i class="fa fa-hourglass-half fa-2x"></i>
                            <span>Changelogs</span>
                        </a>
                    </li>
            <!-- #Menu -->
