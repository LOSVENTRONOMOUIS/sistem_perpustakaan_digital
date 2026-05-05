<?php
session_start();
require 'koneksi.php';

/* =========================
   TAMBAH ANGGOTA
========================= */
if(isset($_POST['tambah'])){
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $role  = $_POST['role'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"
    INSERT INTO users (nama,email,password,role)
    VALUES ('$nama','$email','$pass','$role')
    ");
}

/* =========================
   EDIT ANGGOTA
========================= */
if(isset($_POST['edit'])){
    $id    = $_POST['id'];
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    if(!empty($_POST['password'])){
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($conn,"
        UPDATE users SET
        nama='$nama',
        email='$email',
        role='$role',
        password='$pass'
        WHERE id='$id'
        ");
    } else {
        mysqli_query($conn,"
        UPDATE users SET
        nama='$nama',
        email='$email',
        role='$role'
        WHERE id='$id'
        ");
    }
}

/* =========================
   DATA
========================= */
$data = mysqli_query($conn,"
SELECT * FROM users
WHERE role='anggota' OR role='admin'
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body{
    background:#f4f7fe;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}
#mainWrapper{transition:0.3s ease;}
.shifted{margin-left:280px;}
.navbar{
    height:75px;
    border-radius:0 0 20px 20px;
    transition:0.3s;
    z-index:1020;
}
.content{padding:30px;}
.offcanvas{border:none;box-shadow:0 0 30px rgba(0,0,0,0.08);}
.nav-link{
    padding:14px 18px;
    border-radius:14px;
    color:#444;
    font-weight:500;
    margin-bottom:8px;
}
.nav-link:hover,.nav-link.active{
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
    width:65px;height:65px;border-radius:18px;
    display:flex;justify-content:center;align-items:center;
    color:white;font-size:28px;margin-bottom:18px;
}
.bg-blue{background:#0d6efd;}
.table-box{
    background:white;border-radius:24px;padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}
.table th{border:none;color:#666;}
.table td{vertical-align:middle;border-color:#f1f1f1;}
.profile-img{
    width:45px;height:45px;border-radius:50%;
}
@media(max-width:992px){
.shifted{margin-left:0;}
.content{padding:20px;}
}
</style>
</head>

<body>

<div id="mainWrapper">

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">
<div class="d-flex align-items-center">
<button class="btn btn-outline-primary"
data-bs-toggle="offcanvas"
data-bs-target="#sidebar">
<i class="bi bi-list fs-4"></i>
</button>
<h4 class="ms-3 mt-2 fw-bold">Data Anggota</h4>
</div>

<div class="d-flex align-items-center gap-3">
<i class="bi bi-bell fs-5"></i>
<a href="profile2.php">
<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
width="45" class="rounded-circle">
</a>
</div>
</nav>

<!-- CONTENT -->
<div class="content">

<div class="mb-4">
<h1 class="fw-bold">Manajemen Anggota</h1>
<p class="text-muted">Kelola data anggota perpustakaan digital</p>
</div>

<!-- CARD -->
<div class="row g-4 mb-4">
<div class="col-md-4">
<div class="card-dashboard">
<div class="icon-box bg-blue">
<i class="bi bi-people-fill"></i>
</div>
<h2 class="fw-bold"><?= $totalAnggota ?></h2>
<p class="text-muted mb-0">Total Anggota</p>
</div>
</div>
</div>

<!-- TABLE -->
<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">
<h4 class="fw-bold">Data Anggota</h4>

<button class="btn btn-primary rounded-4"
data-bs-toggle="modal"
data-bs-target="#modalTambah">
<i class="bi bi-plus-circle"></i>
Tambah Anggota
</button>
</div>

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

<td><?= $d['nama'] ?></td>
<td><?= $d['email'] ?></td>

<td>
<span class="badge bg-primary"><?= $d['role'] ?></span>
</td>

<td>

<button class="btn btn-warning btn-sm"
data-bs-toggle="modal"
data-bs-target="#edit<?= $d['id'] ?>">
<i class="bi bi-pencil-fill"></i>
</button>

<a href="hapus_anggota.php?id=<?= $d['id'] ?>"
class="btn btn-danger btn-sm">
<i class="bi bi-trash-fill"></i>
</a>

</td>

</tr>

<!-- MODAL EDIT -->
<div class="modal fade" id="edit<?= $d['id'] ?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">

<div class="modal-header">
<h5>Edit Anggota</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" name="id" value="<?= $d['id'] ?>">

<input type="text" name="nama"
value="<?= $d['nama'] ?>"
class="form-control mb-3" required>

<input type="email" name="email"
value="<?= $d['email'] ?>"
class="form-control mb-3" required>

<select name="role" class="form-control mb-3">
<option value="anggota" <?= $d['role']=='anggota'?'selected':'' ?>>Anggota</option>
<option value="admin" <?= $d['role']=='admin'?'selected':'' ?>>Admin</option>
</select>

<input type="password" name="password"
class="form-control"
placeholder="Password baru (opsional)">

</div>

<div class="modal-footer">
<button class="btn btn-success" name="edit">Simpan</button>
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

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
<div class="modal-dialog">
<div class="modal-content">

<form method="POST">

<div class="modal-header">
<h5>Tambah Anggota</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="text" name="nama"
class="form-control mb-3"
placeholder="Nama" required>

<input type="email" name="email"
class="form-control mb-3"
placeholder="Email" required>

<select name="role" class="form-control mb-3">
<option value="anggota">Anggota</option>
<option value="admin">Admin</option>
</select>

<input type="password" name="password"
class="form-control"
placeholder="Password" required>

</div>

<div class="modal-footer">
<button class="btn btn-primary" name="tambah">Tambah</button>
</div>

</form>

</div>
</div>
</div>

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
<h5 class="fw-bold mb-0">Administrator</h5>
<small class="text-muted">Admin Perpustakaan</small>
</div>

<ul class="nav flex-column">
<li><a class="nav-link" href="index.php"><i class="bi bi-grid-fill me-2"></i>Dashboard</a></li>
<li><a class="nav-link" href="buku.php"><i class="bi bi-book-fill me-2"></i>Kelola Buku</a></li>
<li><a class="nav-link active" href="anggota.php"><i class="bi bi-people-fill me-2"></i>Data Anggota</a></li>
<li><a class="nav-link" href="peminjaman.php"><i class="bi bi-journal-check me-2"></i>Peminjaman</a></li>
<li><a class="nav-link" href="kategori.php"><i class="bi bi-tags-fill me-2"></i>Kategori Buku</a></li>
</ul>

<div class="mt-auto border-top pt-3">
<a href="logout.php" class="btn btn-danger w-100 rounded-4">
<i class="bi bi-box-arrow-right"></i> Logout
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
