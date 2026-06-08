<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn,"SELECT * FROM buku WHERE id='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['submit'])){

    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $stok = $_POST['stok'];

    mysqli_query($conn,"UPDATE buku SET
    judul='$judul',
    penulis='$penulis',
    stok='$stok'
    WHERE id='$id'");

    header('location:buku.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">

<h1>Edit Buku</h1>
<br>

<form method="POST">

<div class="form-group">
    <label>Judul Buku</label>
    <input type="text" name="judul" value="<?= $d['judul'] ?>" class="form-control">
</div>

<div class="form-group">
    <label>Penulis</label>
    <input type="text" name="penulis" value="<?= $d['penulis'] ?>" class="form-control">
</div>

<div class="form-group">
    <label>Stok</label>
    <input type="number" name="stok" value="<?= $d['stok'] ?>" class="form-control">
</div>

<button type="submit" name="submit" class="btn btn-primary">
Update
</button>

</form>

</div>

</body>
</html>