<?php

session_start();
	include "../../../sysconfig.php";
		$username = $_POST['username'];
		$password = md5($_POST['password']);


		//membuat sesi jadi 0

		$conn->query("UPDATE `user` SET `limit_sesi` = '0' WHERE user.limit_sesi = '1'") ;
		
		$result=$conn->query("select * from user where BINARY username='$username' and password='$password' ");
		$data=$result->fetch_assoc();
		if($result->num_rows == 0) {
		
			echo "<script>window.alert('Username Atau Password Salah')
    		window.location='./'</script>";
		} else if ($result->num_rows > 0 && $data['level'] == 3 && $data['id_level'] == 3 && $data['limit_sesi'] == 1){
		
			echo "<script>window.alert('Sesi Aktif, hubungi Admin Toko Anda untuk Reset Login')
    		window.location='./'</script>";
			
		} else if ($result->num_rows > 0 && $data['level'] == 4 && $data['id_level'] == 5 && $data['limit_sesi'] == 1){
		
			echo "<script>window.alert('Sesi Aktif, Admin Toko')
    		window.location='./'</script>";
			
		} else {	

			$_SESSION['adminUsername']=$data['username'];
			$_SESSION['level']=$data['level'];
			$_SESSION['sub_level']=$data['id_level'];
			$_SESSION['nama']=$data['nama'];
			$_SESSION['id']=$data['id'];
			$_SESSION['last_login']=$data['last_login'];
			$_SESSION['img']=$data['img'];
			$_SESSION['distributor']=$data['distributor'];
			$_SESSION['gudang']=$data['id_gudang'];
			$_SESSION['toko']=$data['id_gudang'];

			$conn->query("update user set last_login=NOW(), limit_sesi=1 where id='".$data['id']."'");
			header ("location: ".MDL."dashboard/");
		}
		
?>
