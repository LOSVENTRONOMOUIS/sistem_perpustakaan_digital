<?php
require 'koneksi.php';

$id = $_GET['id'];

/* ================= UPDATE ================= */
if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    // CEK DUPLIKAT (KECUALI DIRI SENDIRI)
    $cek = mysqli_query($conn,"
    SELECT * FROM kategori 
    WHERE nama_kategori='$nama' AND id!='$id'
    ");

    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Kategori sudah ada!');</script>";
    }else{
        mysqli_query($conn,"
        UPDATE kategori 
        SET nama_kategori='$nama'
        WHERE id='$id'
        ");

        echo "<script>
        alert('Berhasil update kategori');
        window.location='kategori.php';
        </script>";
    }
}

$data = mysqli_fetch_array(mysqli_query($conn,"
SELECT * FROM kategori WHERE id='$id'
"));
?>

<form method="POST">
    <input type="text" name="nama" value="<?= $data['nama_kategori'] ?>" required>
    <button type="submit" name="update">Update</button>
</form>
