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
/* CSS TETAP SAMA */
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

*{ margin:0; padding:0; box-sizing:border-box; }
body{ background:var(--bg); font-family:'Poppins','DM Sans',sans-serif; overflow-y:auto; overflow-x:hidden; height:100%; min-height:100vh; }
.app{ display:flex; flex-direction:column; min-height:100vh; }
.navbar{ height:75px; border-radius:0 0 20px 20px; position:sticky; top:0; transition:0.3s; z-index:1020; background:white; }
.content{ padding:30px; transition:0.3s; flex:1; }
.shifted{ margin-left:280px; }
.offcanvas{ border:none; box-shadow:0 0 30px rgba(0,0,0,0.08); }
.nav-link-custom{ padding:14px 18px; border-radius:14px; color:#444; font-weight:500; margin-bottom:8px; display:flex; align-items:center; gap:12px; text-decoration:none; transition:0.2s; }
.nav-link-custom:hover, .nav-link-custom.active{ background:#0d6efd; color:white !important; }
.table-box{ background:white; border-radius:24px; padding:25px; box-shadow:0 10px 25px rgba(0,0,0,0.05); border:1px solid #f0f2f5; }
.section-header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px; }
.section-header h3{ font-size:1.35rem; font-weight:700; border-left:5px solid #0d6efd; padding-left:18px; margin:0; }
.search-input-group{ display:flex; align-items:center; background:#f8f9fa; border:1px solid #e9ecef; border-radius:40px; padding:8px 16px; gap:8px; }
.search-input-group input{ border:none; background:transparent; outline:none; font-size:13px; width:200px; }
.search-input-group i{ color:#6c757d; }
.filter-group{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:15px; }
.filter-pill{ padding:6px 16px; border-radius:30px; font-size:12px; font-weight:500; border:1px solid #e9ecef; background:#f8f9fa; color:#6c757d; cursor:pointer; transition:0.2s; }
.filter-pill:hover{ border-color:#0d6efd; color:#0d6efd; }
.filter-pill.active{ background:#0d6efd; border-color:#0d6efd; color:white; }
.book-grid-2col{ display:grid; grid-template-columns:repeat(2, 1fr); gap:16px; }
.book-card{ display:flex; gap:12px; padding:14px; background:#f8f9fa; border-radius:16px; transition:0.2s; border:1px solid #e9ecef; align-items:center; }
.book-card:hover{ transform:translateY(-2px); box-shadow:0 8px 16px rgba(0,0,0,0.06); border-color:#0d6efd; }
.book-icon{ width:55px; height:75px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
.book-info{ flex:1; min-width:0; }
.book-info h4{ font-size:0.85rem; font-weight:700; margin-bottom:3px; color:#1a1a2e; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.book-info .author{ font-size:9px; color:#6c757d; margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.book-bottom{ display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.badge-custom{ font-size:9px; padding:3px 10px; border-radius:20px; font-weight:600; display:inline-block; }
.badge-tersedia{ background:#d4edda; color:#276432; }
.badge-habis{ background:#f8d7da; color:#842029; }
.badge-terbatas{ background:#fff3cd; color:#856404; }
.btn-pinjam{ border:none; padding:4px 12px; border-radius:20px; background:#0d6efd; color:white; font-size:9px; font-weight:600; cursor:pointer; transition:0.2s; }
.btn-pinjam:hover{ background:#0a58ca; transform:translateY(-1px); }
.btn-pinjam:disabled{ background:#adb5bd; cursor:not-allowed; opacity:0.6; transform:none; }
.empty-state{ text-align:center; padding:60px; color:#6c757d; display: none; }
.empty-state i{ font-size:64px; margin-bottom:20px; display:block; opacity:0.5; }

/* Modal Peminjaman */
.modal-faux{ display:none; position:fixed; inset:0; z-index:1060; background:rgba(0,0,0,.5); backdrop-filter:blur(3px); align-items:center; justify-content:center; }
.modal-faux.show{ display:flex; }
.modal-box{ background:white; border-radius:24px; width:95%; max-width:400px; padding:20px; box-shadow:0 20px 35px rgba(0,0,0,0.2); animation:modalShow 0.28s ease; max-height:90vh; overflow-y:auto; }
@keyframes modalShow{ from{opacity:0;transform:scale(0.95) translateY(10px);} to{opacity:1;transform:scale(1) translateY(0);} }
.book-preview{ display:flex; align-items:center; gap:12px; background:#f8f9fa; border-radius:16px; padding:12px; margin-bottom:16px; border:1px solid #e9ecef; }
.book-preview-cover{ width:50px; height:66px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; }
.book-preview-title{ font-size:13px; font-weight:700; margin-bottom:3px; }
.book-preview-author{ font-size:10px; color:#6c757d; margin-bottom:5px; }
.form-row{ display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px; }
.form-group{ display:flex; flex-direction:column; gap:4px; }
.form-group label{ font-size:10px; font-weight:600; color:#6c757d; }
.form-group input{ padding:8px 10px; border:1px solid #e9ecef; border-radius:10px; font-size:12px; background:#f8f9fa; }
.modal-footer{ display:flex; gap:10px; justify-content:flex-end; margin-top:18px; padding-top:15px; border-top:1px solid #e9ecef; }
.btn-batal{ padding:8px 18px; border-radius:30px; background:#f0f0f0; border:none; font-size:11px; font-weight:600; cursor:pointer; }
.btn-proses{ padding:8px 20px; border-radius:30px; background:#0d6efd; border:none; color:white; font-size:11px; font-weight:600; cursor:pointer; }

/* NOTIFIKASI BESAR DI TENGAH */
.notif-center { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(10px); z-index: 1100; display: none; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; opacity: 0; transition: opacity 0.25s ease; }
.notif-center.show { display: flex; opacity: 1; }
.notif-card { background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%); border-radius: 56px; max-width: 440px; width: 86%; padding: 2rem 1.5rem 2.2rem 1.5rem; text-align: center; box-shadow: 0 40px 65px rgba(0, 0, 0, 0.25), 0 10px 20px rgba(0, 0, 0, 0.1); animation: notifPop 0.4s cubic-bezier(0.21, 1.11, 0.32, 1); border: 1px solid rgba(13, 110, 253, 0.2); }
@keyframes notifPop { 0% { transform: scale(0.85); opacity: 0; } 80% { transform: scale(1.02); } 100% { transform: scale(1); opacity: 1; } }
.notif-icon { font-size: 70px; background: linear-gradient(135deg, #0d6efd, #0a58ca); width: 100px; height: 100px; display: inline-flex; align-items: center; justify-content: center; border-radius: 60px; margin-bottom: 20px; color: white; box-shadow: 0 12px 25px rgba(13, 110, 253, 0.3); }
.notif-title { font-size: 28px; font-weight: 800; margin-bottom: 10px; background: linear-gradient(125deg, #0d6efd, #0b5ed7); background-clip: text; -webkit-background-clip: text; color: transparent; letter-spacing: -0.3px; }
.notif-message { font-size: 18px; font-weight: 500; color: #1e2a3a; margin-bottom: 20px; padding: 0 10px; line-height: 1.4; }
.notif-action-btn { background: #0d6efd; border: none; padding: 12px 28px; border-radius: 50px; font-weight: 700; font-size: 16px; letter-spacing: 0.3px; color: white; box-shadow: 0 8px 18px rgba(13, 110, 253, 0.3); transition: 0.2s; cursor: pointer;}
.notif-action-btn:hover { background: #0b5ed7; transform: scale(1.02); box-shadow: 0 10px 22px rgba(13, 110, 253, 0.4); }
</style>
</head>
<body>

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
<a class="nav-link-custom active"
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

        <div class="filter-group" id="categoryFilter">
            <button class="filter-pill active" data-cat="all">Semua</button>
            <?php 
            if(isset($bukuList) && !empty($bukuList)) {
                // UBAH 'kategori' MENJADI 'nama_kategori' DI SINI
                 $categories = array_unique(array_column($bukuList, 'nama_kategori'));
        
            foreach($categories as $cat): 
            // Tambahkan pengecekan agar tidak mencetak tombol kosong
            if(!empty($cat)): 
            ?>
            <button class="filter-pill" data-cat="<?= strtolower($cat); ?>"><?= htmlspecialchars($cat); ?></button>
            <?php 
            endif;
            endforeach; 
             }
            ?>
        </div>

        <div class="filter-group" id="statusFilter">
            <button class="filter-pill active" data-stat="all">Semua Status</button>
            <button class="filter-pill" data-stat="tersedia">Tersedia</button>
            <button class="filter-pill" data-stat="terbatas">Terbatas</button>
            <button class="filter-pill" data-stat="habis">Habis</button>
        </div>

        <div id="emptyState" class="empty-state">
            <i class="bi bi-journal-x"></i>
            <h4>Buku tidak ditemukan</h4>
            <p>Coba gunakan kata kunci atau filter lain.</p>
        </div>

        <div class="book-grid-2col" id="katalogGrid">
            <?php 
            if(isset($bukuList) && !empty($bukuList)): 
                foreach($bukuList as $buku): 
                    $stok = (int)$buku['stok'];
                    if($stok <= 0){
                        $badgeText  = "Habis";
                        $badgeClass = "badge-habis";
                        $status     = "habis";
                    } elseif($stok <= 5){
                        $badgeText  = $stok . " Tersisa";
                        $badgeClass = "badge-terbatas";
                        $status     = "terbatas";
                    } else{
                        $badgeText  = "Tersedia";
                        $badgeClass = "badge-tersedia";
                        $status     = "tersedia";
                    }
            ?>
            <div class="book-card"
                 data-category="<?= strtolower($buku['nama_kategori'] ?? 'lainnya'); ?>"
                 data-status="<?= $status; ?>"
                 data-title="<?= strtolower($buku['judul']); ?>"
                 data-author="<?= strtolower($buku['penulis']); ?>">

                <div class="book-icon">📘</div>

                <div class="book-info">
                    <h4><?= htmlspecialchars($buku['judul']); ?></h4>
                    <div class="author">
                        <?= htmlspecialchars($buku['penulis']); ?> · <?= htmlspecialchars($buku['nama_kategori'] ?? 'Tidak Berkategori'); ?>
                    </div>
                    <div class="book-bottom">
                        <span class="badge-custom <?= $badgeClass; ?>"><?= $badgeText; ?></span>

                        <?php if($stok <= 0): ?>
                            <button class="btn-pinjam" disabled>Stok Habis</button>
                        <?php else: ?>
                            <button class="btn-pinjam" 
                                onclick="pinjamBuku(<?= $buku['id']; ?>, '<?= addslashes($buku['judul']); ?>', '<?= addslashes($buku['penulis']); ?>')">
                                Pinjam
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endforeach; 
            endif;
            ?>
        </div>
    </div>
</div>

<div class="modal-faux" id="modalOverlay">
  <div class="modal-box">
    
    <form id="formPinjam" onsubmit="memprosesPeminjaman(event)">
        <h4 style="text-align:center; font-weight:bold; margin-bottom:15px;">Form Peminjaman</h4>
        
        <input type="hidden" name="buku_id" id="idBuku">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['id'] ?? 1); ?>">
        <input type="hidden" name="status" value="dipinjam">

        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="inputEmail" value="<?= htmlspecialchars($currentUser['email'] ?? ''); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Nama Peminjam</label>
                <input type="text" id="inputNama" value="<?= htmlspecialchars($currentUser['nama'] ?? ''); ?>" readonly>
            </div>
        </div>

        <div class="book-preview">
            <div class="book-preview-cover" style="background:#d4e8f4;">📘</div>
            <div>
                <div class="book-preview-title" id="mJudul2">—</div>
                <div class="book-preview-author" id="mPenulis2">—</div>
                <span class="badge-custom badge-tersedia">Tersedia</span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" id="tanggalPinjam" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggalKembali" readonly>
            </div>
        </div>

        <div class="form-group" style="margin-bottom:10px;">
            <label>Durasi</label>
            <input type="text" value="14 Hari" readonly>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
            <button type="submit" class="btn-proses">Proses Pinjam</button>
        </div>
    </form>
  </div>
</div>

<div id="bigNotifCenter" class="notif-center">
  <div class="notif-card">
    <div class="notif-icon"><i class="bi bi-check2-circle"></i></div>
    <div class="notif-title">Peminjaman Berhasil!</div>
    <div class="notif-message">
      Silahkan ambil buku di perpustakaan.<br>
      <span id="bigNotifBookName" style="font-weight:600; display:block; margin-top:10px; color:#0d6efd;">—</span>
    </div>
    <div style="font-size:14px; color:#6c757d; margin-bottom: 20px;" id="bigNotifUser">Terima kasih telah meminjam</div>
    <button class="notif-action-btn" id="closeBigNotifBtn" onclick="selesai()">OK, Mengerti</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Sidebar logika
const sidebar = document.getElementById('sidebar');
const content = document.querySelector('.content');
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

// VARIABEL PEMINJAMAN
let currentBook = {};

// MEMPERSIAPKAN DATA MODAL SAAT TOMBOL PINJAM DIKLIK
function pinjamBuku(id, judul, penulis) {
    currentBook = { id: id, judul: judul, penulis: penulis };

    document.getElementById('idBuku').value = id;
    document.getElementById('mJudul2').innerText = judul;
    document.getElementById('mPenulis2').innerText = penulis;

    // Set Tanggal Pinjam & Kembali otomatis (format YYYY-MM-DD)
    let today = new Date();
    let kembali = new Date();
    kembali.setDate(today.getDate() + 14); // 14 Hari peminjaman

    // Konversi ke format string ISO
    document.getElementById('tanggalPinjam').value = today.toISOString().split('T')[0];
    document.getElementById('tanggalKembali').value = kembali.toISOString().split('T')[0];

    document.getElementById('modalOverlay').classList.add('show');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('show');
}

// MENGIRIM DATA KE CONTROLLER MENGGUNAKAN FETCH API (AJAX)
function memprosesPeminjaman(event) {
    // Mencegah form memuat ulang halaman
    event.preventDefault(); 
    
    // Tutup modal formulir
    closeModal();
    
    const formElement = document.getElementById('formPinjam');
    const formData = new FormData(formElement);

    // GANTI URL FETCH-NYA MENJADI SEPERTI INI:
    fetch('peminjaman.php?action=store', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const namaPeminjam = document.getElementById('inputNama').value || "Mahasiswa";
            
            document.getElementById('bigNotifBookName').innerText = `📖 "${currentBook.judul}"`;
            document.getElementById('bigNotifUser').innerText = `Peminjam: ${namaPeminjam} • Selamat membaca!`;
            
            document.getElementById('bigNotifCenter').classList.add('show');
        } else {
            alert("Gagal memproses peminjaman: " + data.message);
            console.log(data);
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert("Gagal menghubungi server database.");
    });
}

// MENUTUP NOTIFIKASI BESAR
function selesai() {
    document.getElementById('bigNotifCenter').classList.remove('show');
    
    // Refresh otomatis agar stok buku terupdate secara visual
    window.location.reload(); 
}
</script>
</body>
</html>