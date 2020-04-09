<?php eval("?>".base64_decode("PD9waHAgDQppbmNsdWRlICcuLi8uLi8uLi9zeXNjb25maWcucGhwJzsNCj8+DQo=")); ?>
<?php 
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']!=2) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../kasir'</script>";
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
<?php include DOT.'partial/left_sidebar.php';

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-area-chart fa-lg"></i> Laporan</a></li>
			</ol>  
            
            
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               PENCARIAN BARANG 
                            </h2>
                        </div>
                        <div class="body">
                            <form name="form_login" id="form_login" autocomplete="off">
                                <div class="row clearfix">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="cari" class="form-control" minlength="3" required>
                                                <label class="form-label">Masukan Kode/Nama Barang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <button type="submit" class="btn btn-primary btn-sm waves-effect">Cari</button>
                                    </div>
                                </div>
                            </form>

							<div class="daftar_barang"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
            
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               DATA LOG STOK OPNAME 
                            </h2>
                        </div>
                        <div class="body">

							<div class="list-data"></div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
            
            
            <!-- Large Size -->
            <div class="modal fade rincian" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Pembelian</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            <!-- Large Size -->
            <div class="modal fade rincian2" id="largeModal2" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Penjualan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data2"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            <div class="modal fade rincian3" id="largeModal3" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian Alokasi Stok</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-data3"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            
            <!-- Large Size -->
            <div class="modal fade belum_ambil" id="belum_ambil" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian QTY Belum Ambil</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-belum_ambil"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            
            <!-- Large Size -->
            <div class="modal fade belum_alokasi" id="belum_alokasi" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Rincian QTY Belum Dialokasikan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="fetched-belum_alokasi"></div>
                        </div><!--#End <div class="modal-body">-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Large Size -->
            
                 
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

    <!-- Select Plugin Js -->
    <script src="<?=PLG?>bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Multi Select Plugin Js -->
    <script src="<?=PLG?>multi-select/js/jquery.multi-select.js"></script>
    <!-- Input Mask Plugin Js -->
    <script src="<?=JS?>my.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>
    
    <!-- Jquery Spinner Plugin Js -->
    <script src="<?=PLG?>jquery-spinner/js/jquery.spinner.js"></script>


    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
	<!-- SweetAlert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>    
    
    <!-- Light Gallery Plugin Js -->
    <script src="<?=PLG?>light-gallery/js/lightgallery-all.js"></script>


    <!-- Jquery DataTable Plugin Js -->
    <script src="<?=PLG?>jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?=PLG?>jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?=PLG?>jquery-datatable/extensions/export/buttons.print.min.js"></script>
	<script src="<?=PLG?>editable-table/mindmup-editabletable.js"></script>
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/tables/editable-table.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    
    <!-- Custom Js -->
<script>
function saveToDatabase(editableObj,column,id) {
	$(editableObj).css("background","#FFF url(img/loader.gif) no-repeat right");
	$.ajax({
		url: "../stok/form_crud.php?live_edit",
		type: "POST",
		data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
		success: function(data){
			$(editableObj).css("background","#FDFDFD");
		}        
   });
}
</script>

<script type="application/javascript">
$(document).ready(function (e) {
	$("#form_login").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "daftar_barang.php?input",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result){
			var response = JSON.parse(result);
			if (response.status){
				$(".daftar_barang").load("daftar_barang.php?ambil_data&cari="+response.cari);
				}  else if (response.error) {
				swal("Gagal", response.pesan, "error");
				} 
		    },
	   });
	}));
});
</script>       



<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rincian').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../stok/detail.php?detail_pembelian',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rincian2').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../stok/detail.php?detail_penjualan',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.rincian3').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../stok/detail.php?alokasi_stok',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data3').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.belum_ambil').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../stok/detail.php?belum_ambil',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-belum_ambil').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.belum_alokasi').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../stok/detail.php?belum_alokasi',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-belum_alokasi').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->

<script type="application/javascript">
 function tes(id) {
 //var kode_barang   = document.getElementById("kode_barang").value;
    swal({
        title: "Generate Stok Opname",
        text: "Tekan OK untuk Generate Laporan Kode Barang",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function () {
        $.ajax({
		url	     : 'eksekusi.php?generate',
		type     : 'POST',
		dataType : 'html',
		data     : 'id='+id,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			swal("Sukses!", response.pesan, "success");
			$(".list-data").load("eksekusi.php?data&kode_barang="+response.kode);
			} else if (response.error){
			swal("Gagal!", response.pesan, "error");
			} else {
			swal("Gagal!", response.pesan, "error");
			}
		},
	})
    });
}
</script>

<script type="application/javascript">
 function sesuai(selisih, kode) {
    swal({
        title: "Penyesuain Stok",
        text: "Tekan OK Untuk Melakukan Penyesuaian Stok",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function () {
        $.ajax({
		url	     : 'eksekusi.php?penyesuaian',
		type     : 'POST',
		dataType : 'html',
		data     : 'selisih='+selisih+'&kode='+kode,
		success  : function(result){
			var response = JSON.parse(result);
			if (response.status){
			alert(response.pesan);
			window.location.reload();
			} else if (response.error){
			swal("Gagal!", response.pesan, "error");
			} else {
			swal("Gagal!", response.pesan, "error");
			}
		},
	})
    });

}
</script>


</body>

</html>