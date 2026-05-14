<?php
// DATA BUKU (sesuai yang diminta)
$books = [
    [
        "cover" => "📘",
        "bg" => "#d4e8f4",
        "title" => "Algoritma & Pemrograman",
        "author" => "Rinaldi M. · Informatika",
        "status" => "Tersedia",
        "badge" => "badge-tersedia"
    ],
    [
        "cover" => "📙",
        "bg" => "#fde8d8",
        "title" => "Manajemen Keuangan",
        "author" => "Brigham · Ekonomi",
        "status" => "Habis",
        "badge" => "badge-habis"
    ],
    [
        "cover" => "📗",
        "bg" => "#e8f4d4",
        "title" => "Hukum Perdata Indonesia",
        "author" => "Subekti · Hukum",
        "status" => "6 Tersisa",
        "badge" => "badge-terbatas"
    ],
    [
        "cover" => "📕",
        "bg" => "#f4d4e8",
        "title" => "Biologi Molekuler",
        "author" => "Lewin · Kedokteran",
        "status" => "Tersedia",
        "badge" => "badge-tersedia"
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Perpustakaan</title>

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

.nav-link-custom{
    padding:14px 18px;
    border-radius:14px;
    color:#444;
    font-weight:500;
    margin-bottom:8px;
    display:flex;
    align-items:center;
    gap:12px;
    text-decoration:none;
    transition:0.2s;
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
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    transition:0.3s;
    background:white;
    height:100%;
    min-height:180px;
    display:flex;
    flex-direction:column;
}

.card-dashboard:hover{
    transform:translateY(-5px);
}

.icon-box{
    width:55px;
    height:55px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:24px;
    margin-bottom:16px;
}

.bg-blue{background:linear-gradient(135deg, #0d6efd, #0a58ca);}
.bg-green{background:linear-gradient(135deg, #198754, #146c43);}
.bg-orange{background:linear-gradient(135deg, #fd7e14, #e06a0c);}

.stat-value{
    font-size:32px;
    font-weight:700;
    color:#1a1a2e;
    margin-bottom:5px;
}

.stat-label{
    font-size:14px;
    color:#6c757d;
    font-weight:500;
}

.action-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#fff3cd;
    color:#856404;
    padding:6px 12px;
    border-radius:30px;
    font-size:11px;
    font-weight:600;
    margin-top:10px;
    width:fit-content;
    border:1px solid #ffecb5;
    cursor:default;
    transition:0.2s;
}

.action-badge i{
    font-size:12px;
}

.action-badge:hover{
    background:#ffecb5;
    transform:scale(1.02);
}

.table-box{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

/* Style untuk daftar buku (grid buku diminati) */
.book-list-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.book-list-item {
    display: flex;
    gap: 15px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 16px;
    transition: 0.2s;
    border: 1px solid #e9ecef;
    cursor: pointer;
}

.book-list-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-color: #0d6efd;
}

.book-icon {
    width: 55px;
    height: 75px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    flex-shrink: 0;
}

.book-detail h6 {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 4px;
}

.book-detail p {
    font-size: 11px;
    color: #6c757d;
    margin-bottom: 6px;
}

.badge-custom {
    font-size: 10px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
}

.badge-tersedia {
    background: #d4edda;
    color: #276432;
}

.badge-habis {
    background: #f8d7da;
    color: #842029;
}

.badge-terbatas {
    background: #fff3cd;
    color: #856404;
}

</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">
<button class="btn btn-outline-primary" type="button"
data-bs-toggle="offcanvas"
data-bs-target="#sidebar">
<i class="bi bi-list fs-4"></i>
</button>

<h4 class="ms-3 mt-2 fw-bold">Dashboard Perpustakaan</h4>
</div>

<div class="d-flex align-items-center gap-3">
<i class="bi bi-bell fs-5"></i>

<a href="profil.php">
<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="45"
class="rounded-circle">
</a>
</div>

</nav>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar"
style="width:280px;" data-bs-backdrop="false">

<div class="offcanvas-header border-bottom">
    <h4 class="fw-bold text-primary">
        <i class="bi bi-book-half"></i>
        Digital Library
    </h4>

    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>

<div class="offcanvas-body d-flex flex-column">

<div class="text-center mb-4">
<img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png"
width="110"
class="mb-3">

<h5 class="fw-bold mb-0">Mahasiswa</h5>
<small class="text-muted">Library User</small>
</div>

<ul class="nav flex-column">

<li class="nav-item">
<a class="nav-link-custom active" href="dashboard.php">
<i class="bi bi-grid-fill me-2"></i>
Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link-custom" href="peminjaman.php">
<i class="bi bi-journal-check me-2"></i>
Peminjaman
</a>
</li>

<li class="nav-item">
<a class="nav-link-custom" href="katalog.php">
<i class="bi bi-book-half me-2"></i>
Katalog
</a>
</li>

</ul>

<div class="mt-auto border-top pt-3">
<a href="logout.php" class="btn btn-danger w-100 rounded-4" onclick="logout()">
<i class="bi bi-box-arrow-right me-2"></i>
Logout
</a>
</div>

</div>
</div>

<!-- CONTENT -->
<div class="content" id="mainContent">

<div class="mb-4">
<h1 class="fw-bold">Welcome Back, Mahasiswa</h1>
<p class="text-muted">
Sistem Perpustakaan Digital Modern — Temukan dan pinjam buku favorit Anda
</p>
</div>

<!-- CARD STATISTIK -->
<div class="row g-4 mb-4">

<div class="col-md-4">
<div class="card-dashboard">
<div class="icon-box bg-blue">
<i class="bi bi-book-fill"></i>
</div>
<div class="stat-value">1.240</div>
<div class="stat-label">Total Koleksi Buku</div>
</div>
</div>

<div class="col-md-4">
<div class="card-dashboard">
<div class="icon-box bg-green">
<i class="bi bi-journal-check"></i>
</div>
<div class="stat-value">187</div>
<div class="stat-label">Dipinjam Aktif</div>
</div>
</div>

<div class="col-md-4">
<div class="card-dashboard">
<div class="icon-box bg-orange">
<i class="bi bi-exclamation-triangle-fill"></i>
</div>
<div class="stat-value">12</div>
<div class="stat-label">Terlambat</div>
<div class="action-badge">
<i class="bi bi-clock-history"></i>
Perlu Tindakan
</div>
</div>
</div>

</div>

<!-- BUKU PALING DIMINATI -->
<div class="table-box">
<div class="d-flex justify-content-between align-items-center mb-4">
<h4 class="fw-bold">📚 Buku Paling Diminati</h4>
<a href="katalog.php" class="btn btn-sm btn-outline-primary rounded-4">
Lihat Semua
</a>
</div>

<!-- Search Box untuk filter buku -->
<div class="mb-4">
    <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input type="text" id="searchBookInput" class="form-control" placeholder="Cari buku favorit...">
    </div>
</div>

<div class="book-list-grid" id="bookGrid">
    <?php foreach($books as $index => $book): ?>
    <div class="book-list-item" onclick="window.location.href='katalog.php'">
        <div class="book-icon" style="background: <?= $book['bg']; ?>;">
            <?= $book['cover']; ?>
        </div>
        <div class="book-detail">
            <h6><?= htmlspecialchars($book['title']); ?></h6>
            <p><?= htmlspecialchars($book['author']); ?></p>
            <span class="badge-custom <?= $book['badge']; ?>">
                <?= htmlspecialchars($book['status']); ?>
            </span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div id="noBookResult" class="text-center text-muted mt-3 d-none">
    <i class="bi bi-emoji-frown"></i> Buku tidak ditemukan
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Sidebar shift logic
const sidebar = document.getElementById('sidebar');
const content = document.querySelector('.content');
const navbar = document.querySelector('.navbar');

function isDesktop(){
    return window.innerWidth > 992;
}

if(sidebar) {
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
}

window.addEventListener('resize', () => {
    if(window.innerWidth <= 992){
        content.classList.remove('shifted');
        navbar.classList.remove('shifted');
    }
});

// Search/filter buku
const searchInput = document.getElementById('searchBookInput');
const noResultDiv = document.getElementById('noBookResult');

if(searchInput) {
    searchInput.addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase().trim();
        const bookItems = document.querySelectorAll('.book-list-item');
        let visibleCount = 0;
        
        bookItems.forEach(item => {
            const text = item.innerText.toLowerCase();
            if(keyword === '' || text.includes(keyword)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        if(visibleCount === 0 && keyword !== '') {
            noResultDiv.classList.remove('d-none');
        } else {
            noResultDiv.classList.add('d-none');
        }
    });
}

function logout() {
    if(confirm('Apakah Anda yakin ingin logout?')) {
        alert('Anda telah logout');
        // window.location.href = 'login.php';
    }
}
</script>

</body>
</html>