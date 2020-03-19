<!--Header-->
<?php include "../../partial/header.php";?>
<!--End Header-->

    <!-- Page Loader -->
    <?php include "../../partial/page_loader.php";?>
    <!-- #END# Page Loader -->
    
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <?php include "../../partial/top_bar.php";?>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
         <?php 
		 include "../../partial/left_siderbar.php";?>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>
<!--JUDUL-->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>FITUR MODEM</h2>
            </div>
<!-- JUDUL -->

            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LOG MODEM <?=$_SERVER['DOCUMENT_ROOT']?>
                            </h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#log_modem1" data-toggle="tab">
                                        <i class="material-icons">filter_1</i> MODEM # 1
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#log_modem2" data-toggle="tab">
                                        <i class="material-icons">filter_2</i> MODEM # 2
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#log_modem3" data-toggle="tab">
                                        <i class="material-icons">filter_3</i> MODEM # 3
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="log_modem1">
                                      <div class="form-group form-float form-group-lg">
                                        <button type="button" class="btn btn-danger btn-lg" 
                            			onClick="confirm_modal('hapus_log.php?log_modem=log_modem&modal_id=logsmsdrc');">
                                    	<i class="material-icons">clear</i>
                                    	<span>HAPUS LOG MODEM #1</span>
                                		</button>
                                      </div>
                                      <div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item"
                                      src="bin/win/baca_log.php?modem=logsmsdrc"></iframe>
  									  </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="log_modem2">
                                      <div class="form-group form-float form-group-lg">
                                        <button type="button" class="btn btn-danger btn-lg" 
                            			onClick="confirm_modal('hapus_log.php?log_modem=log_modem&modal_id=logsmsdrc2');">
                                    	<i class="material-icons">clear</i>
                                    	<span>HAPUS LOG MODEM #2</span>
                                		</button>
                                      </div>
                                      <div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item"
                                      src="bin/win/baca_log.php?modem=logsmsdrc2"></iframe>
                                      </div>  
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="log_modem3">
                                      <div class="form-group form-float form-group-lg">
                                        <button type="button" class="btn btn-danger btn-lg" 
                            			onClick="confirm_modal('hapus_log.php?log_modem=log_modem&modal_id=logsmsdrc3');">
                                    	<i class="material-icons">clear</i>
                                    	<span>HAPUS LOG MODEM #3</span>
                                		</button>
                                      </div>
                                      <div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item"
                                      src="bin/win/baca_log.php?modem=logsmsdrc3"></iframe>
                                      </div>  
                                </div>
 <!--TAB TPS-->                              
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Icon Title -->

        </div>
    </section>
<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Hapus LOG ?</h4>
      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal delete-->
    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js 
    <script src="../../plugins/bootstrap-select/js/bootstrap-select.js"></script>-->

    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Colorpicker Js -->
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="../../plugins/dropzone/dropzone.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Multi Select Plugin Js -->
    <script src="../../plugins/multi-select/js/jquery.multi-select.js"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="../../plugins/jquery-spinner/js/jquery.spinner.js"></script>

    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="../../plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
        <script src="../../plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Sweet Alert Plugin Js -->
    <script src="../../plugins/sweetalert/sweetalert.min.js"></script>


    <!-- noUISlider Plugin Js -->
    <script src="../../plugins/nouislider/nouislider.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>
    
    <!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/forms/advanced-form-elements.js"></script>
    <script src="../../js/pages/ui/modals.js"></script>

    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
	<script src="../../js/jquery.chained.min.js"></script>
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