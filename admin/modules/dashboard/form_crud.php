<?php
include '../../../sysconfig.php';

if (isset($_GET['profil'])) :
$id = $_POST['rowid'];
$user=$conn->query("select * from user where id='$id'")->fetch_array();
?>

                            <form method="post" action="form_crud.php" id="sign_up" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?=$id?>" />
                            <input type="hidden" name="ubah_profil"/>
                            
                            <label for="email_address">Username</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="username" class="form-control" value="<?=$user['username']?>" required>
                                    </div>
                                </div>
                                
                            <label for="email_address">Nama</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="nama" class="form-control" value="<?=$user['nama']?>" required/>
                                    </div>
                                </div>
                                
                                
                            <label for="email_address">Password (Abaikan jika tidak melakukan Perubahan Password)</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" minlength="5" placeholder="Password">
                                    </div>
                                </div>

                            
                            <label for="email_address">Konfirmasi Password</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password2" minlength="5" placeholder="Konfirmasi Password">
                                    </div>
                                </div>
                                
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning waves-effect">UPDATE</button>
                            <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                           </form>


<?php
endif;


if (isset($_POST['ganti_foto'])) :
$id=$_POST['id'];
$gambar_lama=$_POST['gambar_lama'];
$nama_baru=strtotime(date('Y-m-d H:i:s')).'-'.$_POST['nama'].'-';

$file = $_FILES['gambar']['name'];
$nama_file=$nama_baru.$file;
$ukuran_file = $_FILES['gambar']['size'];
$tipe_file = $_FILES['gambar']['type'];
$tmp_file = $_FILES['gambar']['tmp_name'];

$path = "images/".$nama_file;

if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){ 
  if($ukuran_file <= 1000000){ 
    if(move_uploaded_file($tmp_file, $path)){ 
      $sql = $conn->query("update user set img='$nama_file' where id='$id'");
      
      if($sql){
	  	unlink($gambar_lama);
        echo "<script>window.alert('Foto Diupdate') 
		window.location='profil.php'</script>";
		if (isset($_GET['dari_klien'])) :
        echo "<script>window.alert('Foto Diupdate') 
		window.location='http://127.0.0.1:9999/siako/admin/modules/dashboard/profil.php'</script>";
		endif;
		
      }else{
        echo "<script>window.alert('Foto Gagal Diupdate') 
		window.location='profil.php'</script>";
		if (isset($_GET['dari_klien'])) :
        echo "<script>window.alert('Foto Gagal Diupdate') 
		window.location='http://127.0.0.1:9999/siako/admin/modules/dashboard/profil.php'</script>";
		endif;
      }
    }else{
        echo "<script>window.alert('Foto Gagal Diupdate') 
		window.location='profil.php'</script>";
		if (isset($_GET['dari_klien'])) :
        echo "<script>window.alert('Foto Gagal Diupdate') 
		window.location='http://127.0.0.1:9999/siako/admin/modules/dashboard/profil.php'</script>";
		endif;
    }
  }else{
        echo "<script>window.alert('Ukuran Terlalu Besar') 
		window.location='profil.php'</script>";
		if (isset($_GET['dari_klien'])) :
        echo "<script>window.alert('Ukuran Terlalu Besar') 
		window.location='http://127.0.0.1:9999/siako/admin/modules/dashboard/profil.php'</script>";
		endif;
  }
}else{
        echo "<script>window.alert('Hanya JPG atau PNG yang diperbolehkan') 
		window.location='profil.php'</script>";
		if (isset($_GET['dari_klien'])) :
        echo "<script>window.alert('Hanya JPG atau PNG yang diperbolehkan') 
		window.location='http://127.0.0.1:9999/siako/admin/modules/dashboard/profil.php'</script>";
		endif;
}

endif;

if (isset($_POST['ubah_profil'])) :
$nama = $_POST['nama'];
$username = $_POST['username'];
$id = $_POST['id'];

	if (!empty($_POST['password'])) {
		$password = md5($_POST['password']);
		$password2 = md5($_POST['password2']);

			if ($password != $password2) {
        		echo "<script>window.alert('konfirmasi password tidak sama') 
				window.location='profil.php'</script>";
			} else {
				$update=$conn->query("update user set nama='$nama', username='$username', password='$password' where id='$id'");
        		echo "<script>window.alert('Update Profil dan Ubah Password Berhasil') 
				window.location='profil.php'</script>";
			}
	} else {
	$update=$conn->query("update user set nama='$nama', username='$username' where id='$id'");
	echo "<script>window.alert('Update Profil Tanpa Ubah Password Berhasil') 
	window.location='profil.php'</script>";
	}
endif;

if (isset($_POST['tambah_user'])) :
if (!empty($_POST['id_gudang'])) {$id_gudang=$_POST['id_gudang']; } else {$id_gudang='';};
$username = $_POST['username'];
$nama = $_POST['nama'];
$password = md5($_POST['password']);
$hak_akses = $_POST['hak_akses'];
$pecah = explode("#",$_POST['level']);
$level=$pecah[0];
$id_level=$pecah[1];
$distributor=$pecah[2];

$tambah=$conn->query("INSERT INTO `user`(`username`, `level`, `nama`, `password`, `distributor`, `id_gudang`, `id_level`) VALUES('$username', '$level', '$nama', '$password', '$distributor', '$id_gudang', '$id_level') ");
	echo "<script>window.alert('Tambah User Baru Berhasil') 
	window.location='profil.php'</script>";

endif;

if (isset($_POST['setting'])) :

$printer   = $_POST['printer'];
$nama_toko = $_POST['nama_toko'];

$update=$conn->query("update mst_setting set printer='$printer', nama_toko='$nama_toko' where id=1");
echo "<script>window.alert('Konfigurasi Berhasil') 
	window.location='setting.php'</script>";


endif;

if (isset($_GET['tutup'])) :

echo  "<script type='text/javascript'>";
    echo "window.close();";
    echo "</script>";
endif;


if (isset($_GET['hapus_user'])) :

$id=$_GET['modal_id'];


$hapus=$conn->query("DELETE FROM `user` WHERE id='$id'");

echo "<script>window.alert('User Terhapus') 
	window.location='profil.php'</script>";


endif;

if (isset($_GET['hapus_customer'])) :

$id=$_GET['modal_id'];


$hapus=$conn->query("DELETE FROM `tabel_customer` WHERE id='$id'");

echo "<script>window.alert('Customer Terhapus') 
	window.location='customer.php'</script>";


endif;

if (isset($_GET['live_edit'])) :
$kolom=$_POST['column'];
$id=$_POST['id'];
if ($kolom=='limit_kredit') {
$value=preg_replace('/[^A-Za-z0-9\  ]/', '', $_POST['editval']);
$value = preg_replace("/[^0-9.]/", '', $value);
} else if ($kolom=='no_hp'){
$value=$_POST['editval'];
$value = str_replace(" ","",$value);
$value = str_replace(".","",$value);
$value = preg_replace("/^((\+?)0)/", "+62", $value);
} else {
$value=$_POST['editval'];
}

$update=$conn->query("update tabel_customer SET $kolom = '$value' where id = '$id'");

endif;


if (isset($_POST['tambah_customer'])) :

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$no_hp = $_POST['no_hp'];
$no_hp = str_replace(" ","",$no_hp);
$no_hp = str_replace(".","",$no_hp);
$no_hp = preg_replace("/^((\+?)0)/", "+62", $no_hp);
$limit_kredit = $_POST['limit_kredit'];
$limit_kredit=preg_replace('/[^A-Za-z0-9\  ]/', '', $limit_kredit);
$limit_kredit = preg_replace("/[^0-9.]/", '', $limit_kredit);

$masuk=$conn->query("INSERT INTO `tabel_customer`(`nama`, `alamat`, `no_hp`, `kota`, `limit_kredit`) VALUES('$nama', '$alamat', '$no_hp', '$kota', '$limit_kredit') ");

echo "<script>window.alert('Customer Ditambah') 
	window.location='customer.php'</script>";


endif;



if (isset($_GET['hapus_pesan'])) :

$id = trim($_POST['pwg_id']);

$conn->query("DELETE from kirim_pesan where id in ($id)");


echo $id;

endif;

if (isset($_GET['baca_pesan'])) :

$id = trim($_POST['pwg_id']);

$conn->query("UPDATE kirim_pesan SET is_read=1 where id in ($id)");

endif;

?>