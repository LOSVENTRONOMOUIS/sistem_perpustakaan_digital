<?php
session_start();
require 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profile Mahasiswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
}

/* WRAPPER */

#mainWrapper{
    transition:0.3s ease;
}

.shifted{
    transform:translateX(280px);
}

/* NAVBAR */

.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
    z-index:1020;
}

/* CONTENT */

.content{
    padding:30px;
}

/* SIDEBAR */

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

/* PROFILE */

.profile-card{
    background:white;
    border-radius:24px;
    padding:35px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    margin-bottom:30px;
}

.profile-img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #f1f1f1;
}

.info-item{
    margin-bottom:20px;
}

.info-label{
    color:#888;
    font-size:14px;
    margin-bottom:5px;
}

.info-value{
    font-weight:600;
    font-size:18px;
}

/* TABLE */

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

/* BADGE */

.badge-pinjam{
    background:#fff3cd;
    color:#856404;
    padding:8px 14px;
    border-radius:20px;
}

/* RESPONSIVE */

@media(max-width:992px){

.shifted{
    transform:translateX(0);
}

.content{
    padding:20px;
}

.profile-card{
    padding:25px;
    text-align:center;
}

}

</style>
</head>

<body>

<div id="mainWrapper">

<!-- NAVBAR -->

<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">

<button class="btn btn-outline-primary"
type="button"
data-bs-toggle="offcanvas"
data-bs-target="#sidebar">

<i class="bi bi-list fs-4"></i>

</button>

<h4 class="ms-3 mt-2 fw-bold">
Profile Mahasiswa
</h4>

</div>

<div class="d-flex align-items-center gap-3">

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="45"
class="rounded-circle">

</div>

</nav>

<!-- CONTENT -->

<div class="content">

<!-- PROFILE -->

<div class="profile-card">

<div class="row align-items-center">

<div class="col-md-3 text-center mb-4 mb-md-0">

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
class="profile-img">

</div>

<div class="col-md-9">

<h2 class="fw-bold mb-4">
Nama Mahasiswa
</h2>

<div class="row">

<div class="col-md-6">

<div class="info-item">

<div class="info-label">
Nama Lengkap
</div>

<div class="info-value">
Nama Mahasiswa
</div>

</div>

</div>

<div class="col-md-6">

<div class="info-item">

<div class="info-label">
Username
</div>

<div class="info-value">
mahasiswa01
</div>

</div>

</div>

<div class="col-md-6">

<div class="info-item">

<div class="info-label">
Role
</div>

<div class="info-value">
Mahasiswa
</div>

</div>

</div>

<div class="col-md-6">

<div class="info-item">

<div class="info-label">
Buku Dipinjam
</div>

<div class="info-value">
2 Buku
</div>

</div>

</div>

</div>

</div>

</div>

</div>

<!-- TABLE -->

<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Buku Yang Sedang Dipinjam
</h4>

<span class="badge-pinjam">
2 Buku
</span>

</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>
<th>Judul Buku</th>
<th>Penulis</th>
<th>Tanggal Pinjam</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<tr>

<td>Atomic Habits</td>

<td>James Clear</td>

<td>2025-07-01</td>

<td>

<span class="badge-pinjam">
Dipinjam
</span>

</td>

</tr>

<tr>

<td>Clean Code</td>

<td>Robert C. Martin</td>

<td>2025-07-02</td>

<td>

<span class="badge-pinjam">
Dipinjam
</span>

</td>

</tr>

</tbody>

</table>

</div>

</div>

</div>

</div>

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
Nama Mahasiswa
</h5>

<small class="text-muted">
Mahasiswa
</small>

</div>

<ul class="nav flex-column">

<li class="nav-item">
<a class="nav-link"
href="#">

<i class="bi bi-grid-fill me-2"></i>
Dashboard

</a>
</li>

<li class="nav-item">
<a class="nav-link active"
href="#">

<i class="bi bi-person-fill me-2"></i>
Profile

</a>
</li>

<li class="nav-item">
<a class="nav-link"
href="#">

<i class="bi bi-book-fill me-2"></i>
Daftar Buku

</a>
</li>

</ul>

<div class="mt-auto border-top pt-3">

<a href="#"
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

window.addEventListener('resize', function(){

    if(window.innerWidth <= 992){
        wrapper.classList.remove('shifted');
    }

});

</script>

</body>
</html>
