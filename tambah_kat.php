<?php
require 'koneksi.php';

$nama = mysqli_real_escape_string($conn, $_POST['nama']);

// CEK DUPLIKAT
$cek = mysqli_query($conn,"
SELECT * FROM kategori WHERE nama_kategori='$nama'
");

if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Kategori sudah ada!');history.back();</script>";
}else{
    mysqli_query($conn,"
    INSERT INTO kategori (nama_kategori)
    VALUES ('$nama')
    ");

    echo "<script>
    alert('Berhasil tambah kategori');
    window.location='kategori.php';
    </script>";
}
?>
