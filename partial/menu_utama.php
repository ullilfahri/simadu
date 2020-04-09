            <!-- Menu -->
					<?php if (preg_match("/master_data/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-asterisk fa-2x"></i>
                            <span>MASTER DATA</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/lokasi/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/lokasi.php">Lokasi</a>
                            </li>
                            <?php if (preg_match("/supplier/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/supplier.php?main">Supplier</a>
                            </li>
                            <?php if (preg_match("/customer/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/customer.php?main">Customer</a>
                            </li>
                            <?php if (preg_match("/buku_bank/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/buku_bank.php?kasir">Buku Bank</a>
                            </li>
                            <?php if (preg_match("/karyawan/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/karyawan.php?main">Karyawan</a>
                            </li>
                            <?php if (preg_match("/tabel_mobil/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/katalog_barang.php?tabel=tabel_mobil&kol1=plat_mobil&kol2=jenis_mobil">Sarana Angkut</a>
                            </li>
                            <?php if (preg_match("/lokasi_antar/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/lokasi_antar.php?main">Lokasi Antar</a>
                            </li>
                            <?php if (preg_match("/setting/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/setting.php">Toleransi Retur Barang</a>
                            </li>
                            <?php if (preg_match("/jenis_pengeluaran/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../master_data/jenis_pengeluaran.php">Jenis Pengeluaran</a>
                            </li>
                            <li <?php if (preg_match("/katalog_barang/i", $_SERVER['REQUEST_URI'])):?>class="active"<?php endif;?>>
                                <a href="javascript:void(0);" class="menu-toggle">
                                	<span>Katalog Barang</span>
                                </a>
                                <ul class="ml-menu">
								   <li <?php if (preg_match("/kode_barang/i", $_SERVER['REQUEST_URI'])):?>class="active"<?php endif;?>>
                                		<a href="../master_data/kode_barang.php?katalog_barang=kode_barang">Kode Barang</a>
                           		 	</li>
								   <li <?php if (preg_match("/barang_jenis/i", $_SERVER['REQUEST_URI'])):?>class="active"<?php endif;?>>
                                		<a href="../master_data/katalog_barang.php?tabel=barang_jenis&kol1=jenis_barang&kol2=merek_barang">Jenis Barang</a>
                           		 	</li>
								   <li <?php if (preg_match("/barang_satuan/i", $_SERVER['REQUEST_URI'])):?>class="active"<?php endif;?>>
                                		<a href="../master_data/katalog_barang.php?tabel=barang_satuan&kol1=satuan_barang&kol2=akronim">Satuan Barang</a>
                           		 	</li>
                                </ul>
                            </li>
                            
                        </ul>
                    </li> 
					
					<?php if (preg_match("/pembelian/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-briefcase fa-2x"></i>
                            <span>PEMBELIAN</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/UytRVB/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pembelian/index.php?UytRVB">Entry Pembelian</a>
                            </li>
                            <?php if (preg_match("/summary_pembelian/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../pembelian/summary_pembelian.php?hari_ini">Summary Pembelian</a>
                            </li>
                        </ul>
                    </li> 
                    
					<?php if (preg_match("/tabel_keluar/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-outdent fa-2x"></i>
                            <span>PENGELUARAN</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/KmjGNBN/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../tabel_keluar/index.php?KmjGNBN">Entry Pengeluaran</a>
                            </li>
                            <?php if (preg_match("/summary_pengeluaran/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../tabel_keluar/summary_pengeluaran.php">Summary Pengeluaran</a>
                            </li>
                        </ul>
                    </li> 
                    
					<?php if (preg_match("/kasir/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-cart-arrow-down fa-2x"></i>
                            <span>PENJUALAN</span>
                        </a>
                        <ul class="ml-menu">
                        
                            <?php if (preg_match("/summary_penjualan/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/summary_penjualan.php?hari_ini">Summary Penjualan</a>
                            </li>
                            <?php if (preg_match("/generate_voucher/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../kasir/generate_voucher.php">Generate Kode Voucher</a>
                            </li>
                        </ul>
                    </li> 

					<?php if (preg_match("/hutang_piutang/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-balance-scale fa-2x"></i>
                            <span>ACCOUNTING</span>
                        </a>
                        <ul class="ml-menu">
                            <!--<?php if (preg_match("/pengeluaran/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/pengeluaran.php?main">Pengeluaran</a>
                            </li>-->
                            <?php if (preg_match("/KjnHTG/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/hutang.php?KjnHTG">Hutang</a>
                            </li>
                            <?php if (preg_match("/LmngTGVf/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../hutang_piutang/piutang.php?LmngTGVf">Piutang</a>
                            </li>
                        </ul>
                    </li> 
                    
					<?php if (preg_match("/perbankan/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-university fa-2x"></i>
                            <span>BANK</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/summary_bank/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../perbankan/kas_bank.php?summary_bank">Summary Bank</a>
                            </li>
                            <?php if (preg_match("/transfer_bank/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../perbankan/entry_bank_baru.php?transfer_bank">Transfer Bank</a>
                            </li>
                            <?php if (preg_match("/kas_tunai/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../perbankan/kas_tunai.php?kas_tunai">Summary Kas Tunai</a>
                            </li>
                        </ul>
                    </li> 


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
                                <a href="../gudang/barang_keluar.php?JMJggj">Summary Pengambilan</a>
                            </li>
                            <?php if (preg_match("/ambil_transaksi/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/ambil_transaksi.php?hari_ini">Summary Barang Keluar</a>
                            </li>
                            <?php if (preg_match("/barang_masuk/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../gudang/barang_masuk.php?KHhdhydv">Summary Barang Masuk</a>
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

<?php if ($_SESSION['level']==1) :?>
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
            <!-- #Menu -->
            
                    <li class="header">REPORT</li>
                    <?php if (preg_match("/report/i", $_SERVER['PHP_SELF'])){?><li class="active"><?php }else{?><li><?php }?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-area-chart fa-2x"></i>
                            <span>LAPORAN</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if (preg_match("/YhnGTr/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/index.php?YhnGTr">Laporan Data Barang</a>
                            </li>
                            <?php if (preg_match("/laporan_piutang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_piutang.php">Laporan Buku Piutang</a>
                            </li>
                            <?php if (preg_match("/laporan_hutang/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_hutang.php">Laporan Hutang</a>
                            </li>
                            <?php if (preg_match("/laporan_harga/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/laporan_harga.php">Laporan Perubahan Harga</a>
                            </li>
                            <?php if (preg_match("/perbaikan_stok/i", $_SERVER['REQUEST_URI'])){?><li class="active"><?php }else{?><li><?php }?>
                                <a href="../report/perbaikan_stok.php">Laporan Perbaikan Stok</a>
                            </li>
                        </ul>
                    </li> 
                        
                        
