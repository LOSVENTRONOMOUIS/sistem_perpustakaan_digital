<?php
$totalBuku = $totalBuku ?? 0;
$riwayatPinjam = $riwayatPinjam ?? [];
$semuaBuku = $semuaBuku ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Anggota</title>

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
    transition:.3s;
    z-index:1020;
}

.content{
    padding:30px;
    transition:.3s;
}

.shifted{
    margin-left:280px;
}

.offcanvas{
    border:none;
    box-shadow:0 0 30px rgba(0,0,0,.08);
}

.nav-link-custom{
    padding:14px 18px;
    border-radius:14px;
    color:#444;
    font-weight:500;
    margin-bottom:8px;
    display:flex;
    gap:12px;
    text-decoration:none;
}

.nav-link-custom:hover,
.nav-link-custom.active{
    background:#0d6efd;
    color:white !important;
}

.card-dashboard{
    border:none;
    border-radius:24px;
    padding:25px;
    background:white;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
    height:100%;
}

.card-dashboard:hover{
    transform:translateY(-5px);
}

.icon-box{
    width:55px;
    height:55px;
    border-radius:16px;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-size:24px;
    margin-bottom:15px;
}

.bg-blue{
    background:linear-gradient(135deg,#0d6efd,#0a58ca);
}

.bg-green{
    background:linear-gradient(135deg,#198754,#146c43);
}

.bg-orange{
    background:linear-gradient(135deg,#fd7e14,#e06a0c);
}

.stat-value{
    font-size:32px;
    font-weight:700;
}

.stat-label{
    color:#777;
}

.table-box{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.book-list-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.book-list-item{
    display:flex;
    gap:15px;
    padding:12px;
    background:#f8f9fa;
    border-radius:16px;
    border:1px solid #eee;
    transition:.3s;
}

.book-list-item:hover{
    transform:translateY(-3px);
}

.book-icon{
    width:55px;
    height:75px;
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:28px;
    background:#d4e8f4;
}

.book-detail h6{
    font-size:14px;
    font-weight:700;
}

.book-detail p{
    font-size:12px;
    color:#777;
    margin-bottom:6px;
}

.badge-custom{
    font-size:10px;
    padding:5px 10px;
    border-radius:20px;
}

.badge-tersedia{
    background:#d4edda;
    color:#276432;
}

.badge-habis{
    background:#f8d7da;
    color:#842029;
}

.badge-terbatas{
    background:#fff3cd;
    color:#856404;
}

</style>
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">

<button class="btn btn-outline-primary"
data-bs-toggle="offcanvas"
data-bs-target="#sidebar">

<i class="bi bi-list fs-4"></i>

</button>

<h4 class="ms-3 mt-2 fw-bold">
Dashboard Anggota
</h4>

</div>

<div class="d-flex align-items-center gap-3">

<i class="bi bi-bell fs-5"></i>

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="45"
class="rounded-circle">

</div>

</nav>

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
data-bs-dismiss="offcanvas"></button>

</div>

<div class="offcanvas-body d-flex flex-column">

<div class="text-center mb-4">

<img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png"
width="110">

<h5 class="fw-bold mt-3">
<?= $_SESSION['nama']; ?>
</h5>

<small class="text-muted">
Anggota Perpustakaan
</small>

</div>

<ul class="nav flex-column">

<li>
<a class="nav-link-custom active"
href="dashboard_anggota.php">

<i class="bi bi-grid-fill"></i>
Dashboard

</a>
</li>

<li>
<a class="nav-link-custom"
href="katalog.php">

<i class="bi bi-book-fill"></i>
Katalog Buku

</a>
</li>

<li>
<a class="nav-link-custom"
href="pinjam.php">

<i class="bi bi-journal-check"></i>
Riwayat Pinjam

</a>
</li>

</ul>

<div class="mt-auto border-top pt-3">

<a href="logout.php"
class="btn btn-danger w-100 rounded-4">

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
<?= $_SESSION['nama']; ?>
</h1>

<p class="text-muted">
Sistem Perpustakaan Digital Modern
</p>

</div>

<!-- CARD -->

<div class="row g-4 mb-4">

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-blue">
<i class="bi bi-book-fill"></i>
</div>

<div class="stat-value">
<?= $totalBuku ?>
</div>

<div class="stat-label">
Total Koleksi Buku
</div>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-green">
<i class="bi bi-journal-check"></i>
</div>

<div class="stat-value">
<?= count($riwayatPinjam) ?>
</div>

<div class="stat-label">
Riwayat Peminjaman
</div>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-orange">
<i class="bi bi-person-fill"></i>
</div>

<div class="stat-value">
1
</div>

<div class="stat-label">
Akun Aktif
</div>

</div>

</div>

</div>

<!-- BUKU -->

<div class="table-box">

<div class="d-flex justify-content-between mb-4">

<h4 class="fw-bold">
📚 Koleksi Buku
</h4>

</div>

<input type="text"
id="searchBookInput"
class="form-control mb-4"
placeholder="Cari buku...">

<div class="book-list-grid"
id="bookGrid">

<?php foreach(array_slice($semuaBuku,0,6) as $b){ ?>

<div class="book-list-item">

<div class="book-icon">
📘
</div>

<div class="book-detail">

<h6>
<?= $b['judul']; ?>
</h6>

<p>

<?= $b['penulis']; ?>

<br>

<?= $b['penerbit']; ?>

</p>

<?php if($b['stok'] > 5){ ?>

<span class="badge-custom badge-tersedia">
Tersedia
</span>

<?php }elseif($b['stok'] > 0){ ?>

<span class="badge-custom badge-terbatas">
<?= $b['stok']; ?> Tersisa
</span>

<?php }else{ ?>

<span class="badge-custom badge-habis">
Habis
</span>

<?php } ?>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const searchInput = document.getElementById('searchBookInput');

searchInput.addEventListener('keyup',function(){

let keyword = this.value.toLowerCase();

document.querySelectorAll('.book-list-item').forEach(item=>{

item.style.display =
item.innerText.toLowerCase().includes(keyword)
? 'flex'
: 'none';

});

});

</script>

</body>
</html>