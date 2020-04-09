<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']>6) :
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

if ($_SESSION['level']==1) {
$profil=$conn->query("select * from user order by id ASC");
} else {
$profil=$conn->query("select * from user where id='".$_SESSION['id']."'");
}

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-user fa-lg"></i> Profil</a></li>
			</ol>

            <!-- Custom Content -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EDIT PROFIL
                            </h2>
                            <?php if ($_SESSION['level']==1) :?><br><a href="cari_level.php"><button type="button" class="btn btn-info btn-sm">Tambah User</button></a><?php endif;?> 
                        </div>
                        <div class="body">
                            <div class="row">
                            
                            <?php
                            while ($x=$profil->fetch_array()) :
							if (empty($x['img'])) { 
							$pic=DOT.'images/user.png';
							} else {
							$pic='images/'.$x['img'];
							}
							$hak_akses=$conn->query("select a.pengguna, b.hak_akses from mst_hak_akses as a left join mst_level as b ON a.id_akses=b.id where a.id_level='".$x['id_level']."'")->fetch_array();
							/*if ($x['level']!=1) {
							$tombol='<button type="button" class="btn btn-danger btn-sm" onClick="confirm_modal(\'form_crud.php?hapus_user&modal_id='.$x['id'].'");\'>Hapus '.$x['username'].'</button>';
							} else {
							$tombol='';
							}*/
							?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <center><img src="<?=$pic?>" width="145px"><br><br>
                                        <form method="post" action="form_crud.php" enctype="multipart/form-data" id="form1" name="form1" onsubmit="return false">
                                        <input type="hidden" name="id" value="<?=$x['id']?>" />
                                        <input type="hidden" name="nama" value="<?=$x['nama']?>" />
                                        <?php if (!empty($x['img'])) :?><input type="hidden" name="gambar_lama" value="<?=$pic?>" /><?php endif;?>
                                        <input type="hidden" name="ganti_foto" />
                                        <input type="file" id="file" name="gambar" onchange="return fileValidation()" required>
                                        <div id="imagePreview"></div>
                                        
                                        <button type="submit" class="btn btn-warning btn-sm"> Update Foto</button> <a href=""><button type="button" href="#" class="btn btn-danger btn-sm"> Reset Foto</button></a>
                                        
                                        </center>
                                        </form>
                                        <div class="caption">
                                            <h3><?=$x['username']?></h3>
                                            <p>
                                                NAMA       : <?=$x['nama']?><br>
                                                HAK AKSES  : <?=$hak_akses[1]?><br>
                                                PENGGUNA   : <?=$hak_akses[0]?><br>
                                                LAST LOGIN : <?=$x['last_login']?>
                                            </p>
                                            <p>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target=".edit" data-id="<?=$x['id'];?>"> Update</button>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php if ($x['level'] !=1 && $_SESSION['id'] != $x['id']) :?>
                                            	<button type="button" class="btn btn-danger btn-sm" onClick="confirm_modal('form_crud.php?hapus_user&&modal_id=<?=$x['id']; ?>');">Hapus <?=$x['nama']?></button>
                                                <?php endif;?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                             
                             <?php endwhile;?>   
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Custom Content -->
            
<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Hapus User ?</h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal Delete-->

<!--MODAL EDIT-->        
<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">UBAH PROFIL</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-data"></div>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT-->    
<!--MODAL EDIT-->        
<div class="modal fade edit2" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">UBAH FOTO</h4>
                        </div>
                        <div class="modal-body">
                        <div class="fetched-data"></div>
                        </div>
                      </div>
                    </div>
                  </div>
<!--AKHIR MODAL EDIT-->        


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

<!-- Javascript untuk popup modal Delete--> 
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
<!--Akhir Javasrip Modal Delete-->  



</body>

</html>