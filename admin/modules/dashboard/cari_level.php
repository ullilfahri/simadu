<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_form2.php';
include MDL.'login/session.php';
if ($_SESSION['level']>2) :
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
				<li><a href="javascript:void(0);"><i class="fa fa-user fa-lg"></i> Tambah User</a></li>
			</ol>

            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               TAMBAH USER
                            </h2>
                        </div>
                        <div class="body">
                        <form method="post" action="form_crud.php" class="form-horizontal" autocomplete="off">
                        
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="username" class="form-control" placeholder="Masukan Username" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password">Password <a href="javascript:void(0);"><i class="glyphicon glyphicon-eye-open"></i></a></label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" name="password" id="passwordfield" class="form-control time12" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_2">Hak Akses</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                    <?php $kat=$conn->query("select * from mst_level order by id ASC");?>
                                    <select id="kecamatan" name="hak_akses" class="form-control show-tick" onchange="javascript:rubah(this)" required>
                                        <option value="">-- PILIH HAK AKSES --</option>
                                        <?php
										while ($k=$kat->fetch_array()) :
										?>
                                        <option value="<?php echo $k['id'];?>"><?php echo $k['hak_akses'];?></option>
                                        <?php endwhile;?>
                                    </select>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_3">Pengguna</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
									<?php $lev=$conn->query("SELECT b.id, a.pengguna, a.id_akses, a.kode, a.id_level FROM mst_hak_akses as a INNER JOIN mst_level as b ON a.id_akses = b.id");?>
                                    <select id="desa" name="level" class="form-control" required>
                                        <option value="">-- PILIH PENGGUNA --</option>
                                    <?php 
									while ($l=$lev->fetch_array()) { ?>
            							<option id ="desa" class="<?php echo $l[0];?>" value="<?php echo $l[2].'#'.$l[4].'#'.$l[3];?>"><?php echo $l[1];?></option>
                                        <?php }?>
                                    </select>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_3">Gudang/Toko</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                    <select id="gudang" name="id_gudang" class="form-control" required>
                                        <option value="">-- PILIH GUDANG/TOKO --</option>
                                    <?php 
									$toko_sql=$conn->query("SELECT id_level, id_lokasi, nama from lokasi order by nama ASC ");
									while ($t=$toko_sql->fetch_array()) : ?>
            							<option id ="gudang" class="3 4 6" value="<?php echo $t[1];?>"><?php echo $t[2];?></option>
                                    <?php endwhile;?>
                                    </select>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Nama</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" name="tambah_user" class="btn btn-primary m-t-15 waves-effect">Simpan</button>
                                    </div>
                                </div>
                                                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Horizontal Layout -->            
                    
 
            </div>
    </section>
    
    <!-- Jquery Core Js -->
    <script src="<?=PLG?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=PLG?>bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=PLG?>jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Colorpicker Js -->
    <script src="<?=PLG?>bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="<?=PLG?>dropzone/dropzone.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="<?=PLG?>jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Multi Select Plugin Js -->
    <script src="<?=PLG?>multi-select/js/jquery.multi-select.js"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="<?=PLG?>jquery-spinner/js/jquery.spinner.js"></script>

    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="<?=PLG?>bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
        <script src="<?=PLG?>jquery-validation/jquery.validate.js"></script>
    <!-- Sweet Alert Plugin Js -->
    <script src="<?=PLG?>sweetalert/sweetalert.min.js"></script>


    <!-- noUISlider Plugin Js -->
    <script src="<?=PLG?>nouislider/nouislider.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?=PLG?>node-waves/waves.js"></script>
    
    <!-- Moment Plugin Js -->
    <script src="<?=PLG?>momentjs/moment.js"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?=PLG?>bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Custom Js -->
    <script src="<?=JS?>admin.js"></script>
    <script src="<?=JS?>pages/forms/advanced-form-elements.js"></script>
    <script src="<?=JS?>pages/ui/modals.js"></script>
    
    <script src="<?=JS?>jquery.chained.min.js"></script>
   <script>
            $("#desa").chained("#kecamatan");
            $("#gudang").chained("#kecamatan");
   </script>

 <script>
 

$("#passwordfield").on("keyup",function(){
    if($(this).val())
        $(".glyphicon-eye-open").show();
    else
        $(".glyphicon-eye-open").hide();
    });
$(".glyphicon-eye-open").mousedown(function(){
                $("#passwordfield").attr('type','text');
            }).mouseup(function(){
                $("#passwordfield").attr('type','password');
            }).mouseout(function(){
                $("#passwordfield").attr('type','password');
            });
</script>			   

    
</body>
</html>