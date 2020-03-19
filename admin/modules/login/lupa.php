<?php
date_default_timezone_set("Asia/Jakarta");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     <title>LOGIN | SIAKO </title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="../../../assets/img/avatar.png">

    <!-- Google Fonts -->
     <!-- Google Fonts -->
    <link href="../../../css/css.css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="../../../css/icon.css?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../../../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../../../css/style.css" rel="stylesheet">
</head>

<body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>SIAKO</b></a>
            <small>Sistem Informasi Manajemen TOKO</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="forgot_password" method="POST" action="">
                    <div class="msg">
                        Masukan Username & Kode Aktivasi, untuk mendapatkan kode aktivasi, kirim SMS dengan format AKTIVASI kirim ke 081255754288.
                        <?=strtotime(date('Y-m-d H:i:s'))?> <?=strtotime(date('2018-11-17 00:05:00'))?> <?=date('Y-m-d H:i:s')?>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="aktivasi" placeholder="Kode Aktivasi" required autofocus>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> AKTIVASI</button>

                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../../plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="../../../plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="../../../js/admin.js"></script>
    <script src="../../../js/pages/examples/forgot-password.js"></script>
</body>

</html>
