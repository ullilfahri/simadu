<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>SIMADU | Sistem Informasi & Manajemen Aplikasi terpaDU</title>
    <!-- Favicon-->
    <link rel="icon" href="<?=DOT?>favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <style>
@font-face {
   font-family: 'Material Icons';
   font-style: normal;
   font-weight: 400;
   src: url(../../../plugins/iconfont/MaterialIcons-Regular.eot); /* For IE6-8 */
   src: local('Material Icons'),
        local('MaterialIcons-Regular'),
        url(../../../plugins/iconfont/MaterialIcons-Regular.woff2) format('woff2'),
        url(../../../plugins/iconfont/MaterialIcons-Regular.woff) format('woff'),
        url(../../../plugins/iconfont/MaterialIcons-Regular.ttf) format('truetype');
}

.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;  /* Preferred icon size */
  display: inline-block;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;

  /* Support for all WebKit browsers. */
  -webkit-font-smoothing: antialiased;
  /* Support for Safari and Chrome. */
  text-rendering: optimizeLegibility;

  /* Support for Firefox. */
  -moz-osx-font-smoothing: grayscale;

  /* Support for IE. */
  font-feature-settings: 'liga';
}
</style>
    <!-- Bootstrap Core Css -->
    <link href="<?=PLG?>bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?=PLG?>node-waves/waves.css" rel="stylesheet" />
    
    <!-- JQuery DataTable Css -->
    <link href="<?=PLG?>jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Multi Select Css -->
    <link href="<?=PLG?>multi-select/css/multi-select.css" rel="stylesheet">
    <link href="<?=PLG?>bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <link href="<?=PLG?>nouislider/nouislider.min.css" rel="stylesheet" />
	<link href="<?=PLG?>jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">
    
    <!-- Bootstrap Tagsinput Css -->
    <link href="<?=PLG?>bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?=PLG?>bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?=PLG?>waitme/waitMe.css" rel="stylesheet" />
    
    <!--JS GRID-->
   <link href="<?=PLG?>editable/bootstrap-editable.css" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="<?=PLG?>bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    
    <!-- Animation Css -->
    <link href="<?=PLG?>animate-css/animate.css" rel="stylesheet" />
    <link href="<?=PLG?>font-awesome\css/font-awesome.css" rel="stylesheet" />
    <link href="<?=PLG?>font-awesome\css/font-awesome-animation.min.css" rel="stylesheet" />
    <link href="<?=PLG?>light-gallery/css/lightgallery.css" rel="stylesheet">
    <link href="<?=CSS?>anic.css" rel="stylesheet">
	<!-- Sweetalert Css -->
    <link href="<?=PLG?>sweetalert/sweetalert.css" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <link href="<?=PLG?>morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?=CSS?>style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?=CSS?>themes/all-themes.css" rel="stylesheet" />

		<script type="text/javascript">
		var refreshId = setInterval(function(){
			$.ajax({
			url: "../dashboard/pesan_crud.php?ambil_pesan",
			dataType : 'html',
			success  : function(result){
				var response = JSON.parse(result);
				$("#jumlah_pesan").text(""+response.pesan+"");
				}
			})
		}, 5000);
		</script>
<?php include PRT.'end_body.php'?>        
    
</head>
