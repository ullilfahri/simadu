<?php
//koneksi dan menentukan database
include '../../../sysconfig.php';

$pecah = explode('#' , $_GET['data_paginasi']);
$tabel=$_GET['tabel'];
if (!empty($_GET['awal']) && !empty($_GET['akhir'])) {
$awal=$_GET['awal'];
$akhir=$_GET['akhir'];
$kriteria = "AND tgl_approve between '$awal' and '$akhir'";
} else {
$kriteria ='';
}


?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagination dengan PHP</title>

    <!-- Load File bootstrap.min.css yang ada difolder css -->
    <link href="<?=PLG?>bootstrap\css/bootstrap.min.css" rel="stylesheet">
    <style>
    .align-middle{
      vertical-align: middle !important;
    }
    </style>
  </head>
  <body>
    
    <div style="padding: 0 15px;">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th>No</th>
            <th>Tgl Approve</th>
            <th>Jumlah</th>
            <th>Item Pengeluaran</th>
            <th>Status Kas</th>
          </tr>
          <?php
          // Cek apakah terdapat data page pada URL
          $page = (isset($_GET['page']))? $_GET['page'] : 1;
          
          $limit = 10; // Jumlah data per halamannya
          
          // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
          $limit_start = ($page - 1) * $limit;
		  
			if ($pecah[0]=='distributor') {
				$sql = $conn->query("SELECT * FROM $tabel where jenis=2 AND distributor = '".$pecah[1]."' $kriteria LIMIT ".$limit_start.",".$limit);
				} else if ($pecah[0]=='kasir') {
				$sql = $conn->query("SELECT * FROM $tabel where jenis=2 AND id_toko = '".$pecah[1]."' $kriteria LIMIT ".$limit_start.",".$limit);
				} else {
				$sql = $conn->query("SELECT * FROM $tabel where jenis=2 $kriteria LIMIT ".$limit_start.",".$limit);
			}
                  
          $no = $limit_start + 1; // Untuk penomoran tabel
          while($data = $sql->fetch_array()){ // Ambil semua data dari hasil eksekusi $sql
		  if ($tabel=='konfirmasi_bank') {
		  $bank=$conn->query("select bank from rekening_bank where id = '".$data['id_bank']."'")->fetch_array();
		  $status=$bank[0];
		  } else {
		  $status='Cash In Hand';
		  }
          ?>
            <tr>
              <td class="align-middle text-center"><?php echo $no; ?></td>
              <td class="align-middle"><?php echo date_format(date_create_from_format('Y-m-d H:i:s', $data['tgl_approve']), 'd-m-Y'); ?></td>
              <td class="align-middle"><?php echo angka($data['jumlah_bayar']); ?></td>
              <td class="align-middle"><?php echo ucwords(strtolower($data['keterangan'])); ?></td>
              <td class="align-middle"><?=$status?></td>
            </tr>
          <?php
            $no++; // Tambah 1 setiap kali looping
          }
          ?>
        </table>
      </div>
      
      <!--
      -- Buat Paginationnya
      -- Dengan bootstrap, kita jadi dimudahkan untuk membuat tombol-tombol pagination dengan design yang bagus tentunya
      -->
      <ul class="pagination">
        <!-- LINK FIRST AND PREV -->
        <?php
        if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
        ?>
          <li class="disabled"><a href="#">First</a></li>
          <li class="disabled"><a href="#">&laquo;</a></li>
        <?php
        }else{ // Jika page bukan page ke 1
          $link_prev = ($page > 1)? $page - 1 : 1;
        ?>
          <li><a href="<?=$_SERVER['REQUEST_URI']?>&page=1">First</a></li>
          <li><a href="<?=$_SERVER['REQUEST_URI']?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
        <?php
        }
        ?>
        
        <!-- LINK NUMBER -->
        <?php
        // Buat query untuk menghitung semua jumlah data
     if ($pecah[0]=='distributor') {
        $get_jumlah = $conn->query("SELECT COUNT(*) AS jumlah FROM $tabel where jenis=2 AND distributor = '".$pecah[1]."' $kriteria")->fetch_array();
        } else if ($pecah[0]=='kasir') {
        $get_jumlah = $conn->query("SELECT COUNT(*) AS jumlah FROM $tabel where jenis=2 AND id_toko = '".$pecah[1]."' $kriteria")->fetch_array();
        } else {
        $get_jumlah = $conn->query("SELECT COUNT(*) AS jumlah FROM $tabel where jenis=2 $kriteria ")->fetch_array();
     }
        $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($page == $i)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="<?=$_SERVER['REQUEST_URI']?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
        }
        ?>
        
        <!-- LINK NEXT AND LAST -->
        <?php
        // Jika page sama dengan jumlah page, maka disable link NEXT nya
        // Artinya page tersebut adalah page terakhir 
        if($page == $jumlah_page){ // Jika page terakhir
        ?>
          <li class="disabled"><a href="#">&raquo;</a></li>
          <li class="disabled"><a href="#">Last</a></li>
        <?php
        }else{ // Jika Bukan page terakhir
          $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
        ?>
          <li><a href="<?=$_SERVER['REQUEST_URI']?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
          <li><a href="<?=$_SERVER['REQUEST_URI']?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
        <?php
        }
        ?>
      </ul>
    </div>
  </body>
</html>