<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';

if ($_SESSION['level'] == 4) :
$ada = $conn->query(" SELECT * FROM tabel_retur where jumlah_barang != is_alokasi")->num_rows;

   if ($ada > 0) :
   echo "<script>window.alert('Terdapat $ada barang Retur/Transfer yang belum dialokasikan')
    		window.location='../transfer_retur/summary_data.php?data=data_retur'</script>";
   endif;

endif;

if ($_SESSION['level'] == 3) :
$tempo=$conn->query("SELECT  COUNT(*) FROM tabel_faktur AS a LEFT JOIN tabel_bayar AS b ON a.no_faktur=b.no_faktur WHERE a.metode_bayar = 1 AND b.jumlah_transaksi-b.jumlah_bayar > 0 AND a.jatuh_tempo <= '".date('Y-m-d')."' AND a.id_toko = '".$_SESSION['toko']."' ")->fetch_array();

   if ($tempo[0] > 0) :
   //echo "<script>window.alert('Terdapat $tempo[0] Data Piutang Pelanggan Yang Jatuh Tempo')
    //		window.location='../hutang_piutang/jatuh_tempo.php'</script>";
   endif;

endif;



?>
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
<?php include DOT.'partial/left_sidebar.php';?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">

                <!-- CONTENT -->
                <div class="badan"></div>
                
                <!-- #END# CONTENT -->
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script type="text/javascript" src="<?=DOT?>js/jquery2.js"></script>
    <script type="text/javascript" >
	$(document).ready(function(){
		$('.klik_menu').click(function(){
			var menu = $(this).attr('id');
			if(menu == "customer"){
				$('.badan').load('admin/master_data/home.php');						
			}else if(menu == "arus_kas"){
				$('.badan').load('../bendahara/arus_kas.php');						
			}else if(menu == "anggota"){
				$('.badan').load('../keanggotaan/anggota.php');
			}else if(menu == "lapor"){
				$('.badan').load('../pelaporan/harian.php');						
			}
		});
 
 
		// halaman yang di load default pertama kali
		$('.badan').load('home.php');
	});
 </script>
<?php include DOT.'partial/js_index.php';?>
    
<?php include PRT.'end_body.php';?>
