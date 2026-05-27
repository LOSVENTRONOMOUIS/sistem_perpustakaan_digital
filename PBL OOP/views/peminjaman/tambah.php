<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Peminjaman</title>

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
Tambah Peminjaman
</h2>

<form action="store_peminjaman.php" method="POST">

<div class="mb-3">

<label class="form-label">
ID User
</label>

<input type="number"
name="user_id"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
ID Buku
</label>

<input type="number"
name="buku_id"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
Tanggal Pinjam
</label>

<input type="date"
name="tanggal_pinjam"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
Tanggal Kembali
</label>

<input type="date"
name="tanggal_kembali"
class="form-control rounded-4"
required>

</div>

<div class="mb-4">

<label class="form-label">
Status
</label>

<select name="status"
class="form-control rounded-4">

<option value="dipinjam">
Dipinjam
</option>

<option value="dikembalikan">
Dikembalikan
</option>

</select>

</div>

<div class="d-flex gap-2">

<a href="peminjaman.php"
class="btn btn-secondary rounded-4">

Kembali

</a>

<button type="submit"
class="btn btn-primary rounded-4">

Simpan

</button>

</div>

</form>

</div>

</div>

</body>
</html>