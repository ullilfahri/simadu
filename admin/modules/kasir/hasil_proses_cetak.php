<?php
$nama_dir = 'C://print_siako';

if(!is_dir($nama_dir)):
    mkdir($nama_dir, 0755);
	$file = 'http://'.$_SERVER['HTTP_HOST'].'/SIAKO\admin\modules\kasir\print\DOSPrinter.exe';
	$newfile = $nama_dir.'/DOSPrinter.exe';
	copy($file, $newfile);
	$file2 = 'http://'.$_SERVER['HTTP_HOST'].'/SIAKO\admin\modules\kasir\print\Language.ini';
	$newfile2 = $nama_dir.'/Language.ini';
	copy($file2, $newfile2);

endif;


include '../../../sysconfig.php';
$no_faktur=$_GET['no_faktur'];
$id_gudang=$_GET['id_gudang'];
$distributor=$_GET['distributor'];
$data=$conn->query("select a.total, b.nama, a.customer, a.cus_umum from tabel_faktur as a left join user as b on a.kasir=b.id where a.no_faktur='$no_faktur'")->fetch_array();
$gudang=$conn->query("select nama from lokasi where id_lokasi='$id_gudang'")->fetch_array();

if ($data[2] > 0) {
$customer=$conn->query("select * from tabel_customer where id='".$data[2]."'")->fetch_array();
$nama_customer=$customer['nama'];
$alamat_customer=$customer['alamat'];
$kota_customer=$customer['kota'];
$hp_customer=$customer['no_hp'];
} else if ($data[2] == 0 && $data[3] !='' ) {
$arr = json_decode($data[3], true);
$nama_customer=$arr["umum"]["nama"];
$alamat_customer=$arr["umum"]["alamat"];
$kota_customer=$arr["umum"]["kota"];
$hp_customer=$arr["umum"]["hp"];
} else {
$nama_customer='';
$alamat_customer='';
$kota_customer='';
$hp_customer='';
}

// # STart Looping


$namafile = $nama_dir."/surat_jalan.prn"; 
@unlink(nama_dir."/surat_jalan.prn");
$handle = fopen ($namafile, "w"); 

$string  = "                                   SURAT JALAN
";
$string .= "No. Invoice : ".$no_faktur."
";
$string .= "Tanggal     : ".tanggal_indo(date('Y-m-d', $no_faktur))."
";
$string .= "-------------------------------------------------------------------------------
";

$string .= "Kepada Yth.
";
$string .= "
";
$string .= "Nama            : ".$nama_customer."
";
$string .= "Alamat          : ".$alamat_customer." ".$kota_customer."
";
$string .= "No. Telp/Fax/Hp : ".$hp_customer."
";
$string .= "
";
$string .= "-------------------------------------------------------------------------------
";
$string .= " NO          KODE                         NAMA BARANG                  QTY
";
$string .= "-------------------------------------------------------------------------------
";

ob_start();
$tbl = "";

$data=$conn->query("select kode_barang, nama_barang, SUM(jumlah), satuan  from tabel_trx where no_faktur='$no_faktur' and distributor='$distributor' AND id_gudang='$id_gudang' GROUP BY kode_barang DESC");
$ny=1;
$baris1='    ';
$baris2='                    ';
$baris3='                                        ';
$baris4='            ';

while ($y=$data->fetch_array()) :

$kata1=' '.$ny;
$kata2=' '.$y[0];
$kata3=' '.$y[1];
$kata4=' '.$y[2].' '.$y[3];

$jml_1=strlen($kata1);
$jml_2=strlen($kata2);
$jml_3=strlen($kata3);
$jml_4=strlen($kata4);

$potong1 = $kata1.substr($baris1, $jml_1).' ';
$potong2 = $kata2.substr($baris2, $jml_2).' ';
$potong3 = $kata3.substr($baris3, $jml_3).' ';
$potong4 = $kata4.substr($baris4, $jml_4);

$tbl .= $potong1.$potong2.$potong3.$potong4."
";
$ny++;
endwhile;

$jml_data=$data->num_rows;

if ($jml_data==1) {
$tbl .= "
";
$tbl .= "
";
$tbl .= "
";
$tbl .= "
";
} else if ($jml_data==2) {
$tbl .= "
";
$tbl .= "
";
$tbl .= "
";
} else if ($jml_data==3) {
$tbl .= "
";
$tbl .= "
";
} else  {
$tbl .= "
";
}
echo $tbl;

$string .= ob_get_contents();
ob_end_clean();

$string .= "-------------------------------------------------------------------------------
";

$string .= "Catatan :


";
$string .="Dibuat Oleh,     Menyetujui,   Dikeluarkan,   Diperiksa,   Pengirim,   Penerima,


(__________)    (__________)   (__________)  (__________)  (________)  (_______)
    Adm            GM/AM        Ka. Gudang     Ka. Opr       Sopir      Customer
";

fwrite ($handle, $string); 
fclose($handle); 

	@unlink($nama_dir."/surat_jalan.bat");
	$run = fopen($nama_dir."/surat_jalan.bat", "w");
	$oke = 'CD '.$nama_dir.'
	';
	$oke .= 'start DOSPrinter.exe /LINES/PDF/FILE /F\'Lucida Console\' /LEFT0.5 "surat_jalan.prn"
	';
	$path=$nama_dir.'/DOSPrinter.exe';
	$dir=$nama_dir.'/';
	fwrite($run, $oke);
	fclose($run);
	
	
	shell_exec($dir.'surat_jalan.bat');   

copy($dir.'surat_jalan.PDF' , $_SERVER['DOCUMENT_ROOT']."/folder_upload/file_cetak/surat_jalan/".$_GET['no_faktur'].'-'.$_GET['distributor'].'.PDF');

$file_pdf=$_GET['no_faktur'].'-'.$_GET['distributor'].'.PDF';
 

header ("location: ../pdf_viewer/index.php?dir=surat_jalan&file=$file_pdf"); 


// # END Looping
