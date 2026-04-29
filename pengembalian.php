<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn,"SELECT * FROM peminjaman WHERE id='$id'");
$d = mysqli_fetch_array($data);

$buku = $d['buku_id'];

mysqli_query($conn,"UPDATE peminjaman SET status='dikembalikan' WHERE id='$id'");

mysqli_query($conn,"UPDATE buku SET stok = stok + 1 WHERE id='$buku'");

header('location:peminjaman.php');
?>