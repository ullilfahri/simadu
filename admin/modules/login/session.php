<?php
require_once '../../../sysconfig.php';
@session_start();
if (!isset($_SESSION['adminUsername'])) {
  echo '<script>
  window.location.href="../../modules/login"
  </script>';
}

if ($_SESSION['sub_level']==3 || $_SESSION['sub_level']==5) {
$ada=$conn->query("SELECT * FROM user where id = '".$_SESSION['id']."' AND limit_sesi=0")->num_rows;
if ($ada > 0) :
echo "<script>alert('Anda telah dikeluarkan oleh Admin'); window.location = '../login/logout.php'</script>";
endif;
}

$timeout = 30; // Set timeout menit
$logout_redirect_url = "../login"; // Set logout URL

$timeout = $timeout * 60; // Ubah menit ke detik
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
		$conn->query("update user set limit_sesi=0 where id = '".$_SESSION['id']."'");
        session_destroy();
        echo "<script>alert('Sesi Berakhir, Silahkan Login Kembali!'); window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();


?>
