<?php
require 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "
DELETE FROM kategori 
WHERE id='$id'
");

echo "<script>
alert('Kategori berhasil dihapus!');
window.location='kategori.php';
</script>";
