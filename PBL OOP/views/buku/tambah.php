<?php
// debug
// print_r($kategori);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Buku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
}

.form-box{
    max-width:650px;
    margin:50px auto;
    background:white;
    padding:35px;
    border-radius:24px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

</style>

</head>

<body>

<div class="container">

<div class="form-box">

<h2 class="fw-bold mb-4">
Tambah Buku
</h2>

<form action="store_buku.php" method="POST">

<!-- JUDUL -->
<div class="mb-3">

<label class="form-label">
Judul Buku
</label>

<input
type="text"
name="judul"
class="form-control rounded-4"
required>

</div>

<!-- PENULIS -->
<div class="mb-3">

<label class="form-label">
Penulis
</label>

<input
type="text"
name="penulis"
class="form-control rounded-4"
required>

</div>

<!-- PENERBIT -->
<div class="mb-3">

<label class="form-label">
Penerbit
</label>

<input
type="text"
name="penerbit"
class="form-control rounded-4"
required>

</div>

<!-- TAHUN -->
<div class="mb-3">

<label class="form-label">
Tahun Terbit
</label>

<input
type="number"
name="tahun"
class="form-control rounded-4"
required>

</div>

<!-- KATEGORI -->
<div class="mb-3">

<label class="form-label">
Kategori
</label>

<select
name="kategori"
class="form-control rounded-4"
required>

<option value="">
-- Pilih Kategori --
</option>

<?php foreach($kategori as $k){ ?>

<?php print_r($k); ?>

<option value="<?= $k['id'] ?>">

<?= $k['nama_kategori'] ?>

</option>

<?php } ?>

</select>

</div>

<!-- STOK -->
<div class="mb-3">

<label class="form-label">
Stok Buku
</label>

<input
type="number"
name="stok"
class="form-control rounded-4"
required>

</div>

<!-- BUTTON -->
<div class="d-flex gap-2">

<a href="buku.php"
class="btn btn-secondary rounded-4">

Kembali

</a>

<button
type="submit"
class="btn btn-primary rounded-4">

Simpan Buku

</button>

</div>

</form>

</div>

</div>

</body>
</html>