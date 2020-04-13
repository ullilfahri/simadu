
<?php
$tanggal = mysqli_real_escape_string($conn,$_GET["tanggal"]) ;
$kode_barang = mysqli_real_escape_string($conn,$_GET["kode_barang"]) ;
$id_gudang = mysqli_real_escape_string($conn,$_GET["gudang"]) ;

$qgd = mysqli_query($conn,"SELECT * FROM `lokasi` WHERE `id_lokasi` = '$id_gudang' ORDER BY `nama` DESC ") ;

$tgudang = mysqli_fetch_array($qgd) ;
$nama_gudang = $tgudang["nama"] ;
 
?>

<br>
<br>
<hr>
<div class="alert alert-danger">Stok Awal Pada Tanggal  <?php echo $tanggal ?> Pada Gudang <?php echo $nama_gudang ?> Dengan Kode Barang <?php echo $kode_barang ?> Belum Pernah Melakukan Input Stok Awal </div>


<form method="post" action="">
    <input type="text" name="stokupdate" value="0">
    
    <input type="hidden" name="tanggal" value="<?php echo $tanggal ?>">

    <input type="hidden" name="id_gudang" value="<?php echo $id_gudang ?>">

    <input type="hidden" name="kode_barang" value="<?php echo $kode_barang ?>">

    <input class="btn btn-info" type="submit" name="simpan" value="Update Stok">
</form>

<?php
if(isset($_POST["simpan"])) {
$stokk = mysqli_real_escape_string($conn,$_POST["stokupdate"]) ;
$tanggalx = mysqli_real_escape_string($conn,$_POST["tanggal"]) ;
$id_gudangx = mysqli_real_escape_string($conn,$_POST["id_gudang"]) ;
$kode_barangx = mysqli_real_escape_string($conn,$_POST["kode_barang"]) ;

mysqli_query($conn,"INSERT INTO `stok_awal` (`id_stok_awal`, `tanggal`, `kode_barang`, `id_gudang`, `stok`) VALUES (NULL, '$tanggalx', '$kode_barangx', '$id_gudangx', '$stokk');") ;

echo "<script>alert('Stok Awal Berhasil Di Tambahkan')</script>" ;
echo "<script>window.location='perbaikan.php'</script>" ;

}

?>