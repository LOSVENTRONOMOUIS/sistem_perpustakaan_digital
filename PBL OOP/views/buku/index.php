<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Buku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
    transition:0.3s;
    z-index:1020;
}

.content{
    padding:30px;
    transition:0.3s;
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

.bg-blue{background:#0d6efd;}
.bg-green{background:#198754;}
.bg-red{background:#dc3545;}

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
    vertical-align:middle;
    border-color:#f1f1f1;
}

.badge{
    padding:8px 14px;
    border-radius:12px;
}

@media (min-width: 992px) {
    /* 1. Paksa sidebar selalu muncul & menempel di kiri */
    #sidebar {
        transform: none !important; 
        visibility: visible !important; 
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        background-color: white;
        z-index: 1030;
        display: block !important;
    }
    
    /* 2. Paksa pembungkus utama selalu geser ke kanan 280px */
    #mainWrapper {
        margin-left: 280px !important;
    }
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">

<button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
    <i class="bi bi-list fs-4"></i>
</button>



<h4 class="ms-3 mt-2 fw-bold">
Kelola Buku
</h4>

</div>

<div class="d-flex align-items-center gap-3">

<i class="bi bi-bell fs-5"></i>

<a href="#">

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="45"
class="rounded-circle">

</a>

</div>

</nav>

<!-- CONTENT -->
<div class="content">

<div class="mb-4">

<h1 class="fw-bold">
Manajemen Buku
</h1>

<p class="text-muted">
Kelola seluruh data buku perpustakaan digital
</p>

</div>

<!-- CARD -->
<div class="row g-4 mb-4">

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-blue">
<i class="bi bi-book-fill"></i>
</div>

<h2 class="fw-bold">
<?= isset($totalBuku) ? $totalBuku : 0 ?>
</h2>

<p class="text-muted mb-0">
Total Buku
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-green">
<i class="bi bi-check-circle-fill"></i>
</div>

<h2 class="fw-bold">
<?= isset($totalTersedia) ? $totalTersedia : 0 ?>
</h2>

<p class="text-muted mb-0">
Buku Tersedia
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-red">
<i class="bi bi-x-circle-fill"></i>
</div>

<h2 class="fw-bold">
<?= isset($totalHabis) ? $totalHabis : 0 ?>
</h2>

<p class="text-muted mb-0">
Buku Habis
</p>

</div>

</div>

</div>

<!-- TABLE -->
<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Daftar Buku
</h4>

<a href="tambah_buku.php"
class="btn btn-primary rounded-4">

<i class="bi bi-plus-circle"></i>
Tambah Buku

</a>

</div>

<table class="table align-middle">

<thead>

<tr>

<th>Judul</th>
<th>Penulis</th>
<th>Penerbit</th>
<th>Tahun</th>
<th>Kategori</th>
<th>Stok</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php if(!empty($books)){ ?>

<?php foreach($books as $b){ ?>

<tr>

<td>
<b><?= isset($b['judul']) ? $b['judul'] : '-' ?></b>
</td>

<td>
<?= isset($b['penulis']) ? $b['penulis'] : '-' ?>
</td>

<td>
<?= isset($b['penerbit']) ? $b['penerbit'] : '-' ?>
</td>

<td>
<?= isset($b['tahun']) ? $b['tahun'] : '-' ?>
</td>

<td>

<span class="badge bg-primary">

<?= isset($b['nama_kategori']) ? $b['nama_kategori'] : '-' ?>

</span>

</td>

<td>
<?= isset($b['stok']) ? $b['stok'] : 0 ?>
</td>

<td>

<?php if(isset($b['stok']) && $b['stok'] > 0){ ?>

<span class="badge bg-success">
Tersedia
</span>

<?php } else { ?>

<span class="badge bg-danger">
Habis
</span>

<?php } ?>

</td>

<td>

<a href="edit_buku.php?id=<?= $b['id'] ?>"
class="btn btn-warning btn-sm rounded-3">

<i class="bi bi-pencil-fill"></i>

</a>

<a href="hapus_buku.php?id=<?= $b['id'] ?>"
class="btn btn-danger btn-sm rounded-3"
onclick="return confirm('Yakin ingin hapus buku?')">

<i class="bi bi-trash-fill"></i>

</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="8" class="text-center text-muted">
Data buku belum ada
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start"
id="sidebar"
style="width:280px;"
data-bs-backdrop="false">

<div class="offcanvas-header border-bottom">

<h4 class="fw-bold text-primary">

<i class="bi bi-book-half"></i>
Digital Library

</h4>

<button class="btn-close"
data-bs-dismiss="offcanvas">
</button>

</div>

<div class="offcanvas-body d-flex flex-column">

<div class="text-center mb-4">

<img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png"
width="110"
class="mb-3">

<h5 class="fw-bold mb-0">
Administrator
</h5>

<small class="text-muted">
Admin Perpustakaan
</small>

</div>

<ul class="nav flex-column">

<li>
<a class="nav-link"
href="dashboard.php">

<i class="bi bi-grid-fill me-2"></i>
Dashboard

</a>
</li>

<li>
<a class="nav-link active"
href="buku.php">

<i class="bi bi-book-fill me-2"></i>
Kelola Buku

</a>
</li>

<li>
<a class="nav-link"
href="anggota.php">

<i class="bi bi-people-fill me-2"></i>
Data Anggota

</a>
</li>

<li>
<a class="nav-link"
href="peminjaman.php">

<i class="bi bi-journal-check me-2"></i>
Peminjaman

</a>
</li>

<li>
<a class="nav-link"
href="kategori.php">

<i class="bi bi-tags-fill me-2"></i>
Kategori Buku

</a>
</li>

</ul>

<div class="mt-auto border-top pt-3">

<a href="logout.php"
class="btn btn-danger w-100 rounded-4">

<i class="bi bi-box-arrow-right"></i>
Logout

</a>

</div>

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

window.addEventListener('resize', function(){

    if(window.innerWidth <= 992){

        content.classList.remove('shifted');
        navbar.classList.remove('shifted');

    }

});

</script>

</body>
</html>