

<br>
<br>
<hr>
<div class="alert alert-info">Anda Akan melakukan Update Stok Awal Pada Gudang <?php echo $ts["nama"] ?> Pada Tanggal <?php echo $ts["tanggal"]  ?> Dengan Kode Barang <?php echo $ts["kode_barang"] ?> , Jumlah Stok Awal Sebelumnya = <?php echo $ts["stok"] ?> </div>


<form method="post" action="">
    <input type="text" name="stokupdate" value="<?php echo $ts["stok"] ?>">
    <input type="hidden" name="id" value="<?php echo $ts["id_stok_awal"] ?>">
    <input class="btn btn-info" type="submit" name="simpan" value="Update Stok">
</form>

<?php
if(isset($_POST["simpan"])) {
$stokk = mysqli_real_escape_string($conn,$_POST["stokupdate"]) ;
$id = mysqli_real_escape_string($conn,$_POST["id"]) ;

mysqli_query($conn,"UPDATE `stok_awal` SET `stok` = '$stokk' WHERE `stok_awal`.`id_stok_awal` = $id") ;

echo "<script>alert('Stok Awal Berhasil Di Update')</script>" ;
echo "<script>window.location='perbaikan.php'</script>" ;

}

?>