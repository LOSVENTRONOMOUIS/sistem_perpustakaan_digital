<!-- views/anggota/index.php -->

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
}

.content{
    padding:30px;
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

<div id="mainWrapper">

<!-- NAVBAR -->

<nav class="navbar navbar-light bg-white shadow-sm px-4">

<div class="d-flex align-items-center">

<button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
    <i class="bi bi-list fs-4"></i>
</button>



<h4 class="ms-3 mt-2 fw-bold">
Data Anggota
</h4>

</div>

<div class="d-flex align-items-center gap-3">

<i class="bi bi-bell fs-5"></i>

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="45"
class="rounded-circle">

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

<button class="btn btn-primary rounded-4"
data-bs-toggle="modal"
data-bs-target="#modalTambah">

<i class="bi bi-plus-circle"></i>

Tambah Anggota

</button>

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

<?php foreach($users as $d){ ?>

<tr>

<td>

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
class="profile-img">

</td>

<td>

<?= $d['nama'] ?>

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

<!-- EDIT -->

<button class="btn btn-warning btn-sm rounded-3"
data-bs-toggle="modal"
data-bs-target="#edit<?= $d['id'] ?>">

<i class="bi bi-pencil-fill"></i>

</button>

<!-- HAPUS -->

<a href="hapus_anggota.php?id=<?= $d['id'] ?>"
class="btn btn-danger btn-sm rounded-3"
onclick="return confirm('Yakin hapus data?')">

<i class="bi bi-trash-fill"></i>

</a>

</td>

</tr>

<!-- MODAL EDIT -->

<div class="modal fade"
id="edit<?= $d['id'] ?>">

<div class="modal-dialog">

<div class="modal-content rounded-4 border-0">

<form action="update_anggota.php"
method="POST">

<div class="modal-header border-0">

<h5 class="fw-bold">
Edit Anggota
</h5>

<button class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<input type="hidden"
name="id"
value="<?= $d['id'] ?>">

<div class="mb-3">

<label class="form-label">
Nama
</label>

<input type="text"
name="nama"
value="<?= $d['nama'] ?>"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
Email
</label>

<input type="email"
name="email"
value="<?= $d['email'] ?>"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
Role
</label>

<select name="role"
class="form-control rounded-4">

<option value="anggota"
<?= $d['role']=='anggota'?'selected':'' ?>>

Anggota

</option>

<option value="admin"
<?= $d['role']=='admin'?'selected':'' ?>>

Admin

</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">
Password Baru
</label>

<input type="password"
name="password"
class="form-control rounded-4"
placeholder="Opsional">

</div>

</div>

<div class="modal-footer border-0">

<button class="btn btn-secondary rounded-4"
data-bs-dismiss="modal">

Batal

</button>

<button class="btn btn-success rounded-4">

Simpan

</button>

</div>

</form>

</div>

</div>

</div>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<!-- MODAL TAMBAH -->

<div class="modal fade"
id="modalTambah">

<div class="modal-dialog">

<div class="modal-content rounded-4 border-0">

<form action="store_anggota.php"
method="POST">

<div class="modal-header border-0">

<h5 class="fw-bold">
Tambah Anggota
</h5>

<button class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="mb-3">

<label class="form-label">
Nama
</label>

<input type="text"
name="nama"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
Email
</label>

<input type="email"
name="email"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label class="form-label">
Role
</label>

<select name="role"
class="form-control rounded-4">

<option value="anggota">
Anggota
</option>

<option value="admin">
Admin
</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">
Password
</label>

<input type="password"
name="password"
class="form-control rounded-4"
required>

</div>

</div>

<div class="modal-footer border-0">

<button class="btn btn-secondary rounded-4"
data-bs-dismiss="modal">

Batal

</button>

<button class="btn btn-primary rounded-4">

Tambah

</button>

</div>

</form>

</div>

</div>

</div>

<!-- SIDEBAR -->

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