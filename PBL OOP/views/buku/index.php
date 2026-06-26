<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background: #f4f7fe;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        #mainWrapper {
            transition: 0.3s ease;
        }

        .shifted {
            margin-left: 280px;
        }

        .navbar {
            height: 75px;
            border-radius: 0 0 20px 20px;
            transition: 0.3s;
            z-index: 1020;
        }

        .content {
            padding: 30px;
        }

        .offcanvas {
            border: none;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
        }

        .nav-link {
            padding: 14px 18px;
            border-radius: 14px;
            color: #444;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 15px; /* Diperbesar sedikit */
        }

        .nav-link:hover,
        .nav-link.active {
            background: #0d6efd;
            color: white !important;
        }

        .card-dashboard {
            border: none;
            border-radius: 24px;
            padding: 25px;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .bg-blue { background: #0d6efd; }
        .bg-green { background: #198754; }
        .bg-red { background: #dc3545; }

        .table-box {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* ===== PERBESARAN FONT TABEL ===== */
        .table th {
            border: none;
            color: #666;
            font-size: 16px; /* Diperbesar dari 14px */
            padding-bottom: 15px;
        }

        .table td {
            vertical-align: middle;
            border-color: #f8f9fa;
            font-size: 15px; /* Diperbesar dari 14px */
        }

        .badge {
            padding: 8px 14px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 13px; /* Diperbesar */
        }

        /* ===== PERBESARAN GAMBAR DAN JUDUL ===== */
        .cover-thumbnail {
            width: 65px; /* Diperbesar dari 45px */
            height: 95px; /* Diperbesar dari 65px */
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            border: 1px solid #eaeaea;
        }

        .book-title-wrapper {
            display: flex;
            align-items: center;
            gap: 18px; /* Jarak gambar dan teks diperlebar sedikit */
        }

        .book-title-text h6 {
            margin: 0;
            font-weight: 700;
            font-size: 16px; /* Diperbesar dari 14px */
            color: #2b2b2b;
            line-height: 1.4;
        }

        @media (min-width: 992px) {
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
            #mainWrapper {
                margin-left: 280px !important;
            }
        }
    </style>
</head>

<body>

<div id="mainWrapper">

    <nav class="navbar navbar-light bg-white shadow-sm px-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-primary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list fs-4"></i>
            </button>
            <h4 class="ms-3 mt-2 fw-bold">Kelola Buku</h4>
        </div>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-bell fs-5"></i>
            <a href="#">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle">
            </a>
        </div>
    </nav>

    <div class="content">
        <div class="mb-4">
            <h1 class="fw-bold">Manajemen Buku</h1>
            <p class="text-muted fs-6">Kelola seluruh data buku perpustakaan digital</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-dashboard">
                    <div class="icon-box bg-blue">
                        <i class="bi bi-book-fill"></i>
                    </div>
                    <h2 class="fw-bold"><?= isset($totalBuku) ? $totalBuku : 0 ?></h2>
                    <p class="text-muted mb-0 fs-6">Total Buku</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-dashboard">
                    <div class="icon-box bg-green">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="fw-bold"><?= isset($totalTersedia) ? $totalTersedia : 0 ?></h2>
                    <p class="text-muted mb-0 fs-6">Buku Tersedia</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-dashboard">
                    <div class="icon-box bg-red">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <h2 class="fw-bold"><?= isset($totalHabis) ? $totalHabis : 0 ?></h2>
                    <p class="text-muted mb-0 fs-6">Buku Habis</p>
                </div>
            </div>
        </div>

        <div class="table-box">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0">Daftar Buku</h4>
                <a href="tambah_buku.php" class="btn btn-primary rounded-4 px-4 py-2">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Buku
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="min-width: 300px;">Buku</th> 
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($books)){ ?>
                            <?php foreach($books as $b){ ?>
                            <tr>
                                <td>
                                    <div class="book-title-wrapper">
                                        <?php 
                                        if(!empty($b['cover'])) {
                                            $imgSrc = "../assets/images/covers/" . htmlspecialchars($b['cover']); 
                                        } else {
                                            $imgSrc = 'https://placehold.co/65x95/e9ecef/a3a3a3?text=No+Cover';
                                        }
                                        ?>
                                        <img src="<?= $imgSrc ?>" alt="Cover Buku" class="cover-thumbnail">
                                        
                                        <div class="book-title-text">
                                            <h6><?= isset($b['judul']) ? htmlspecialchars($b['judul']) : '-' ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?= isset($b['penulis']) ? htmlspecialchars($b['penulis']) : '-' ?></td>
                                <td><?= isset($b['penerbit']) ? htmlspecialchars($b['penerbit']) : '-' ?></td>
                                <td><?= isset($b['tahun']) ? htmlspecialchars($b['tahun']) : '-' ?></td>
                                <td><span class="badge bg-light text-primary border border-primary-subtle"><?= isset($b['nama_kategori']) ? htmlspecialchars($b['nama_kategori']) : '-' ?></span></td>
                                <td><span class="fw-bold"><?= isset($b['stok']) ? htmlspecialchars($b['stok']) : 0 ?></span></td>
                                <td>
                                    <?php if(isset($b['stok']) && $b['stok'] > 0){ ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle">Tersedia</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle">Habis</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="edit_buku.php?id=<?= $b['id'] ?>" class="btn btn-warning btn-sm rounded-3 text-white px-2 py-1">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="hapus_buku.php?id=<?= $b['id'] ?>" class="btn btn-danger btn-sm rounded-3 px-2 py-1" onclick="return confirm('Yakin ingin hapus buku ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5 fs-5">Data buku belum ada</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> 

<div class="offcanvas offcanvas-start" id="sidebar" style="width:280px;" data-bs-backdrop="false">
    <div class="offcanvas-header border-bottom">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-book-half"></i> Digital Library
        </h4>
        <button class="btn-close d-lg-none" data-bs-dismiss="offcanvas"></button>
    </div>
    
    <div class="offcanvas-body d-flex flex-column">
        <div class="text-center mb-4">
            <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3">
            <h5 class="fw-bold mb-0">Administrator</h5>
            <small class="text-muted">Admin Perpustakaan</small>
        </div>

        <ul class="nav flex-column">
            <li><a class="nav-link" href="dashboard.php"><i class="bi bi-grid-fill me-2"></i> Dashboard</a></li>
            <li><a class="nav-link active" href="buku.php"><i class="bi bi-book-fill me-2"></i> Kelola Buku</a></li>
            <li><a class="nav-link" href="anggota.php"><i class="bi bi-people-fill me-2"></i> Data Anggota</a></li>
            <li><a class="nav-link" href="peminjaman.php"><i class="bi bi-journal-check me-2"></i> Peminjaman</a></li>
            <li><a class="nav-link" href="kategori.php"><i class="bi bi-tags-fill me-2"></i> Kategori Buku</a></li>
        </ul>

        <div class="mt-auto border-top pt-3">
            <a href="logout.php" class="btn btn-danger w-100 rounded-4 py-2">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
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