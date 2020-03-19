
<?php 
include '../../../sysconfig.php';
include DOT.'partial/header_index.php';
include MDL.'login/session.php';
if ($_SESSION['level']>2) :
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
$stok=$conn->query("select * from stok_barang");

?>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
			<ol class="breadcrumb breadcrumb-bg-teal align-left">
				<li><a href="javascript:void(0);"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-clipboard fa-lg"></i> Admin</a></li>
				<li><a href="javascript:void(0);"><i class="fa fa-edit fa-lg"></i> Stok</a></li>
			</ol>  

            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LOKASI
                            </h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#rincian" data-toggle="tab">
                                        <i class="fa fa-home fa-2x"></i> RINCIAN LOKASI
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#marker" data-toggle="tab">
                                        <i class="fa fa-map fa-2x"></i> LOKASI
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#tambah_lokasi" data-toggle="tab">
                                        <i class="fa fa-edit fa-2x"></i> TAMBAH LOKASI
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#detail_gudang" data-toggle="tab">
                                        <i class="fa fa-edit fa-2x"></i> ENTRI DETAIL GUDANG
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="rincian">
                                    <div class="body">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lokasi</th>
                                            <th>Pintu/Ruang/Sekat</th>
                                            <th>Alamat Faktual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $lokasi=$conn->query("SELECT * FROM lokasi");
									$nl=1;
									while ($l=$lokasi->fetch_array()) :
									$pintu=$conn->query("SELECT * FROM `pintu_gudang` WHERE id_gudang='".$l['id_lokasi']."'");
									ob_start();
									while ($p=$pintu->fetch_array()) :
									echo $p['nama_pintu'].', ';
									endwhile;
									$detail=ob_get_contents();
									ob_end_clean();
									?>
                                        <tr>
                                            <td><?=$nl++?></td>
                                            <td><?=$l['nama']?></td>
                                            <td>
                                            <button type="button" class="btn btn-primary btn-block waves-effect" data-trigger="focus" data-container="body" data-toggle="popover"
                                            data-placement="top" title="<?=$l['nama']?>" data-content="<?=$detail?>">
                                        	Klik Detail
                                    		</button>
                                            </td>
                                            <td><?=$l['alamat']?></td>
                                        </tr>
                                   <?php endwhile;?>     
                                    </tbody>
                                </table>

                                    </div><!--# END <div class="body">-->    
                                </div><!--# End id="rincian">-->
                                
                                <div role="tabpanel" class="tab-pane fade" id="marker">
                                    <b>Lokasi Gudang</b>
                                    <div class="body">
										<div class="embed-responsive embed-responsive-16by9">
										<iframe class="embed-responsive-item" src="peta.php">
										</iframe>
										</div>
                                    </div><!--# END <div class="body">-->  
                                </div>      
                                
                                <div role="tabpanel" class="tab-pane fade" id="toko">
                                    <b>Lokasi Toko</b>
                                    <div class="body">
                                        <div id="gmap_markers" style="width: 900px; height: 600px;"></div>
                                    </div><!--# END <div class="body">-->    
                                </div><!--# End id="marker">-->
                                
                                

                                <div role="tabpanel" class="tab-pane fade" id="detail_gudang"><!--# Start id="detail_gudang">-->
                                    <div class="body"><!--Start <div class="body">-->
            <!-- Inline Layout -->
                            <form method="post" action="form_crud.php">
                            <div class="row clearfix"><!--Start <div class="row clearfix">-->
                                <div class="col-md-6">
                                    <p>
                                        <b>Pilih Gudang</b>
                                    </p>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <i class="fa fa-institution"></i>
                                        </span>
                                        <div class="form-line">
                                                <select class='form-control show-tick' name='id_gudang' data-live-search="true" required>
                                                <option value=''>-- Silahkan Pilih Gudang --</option>
                                                <?php 
												$gudang=$conn->query("select id_lokasi, nama from lokasi where id_level=4 order by nama asc");
												while ($g=$gudang->fetch_array()):
												?>
                                                <option value='<?=$g[0]?>'><?=$g[1]?></option><?php endwhile;?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <b>Nama Pintu/Ruang/Sekat</b>
                                    </p>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <i class="fa fa-windows"></i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="nama_pintu" placeholder="Masukan Pintu/Ruang/Sekat" required>
                                        </div>
                                        <span class="input-group-addon">
                                            <button type="submit" name="tambah_pintu_gudang" class="btn btn-success m-t-15 waves-effect">Simpan</button>
                                        </span>
                                    </div>
                                </div>
                                
                            </div><!--End <div class="row clearfix">-->
                            </form>
            <!-- #END# Inline Layout -->
                                    </div><!--# END <div class="body">-->    
                                </div><!--# End id="detail_gudang">-->

                                
                                
                                <div role="tabpanel" class="tab-pane fade" id="tambah_lokasi">
                                    <b>Tambah Lokasi Dengan Menggeser Balon</b>
                                    <div class="body">
                                    <div id="map" style="width:900px;height: 300px;"></div>
                                    	<form   method="POST" id="form1" action="form_crud.php" class='form-horizontal'>
                                        <input type="hidden" name="simpan_koordinat" />
                                        <br/>
    									<div class="control-group">
       										<label class="control-label" for="jenis">JENIS LOKASI</label>
       											<div class="controls">
         										<select name='id_level' class="form-control" required>
                                                <option value=''>--PILIH JENIS LOKASI--</option>
                                                <option value='3'>TOKO</option>
                                                <option value='4'>GUDANG</option>
                                                <option value='4'>TOKO GUDANG</option>
                                                </select>
       											</div>
    									</div> 
                                        
    									<div class="control-group">
       										<label class="control-label" for="nama">Nama Lokasi</label>
       											<div class="controls">
         										<input type="text" name='nama' class="form-control" required>
       											</div>
    									</div> 
                                        
    									<div class="control-group">
       										<label class="control-label" for="nama">Alamat Faktual</label>
       											<div class="controls">
         										<textarea class="form-control" name="alamat" required></textarea>
       											</div>
    									</div> 
                                        
                                       <div class="control-group">
       									<label class="control-label" for="lat">latitude</label>
      					 					<div class="controls">
         										<input type="text" name='lat' id='lat'  class="form-control" required>
       										</div>
     									</div>
 
     								<div class="control-group">
       									<label class="control-label" for="lng">Longitude</label>
       										<div class="controls">
         									<input type="text" name='lng' id='lng' class="form-control" required>
       										</div>
     								</div>
                                    
     								<div class="control-group">
       									<div class="controls">
         								<button type="submit" class="btn btn-success" name='aksi'>Simpan</button>
       									</div>
     								</div>
    								</form>
                                    
                                </div><!--# End id="tambah_lokasi">-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Icon Title -->
            
            
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-5qmlNLOo0pdDsU1G4IIBr-4NdzTje5Y&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    document.getElementById('reset').onclick= function() {
        var field1= document.getElementById('lng');
 var field2= document.getElementById('lat');
        field1.value= field1.defaultValue;
 field2.value= field2.defaultValue;
    };
</script>    
<script type="text/javascript">
     function updateMarkerPosition(latLng) {
  document.getElementById('lat').value = [latLng.lat()];
  document.getElementById('lng').value = [latLng.lng()];
  }

    var myOptions = {
      zoom: 15,
        scaleControl: true,
      center:  new google.maps.LatLng(-1.828525, 109.978177),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

 
    var map = new google.maps.Map(document.getElementById("map"),
        myOptions);

 var marker1 = new google.maps.Marker({
 position : new google.maps.LatLng(-1.828525, 109.978177),
 title : 'lokasi',
 map : map,
 draggable : true
 });
 
 //updateMarkerPosition(latLng);

 google.maps.event.addListener(marker1, 'drag', function() {
  updateMarkerPosition(marker1.getPosition());
 });
</script>

<script type="application/javascript">

$(function () {
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    //Popover
    $('[data-toggle="popover"]').popover();
})

</script>
    


</body>

</html>