<?php
// Data dari controller
// $data
// $totalPinjam
// $totalDipinjam
// $totalKembali
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pinjaman Saya</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

#mainWrapper{
    transition:.3s ease;
}

.shifted{
    margin-left:280px;
}

.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
}

.content{
    padding:30px;
}

.offcanvas{
    border:none;
    box-shadow:0 0 30px rgba(0,0,0,.08);
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
    box-shadow:0 10px 25px rgba(0,0,0,.05);
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

.bg-blue{
    background:#0d6efd;
}

.bg-green{
    background:#198754;
}

.bg-orange{
    background:#fd7e14;
}

.table-box{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.badge-pinjam{
    background:#fff3cd;
    color:#856404;
    padding:8px 14px;
    border-radius:20px;
}

.badge-kembali{
    background:#d1e7dd;
    color:#0f5132;
    padding:8px 14px;
    border-radius:20px;
}

.profile-img{
    width:45px;
    height:45px;
    border-radius:50%;
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

</style>

</head>

<body>

<div id="mainWrapper">

<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">

<button class="btn btn-outline-primary"
data-bs-toggle="offcanvas"
data-bs-target="#sidebar">

<i class="bi bi-list fs-4"></i>

</button>

<h4 class="ms-3 mt-2 fw-bold">
Pinjaman Saya
</h4>

</div>

<div class="d-flex align-items-center gap-3">

<i class="bi bi-bell fs-5"></i>

<img
src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
class="profile-img">

</div>

</nav>

<div class="content">

<div class="mb-4">

<h1 class="fw-bold">
Riwayat Peminjaman Buku
</h1>

<p class="text-muted">
Daftar buku yang sedang dan pernah Anda pinjam
</p>

</div>

<div class="row g-4 mb-4">

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-blue">
<i class="bi bi-journal-bookmark-fill"></i>
</div>

<h2 class="fw-bold">
<?= $totalPinjam ?>
</h2>

<p class="text-muted mb-0">
Total Pinjaman
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-orange">
<i class="bi bi-clock-history"></i>
</div>

<h2 class="fw-bold">
<?= $totalDipinjam ?>
</h2>

<p class="text-muted mb-0">
Sedang Dipinjam
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-green">
<i class="bi bi-check-circle-fill"></i>
</div>

<h2 class="fw-bold">
<?= $totalKembali ?>
</h2>

<p class="text-muted mb-0">
Sudah Dikembalikan
</p>

</div>

</div>

</div>

<div class="table-box">

<div class="mb-4">
<h4 class="fw-bold">
Data Pinjaman Saya
</h4>
</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>
<th>No</th>
<th>Judul Buku</th>
<th>Tanggal Pinjam</th>
<th>Tanggal Kembali</th>
<th>Status</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php $no = 1; ?>

<?php foreach($data as $d): ?>

<tr>

<td><?= $no++ ?></td>

<td>
<?= htmlspecialchars($d['judul']) ?>
</td>

<td>
<?= $d['tanggal_pinjam'] ?>
</td>

<td>
<?= $d['tanggal_kembali'] ?>
</td>

<td>

<?php if($d['status'] == 'dipinjam'): ?>

<span class="badge-pinjam">
Dipinjam
</span>

<?php elseif($d['status'] == 'terlambat'): ?>

<span class="badge bg-danger">
Terlambat
</span>

<?php else: ?>

<span class="badge-kembali">
Dikembalikan
</span>

<?php endif; ?>

</td>

<td>

<button
class="btn btn-primary btn-sm"
data-bs-toggle="modal"
data-bs-target="#detail<?= $d['id'] ?>">

<i class="bi bi-eye-fill"></i>

</button>

</td>

</tr>

<div
class="modal fade"
id="detail<?= $d['id'] ?>"
tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">
Detail Peminjaman
</h5>

<button
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<p>
<strong>Judul Buku :</strong>
<?= htmlspecialchars($d['judul']) ?>
</p>

<p>
<strong>Tanggal Pinjam :</strong>
<?= $d['tanggal_pinjam'] ?>
</p>

<p>
<strong>Tanggal Kembali :</strong>
<?= $d['tanggal_kembali'] ?>
</p>

<p>
<strong>Status :</strong>
<?= ucfirst($d['status']) ?>
</p>

</div>

</div>

</div>

</div>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

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
<a class="nav-link-custom"
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
<a class="nav-link-custom active"
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const sidebar = document.getElementById('sidebar');
const wrapper = document.getElementById('mainWrapper');

function isDesktop(){
    return window.innerWidth > 992;
}

sidebar.addEventListener('shown.bs.offcanvas', function () {

    if(isDesktop()){
        wrapper.classList.add('shifted');
    }

});

sidebar.addEventListener('hidden.bs.offcanvas', function () {

    wrapper.classList.remove('shifted');

});

</script>

</body>
</html>