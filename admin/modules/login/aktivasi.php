<?php

session_start();

    include "../../partial/pilkada_db.php";


		$aktivasi =$conn->query("select * from kode_aktivasi where BINARY kode='".$_POST['aktivasi']."'");
		$x=$aktivasi->fetch_array();
		$aktiv=$aktivasi->num_rows;
		if($aktiv>0)
		{
			$data = $conn->query("select * from user where username='".$x['username']."'")->fetch_array();
			$_SESSION['adminUsername']=$data['username'];
			$_SESSION['nama']=$data['nama'];
			header ("location: reset_password.php");
		}
		else {
		echo "<script>window.alert('Username Atau Kode Aktivasi Salah')
    		window.location='lupa.php'</script>";
		}
	//}

?>
