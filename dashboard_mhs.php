```php
<?php
session_start();
require 'koneksi.php';

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_array(mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'"));

$totalDipinjam = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM peminjaman 
WHERE user_id='$user_id' 
AND status='dipinjam'"));

$totalKembali = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM peminjaman 
WHERE user_id='$user_id' 
AND status='dikembalikan'"));

$totalBuku = mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM buku"));

$peminjaman = mysqli_query($conn,"
SELECT peminjaman.*, buku.judul, buku.penulis
FROM peminjaman
JOIN buku ON peminjaman.buku_id = buku.id
WHERE peminjaman.user_id='$user_id'
ORDER BY peminjaman.id DESC
LIMIT 5
");

$buku = mysqli_query($conn,
"SELECT * FROM buku ORDER BY id DESC LIMIT 4");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Mahasiswa</title>

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

.bg-blue{background:#0d6efd;}
.bg-green{background:#198754;}
.bg-orange{background:#fd7e14;}

.table-box{
    background:white;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
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

.badge-pinjam{
    background:#fff3cd;
    color:#856404;
    padding:7px 14px;
    border-radius:20px;
}

.badge-kembali{
    background:#d1e7dd;
    color:#0f5132;
    padding:7px 14px;
    border-radius:20px;
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
Dashboard Mahasiswa
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

<img src="https://cdn-icons-png.flaticon.com/512/2202/2202112.png"
width="110"
class="mb-3">

<h5 class="fw-bold mb-0">
<?= $user['nama'] ?>
</h5>

<small class="text-muted">
Mahasiswa
</small>

</div>

<ul class="nav flex-column">

<li class="nav-item">
<a class="nav-link active" href="dashboard_mahasiswa.php">
<i class="bi bi-grid-fill me-2"></i>
Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="katalog.php">
<i class="bi bi-book-fill me-2"></i>
Katalog Buku
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="riwayat.php">
<i class="bi bi-clock-history me-2"></i>
Riwayat Peminjaman
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
Halo, <?= $user['nama'] ?>
</h1>

<p class="text-muted">
Selamat datang di sistem perpustakaan digital mahasiswa
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
<?= $totalBuku ?>
</h2>

<p class="text-muted mb-0">
Total Buku
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-dashboard">

<div class="icon-box bg-orange">
<i class="bi bi-journal-check"></i>
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

<div class="row">

<div class="col-lg-8">

<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">



<?php while($p = mysqli_fetch_array($peminjaman)){ ?>

<tr>

<td><?= $p['judul'] ?></td>

<td><?= $p['penulis'] ?></td>

<td><?= $p['tanggal_pinjam'] ?></td>

<td>

<?php if($p['status'] == 'dipinjam'){ ?>

<span class="badge-pinjam">
Dipinjam
</span>

<?php } else { ?>

<span class="badge-kembali">
Dikembalikan
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="table-box mb-4">

<h4 class="fw-bold mb-4">
Buku Terbaru
</h4>

<div class="row g-3">

<?php while($b = mysqli_fetch_array($buku)){ ?>

<div class="col-12">

<div class="book-card">

<img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=800&auto=format&fit=crop">

<h6 class="fw-bold">
<?= $b['judul'] ?>
</h6>

<p class="text-muted mb-2">
<?= $b['penulis'] ?>
</p>

<a href="pinjam.php?id=<?= $b['id'] ?>"
class="btn btn-primary w-100 rounded-4">

Pinjam Buku

</a>

</div>

</div>

<?php } ?>

</div>

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
```
