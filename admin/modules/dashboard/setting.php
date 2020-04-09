
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level'] != 2) :
	echo "<script>window.alert('Anda Tidak Memiliki Hak Akses..!')
    		window.location='../dashboard'</script>";
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

if ($_SESSION['level']!=1) {
$disabled='';
} else {
$disabled='readonly';
}

$customer=$conn->query("select * from mst_setting where id like '%".$_SESSION['toko']."%'");
?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-wrench fa-lg"></i> Setting</a></li>
			</ol>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DATA TOKO<br><br>
                                <div class="button-demo js-modal-buttons">
                                <button type="button" data-color="light-blue" class="btn bg-light-blue waves-effect">Tambah Data Toko</button>
                                </div>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="mainTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>No HP</th>
                                            <th>Limit Kredit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no=1;
									while ($x=$customer->fetch_array()) :
									?>
                                        <tr>
                                            <th scope="row"><?=$no++?></th>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'nama','<?=$x['id']?>')" onClick="showEdit(this);"><?=$x['nama']?></td>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'alamat','<?=$x['id']?>')" onClick="showEdit(this);"><?=$x['alamat']?></td>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'kota','<?=$x['id']?>')" onClick="showEdit(this);"><?=$x['kota']?></td>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'no_hp','<?=$x['id']?>')" onClick="showEdit(this);"><?=substr_replace($x['no_hp'],'0',0,3);?></td>
                                            <td contenteditable="true" onBlur="saveToDatabase(this,'limit_kredit','<?=$x['id']?>')" onClick="showEdit(this);"><?=angka($x['limit_kredit'])?></td>
                                            <td><button type="button" class="btn btn-danger btn-sm" onClick="confirm_modal('form_crud.php?hapus_customer&&modal_id=<?=$x['id']; ?>');">Hapus</button></td>
                                        </tr>
                                    <?php endwhile;?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
            
 
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

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
    <!-- Autosize Plugin Js -->
    <script src="<?=PLG?>autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?=PLG?>jquery-countto/jquery.countTo.js"></script>
    
    <!-- Sparkline Chart Plugin Js -->
    <script src="<?=PLG?>jquery-sparkline/jquery.sparkline.js"></script>
            
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

    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/tables/jquery-datatable.js"></script>
    <script src="<?=JS?>pages/forms/basic-form-elements.js"></script>
    <script src="<?=JS?>helpers.js"></script>
    <script src="<?=JS?>pages/widgets/infobox/infobox-5.js"></script>
    <script src="<?=PLG?>jquery-validation/jquery.validate.js"></script>
    <script src="<?=JS?>pages/ui/modals.js"></script>
    <!-- Demo Js -->
    <script src="<?=JS?>demo.js"></script>
    <script src="<?=JS?>pages/examples/sign-up.js"></script>
<!-- Javasrip Modal Detail-->
   <script type="text/javascript">
    $(document).ready(function(){
        $('.edit').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?profil',
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
        $('.edit2').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'form_crud.php?foto',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
<!--Akhir Javasrip Modal Detail-->


<script type="text/javascript">
function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Hanya File Gambar yg diijinkan : .jpeg/.jpg/.png/.gif.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="145px"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
</script>



</body>

</html>