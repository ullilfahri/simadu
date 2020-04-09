					<?php if (preg_match("/kasir/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-edit fa-2x"></i>
                            <span>ARSIP TOKO</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/unggah_dokumen/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/unggah_dokumen.php?hari_ini"><span>Unggah Dokumen</span></a>
                                    </li>
                            <?php if (preg_match("/transaksi/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/transaksi.php?hari_ini"><span>Cetak Transaksi</span></a>
                                    </li>
                            <?php if (preg_match("/summary_pembatalan/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/summary_pembatalan.php?hari_ini"><span>Summary Pembatalan Transaksi</span></a>
                                    </li>
                            <?php if (preg_match("/file_transfer/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/file_transfer.php?menu&uri=hari_ini">
                                            <span>Dokumen Retur Barang</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>


					<?php if (preg_match("/gudang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-folder-open fa-2x"></i>
                            <span>ARSIP GUDANG</span>
                         </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/unggah_dokumen/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/unggah_dokumen.php?menu&uri=hari_ini">
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

