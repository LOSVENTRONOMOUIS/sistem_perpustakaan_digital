<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Buku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
}

.card-box{
    border:none;
    border-radius:24px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card card-box p-4">

<h2 class="fw-bold mb-4">
Edit Buku
</h2>

<form action="update_buku.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $book['id'] ?>"
>

<div class="mb-3">

<label class="form-label">
Judul Buku
</label>

<input
type="text"
name="judul"
class="form-control rounded-4"
value="<?= $book['judul'] ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Penulis
</label>

<input
type="text"
name="penulis"
class="form-control rounded-4"
value="<?= $book['penulis'] ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Penerbit
</label>

<input
type="text"
name="penerbit"
class="form-control rounded-4"
value="<?= $book['penerbit'] ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Tahun Terbit
</label>

<input
type="number"
name="tahun"
class="form-control rounded-4"
value="<?= $book['tahun'] ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Kategori
</label>

<select
name="kategori"
class="form-control rounded-4"
required>

<?php foreach($kategori as $k){ ?>

<option
value="<?= $k['id'] ?>"

<?= ($book['kategori'] == $k['id'])
? 'selected'
: '' ?>>

<?= $k['nama_kategori'] ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">
Stok
</label>

<input
type="number"
name="stok"
class="form-control rounded-4"
value="<?= $book['stok'] ?>"
required>

</div>

<div class="d-flex gap-2">

<button
type="submit"
class="btn btn-primary rounded-4">

Update Buku

</button>

<a
href="buku.php"
class="btn btn-secondary rounded-4">

Kembali

</a>

</div>

</form>

</div>

</div>

</body>
</html>