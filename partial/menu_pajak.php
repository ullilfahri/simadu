            <!-- Menu -->
					<?php if (preg_match("/pajak/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-folder-open fa-2x"></i>
                            <span>PAJAK</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/pajak_penjualan/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pajak/pajak_penjualan.php?hari_ini">Pajak Penjualan</a>
                            </li>
                            <?php if (preg_match("/pajak_pembelian/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pajak/pajak_pembelian.php?hari_ini">Pajak Pembelian</a>
                            </li>
                            <?php if (preg_match("/pajak_retur/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pajak/pajak_retur.php?hari_ini">Retur Barang</a>
                            </li>
                        </ul>
                    </li> 
            <!-- Menu -->
