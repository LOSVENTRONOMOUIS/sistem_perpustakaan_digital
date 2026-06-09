<?php


?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Perpustakaan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
}

.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
    position:relative;
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
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    transition:0.3s;
    background:white;
}

.card-dashboard:hover{
    transform:translateY(-5px);
}

.icon-box{
    width:65px;
    height:65px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:28px;
    margin-bottom:18px;
}

.bg-blue{background:#0d6efd;}
.bg-green{background:#198754;}
.bg-orange{background:#fd7e14;}
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
    vertical-align:middle;
    border-color:#f1f1f1;
}

.activity-item{
    display:flex;
    gap:15px;
    margin-bottom:20px;
}

.activity-icon{
    width:50px;
    height:50px;
    border-radius:14px;
    background:#e9f2ff;
    color:#0d6efd;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
}

.book-card{
    background:white;
    border-radius:22px;
    padding:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

.book-card img{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:16px;
    margin-bottom:15px;
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

<i class="bi bi-list fs-4"></i>

</button>

<h4 class="ms-3 mt-2 fw-bold">
Dashboard Perpustakaan
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

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start"
tabindex="-1"
id="sidebar"
style="width:280px;"
data-bs-backdrop="false">

<div class="offcanvas-header border-bottom">

<h4 class="fw-bold text-primary">

<i class="bi bi-book-half"></i>
Digital Library

</h4>

<button type="button"
class="btn-close"
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

<li class="nav-item">
<a class="nav-link active"
href="dashboard.php">

<i class="bi bi-grid-fill me-2"></i>
Dashboard

</a>
</li>

<li class="nav-item">
<a class="nav-link"
href="buku.php">

<i class="bi bi-book-fill me-2"></i>
Kelola Buku

</a>
</li>

<li class="nav-item">
<a class="nav-link"
href="anggota.php">

<i class="bi bi-people-fill me-2"></i>
Data Anggota

</a>
</li>

<li class="nav-item">
<a class="nav-link"
href="peminjaman.php">

<i class="bi bi-journal-check me-2"></i>
Peminjaman

</a>
</li>

<li class="nav-item">
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

<!-- CONTENT -->
<div class="content">

<div class="mb-4">

<h1 class="fw-bold">
Welcome Back,
</h1>

<p class="text-muted">
Sistem Perpustakaan Digital Modern
</p>

</div>

<!-- CARD -->
<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="card-dashboard">

<div class="icon-box bg-blue">
<i class="bi bi-book-fill"></i>
</div>

<h2 class="fw-bold">
<?= $totalBuku ?>
</h2>

<p class="text-muted mb-0">
Total Buku
</p>

</div>

</div>

<div class="col-md-3">

<div class="card-dashboard">

<div class="icon-box bg-green">
<i class="bi bi-people-fill"></i>
</div>

<h2 class="fw-bold">
<?= $totalAnggota ?>
</h2>

<p class="text-muted mb-0">
Total Anggota
</p>

</div>

</div>

<div class="col-md-3">

<div class="card-dashboard">

<div class="icon-box bg-orange">
<i class="bi bi-journal-check"></i>
</div>

<h2 class="fw-bold">
<?= $totalPeminjaman ?>
</h2>

<p class="text-muted mb-0">
Peminjaman Aktif
</p>

</div>

</div>

<div class="col-md-3">

<div class="card-dashboard">

<div class="icon-box bg-purple">
<i class="bi bi-tags-fill"></i>
</div>

<h2 class="fw-bold">
<?= $totalKategori ?>
</h2>

<p class="text-muted mb-0">
Kategori Buku
</p>

</div>

</div>

</div>

<div class="row">

<div class="col-lg-8">

<!-- AKTIVITAS -->
<div class="table-box mb-4">

<h4 class="fw-bold mb-4">
Aktivitas Terbaru
</h4>

<?php foreach($aktivitas as $a){ ?>

<div class="activity-item">

<div class="activity-icon">
<i class="bi bi-clock-history"></i>
</div>

<div>

<h6 class="mb-1 fw-bold">
<?= $a['nama'] ?>
</h6>

<p class="text-muted mb-1">

Meminjam buku
<strong><?= $a['judul'] ?></strong>

</p>

<small>
<?= $a['tanggal_pinjam'] ?>
</small>

</div>

</div>

<?php } ?>

</div>

<!-- DATA BUKU -->
<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Data Buku
</h4>

<a href="tambah_buku.php"
class="btn btn-primary rounded-4">

Tambah Buku

</a>

</div>

<table class="table align-middle">

<thead>

<tr>
<th>Judul</th>
<th>Penulis</th>
<th>Stok</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php foreach($buku as $b){ ?>

<tr>

<td><?= $b['judul'] ?></td>

<td><?= $b['penulis'] ?></td>

<td><?= $b['stok'] ?></td>

<td>

<a href="edit_buku.php?id=<?= $b['id'] ?>"
class="btn btn-warning btn-sm rounded-3">

Edit

</a>

<a href="hapus_buku.php?id=<?= $b['id'] ?>"
class="btn btn-danger btn-sm rounded-3">

Hapus

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<div class="col-lg-4">

<div class="table-box mb-4">

<h4 class="fw-bold mb-4">
Quick Menu
</h4>

<div class="d-grid gap-3">

<a href="buku.php"
class="btn btn-outline-primary rounded-4 p-3">

📚 Kelola Buku

</a>

<a href="anggota.php"
class="btn btn-outline-success rounded-4 p-3">

👥 Data Anggota

</a>

<a href="peminjaman.php"
class="btn btn-outline-warning rounded-4 p-3">

📖 Peminjaman Buku

</a>

<a href="kategori.php"
class="btn btn-outline-dark rounded-4 p-3">

📊 Kategori Buku

</a>

</div>

</div>

<div class="book-card">

<img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=800&auto=format&fit=crop">

<h5 class="fw-bold">
Digital Library
</h5>

<p class="text-muted mb-0">
Modern dashboard untuk sistem perpustakaan digital.
</p>

</div>

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

window.addEventListener('resize', () => {

    if(window.innerWidth <= 992){
        content.classList.remove('shifted');
        navbar.classList.remove('shifted');
    }

});

</script>

</body>
</html>