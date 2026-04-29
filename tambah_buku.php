<?php
include 'koneksi.php';

if(isset($_POST['submit'])){

    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $stok = $_POST['stok'];

    mysqli_query($conn,"INSERT INTO buku(judul,penulis,stok)
    VALUES('$judul','$penulis','$stok')");

    header('location:buku.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">

<h1>Tambah Buku</h1>
<br>

<form method="POST">

<div class="form-group">
    <label>Judul Buku</label>
    <input type="text" name="judul" class="form-control">
</div>

<div class="form-group">
    <label>Penulis</label>
    <input type="text" name="penulis" class="form-control">
</div>

<div class="form-group">
    <label>Stok</label>
    <input type="number" name="stok" class="form-control">
</div>

<button type="submit" name="submit" class="btn btn-primary">
Simpan
</button>

</form>

</div>

</body>
</html>