<!DOCTYPE html>
<html>
<head>
    <title>SIMPADA | 2.2</title>
    <!-- Bootstrap Core Css -->
    <link href="../../../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../../../../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../../../../css/style.css" rel="stylesheet">
</head>
<body>
	<center>		
		<h1>INFORMASI USSD</h1>	
	</center>
	<!--<div class="loader">Loading..</div>	-->	

	<!--<div class="loader2">Loading..</div>-->

	<!--<div class="loader3">Loading..</div>-->
<?php
require "../../dir.php";
function decode_string($str){
    //split the reply in chunks of 4 characters (each 4 character is hex encoded), use | as separator
    $str = str_replace(" ", "", $str); // remove normal space, you might have better ways of doing this
    $chunk = chunk_split($str, 4, '|');
    $coded_array = explode('|', $chunk);
    $n = count($coded_array);
    $decoded = '';
    for($i = 0; $i < $n; $i++){
        $decoded .= chr(hexdec($coded_array[$i]));
    }
    return $decoded;
}


if ($_GET['enkripsi']==1){	
// jalankan perintah cek pulsa via gammu
exec(SB.'bin\win\gammu '.$_GET['dev'].' getussd '.trim($_GET['command']), $hasil);
 
// proses filter hasil output
for ($i=0; $i<=count($hasil)-1; $i++)
{
   if (substr_count($hasil[$i], 'Service reply') > 0) $index = $i;
}
 
// menampilkan sisa pulsa
$tampil= $hasil[$index];
if (preg_match('/Service reply/',$tampil)) {$kata=$tampil;} else {$kata="Kode USSD ".$_GET['command']." sedang error..! <a href='dir.php?ulang&enkripsi=".$_GET['enkripsi']."&dev=".$_GET['dev']."&command=".$_GET['command']."'><button class='btn btn-success'>Kirim Ulang</button></a>";}
if (strlen($kata)>300) {
	$pecah = explode('"',$tampil);
	$kalimat=decode_string($pecah[1]);
echo '<div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="defaultModalLabel">INFORMASI USSD</h4>
         </div>
           <div class="modal-body">
             <pre>'.$kalimat.'</pre>
			 <p>
			 <form class="form-horizontal form-label-left input_mask" method="get" action="dir.php" autocomplete="off">
	  		 <input type="hidden" name="dev" value='.$_GET['dev'].'>
	  		 <input type="hidden" name="command1" value='.$_GET['command'].'>
	  		 <input type="hidden" name="enkripsi" value='.$_GET['enkripsi'].'>
	  		 <input type="text" name="command2" class="form-control has-feedback-left" placeholder="Masukan Balasan" required>
	  		 <button type="submit" name="kirim2"  class="btn btn-info">KIRIM</button>
	  		 </form>
			 </p>
            </div>
            <div class="modal-footer">
            <a href="../../kode_ussd.php?bLdeWt&CmRwxxS"><button class="btn btn-success">TUTUP</button></a>
            </div>
          </div>
        </div>';
	
	} else {
echo '<div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="defaultModalLabel">INFORMASI USSD</h4>
         </div>
           <div class="modal-body">
             <pre>'.$kata.'</pre>
			 <p>
			 <form class="form-horizontal form-label-left input_mask" method="get" action="dir.php" autocomplete="off">
	  		 <input type="hidden" name="dev" value='.$_GET['dev'].'>
	  		 <input type="hidden" name="command1" value='.$_GET['command'].'>
	  		 <input type="hidden" name="enkripsi" value='.$_GET['enkripsi'].'>
	  		 <input type="text" name="command2" class="form-control has-feedback-left" placeholder="Masukan Balasan" required>
	  		 <button type="submit" name="kirim2"  class="btn btn-info">KIRIM</button>
	  		 </form>
			 </p>
            </div>
            <div class="modal-footer">
            <a href="../../kode_ussd.php?bLdeWt&CmRwxxS"><button class="btn btn-success">TUTUP</button></a>
            </div>
          </div>
        </div>';
	
	}

} else {?>

<div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="defaultModalLabel">INFORMASI USSD</h4>
         </div>
           <div class="modal-body">
             <pre><?php passthru(SB.'bin\win\gammu '.$_GET['dev'].' getussd '.trim($_GET['command']));?></pre>
			 <p>
			 <form class="form-horizontal form-label-left input_mask" method="get" action="dir.php" autocomplete="off">
	  		 <input type="hidden" name="dev" value="<?php echo $_GET['dev']?>">
	  		 <input type="hidden" name="command1" value="<?php echo $_GET['command'];?>">
	  		 <input type="hidden" name="enkripsi" value="<?php echo $_GET['enkripsi'];?>">
	  		 <input type="text" name="command2" class="form-control has-feedback-left" placeholder="Masukan Balasan" required>
	  		 <button type="submit" name="kirim2"  class="btn btn-info">KIRIM</button>
	  		 </form>
			 </p>
            </div>
            <div class="modal-footer">
            <a href="../../kode_ussd.php?bLdeWt&CmRwxxS"><button class="btn btn-success">TUTUP</button></a>
            </div>
          </div>
        </div>

<?php }	?>
            <!-- Default Size -->
</body>
</html>

 		