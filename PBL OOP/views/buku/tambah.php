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
    max-width:750px;
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

<form action="../../public/store_buku.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Judul Buku
</label>

<input type="text"
name="judul"
class="form-control rounded-4"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Penulis
</label>

<input type="text"
name="penulis"
class="form-control rounded-4"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Penerbit
</label>

<input type="text"
name="penerbit"
class="form-control rounded-4"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Tahun
</label>

<input type="number"
name="tahun"
class="form-control rounded-4"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Kategori
</label>

<input type="text"
name="kategori"
class="form-control rounded-4"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Stok
</label>

<input type="number"
name="stok"
class="form-control rounded-4"
required>

</div>

<div class="col-md-12 mb-3">

<label class="form-label">
Status
</label>

<select name="status"
class="form-select rounded-4">

<option value="Tersedia">
Tersedia
</option>

<option value="Habis">
Habis
</option>

</select>

</div>

</div>

<div class="d-flex gap-2 mt-3">

<a href="../../public/buku.php"
class="btn btn-secondary rounded-4">

Kembali

</a>

<button type="submit"
class="btn btn-primary rounded-4">

Simpan Buku

</button>

</div>

</form>

</div>

</div>

</body>
</html>