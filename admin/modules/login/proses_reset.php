<?php

	include "../../partial/pilkada_db.php";
	
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		
		$update=$conn->query("update user set password='$password' where username='$username' ");
		
		if ($update){
			echo "<script>window.alert('Password Telah Direset, Silahkan Login Kembali Menggunakan Password Baru')
    		window.location='index.php'</script>";
			} else {
			echo "<script>window.alert('Password Gagal Direset')
    		window.location='index.php'</script>";
			}


?>
