<?php
require_once '../../../sysconfig.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>LOGIN | SIMADU | 1.0</title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="../../assets/img/avatar.png">

    <!-- Google Fonts -->
     <!-- Google Fonts -->
    <link href="<?php echo CSS;?>css.css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="<?php echo CSS;?>icon.css?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo PLG;?>bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo PLG;?>node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo PLG;?>animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo CSS;?>style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>SIMADU</b></a>
            <small>Sistem Informasi & Manajemen terpaDU</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="proses_login.php">
                    <div class="msg">Silahkan login terlebih dahulu<br>HOST USER : <?=getenv('REMOTE_ADDR')?></div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" id="passwordfield" placeholder="Password" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-6">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">LOGIN</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?php echo PLG;?>jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo PLG;?>bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo PLG;?>node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo PLG;?>jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo JS;?>admin.js"></script>
    <script src="<?php echo JS;?>pages/examples/sign-in.js"></script>
    
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