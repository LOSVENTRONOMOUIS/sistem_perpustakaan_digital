<?php
session_start();
require 'koneksi.php';

$data = mysqli_query($conn,"
SELECT * FROM users
WHERE role='anggota'
ORDER BY id DESC
");

$totalAnggota = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM users WHERE role='anggota'"
));
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Anggota</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

#mainWrapper{
    transition:0.3s ease;
}

.shifted{
    margin-left:280px;
}

.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
    transition:0.3s;
    z-index:1020;
    position:relative;
}

.content{
    padding:30px;
    transition:0.3s;
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
    transition:0.3s;
}

.card-dashboard:hover{
    transform:translateY(-5px);
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

.profile-img{
    width:45px;
    height:45px;
    border-radius:50%;
    object-fit:cover;
}

@media(max-width:992px){

.shifted{
    margin-left:0;
}

.content{
    padding:20px;
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
Data Anggota
</h4>

</div>

<div class="d-flex align-items-center gap-3">

<i class="bi bi-bell fs-5"></i>

<a href="profile2.php">
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
Manajemen Anggota
</h1>

<p class="text-muted">
Kelola data anggota perpustakaan digital
</p>

</div>

<!-- CARD -->

<div class="row g-4 mb-4">

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-blue">
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

</div>

<!-- TABLE -->

<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold">
Data Anggota
</h4>

<a href="tambah_anggota.php"
class="btn btn-primary rounded-4">

<i class="bi bi-plus-circle"></i>
Tambah Anggota

</a>

</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>
<th>Foto</th>
<th>Nama</th>
<th>Email</th>
<th>Role</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php while($d = mysqli_fetch_array($data)){ ?>

<tr>

<td>

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
class="profile-img">

</td>

<td>

<div class="fw-bold">
<?= $d['nama'] ?>
</div>

</td>

<td>
<?= $d['email'] ?>
</td>

<td>

<span class="badge bg-primary">
<?= $d['role'] ?>
</span>

</td>

<td>

<a href="edit_anggota.php?id=<?= $d['id'] ?>"
class="btn btn-warning btn-sm rounded-3">

<i class="bi bi-pencil-fill"></i>

</a>

<a href="hapus_anggota.php?id=<?= $d['id'] ?>"
class="btn btn-danger btn-sm rounded-3">

<i class="bi bi-trash-fill"></i>

</a>

</td>

</tr>

<?php } ?>

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
Administrator
</h5>

<small class="text-muted">
Admin Perpustakaan
</small>

</div>

<ul class="nav flex-column">

<li class="nav-item">
<a class="nav-link"
href="index.php">

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
<a class="nav-link active"
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
```
