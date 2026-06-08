<?php
// Data buku katalog
$bukuList = [
    [
        "judul" => "Algoritma & Pemrograman",
        "penulis" => "Rinaldi M. · Informatika",
        "kategori" => "Informatika",
        "status" => "tersedia",
        "badge" => "Tersedia",
        "badgeClass" => "badge-tersedia",
        "cover" => "📘",
        "bg" => "#d4e8f4"
    ],
    [
        "judul" => "Manajemen Keuangan",
        "penulis" => "Brigham · Ekonomi",
        "kategori" => "Ekonomi",
        "status" => "habis",
        "badge" => "Habis",
        "badgeClass" => "badge-habis",
        "cover" => "📙",
        "bg" => "#fde8d8"
    ],
    [
        "judul" => "Hukum Perdata Indonesia",
        "penulis" => "Subekti · Hukum",
        "kategori" => "Hukum",
        "status" => "terbatas",
        "badge" => "6 Tersisa",
        "badgeClass" => "badge-terbatas",
        "cover" => "📗",
        "bg" => "#e8f4d4"
    ],
    [
        "judul" => "Biologi Molekuler",
        "penulis" => "Lewin · Kedokteran",
        "kategori" => "Kedokteran",
        "status" => "tersedia",
        "badge" => "Tersedia",
        "badgeClass" => "badge-tersedia",
        "cover" => "📕",
        "bg" => "#f4d4e8"
    ],
    [
        "judul" => "Fisika Dasar",
        "penulis" => "Halliday · Sains",
        "kategori" => "Sains",
        "status" => "tersedia",
        "badge" => "Tersedia",
        "badgeClass" => "badge-tersedia",
        "cover" => "📒",
        "bg" => "#f4f0d4"
    ],
    [
        "judul" => "Kimia Organik",
        "penulis" => "McMurry · Kimia",
        "kategori" => "Kimia",
        "status" => "terbatas",
        "badge" => "3 Tersisa",
        "badgeClass" => "badge-terbatas",
        "cover" => "📓",
        "bg" => "#e4d4f4"
    ],
    [
        "judul" => "Basis Data Modern",
        "penulis" => "Ramakrishnan · Informatika",
        "kategori" => "Informatika",
        "status" => "tersedia",
        "badge" => "Tersedia",
        "badgeClass" => "badge-tersedia",
        "cover" => "📔",
        "bg" => "#d4eaf4"
    ],
    [
        "judul" => "Akuntansi Keuangan",
        "penulis" => "Kieso · Ekonomi",
        "kategori" => "Ekonomi",
        "status" => "terbatas",
        "badge" => "2 Tersisa",
        "badgeClass" => "badge-terbatas",
        "cover" => "📜",
        "bg" => "#fdf4d4"
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Katalog - Sistem Perpustakaan Digital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --green:#3B6D11;
  --green-light:#639922;
  --green-bg:#EAF3DE;
  --green-sidebar:#C0DD97;
  --sidebar-w:280px;

  --bg:#f4f7fe;
  --card-bg:#ffffff;
  --card-border:#e9ecef;

  --text:#1a1a1a;
  --text-muted:#6c757d;

  --radius:24px;
}

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background:var(--bg);
  font-family:'Poppins','DM Sans',sans-serif;
  overflow-y:auto;
  overflow-x:hidden;
  height:100%;
  min-height:100vh;
}

.app{
  display:flex;
  flex-direction:column;
  min-height:100vh;
}

/* NAVBAR */
.navbar{
  height:75px;
  border-radius:0 0 20px 20px;
  position:sticky;
  top:0;
  transition:0.3s;
  z-index:1020;
  background:white;
}

.content{
  padding:30px;
  transition:0.3s;
  flex:1;
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

/* Card Style */
.table-box{
  background:white;
  border-radius:24px;
  padding:25px;
  box-shadow:0 10px 25px rgba(0,0,0,0.05);
  border:1px solid #f0f2f5;
}

.section-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
  flex-wrap:wrap;
  gap:15px;
}

.section-header h3{
  font-size:1.35rem;
  font-weight:700;
  border-left:5px solid #0d6efd;
  padding-left:18px;
  margin:0;
}

/* Search Box */
.search-input-group{
  display:flex;
  align-items:center;
  background:#f8f9fa;
  border:1px solid #e9ecef;
  border-radius:40px;
  padding:8px 16px;
  gap:8px;
}

.search-input-group input{
  border:none;
  background:transparent;
  outline:none;
  font-size:13px;
  width:200px;
}

.search-input-group i{
  color:#6c757d;
}

/* Filter Pills */
.filter-group{
  display:flex;
  gap:8px;
  flex-wrap:wrap;
  margin-bottom:15px;
}

.filter-pill{
  padding:6px 16px;
  border-radius:30px;
  font-size:12px;
  font-weight:500;
  border:1px solid #e9ecef;
  background:#f8f9fa;
  color:#6c757d;
  cursor:pointer;
  transition:0.2s;
}

.filter-pill:hover{
  border-color:#0d6efd;
  color:#0d6efd;
}

.filter-pill.active{
  background:#0d6efd;
  border-color:#0d6efd;
  color:white;
}

/* Book Grid - 2 KOLOM RAPI */
.book-grid-2col{
  display:grid;
  grid-template-columns:repeat(2, 1fr);
  gap:16px;
}

.book-card{
  display:flex;
  gap:12px;
  padding:14px;
  background:#f8f9fa;
  border-radius:16px;
  transition:0.2s;
  border:1px solid #e9ecef;
  align-items:center;
}

.book-card:hover{
  transform:translateY(-2px);
  box-shadow:0 8px 16px rgba(0,0,0,0.06);
  border-color:#0d6efd;
}

.book-icon{
  width:55px;
  height:75px;
  border-radius:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:28px;
  flex-shrink:0;
  box-shadow:0 2px 6px rgba(0,0,0,0.08);
}

.book-info{
  flex:1;
  min-width:0;
}

.book-info h4{
  font-size:0.85rem;
  font-weight:700;
  margin-bottom:3px;
  color:#1a1a2e;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.book-info .author{
  font-size:9px;
  color:#6c757d;
  margin-bottom:6px;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.book-bottom{
  display:flex;
  align-items:center;
  gap:8px;
  flex-wrap:wrap;
}

.badge-custom{
  font-size:9px;
  padding:3px 10px;
  border-radius:20px;
  font-weight:600;
  display:inline-block;
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

.btn-pinjam{
  border:none;
  padding:4px 12px;
  border-radius:20px;
  background:#0d6efd;
  color:white;
  font-size:9px;
  font-weight:600;
  cursor:pointer;
  transition:0.2s;
}

.btn-pinjam:hover{
  background:#0a58ca;
  transform:translateY(-1px);
}

.btn-pinjam:disabled{
  background:#adb5bd;
  cursor:not-allowed;
  opacity:0.6;
  transform:none;
}

.empty-state{
  text-align:center;
  padding:60px;
  color:#6c757d;
}

.empty-state i{
  font-size:64px;
  margin-bottom:20px;
  display:block;
  opacity:0.5;
}

/* Modal Peminjaman */
.modal-faux{
  display:none;
  position:fixed;
  inset:0;
  z-index:1060;
  background:rgba(0,0,0,.5);
  backdrop-filter:blur(3px);
  align-items:center;
  justify-content:center;
}

.modal-faux.show{
  display:flex;
}

.modal-box{
  background:white;
  border-radius:24px;
  width:95%;
  max-width:400px;
  padding:20px;
  box-shadow:0 20px 35px rgba(0,0,0,0.2);
  animation:modalShow 0.28s ease;
  max-height:90vh;
  overflow-y:auto;
}

@keyframes modalShow{
  from{opacity:0;transform:scale(0.95) translateY(10px);}
  to{opacity:1;transform:scale(1) translateY(0);}
}

.modal-title{
  font-size:14px;
  font-weight:700;
  margin-bottom:16px;
  text-align:center;
  color:#1a1a2e;
}

.stepper{
  display:flex;
  align-items:flex-start;
  justify-content:center;
  margin-bottom:20px;
}

.step{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:5px;
  flex:1;
}

.step-circle{
  width:32px;
  height:32px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:13px;
  font-weight:700;
  background:#f0f0f0;
  border:2px solid #ddd;
  color:#999;
  transition:all 0.3s;
}

.step.active .step-circle,
.step.done .step-circle{
  background:#0d6efd;
  border-color:#0d6efd;
  color:white;
}

.step-label{
  font-size:9px;
  color:#999;
  font-weight:500;
}

.step.active .step-label,
.step.done .step-label{
  color:#0d6efd;
  font-weight:700;
}

.step-line{
  flex:1;
  height:2px;
  background:#ddd;
  margin-top:15px;
  transition:background 0.3s;
}

.step-line.done{
  background:#0d6efd;
}

.book-preview{
  display:flex;
  align-items:center;
  gap:12px;
  background:#f8f9fa;
  border-radius:16px;
  padding:12px;
  margin-bottom:16px;
  border:1px solid #e9ecef;
}

.book-preview-cover{
  width:50px;
  height:66px;
  border-radius:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:28px;
  flex-shrink:0;
}

.book-preview-title{
  font-size:13px;
  font-weight:700;
  margin-bottom:3px;
}

.book-preview-author{
  font-size:10px;
  color:#6c757d;
  margin-bottom:5px;
}

.form-row{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
  margin-bottom:10px;
}

.form-group{
  display:flex;
  flex-direction:column;
  gap:4px;
}

.form-group label{
  font-size:10px;
  font-weight:600;
  color:#6c757d;
}

.form-group input{
  padding:8px 10px;
  border:1px solid #e9ecef;
  border-radius:10px;
  font-size:12px;
  background:#f8f9fa;
}

.modal-footer{
  display:flex;
  gap:10px;
  justify-content:flex-end;
  margin-top:18px;
  padding-top:15px;
  border-top:1px solid #e9ecef;
}

.btn-batal{
  padding:8px 18px;
  border-radius:30px;
  background:#f0f0f0;
  border:none;
  font-size:11px;
  font-weight:600;
  cursor:pointer;
}

.btn-proses{
  padding:8px 20px;
  border-radius:30px;
  background:#0d6efd;
  border:none;
  color:white;
  font-size:11px;
  font-weight:600;
  cursor:pointer;
}

.success-box{
  text-align:center;
  padding:20px 10px;
}

.success-icon{
  font-size:50px;
  margin-bottom:12px;
  display:block;
}

.success-title{
  font-size:16px;
  font-weight:700;
  margin-bottom:5px;
}

.success-sub{
  font-size:11px;
  color:#6c757d;
}

/* ========== NOTIFIKASI BESAR DI TENGAH ========== */
.notif-center {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.65);
  backdrop-filter: blur(10px);
  z-index: 1100;
  display: none;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', sans-serif;
  opacity: 0;
  transition: opacity 0.25s ease;
}

.notif-center.show {
  display: flex;
  opacity: 1;
}

.notif-card {
  background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
  border-radius: 56px;
  max-width: 440px;
  width: 86%;
  padding: 2rem 1.5rem 2.2rem 1.5rem;
  text-align: center;
  box-shadow: 0 40px 65px rgba(0, 0, 0, 0.25), 0 10px 20px rgba(0, 0, 0, 0.1);
  animation: notifPop 0.4s cubic-bezier(0.21, 1.11, 0.32, 1);
  border: 1px solid rgba(13, 110, 253, 0.2);
}

@keyframes notifPop {
  0% {
    transform: scale(0.85);
    opacity: 0;
  }
  80% {
    transform: scale(1.02);
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.notif-icon {
  font-size: 70px;
  background: linear-gradient(135deg, #0d6efd, #0a58ca);
  width: 100px;
  height: 100px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 60px;
  margin-bottom: 20px;
  color: white;
  box-shadow: 0 12px 25px rgba(13, 110, 253, 0.3);
}

.notif-icon i {
  font-size: 52px;
}

.notif-title {
  font-size: 28px;
  font-weight: 800;
  margin-bottom: 10px;
  background: linear-gradient(125deg, #0d6efd, #0b5ed7);
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
  letter-spacing: -0.3px;
}

.notif-message {
  font-size: 18px;
  font-weight: 500;
  color: #1e2a3a;
  margin-bottom: 20px;
  padding: 0 10px;
  line-height: 1.4;
}

.notif-book-name {
  font-size: 17px;
  font-weight: 700;
  background: #f0f7ff;
  display: inline-block;
  padding: 6px 18px;
  border-radius: 80px;
  color: #0d6efd;
  margin-top: 6px;
  margin-bottom: 20px;
}

.notif-action-btn {
  background: #0d6efd;
  border: none;
  padding: 12px 28px;
  border-radius: 50px;
  font-weight: 700;
  font-size: 16px;
  letter-spacing: 0.3px;
  color: white;
  box-shadow: 0 8px 18px rgba(13, 110, 253, 0.3);
  transition: 0.2s;
}

.notif-action-btn:hover {
  background: #0b5ed7;
  transform: scale(1.02);
  box-shadow: 0 10px 22px rgba(13, 110, 253, 0.4);
}

@media (max-width: 520px) {
  .notif-card {
    width: 90%;
    padding: 1.5rem 1rem;
  }
  .notif-title {
    font-size: 24px;
  }
  .notif-message {
    font-size: 16px;
  }
  .notif-icon {
    width: 80px;
    height: 80px;
    font-size: 56px;
  }
  .notif-icon i {
    font-size: 42px;
  }
}

</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">
<div class="d-flex align-items-center">
<button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
<i class="bi bi-list fs-4"></i>
</button>
<h4 class="ms-3 mt-2 fw-bold">Dashboard Perpustakaan</h4>
</div>
<div class="d-flex align-items-center gap-3">
<i class="bi bi-bell fs-5"></i>
<a href="profil.php"><img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle"></a>
</div>
</nav>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" style="width:280px;" data-bs-backdrop="false">
<div class="offcanvas-header border-bottom">
    <h4 class="fw-bold text-primary"><i class="bi bi-book-half"></i> Digital Library</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body d-flex flex-column">
<div class="text-center mb-4">
<img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3">
<h5 class="fw-bold mb-0">Mahasiswa</h5>
<small class="text-muted">Library User</small>
</div>
<ul class="nav flex-column">
<li class="nav-item"><a class="nav-link-custom" href="dashboard.php"><i class="bi bi-grid-fill me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link-custom" href="peminjaman.php"><i class="bi bi-journal-check me-2"></i>Peminjaman</a></li>
<li class="nav-item"><a class="nav-link-custom active" href="katalog.php"><i class="bi bi-book-half me-2"></i>Katalog</a></li>
</ul>
<div class="mt-auto border-top pt-3">
<a href="logout.php" class="btn btn-danger w-100 rounded-4"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
</div>
</div>
</div>

<!-- CONTENT -->
<div class="content" id="mainContent">

<div class="mb-4">
<h1 class="fw-bold">📚 Katalog Buku</h1>
<p class="text-muted">Jelajahi koleksi buku digital dan fisik yang tersedia di perpustakaan kami</p>
</div>

<div class="table-box">

<div class="section-header">
<h3>Koleksi Buku</h3>
<div class="search-input-group">
<i class="bi bi-search"></i>
<input type="text" id="searchKatalog" placeholder="Cari judul atau penulis..." oninput="filterBooks()">
</div>
</div>

<!-- Filter Kategori -->
<div class="filter-group" id="categoryFilter">
    <button class="filter-pill active" data-cat="all">Semua</button>
    <?php 
    $categories = array_unique(array_column($bukuList, 'kategori'));
    foreach($categories as $cat): 
    ?>
    <button class="filter-pill" data-cat="<?= strtolower($cat); ?>"><?= $cat; ?></button>
    <?php endforeach; ?>
</div>

<!-- Filter Status -->
<div class="filter-group" id="statusFilter">
    <button class="filter-pill active" data-stat="all">Semua Status</button>
    <button class="filter-pill" data-stat="tersedia">Tersedia</button>
    <button class="filter-pill" data-stat="terbatas">Terbatas</button>
    <button class="filter-pill" data-stat="habis">Habis</button>
</div>

<!-- BUKU GRID 2 KOLOM RAPI -->
<div class="book-grid-2col" id="katalogGrid">
    <?php foreach($bukuList as $index => $buku): ?>
    <div class="book-card" 
         data-category="<?= strtolower($buku['kategori']); ?>" 
         data-status="<?= $buku['status']; ?>"
         data-title="<?= strtolower($buku['judul']); ?>"
         data-author="<?= strtolower($buku['penulis']); ?>">
        <div class="book-icon" style="background: <?= $buku['bg']; ?>;">
            <?= $buku['cover']; ?>
        </div>
        <div class="book-info">
            <h4><?= htmlspecialchars($buku['judul']); ?></h4>
            <div class="author"><?= htmlspecialchars($buku['penulis']); ?></div>
            <div class="book-bottom">
                <span class="badge-custom <?= $buku['badgeClass']; ?>">
                    <?= $buku['badge']; ?>
                </span>
                <?php if($buku['status'] == 'habis'): ?>
                    <button class="btn-pinjam" disabled>Stok Habis</button>
                <?php else: ?>
                    <button class="btn-pinjam" onclick="pinjamBuku('<?= addslashes($buku['judul']); ?>', '<?= addslashes($buku['penulis']); ?>', '<?= $buku['bg']; ?>', '<?= $buku['cover']; ?>')">
                        Pinjam
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div id="emptyState" class="empty-state" style="display: none;">
    <i class="bi bi-emoji-frown"></i>
    <p>Tidak ada buku yang sesuai dengan filter yang dipilih</p>
</div>

</div>

</div>

<!-- MODAL PEMINJAMAN (Proses 3 Langkah) -->
<div class="modal-faux" id="modalOverlay">
  <div class="modal-box">
    <div class="modal-title">Alur Peminjaman Buku</div>
    <div class="stepper">
      <div class="step active" id="step1"><div class="step-circle">1</div><div class="step-label">Pilih Buku</div></div>
      <div class="step-line" id="line1"></div>
      <div class="step" id="step2"><div class="step-circle">2</div><div class="step-label">Peminjaman</div></div>
      <div class="step-line" id="line2"></div>
      <div class="step" id="step3"><div class="step-circle">3</div><div class="step-label">Konfirmasi</div></div>
    </div>
    <div id="modalStep1">
      <div class="book-preview">
        <div class="book-preview-cover" id="mCover" style="background:#d4e8f4;">📘</div>
        <div>
          <div class="book-preview-title" id="mJudul">—</div>
          <div class="book-preview-author" id="mPenulis">—</div>
          <span class="badge-custom badge-tersedia">Tersedia</span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-batal" onclick="closeModal()">Batal</button>
        <button class="btn-proses" onclick="goStep(2)">Lanjut →</button>
      </div>
    </div>
    <div id="modalStep2" style="display:none;">
      <div class="form-row">
        <div class="form-group"><label>NIM Peminjam</label><input type="text" id="inputNim" placeholder="2021001234" readonly></div>
        <div class="form-group"><label>Nama Peminjam</label><input type="text" id="inputNama" placeholder="Nama lengkap" readonly></div>
      </div>
      <div class="book-preview">
        <div class="book-preview-cover" id="mCover2" style="background:#d4e8f4;">📘</div>
        <div>
          <div class="book-preview-title" id="mJudul2">—</div>
          <div class="book-preview-author" id="mPenulis2">—</div>
          <span class="badge-custom badge-tersedia">Tersedia</span>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Tanggal Dipinjam</label><input type="text" id="iTglPinjam" readonly></div>
        <div class="form-group"><label>Tanggal Kembali</label><input type="text" id="iTglKembali" readonly></div>
      </div>
      <div class="form-group" style="margin-bottom:4px;"><label>Durasi Peminjaman</label><input type="text" id="iDurasi" readonly></div>
      <div class="modal-footer">
        <button class="btn-batal" onclick="goStep(1)">← Kembali</button>
        <button class="btn-proses" onclick="prosesStep2()">Proses Pinjam</button>
      </div>
    </div>
    <div id="modalStep3" style="display:none;">
      <div class="success-box">
        <div class="success-icon">✅</div>
        <div class="success-title">Peminjaman Berhasil!</div>
        <div class="success-sub" id="successDesc">Buku telah berhasil dipinjam.</div>
      </div>
      <div class="modal-footer" style="justify-content:center;">
        <button class="btn-proses" onclick="selesai()">Selesai</button>
      </div>
    </div>
  </div>
</div>

<!-- NOTIFIKASI BESAR DI TENGAH (Custom Popup) -->
<div id="bigNotifCenter" class="notif-center">
  <div class="notif-card">
    <div class="notif-icon">
      <i class="bi bi-check2-circle"></i>
    </div>
    <div class="notif-title">Peminjaman Berhasil!</div>
    <div class="notif-message">
      Silahkan ambil buku di perpustakaan.<br>
      <span id="bigNotifBookName" style="font-weight:600;">—</span>
    </div>
    <div style="font-size:14px; color:#2c7da0; margin-bottom: 16px;" id="bigNotifUser">Terima kasih telah meminjam</div>
    <button class="notif-action-btn" id="closeBigNotifBtn">OK, Mengerti</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Sidebar logika
const sidebar = document.getElementById('sidebar');
const content = document.querySelector('.content');
const navbar = document.querySelector('.navbar');
function isDesktop(){ return window.innerWidth > 992; }
if(sidebar) {
    sidebar.addEventListener('shown.bs.offcanvas', function () { if(isDesktop()) content.classList.add('shifted'); });
    sidebar.addEventListener('hidden.bs.offcanvas', function () { content.classList.remove('shifted'); });
}
window.addEventListener('resize', () => {
    if(window.innerWidth <= 992) content.classList.remove('shifted');
    else if(!sidebar.classList.contains('show')) content.classList.remove('shifted');
});

// FILTER dan SEARCH
let currentCategory = 'all';
let currentStatus = 'all';

function filterBooks() {
    const keyword = document.getElementById('searchKatalog').value.toLowerCase().trim();
    const items = document.querySelectorAll('#katalogGrid .book-card');
    let visibleCount = 0;
    items.forEach(item => {
        const category = item.getAttribute('data-category');
        const status = item.getAttribute('data-status');
        const title = item.getAttribute('data-title') || '';
        const author = item.getAttribute('data-author') || '';
        const matchCategory = currentCategory === 'all' || category === currentCategory;
        const matchStatus = currentStatus === 'all' || status === currentStatus;
        const matchSearch = keyword === '' || title.includes(keyword) || author.includes(keyword);
        const show = matchCategory && matchStatus && matchSearch;
        item.style.display = show ? 'flex' : 'none';
        if(show) visibleCount++;
    });
    document.getElementById('emptyState').style.display = visibleCount === 0 ? 'block' : 'none';
}

document.querySelectorAll('#categoryFilter .filter-pill').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#categoryFilter .filter-pill').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentCategory = this.getAttribute('data-cat');
        filterBooks();
    });
});
document.querySelectorAll('#statusFilter .filter-pill').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#statusFilter .filter-pill').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentStatus = this.getAttribute('data-stat');
        filterBooks();
    });
});
document.getElementById('searchKatalog').addEventListener('input', filterBooks);

// Variabel peminjaman
let currentBook = {};

function pinjamBuku(judul, penulis, coverBg, coverEmoji) {
    currentBook = { judul, penulis, coverBg: coverBg || '#d4e8f4', coverEmoji: coverEmoji || '📘' };
    document.getElementById('mJudul').textContent = judul;
    document.getElementById('mPenulis').textContent = penulis;
    document.getElementById('mCover').style.background = currentBook.coverBg;
    document.getElementById('mCover').textContent = currentBook.coverEmoji;
    document.getElementById('mJudul2').textContent = judul;
    document.getElementById('mPenulis2').textContent = penulis;
    document.getElementById('mCover2').style.background = currentBook.coverBg;
    document.getElementById('mCover2').textContent = currentBook.coverEmoji;
    document.getElementById('inputNim').value = '2021001234';
    document.getElementById('inputNama').value = 'Budi Santoso';
    const today = new Date();
    const due = new Date(today);
    due.setDate(due.getDate() + 14);
    const fmt = d => d.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'});
    currentBook.tglPinjam = fmt(today);
    currentBook.tglKembali = fmt(due);
    document.getElementById('iTglPinjam').value = currentBook.tglPinjam;
    document.getElementById('iTglKembali').value = currentBook.tglKembali;
    document.getElementById('iDurasi').value = '14 hari';
    goStep(1);
    document.getElementById('modalOverlay').classList.add('show');
}

function goStep(n) {
    [1,2,3].forEach(i => {
        const stepDiv = document.getElementById('modalStep'+i);
        if(stepDiv) stepDiv.style.display = i === n ? 'block' : 'none';
        const stepEl = document.getElementById('step'+i);
        if(stepEl) {
            stepEl.classList.remove('active', 'done');
            if (i < n) stepEl.classList.add('done');
            if (i === n) stepEl.classList.add('active');
        }
    });
    const line1 = document.getElementById('line1');
    const line2 = document.getElementById('line2');
    if(line1) line1.classList.toggle('done', n >= 2);
    if(line2) line2.classList.toggle('done', n >= 3);
}

function prosesStep2() {
    const nim = document.getElementById('inputNim').value.trim();
    const nama = document.getElementById('inputNama').value.trim();
    if (!nim || !nama) { alert('Data peminjam wajib diisi!'); return; }
    document.getElementById('successDesc').innerHTML = '"' + currentBook.judul + '" berhasil dipinjam oleh ' + nama + '.';
    goStep(3);
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('show');
}

// ========== NOTIF TENGAH BESAR (Pengganti toast biasa) ==========
function showBigCenterNotification(judulBuku, namaPeminjam = "Budi Santoso") {
    const notifEl = document.getElementById('bigNotifCenter');
    const bookSpan = document.getElementById('bigNotifBookName');
    const userSpan = document.getElementById('bigNotifUser');
    if (bookSpan) bookSpan.innerText = `📖 "${judulBuku}"`;
    if (userSpan) userSpan.innerText = `Peminjam: ${namaPeminjam}  •  Selamat membaca!`;
    notifEl.classList.add('show');
    // Optional: auto close after 4 detik, tapi biar user klik tombol OK biar lebih interaktif
    // kita biarkan manual close dengan tombol.
}

function closeBigNotification() {
    const notifEl = document.getElementById('bigNotifCenter');
    notifEl.classList.remove('show');
}

// selesai() -> notif besar + redirect
function selesai() {
    closeModal();
    // Tampilkan notifikasi besar di tengah
    const namaPeminjam = document.getElementById('inputNama').value.trim() || "Mahasiswa";
    showBigCenterNotification(currentBook.judul, namaPeminjam);
    // Redirect setelah user klik OK
    const closeBtn = document.getElementById('closeBigNotifBtn');
    // Hapus listener lama jika ada untuk mencegah duplikasi
    const newCloseBtn = closeBtn.cloneNode(true);
    closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
    newCloseBtn.addEventListener('click', function() {
        closeBigNotification();
        window.location.href = 'peminjaman.php';
    });
    // Optional: jika tidak klik, tetap redirect setelah 3.5 detik agar tidak macet
    setTimeout(() => {
        if(document.getElementById('bigNotifCenter').classList.contains('show')) {
            closeBigNotification();
            window.location.href = 'peminjaman.php';
        }
    }, 4000);
}

// Pastikan fungsi global dan tidak bentrok
window.filterBooks = filterBooks;
window.pinjamBuku = pinjamBuku;
window.goStep = goStep;
window.prosesStep2 = prosesStep2;
window.closeModal = closeModal;
window.selesai = selesai;
</script>

</body>
</html>