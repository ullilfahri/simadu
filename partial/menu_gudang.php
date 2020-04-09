            <!-- Menu -->
					<?php if (preg_match("/gudang/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-archive fa-2x"></i>
                            <span>GUDANG</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/VBgfTGG/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/index.php?VBgfTGG">Alokasi Stok</a>
                            </li>
                            <?php if (preg_match("/ambil_barang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/ambil_barang.php?WffEFGHH">Entry Pengambilan Barang</a>
                            </li>
                            <?php if (preg_match("/barang_keluar/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/barang_keluar.php?JMJggj">Summary Pengambilan</a>
                            </li>
                            <?php if (preg_match("/ambil_transaksi/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/ambil_transaksi.php?hari_ini">Summary Barang Keluar</a>
                            </li>
                            <?php if (preg_match("/barang_masuk/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/barang_masuk.php?KHhdhydv">Summary Barang Masuk</a>
                            </li>
                            <?php if (preg_match("/metode_ambil/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/metode_ambil.php?KHhdhydv">Summary Metode Pengambilan</a>
                            </li>
                        </ul>
                    </li> 
                    
					<?php if (preg_match("/transfer_retur/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-recycle fa-2x"></i>
                            <span>RETUR / TRANSFER BARANG</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/JmnJUHS/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../transfer_retur/entry_alokasi.php?JmnJUHS">
                                            <span>Entry Transfer Barang</span>
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
                            
					<?php if (preg_match("/arsip_gudang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-folder-open fa-2x"></i>
                            <span>ARSIP GUDANG</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/ungh_dokumen/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/unggah_dokumen.php?menu&uri=hari_ini&ungh_dokumen&arsip_gudang">
                                            <span>Dokumen Surat Jalan</span>
                                        </a>
                                    </li>
                            <?php if (preg_match("/file_transfer/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/file_transfer.php?menu&uri=hari_ini&arsip_gudang">
                                            <span>Dokumen Transfer Barang</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
					<?php if (preg_match("/kasir/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-edit fa-2x"></i>
                            <span>ARSIP TOKO</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/kasir/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/unggah_dokumen.php?hari_ini">
                                            <span>Unggah Dokumen</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

