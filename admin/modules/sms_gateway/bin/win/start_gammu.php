<?php //###### DEKLARASI MODEM ######
include '../../../../../sysconfig.php';

if(@isset($_POST['mati'])){
		$kel=array();
        exec(SB.'bin\win\gammu-smsd -c smsdrc -k -n '.$_POST['mati'].'',$ret,$ker);
		exec(SB.'bin\win\gammu-smsd -n '.$_POST['mati'].' -u');
        //echo "<center>" . $ret."</center>";
		switch($ker){
		case 0:
		echo "<script>window.alert('Service ".$_POST['mati']." Dimatikan...!')
    		window.location='../../index.php?JmnHTE'</script>";
		break;
		case 1:
		echo "<script>window.alert('".$_POST['mati']." ERROR...!')
    		window.location='../../index.php?JmnHTE'</script>";
		break;
		case 2:
		echo "<script>window.alert('".$_POST['mati']." Tidak Terhubung...!')
    		window.location='../../index.php?JmnHTE'</script>";
		break;
		}       
	}
if(@isset($_POST['hidup'])){
        $kel=array();
        exec(SB.'bin\win\gammu-smsd -i -c smsdrc -n '.$_POST['hidup'].'',$kel,$ker);
		exec(SB.'bin\win\gammu-smsd -s -c smsdrc -n '.$_POST['hidup'].'');
        //echo "<center>" . $ret."</center>";
		switch($ker){
		case 0:
		echo "<script>window.alert('Service ".$_POST['hidup']." Dijalankan...!')
    		window.location='../../index.php?JmnHTE'</script>";
		break;
		case 1:
		echo "<script>window.alert('".$_POST['hidup']." Error...!')
    		window.location='../../index.php?JmnHTE'</script>";
		break;
		case 2:
		echo "<script>window.alert('".$_POST['hidup']." Tidak Terhubung...!')
    		window.location='../../index.php?JmnHTE'</script>";
		break;
		}       
    }
	

?>    
