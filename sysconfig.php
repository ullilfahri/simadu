<?php
error_reporting(0) ;
date_default_timezone_set("Asia/Jakarta");
$tgl_now=strtotime(date('Y-m-d H:i:s'));
$tgl_exp=strtotime(date('2030-11-26 00:00:00'));
if ($tgl_now > $tgl_exp ){
  echo '<script>
  window.location.href="../login/lupa.php"
  </script>';
} else {

define('DS', DIRECTORY_SEPARATOR);
define('DOT', '../../..'.DS);
define('LIB', DOT.'lib'.DS);
define('CSS', DOT.'css'.DS);
define('JS', DOT.'js'.DS);
define('PRT', DOT.'partial'.DS);
define('PLG', DOT.'plugins'.DS);
define('SCCS', DOT.'scss'.DS);
define('ADM', DOT.'admin'.DS);
define('MDL', ADM.'modules'.DS);
define('SB', realpath(dirname(__FILE__)).DS.'admin'.DS.'modules'.DS.'sms_gateway'.DS);
define('MTR', ADM.'master_data'.DS);
define('HOST', 'localhost');





	$servername = 'localhost';
	$username = "root";
	$password = "";
	$dbname = "siako2";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$dbs = new mysqli($servername, $username, $password, $dbname);
	$pdo = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if ($dbs->connect_error) {
		die("Connection failed: " . $dbs->connect_error);
	}

function tanggal_indo($tanggal)
{
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

$hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");

function Terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . " belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}

function romawi($tanggal)
{
	$bulan = array (1 =>   'I',
				'II',
				'III',
				'IV',
				'V',
				'VI',
				'VII',
				'VIII',
				'IX',
				'X',
				'XI',
				'XII'
			);
	$split = explode('-', $tanggal);
	return $bulan[ (int)$split[1] ];
}

function bulan($tanggal)
{
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $bulan[ (int)$split[1] ];
}

function rupiah($angka){

	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}

function angka($angka){

	$hasil_rupiah =  number_format($angka,0,',','.');
	return $hasil_rupiah;

}

function acak($panjang)
{
    $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
  $pos = rand(0, strlen($karakter)-1);
  $string .= $karakter{$pos};
    }
    return $string;
}

function limit_words($string, $word_limit){
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}


function time_since($original)
{
  $chunks = array(
      array(60 * 60 * 24 * 365, 'tahun'),
      array(60 * 60 * 24 * 30, 'bulan'),
      array(60 * 60 * 24 * 7, 'minggu'),
      array(60 * 60 * 24, 'hari'),
      array(60 * 60, 'jam'),
      array(60, 'menit'),
  );
  $today = time();
  $since = $today - $original;

  if ($since > 604800)
  {
    $print = date("M jS", $original);
    if ($since > 31536000)
    {
      $print .= ", " . date("Y", $original);
    }
    return $print;
  }

  for ($i = 0, $j = count($chunks); $i < $j; $i++)
  {
    $seconds = $chunks[$i][0];
    $name = $chunks[$i][1];

    if (($count = floor($since / $seconds)) != 0)
      break;
  }

  $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
  return $print . ' yang lalu';
}

function umur($birthdate) {
    list($year,$month,$day) = explode("-",$birthdate);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($month_diff < 0) $year_diff--;
        elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
    return $year_diff;
}


function surat_jalan($n){
$hasil = "";
$isurat_jalan = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
if(array_key_exists($n,$isurat_jalan)){
$hasil = $isurat_jalan[$n];
}elseif($n >= 11 && $n <= 99){
$i = $n % 10;
$hasil = $isurat_jalan[$n-$i] . surat_jalan($n % 10);
}elseif($n >= 101 && $n <= 999){
$i = $n % 100;
$hasil = $isurat_jalan[$n-$i] . surat_jalan($n % 100);
}else{
$i = $n % 1000;
$hasil = $isurat_jalan[$n-$i] . surat_jalan($n % 1000);
}
return $hasil;
}

function lama_kerja($tgl_lahir){
$tgl=explode("-",$tgl_lahir);
$cek_jmlhr1=cal_days_in_month(CAL_GREGORIAN,$tgl['1'],$tgl['2']);
$cek_jmlhr2=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
$sshari=$cek_jmlhr1-$tgl['0'];
$ssbln=12-$tgl['1']-1;
$hari=0;
$bulan=0;
$tahun=0;

if($sshari+date('d')>=$cek_jmlhr2){
$bulan=1;
$hari=$sshari+date('d')-$cek_jmlhr2;
}else{
$hari=$sshari+date('d');
}
if($ssbln+date('m')+$bulan>=12){
$bulan=($ssbln+date('m')+$bulan)-12;
$tahun=date('Y')-$tgl['2'];
}else{
$bulan=($ssbln+date('m')+$bulan);
$tahun=(date('Y')-$tgl['2'])-1;
}

$selisih=$tahun." Tahun ".$bulan." Bulan ".$hari." Hari";
return $selisih;
}


}
