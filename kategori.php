<?php
session_start();
require 'koneksi.php';

/* ================= TAMBAH ================= */
if(isset($_POST['tambah'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    $cek = mysqli_query($conn,"
    SELECT * FROM kategori WHERE nama_kategori='$nama'
    ");

    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Kategori sudah ada!');</script>";
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
}

/* ================= EDIT ================= */
if(isset($_POST['edit'])){
    $id   = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

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

/* ================= DATA ================= */
$data = mysqli_query($conn,"
SELECT * FROM kategori ORDER BY id DESC
");

$totalKategori = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM kategori
"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kategori Buku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
}
.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
    position:relative;
    z-index:1020;
}
.content{
    padding:30px;
}
.shifted{
    margin-left:280px;
}
.offcanvas{
    border:none;
    box-shadow:0 0 30px rgba(0,0,0,0.08);
}
.nav-link{
    padding:14px 18px;
    border-radius:14px;
    color:#444;
    font-weight:500;
    margin-bottom:8px;
}
.nav-link:hover,
.nav-link.active{
    background:#0d6efd;
    color:white !important;
}
.card-dashboard{
    border:none;
    border-radius:24px;
    padding:25px;
    background:white;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}
.icon-box{
    width:65px;
    height:65px;
    border-radius:18px;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-size:28px;
    margin-bottom:18px;
}
.bg-purple{background:#6f42c1;}
.table-box{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}
.table th{
    border:none;
    color:#666;
}
.table td{
    border-color:#f1f1f1;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">
<div class="d-flex align-items-center">
<button class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
<i class="bi bi-list fs-4"></i>
</button>
<h4 class="ms-3 mt-2 fw-bold">Kategori Buku</h4>
</div>

<div class="d-flex align-items-center gap-3">
<i class="bi bi-bell fs-5"></i>
<a href="profile2.php">
<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle">
</a>
</div>
</nav>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" id="sidebar" style="width:280px;" data-bs-backdrop="false">

<div class="offcanvas-header border-bottom">
<h4 class="fw-bold text-primary">
<i class="bi bi-book-half"></i> Digital Library
</h4>
<button class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>

<div class="offcanvas-body d-flex flex-column">

<div class="text-center mb-4">
<img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3">
<h5 class="fw-bold mb-0">
<small class="text-muted">Administrator</small>
</div>

<ul class="nav flex-column">
<li><a class="nav-link" href="index.php"><i class="bi bi-grid-fill me-2"></i>Dashboard</a></li>
<li><a class="nav-link" href="buku.php"><i class="bi bi-book-fill me-2"></i>Kelola Buku</a></li>
<li><a class="nav-link" href="anggota.php"><i class="bi bi-people-fill me-2"></i>Data Anggota</a></li>
<li><a class="nav-link" href="peminjaman.php"><i class="bi bi-journal-check me-2"></i>Peminjaman</a></li>
<li><a class="nav-link active" href="kategori.php"><i class="bi bi-tags-fill me-2"></i>Kategori Buku</a></li>
</ul>

<div class="mt-auto border-top pt-3">
<a href="logout.php" class="btn btn-danger w-100 rounded-4">
<i class="bi bi-box-arrow-right"></i> Logout
</a>
</div>

</div>
</div>

<!-- CONTENT -->
<div class="content">

<div class="mb-4">
<h1 class="fw-bold">Manajemen Kategori</h1>
<p class="text-muted">Kelola kategori buku perpustakaan</p>
</div>

<div class="row g-4 mb-4">
<div class="col-md-4">
<div class="card-dashboard">
<div class="icon-box bg-purple">
<i class="bi bi-tags-fill"></i>
</div>
<h2 class="fw-bold"><?= $totalKategori ?></h2>
<p class="text-muted mb-0">Total Kategori</p>
</div>
</div>
</div>

<div class="table-box">

<div class="d-flex justify-content-between mb-4">
<h4 class="fw-bold">Data Kategori</h4>

<button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
<i class="bi bi-plus-circle"></i> Tambah Kategori
</button>
</div>

<table class="table align-middle">

<thead>
<tr>
<th>No</th>
<th>Nama Kategori</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $no=1; while($d = mysqli_fetch_array($data)){ ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama_kategori'] ?></td>

<td>

<!-- EDIT -->
<button class="btn btn-warning btn-sm rounded-3"
data-bs-toggle="modal"
data-bs-target="#edit<?= $d['id'] ?>">
<i class="bi bi-pencil-fill"></i>
</button>

<!-- HAPUS -->
<a href="hapus_kat.php?id=<?= $d['id'] ?>"
class="btn btn-danger btn-sm rounded-3"
onclick="return confirm('Yakin hapus?')">
<i class="bi bi-trash-fill"></i>
</a>

</td>
</tr>

<!-- MODAL EDIT -->
<div class="modal fade" id="edit<?= $d['id'] ?>">
<div class="modal-dialog">
<form method="POST" class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Kategori</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" name="id" value="<?= $d['id'] ?>">

<input type="text" name="nama"
class="form-control"
value="<?= $d['nama_kategori'] ?>"
required>
</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
<button type="submit" name="edit" class="btn btn-primary">Update</button>
</div>

</form>
</div>
</div>

<?php } ?>

</tbody>
</table>

</div>

</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
<div class="modal-dialog">
<form method="POST" class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Tambah Kategori</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="text" name="nama" class="form-control"
placeholder="Nama Kategori" required>
</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
</div>

</form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const sidebar = document.getElementById('sidebar');
const content = document.querySelector('.content');
const navbar = document.querySelector('.navbar');

function isDesktop(){
    return window.innerWidth > 992;
}

sidebar.addEventListener('shown.bs.offcanvas', function () {
    if(isDesktop()){
        content.classList.add('shifted');
        navbar.classList.add('shifted');
    }
});

sidebar.addEventListener('hidden.bs.offcanvas', function () {
    content.classList.remove('shifted');
    navbar.classList.remove('shifted');
});

window.addEventListener('resize', () => {
    if(window.innerWidth <= 992){
        content.classList.remove('shifted');
        navbar.classList.remove('shifted');
    }
});
</script>

</body>
</html>
