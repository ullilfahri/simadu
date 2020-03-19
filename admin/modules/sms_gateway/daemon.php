<?php
define('SF', $_SERVER['SCRIPT_FILENAME']);
$kunci = array(0=>"DAFTAR","PINDAH","SUARA");
//echo $kunci[0];
include 'D:/SIMPADA_BARU/root/simpada_kpu/partial/simpada_kpu_db.php';
function hapus_simbol($result) {
$result = strtolower($result);
    $result = str_replace("kertamulya", "KERTAMULIA", $result);
    $result = str_replace("kartamulya", "KERTAMULIA", $result);
    $result = str_replace("kartamulia", "KERTAMULIA", $result);
	$result = str_replace("kertamuliya", "KERTAMULIA", $result);
	$result = str_replace("kartamuliya", "KERTAMULIA", $result);
	$result = str_replace("p nibung", "PULAUNIBUNG", $result);
	$result = str_replace("p. nibung", "PULAUNIBUNG", $result);
	$result = str_replace("p.nibung", "PULAUNIBUNG", $result);
	$result = str_replace("p.muntai", "PANGKALANMUNTAI", $result);
	$result = str_replace("p. muntai", "PANGKALANMUNTAI", $result);
	$result = str_replace("p muntai", "PANGKALANMUNTAI", $result);
	$result = str_replace("pudu rundun", "PUDU", $result);
	$result = str_replace("pudurundun", "PUDU", $result);
	$result = str_replace("sei", "sungai", $result);
    $result = str_replace(" ", "", $result);
	$result = preg_replace('/[^A-Za-z0-9\-]/','', $result);
	$result = trim($result);
    return $result;
}

/*date_default_timezone_set("Asia/Jakarta");
$conn = new mysqli('localhost','root','pilkada','simpada_kpu');
$dbs = new mysqli('localhost','root','pilkada','simpada_kpu');*/
$hasil = $conn->query("SELECT * FROM inbox WHERE Processed = 'false'");
while($data = $hasil->fetch_array()){
	$msg = strtoupper($data['TextDecoded']);
	$msg = str_replace(" ","",$msg);
	$msg = str_replace(".","",$msg);
	$tgl_terima=$data['ReceivingDateTime'];
    if (strpos($msg,"#")>0) {
		$pecah = explode("#",$msg);
		$mentah = explode("#",strtoupper($data['TextDecoded']));
		} else {
			$pecah="Reguler";
			}
	$key=$conn->query("select * from mst_setting where keyword='".$pecah[0]."'")->fetch_array();
	$nik=preg_replace('/\s+/', ' ',$pecah[1]);
	$nik = trim($nik);
	$sql2=$conn->query("select * from tabel_pemilih as tp left join tabel_tps as tt on tp.id_tps=tt.id_tps
	                    left join tabel_desa as td on tp.id_desa=td.id_desa where tp.nik_ktp='$nik'");
	$valid_tps=$sql2->num_rows;
	$data_tps=$sql2->fetch_array();
	$kpps=$conn->query("select COUNT(no_hp), id_kecamatan, id_desa from tabel_pps where no_hp='".$data['SenderNumber']."'")->fetch_array();
	$modem=$conn->query("select * from mst_setting where id='11'")->fetch_array();
	if ($modem['set']==1) {
		$sender=$modem['keterangan'];
		} elseif ($modem['set']==2){
		  	switch ($data['SMSCNumber']) {
			case '+6281100000':
			$sender='Modem_1';
			break;
			case '+62816124':
			$sender='Modem_2';
			break;
			default:
			$sender='Modem_3';
			break;
			}	
			/*if ( $data['SMSCNumber'] == '+6281100000') {$sender='Modem_1';}
			elseif ( preg_match("/+62815/i", $data['SenderNumber']) || preg_match("/+62816/i", $data['SenderNumber']) || preg_match("/+62858/i", $data['SenderNumber']) 
				|| preg_match("/+62856/i", $data['SenderNumber']) || preg_match("/+62857/i", $data['SenderNumber']) ) {$sender='Modem_2';}
			else {$sender='Modem_3';}*/		 
		} else {
		$sender=$data['RecipientID'];
		}
	//Amun SMS TIDAK ADA FORMAT
	if ($pecah=='Reguler' || $data['SenderNumber']=="TELKOMSEL" || $data['SenderNumber']=="INDOSAT"  || strlen($data['SenderNumber'])<5) {
	$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', 'SMS Reguler', '".$tgl_terima."')");
	$delete = $conn->query("delete from inbox WHERE ID = '".$data['ID']."'");
	//Amun fitur kada aktif
	} else if ($key['set']=="0") {
	    $cek="Format SMS Tidak Diaktifkan";
		$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
		$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  'SIMPADA')");
		$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");
		
		//Amun fitur aktif & kunci TPS berlaku untuk semua orang
		} else if ($key['set']=="1" && $pecah[0]=="TPS") {
			//amun balum terdaftar
			if ($valid_tps==0) {
				$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
    			$cek='Anda tidak Terdaftar sebagai Pemilih, Silahkan hubungi Petugas PPS atau regristrasi dengan format SMS : DAFTAR#NIK#NAMA LENGKAP#ALAMAT#DESA/KELURAHAN';
				$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  						VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
										'".$sender."', 'SIMPADA')");
				$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");						

				  //Amun Ganda					
				  } elseif ($valid_tps>1) {
				    $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
				    $cek='System mendeteksi anda terdaftar Ganda Silahkan hubungi Petugas PPS Setempat';
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID,
										    CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
										    '".$sender."', 'SIMPADA')");
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");				  
					//Amun udah terdaftar						
				  } else {
				    $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
				    $cek='NIK '.$data_tps['nik_ktp'].', Nama '.$data_tps['nama_pemilih'].' terdaftar di '.$data_tps['nama_desa'].' TPS '.$data_tps['nama_tps'].'';
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID,
										    CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
										    '".$sender."', 'SIMPADA')");
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");				  
											
				}	

		//Amun fitur aktif & kunci PINDAH
		} else if ($key['set']=="1" && $pecah[0]=="PINDAH" && strlen($pecah[3]) > 0) {
		    $proses=hapus_simbol($mentah[3]);
			/*$proses = trim($proses);
			$proses=substr($proses, 0,5);*/
			$sql = $conn->query("SELECT * FROM tabel_desa where alias like '%$proses%'");
			$valid_desa=$sql->num_rows;
			$data_desa=$sql->fetch_array();
			$sql3=$conn->query("select * from pemilih_pindah where nik_ktp='$nik'");
			$pernah=$sql3->num_rows;
			$data_pernah=$sql3->fetch_array();
			$waktu=date_create($data_pernah['tanggal_daftar']);
			//Amun desa bujur $ terdaftar Pemilih
			if ($valid_desa==1 && $valid_tps==true) {
				//Amun memang balum terdata di pemilih pindah
				if ($pernah==0) {
			    $cek='TPS Sebelumnya '.$data_tps['nama_desa'].' TPS '.$data_tps['nama_tps'].', Petugas PPS akan segera melakukan verifikasi. Terima Kasih';
				$tps_lama=$data_tps['nama_desa'].' TPS '.$data_tps['nama_tps'];
				$pps='NIK '.$data_tps['nik_ktp'].' Nama '.$data_tps['nama_pemilih'].' PINDAH TPS, ALAMAT '.$mentah[2].' , No HP '.$data['SenderNumber'].' Silahkan diverifikasi data tsb.';
				$pps_asal='NIK '.$data_tps['nik_ktp'].' '.$tps_lama.' Nama Pemilih '.$data_tps['nama_pemilih'].' Pindah domisi, Silahkan diverifikasi data tsb.';
				$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
				$pemilih = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  'SIMPADA')");
				$kirim_pps = $conn->query("INSERT INTO outbox (DestinationNumber,TextDecoded,SendingDateTime,SenderID,CreatorID)
											 SELECT no_hp, '".$pps."',
											 '".date("Y-m-d H:i:s")."','".$sender."','SIMPADA' FROM tabel_pps WHERE id_desa = '".$data_desa['id_desa']."'");
											 
				$kirim_pps_asal = $conn->query("INSERT INTO outbox (DestinationNumber,TextDecoded,SendingDateTime,SenderID,CreatorID)
											 SELECT no_hp, '".$pps_asal."',
											 '".date("Y-m-d H:i:s")."','".$sender."','SIMPADA' FROM tabel_pps WHERE id_desa = '".$data_tps['id_desa']."'");
				$reply='SMS Ke Pemilih :<br>'.$cek.'<br>SMS ke PPS '.$data_desa['nama_desa'].' :<br>'.$pps.'<br>SMS ke PPS '.$data_tps['nama_desa'].' :<br>'.$pps_asal;							 

				$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$reply."', '".$tgl_terima."')");	
				$pernah = $conn->query("INSERT INTO pemilih_pindah (nik_ktp, nama_pemilih, tanggal_daftar, alamat, no_hp, desa_baru, tps_lama) VALUES ('".$nik."', '".$data_tps['nama_pemilih']."', '".date("Y-m-d H:i:s")."', '".$mentah[2]."', '".$data['SenderNumber']."', '".$data_desa['nama_desa']."', '".$tps_lama."')");
				} else {
				$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
			    $cek='Anda telah meminta perpindahan TPS sebelumnya pada tanggal '.date_format($waktu, 'd-m-Y');
				$pemilih = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  'SIMPADA')");
				$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime,
										 SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."',
										  '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");
				}			  
				//AMUN DESA BUJUR TP KADA TERDAFTAR
				} else if ($valid_desa==1 && $valid_tps==0) {
				    $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
    				$cek='Anda tidak Terdaftar sebagai Pemilih, Silahkan hubungi Petugas PPS atau regristrasi dengan format SMS : DAFTAR#NIK#NAMA LENGKAP#ALAMAT#DESA/KELURAHAN';
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 'SIMPADA')");
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");				
					//AMUN DESA KADA BUJUR
					} else {
			    	$cek='Desa '.$mentah[3].' yang anda masukan salah, cek nama desa ketik DESA#NAMA KECAMATAN,mis: DESA#PERMATA KECUBUNG';
					$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, 
											CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
											 '".$sender."', 'SIMPADA')"); 
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");						 
				}							   

//MEMBUAT DAFTAR SMS
		} else if ($key['set']=="1" && $pecah[0]=="DAFTAR" && strlen($pecah[4]) > 0) {
		    /*$proses=preg_replace('/\s+/', ' ',$pecah[4]);
			$proses = trim($proses);
			$proses=substr($proses, 0,8);*/
			$proses=hapus_simbol($mentah[4]);
			$sql = $conn->query("SELECT * FROM tabel_desa where alias like '%$proses%'");
			$valid_desa=$sql->num_rows;
			$data_desa=$sql->fetch_array();
			$sql3=$conn->query("select * from pemilih_baru where nik_ktp='$nik'");
			$pernah=$sql3->num_rows;
			$data_pernah=$sql3->fetch_array();
			$waktu=date_create($data_pernah['tanggal_daftar']);
			//amun karakter kurang dari 4 dan jumlah desa lebih dari
			/*if ($valid_desa>1) {
			  $cek='Desa '.$mentah[4]." kurang spesifik, silahkan kirim ulang SMS dengan nama desa/kelurahan yang lebih spesifik";
			  $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");*/	
			//Amun desa bujur dan balum terdaftar
			if ($valid_desa==1 && $valid_tps==0) {
				// Amun Memang balum ada datanya di Pemilih Baru
				if ($pernah==0) {
			    $cek='Terima Kasih telah melakukan Regristrasi Pemilih Baru, Petugas PPS akan mendatangi anda';
				$pps='NIK '.$nik.', '.$mentah[2].', Regristrasi Pemilih Baru, ALAMAT '.$mentah[3].' No HP '.$data['SenderNumber'];
				$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
				$pemilih = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  'SIMPADA')");
				$kirim_pps = $conn->query("INSERT INTO outbox (DestinationNumber,TextDecoded,SendingDateTime,SenderID,CreatorID)
											 SELECT no_hp, '".$pps."',
											 '".date("Y-m-d H:i:s")."','".$sender."','SIMPADA' FROM tabel_pps WHERE id_desa = '".$data_desa['id_desa']."'");
				$reply='SMS Pemilih : <br>'.$cek.'<br>SMS PPS '.$data_desa['nama_desa'].'<br>'.$pps;
				$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$reply."', '".$tgl_terima."')");
				$pernah = $conn->query("INSERT INTO pemilih_baru (nik_ktp, nama_pemilih, tanggal_daftar, alamat, no_hp, nama_desa) VALUES ('".$nik."', '".$mentah[2]."', '".date("Y-m-d H:i:s")."', '".$mentah[3]."', '".$data['SenderNumber']."', '".$data_desa['nama_desa']."')");
				// Amun sudah ada datanya di Pemilih Baru
				} else {
				$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
			    $cek='Anda telah mendaftar sebelumnya pada tanggal '.date_format($waktu, 'd-m-Y');
				$pemilih = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  'SIMPADA')");
				$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime,
										 SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."',
										  '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");
				}	
				//Amun desa bujur tp udah terdaftar						  
				} else if ($valid_desa==1 && $valid_tps>0) {
				    $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
    				$cek='Anda Telah Terdaftar sebagai Pemilih di TPS '.$data_tps['nama_tps'].' '.$data_tps['nama_desa'];
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 'SIMPADA')");
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");							 
				
				//Amun Desa Kada Bujur
				} else {
			    	$cek='Desa '.$mentah[4].' yang anda masukan salah, cek nama desa ketik DESA#NAMA KECAMATAN,mis: DESA#PERMATA KECUBUNG';
					$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, 
											CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
											 '".$sender."', 'SIMPADA')");
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");						  
				}							   
//AKHIR DAFTAR SMS


//SMS NAMA DESA se kecamatan
		} else if ($key['set']=="1" && $pecah[0]=="DESA" && strlen($pecah[1]) > 0) {
		    //$proses=preg_replace('/\s+/', ' ',$pecah[1]);
			$proses = trim($mentah[1]);
			//$proses=substr($proses, 0,8);
			$sql = $conn->query("SELECT * FROM tabel_desa as td left join tabel_kecamatan as tk on td.id_kecamatan = tk.id_kecamatan where tk.nama_kecamatan like '%$proses%'");
			$valid_desa=$sql->num_rows;
			$data_desa=$sql->fetch_array();
			//Amun Nama Kecamatan bujur 
			if ($valid_desa==true) {
				foreach ($sql as $row) { //start foreach
						$decoded[] = $row['nama_desa'];
				}//end foreach
						$hasil = print_r ($decoded, true);
						$hasil = preg_replace('/[^A-Za-z\-]/', ' ', $hasil);
						$hasil = str_replace('Array', '', $hasil);
						$str = preg_replace('/\s+/', ' ',$hasil);
						$cek = trim($str);
						$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
						$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, 
											CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
											 '".$sender."', 'SIMPADA')");
						$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime,
						 							SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."',
													'".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', 
													'".$cek."', '".$tgl_terima."')");					 
				//Amun Desa Kada Bujur
				} else {
			    	$cek='Kecamatan '.$mentah[1].' yang anda masukan salah, cek nama desa ketik DESA#NAMA KECAMATAN,mis: DESA#PERMATA KECUBUNG';
					$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
					$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, 
											CreatorID) VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."',
											 '".$sender."', 'SIMPADA')");
					$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', '".$cek."', '".$tgl_terima."')");						  
				}							   
//AKHIR SMS NAMA DESA se kecamatan




		//Amun fitur aktif & kunci INFO fitur PPS saja
		} else if ($key['set']=="1" && $pecah[0]=="INFO" && $kpps[0]>0) {
		    $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
    		$cek="Kata Kunci ".$pecah[0];
			$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  'SIMPADA')");
				  
		//Amun fitur aktif & kunci Suara hanya PPS/KPPS
		} else if ($key['set']=="1" && $pecah[0]=="SUARA" && $kpps[0]>0) {
		      //amun hasil suara kada berupa anga
			  if((!preg_match("/^[\d ]+$/", $pecah[1])) || (!preg_match("/^[\d ]+$/", $pecah[2]))){
			  $cek="Format hasil suara Paslon harus berupa angka";
			  $update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
			  $insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  					VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  					'SIMPADA')");
			  } else {
			    //amun formatnya sudah OK (lain Orang Kita lah wal..!!!)
			  	$cek="Terima Kasih, perolehan Hasil Penghituang Suara adalah ".$pecah[1]." dan ".$pecah[2];
				$update = $conn->query("UPDATE inbox SET Processed = 'true' WHERE ID = '".$data['ID']."'");
				$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  					VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  					'SIMPADA')");
				//Masukan perolehan suara ke tabel hasil_hitung
				$suara=$conn->query("REPLACE into tes_hitung (date, sender, id_kecamatan, id_desa, id_tps, paslon_1,
				                       paslon_2) VALUES ('".date("Y-m-d H:i:s")."', '".$data['SenderNumber']."',
									   '".$kpps[1]."', '".$kpps[2]."', '".$kpps[3]."', '".$pecah[1]."', '".$pecah[2]."')");
				}
				
		//Amun Format Salah & kada isi pula masuk dalam banyak kriteria diatas
			} else {  
			  $cek="Maaf format SMS anda salah atau anda belum terdaftar di fasilitas ini";
			  $delete = $conn->query("delete from inbox WHERE ID = '".$data['ID']."'");
			  $insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  					VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  					'SIMPADA')");
			  $insert = $conn->query("INSERT INTO other_inbox (DestinationNumber,TextDecoded,SendingDateTime)
				  					VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."')");
			  $keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime,
						 							SenderID, keterangan, tgl_terima) VALUES ('".$data['SenderNumber']."',
													'".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', 
													'".$cek."', '".$tgl_terima."')");
			}
	} //akhir deklarasi kata kunci benar

/* } else { //deklarasi keywoard salah
   	$cek="Maaf format SMS anda salah atau anda belum terdaftar di fasilitas ini";
	$delete = $conn->query("delete from inbox WHERE ID = '".$data['ID']."'");
	$insert = $conn->query("INSERT INTO outbox (DestinationNumber, TextDecoded, SendingDateTime, SenderID, CreatorID)
				  			VALUES ('".$data['SenderNumber']."', '".$cek."', '".date("Y-m-d H:i:s")."', '".$sender."', 
				  			'SIMPADA')");
	$insert = $conn->query("INSERT INTO other_inbox (DestinationNumber,TextDecoded,SendingDateTime)
				  			VALUES ('".$data['SenderNumber']."', '".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."')");
	$keterangan = $conn->query("INSERT INTO keterangan_inbox (DestinationNumber, TextDecoded, SendingDateTime,
						 		SenderID, keterangan) VALUES ('".$data['SenderNumber']."',
								'".$data['TextDecoded']."', '".date("Y-m-d H:i:s")."', '".$sender."', 
								'".$cek."')");

}//akhirnya while perulanganya euy...	*/

?>
