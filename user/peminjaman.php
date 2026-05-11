<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman - Sistem Perpustakaan Digital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#f4f7fe;
  --card-bg:#ffffff;
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
  height:100vh;
  overflow:hidden;
}

.navbar{
  height:75px;
  border-radius:0 0 20px 20px;
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

.section-box{
  background:white;
  border-radius:24px;
  padding:25px;
  box-shadow:0 10px 25px rgba(0,0,0,0.05);
  border:1px solid #f0f2f5;
}

.pinjam-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.pinjam-header h3{
  font-size:1.35rem;
  font-weight:700;
  border-left:5px solid #0d6efd;
  padding-left:18px;
  margin:0;
}

.pinjam-table{
  width:100%;
  border-collapse:collapse;
}

.pinjam-table th{
  background:#f8f9fa;
  padding:14px 12px;
  text-align:left;
  font-size:13px;
  font-weight:700;
  color:#5b6e8c;
  border-bottom:2px solid #e9ecef;
}

.pinjam-table td{
  padding:14px 12px;
  border-bottom:1px solid #f1f1f1;
  font-size:13px;
  vertical-align:middle;
}

.status-pill{
  padding:6px 14px;
  border-radius:30px;
  font-size:11px;
  font-weight:600;
  display:inline-block;
}

.s-dipinjam{
  background:#fff3cd;
  color:#856404;
}
.s-terlambat{
  background:#f8d7da;
  color:#842029;
}
.s-kembali{
  background:#d4edda;
  color:#276432;
}

.btn-lihat{
  border:none;
  padding:6px 14px;
  border-radius:8px;
  background:#0d6efd;
  color:white;
  font-size:11px;
  font-weight:600;
  cursor:pointer;
  transition:0.2s;
}
.btn-lihat:hover{
  background:#0a58ca;
  transform:translateY(-2px);
}

/* MODAL FORM LOGIN STYLE */
.modal-form-container .modal-content {
    border-radius: 28px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}

.modal-header-form {
    background: #0f172a;
    color: white;
    padding: 22px 28px;
    position: relative;
    text-align: center;
}

.modal-header-form h3 {
    font-weight: 700;
    font-size: 1.35rem;
    margin: 0 0 4px 0;
    letter-spacing: -0.2px;
}

.modal-header-form .trx-code-form {
    font-size: 0.7rem;
    opacity: 0.7;
    margin: 0;
    font-family: monospace;
    letter-spacing: 0.5px;
}

.modal-body-form {
    padding: 28px 30px 20px 30px;
    background: #ffffff;
}

.form-group-box {
    margin-bottom: 20px;
}

.form-group-box label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #5b6e8c;
    margin-bottom: 6px;
    display: block;
}

.form-control-custom {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 12px 18px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #1e293b;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    min-height: 52px;
}

.row-2cols {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
}
.row-2cols .form-group-box {
    flex: 1;
    margin-bottom: 0;
}

.judul-section {
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px dashed #eef2f6;
}
.judul-section h4 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px 0;
}
.judul-section p {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.sisa-merah {
    color: #b91c1c;
    font-weight: 700;
}
.sisa-normal {
    color: #1e293b;
    font-weight: 500;
}
.sisa-hijau {
    color: #065f46;
    font-weight: 600;
}

/* Progress Box untuk Terlambat (warna merah) */
.progress-box-warning {
    background: #fef2f2;
    border: 1.5px solid #fee2e2;
    border-radius: 16px;
    padding: 12px 18px;
    margin-top: 4px;
    margin-bottom: 20px;
}

/* Progress Box untuk Dipinjam (warna biru) */
.progress-box-info {
    background: #f0f9ff;
    border: 1.5px solid #bddfff;
    border-radius: 16px;
    padding: 12px 18px;
    margin-top: 4px;
    margin-bottom: 20px;
}

.progress-header-warning {
    font-size: 0.7rem;
    font-weight: 700;
    color: #b91c1c;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
}

.progress-header-info {
    font-size: 0.7rem;
    font-weight: 700;
    color: #0c6b9e;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
}

.progress-bar-bg-custom {
    background: #e2e8f0;
    border-radius: 40px;
    height: 8px;
    overflow: hidden;
}
.progress-fill-red-custom {
    background: #ef4444;
    height: 100%;
    border-radius: 40px;
    transition: width 0.3s ease;
}
.progress-fill-blue-custom {
    background: #3b82f6;
    height: 100%;
    border-radius: 40px;
    transition: width 0.3s ease;
}

.status-section {
    margin-top: 8px;
    margin-bottom: 8px;
    padding: 0;
}

.status-label-custom {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #5b6e8c;
    margin-bottom: 8px;
    display: block;
}

.status-badge-large {
    display: inline-block;
    padding: 8px 28px;
    border-radius: 40px;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.badge-terlambat-form {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fee2e2;
}
.badge-dipinjam-form {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fef3c7;
}
.badge-kembali-form {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #d1fae5;
}

.modal-footer-form {
    padding: 16px 30px 28px 30px;
    background: white;
    border-top: 1px solid #edf2f7;
    display: flex;
    justify-content: flex-end;
}
.btn-tutup-form {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 10px 32px;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: 0.2s;
}
.btn-tutup-form:hover {
    background: #e2e8f0;
    transform: translateY(-1px);
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
<a href="#"><img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle"></a>
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
        <li class="nav-item"><a class="nav-link-custom active" href="peminjaman.php"><i class="bi bi-journal-check me-2"></i>Peminjaman</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="katalog.php"><i class="bi bi-book-half me-2"></i>Katalog</a></li>
    </ul>
    <div class="mt-auto border-top pt-3">
        <a href="#" class="btn btn-danger w-100 rounded-4"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>
</div>
</div>

<!-- MAIN CONTENT -->
<div class="content" id="mainContent">
  <div class="section-box">
    <div class="pinjam-header"><h3>📋 Data Peminjaman Saya</h3></div>
    <div class="table-responsive">
      <table class="pinjam-table">
        <thead>
          <tr><th>#</th><th>Judul Buku</th><th>Peminjam</th><th>NIM</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php 
          $dataList = [
              ["id" => 1, "judul" => "Algoritma & Pemrograman", "nama" => "Budi Santoso", "nim" => "2021001234", "tglPinjam" => "01 Apr 2025", "tglKembali" => "15 Apr 2025", "status" => "terlambat"],
              ["id" => 2, "judul" => "Basis Data Modern", "nama" => "Budi Santoso", "nim" => "2021001234", "tglPinjam" => "18 Apr 2025", "tglKembali" => "02 May 2025", "status" => "dipinjam"],
              ["id" => 3, "judul" => "Fisika Dasar", "nama" => "Budi Santoso", "nim" => "2021001234", "tglPinjam" => "10 Mar 2025", "tglKembali" => "24 Mar 2025", "status" => "kembali"]
          ];
          function statusLabel($s){ if($s == 'dipinjam') return 'Dipinjam'; if($s == 'terlambat') return 'Terlambat'; return 'Dikembalikan'; }
          function statusClass($s){ if($s == 'dipinjam') return 's-dipinjam'; if($s == 'terlambat') return 's-terlambat'; return 's-kembali'; }
          ?>
          <?php foreach($dataList as $d): ?>
          <tr>
            <td><?= $d['id']; ?></td>
            <td><strong><?= htmlspecialchars($d['judul']); ?></strong></td>
            <td><?= htmlspecialchars($d['nama']); ?></td>
            <td><?= $d['nim']; ?></td>
            <td><?= $d['tglPinjam']; ?></td>
            <td><?= $d['tglKembali']; ?></td>
            <td><span class="status-pill <?= statusClass($d['status']); ?>"><?= statusLabel($d['status']); ?></span></td>
            <td><button class="btn-lihat" onclick="showFormDetail(<?= htmlspecialchars(json_encode($d)); ?>)">👁 Lihat</button></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL DENGAN PROGRESS PER HARI (dari tanggal peminjaman hingga tanggal pengembalian) -->
<div class="modal fade modal-form-container" id="detailFormModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 560px;">
    <div class="modal-content">
      
      <div class="modal-header-form">
        <h3><i class="bi bi-journal-bookmark-fill"></i> Detail Peminjaman</h3>
        <p class="trx-code-form" id="formTrxCode">#TRX-0001</p>
      </div>
      
      <div class="modal-body-form">
        
        <div class="judul-section">
          <h4 id="formJudulBuku">Algoritma & Pemrograman</h4>
          <p><i class="bi bi-person-circle"></i> <span id="formNamaPeminjam">Budi Santoso</span></p>
        </div>
        
        <div class="row-2cols">
          <div class="form-group-box">
            <label><i class="bi bi-qr-code"></i> NIM</label>
            <div class="form-control-custom" id="formNimValue">2021001234</div>
          </div>
          <div class="form-group-box">
            <label><i class="bi bi-person"></i> Nama Lengkap</label>
            <div class="form-control-custom" id="formNamaValue">Budi Santoso</div>
          </div>
        </div>
        
        <div class="form-group-box">
          <label><i class="bi bi-calendar-plus"></i> Tanggal Pinjam</label>
          <div class="form-control-custom" id="formTglPinjam">01 Apr 2025</div>
        </div>
        
        <div class="form-group-box">
          <label><i class="bi bi-calendar-check"></i> Tanggal Kembali</label>
          <div class="form-control-custom" id="formTglKembali">15 Apr 2025</div>
        </div>
        
        <div class="row-2cols">
          <div class="form-group-box">
            <label><i class="bi bi-hourglass-split"></i> Durasi</label>
            <div class="form-control-custom" id="formDurasi">14 Hari</div>
          </div>
          <div class="form-group-box">
            <label><i class="bi bi-clock-history"></i> Sisa Hari</label>
            <div class="form-control-custom" id="formSisaHari">3 Hari</div>
          </div>
        </div>
        
        <!-- PROGRESS AREA UNTUK TERLAMBAT (style merah) - dihitung dari hari keterlambatan -->
        <div id="formProgressTerlambatArea" style="display: none;">
          <div class="progress-box-warning">
            <div class="progress-header-warning">
              <span><i class="bi bi-exclamation-triangle-fill"></i> Status Terlambat</span>
              <span id="formPersenTerlambat">0%</span>
            </div>
            <div class="progress-bar-bg-custom">
              <div class="progress-fill-red-custom" id="formProgressFillTerlambat" style="width: 0%;"></div>
            </div>
            <div style="font-size: 0.7rem; color:#b91c1c; margin-top: 10px; font-weight: 500;" id="formTerlambatDesc">
              ⚠️ Melebihi batas pengembalian
            </div>
          </div>
        </div>
        
        <!-- PROGRESS AREA UNTUK DIPINJAM (style biru) - dihitung dari hari yang sudah berjalan sejak pinjam hingga kembali -->
        <div id="formProgressDipinjamArea" style="display: none;">
          <div class="progress-box-info">
            <div class="progress-header-info">
              <span><i class="bi bi-calendar-week"></i> Progress Peminjaman</span>
              <span id="formPersenDipinjam">0%</span>
            </div>
            <div class="progress-bar-bg-custom">
              <div class="progress-fill-blue-custom" id="formProgressFillDipinjam" style="width: 0%;"></div>
            </div>
            <div style="font-size: 0.7rem; color:#0c6b9e; margin-top: 10px; font-weight: 500;" id="formDipinjamDesc">
              📅 Menghitung masa peminjaman
            </div>
          </div>
        </div>
        
        <div class="status-section">
          <div class="status-label-custom"><i class="bi bi-flag-fill"></i> STATUS PEMINJAMAN</div>
          <span class="status-badge-large" id="formStatusBadge">Terlambat</span>
        </div>
        
      </div>
      
      <div class="modal-footer-form">
        <button class="btn-tutup-form" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Tutup</button>
      </div>
      
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar shifting
const sidebarElem = document.getElementById('sidebar');
const contentDiv = document.querySelector('.content');
const navbarElem = document.querySelector('.navbar');

function isDesktop(){ return window.innerWidth > 992; }

if(sidebarElem) {
    sidebarElem.addEventListener('shown.bs.offcanvas', function () { if(isDesktop()){ contentDiv.classList.add('shifted'); navbarElem.classList.add('shifted'); } });
    sidebarElem.addEventListener('hidden.bs.offcanvas', function () { contentDiv.classList.remove('shifted'); navbarElem.classList.remove('shifted'); });
}
window.addEventListener('resize', () => { if(window.innerWidth <= 992){ contentDiv.classList.remove('shifted'); navbarElem.classList.remove('shifted'); } else if(!sidebarElem.classList.contains('show')) { contentDiv.classList.remove('shifted'); navbarElem.classList.remove('shifted'); } });

// Parse tanggal Indonesia (format: "01 Apr 2025")
function parseIndonesianDate(dateStr) {
    const months = {
        'Jan':0,'Feb':1,'Mar':2,'Apr':3,'May':4,'Jun':5,
        'Jul':6,'Aug':7,'Sep':8,'Oct':9,'Nov':10,'Dec':11
    };
    let parts = dateStr.split(' ');
    if(parts.length === 3) {
        let day = parseInt(parts[0]);
        let month = months[parts[1]];
        let year = parseInt(parts[2]);
        if(!isNaN(day) && month !== undefined && !isNaN(year)) {
            return new Date(year, month, day);
        }
    }
    return new Date(dateStr);
}

/**
 * Menghitung progress pinjaman per hari
 * @param {Date} tglPinjam - tanggal pinjam
 * @param {Date} tglKembali - tanggal kembali (jatuh tempo)
 * @param {Date} today - tanggal hari ini
 * @returns {Object} { durasi, hariBerjalan, sisaHari, persenProgress }
 */
function hitungProgressPerHari(tglPinjam, tglKembali, today) {
    // Reset jam ke 00:00:00 untuk perbandingan hari yang akurat
    const pinjam = new Date(tglPinjam);
    pinjam.setHours(0,0,0,0);
    const kembali = new Date(tglKembali);
    kembali.setHours(0,0,0,0);
    const sekarang = new Date(today);
    sekarang.setHours(0,0,0,0);
    
    // Durasi total dalam hari (termasuk tanggal awal dan akhir? Untuk progress, total hari dari pinjam sampai kembali)
    // Contoh: pinjam 1 Apr, kembali 15 Apr -> total durasi = 14 hari (selisih)
    const durasiMillis = kembali.getTime() - pinjam.getTime();
    const durasi = Math.ceil(durasiMillis / (1000 * 60 * 60 * 24));
    
    // Hitung hari yang sudah berjalan (sudah lewat sejak pinjam)
    let hariBerjalan = Math.ceil((sekarang.getTime() - pinjam.getTime()) / (1000 * 60 * 60 * 24));
    hariBerjalan = Math.max(0, Math.min(hariBerjalan, durasi));
    
    // Sisa hari (jika belum lewat jatuh tempo)
    let sisaHari = Math.ceil((kembali.getTime() - sekarang.getTime()) / (1000 * 60 * 60 * 24));
    sisaHari = Math.max(0, sisaHari);
    
    // Persentase progress: (hariBerjalan / durasi) * 100
    let persenProgress = durasi > 0 ? (hariBerjalan / durasi) * 100 : 0;
    persenProgress = Math.min(Math.max(persenProgress, 0), 100);
    
    return { durasi, hariBerjalan, sisaHari, persenProgress };
}

/**
 * Menghitung progres untuk status terlambat
 * Menghitung berapa hari keterlambatan dan persen terhadap durasi
 */
function hitungProgressTerlambat(tglKembali, today, durasi) {
    const kembali = new Date(tglKembali);
    kembali.setHours(0,0,0,0);
    const sekarang = new Date(today);
    sekarang.setHours(0,0,0,0);
    
    let hariTerlambat = Math.ceil((sekarang.getTime() - kembali.getTime()) / (1000 * 60 * 60 * 24));
    hariTerlambat = Math.max(0, hariTerlambat);
    
    // Persentase keterlambatan dibanding durasi (maks 100%)
    let persenTerlambat = durasi > 0 ? (hariTerlambat / durasi) * 100 : 0;
    persenTerlambat = Math.min(Math.max(persenTerlambat, 0), 100);
    
    return { hariTerlambat, persenTerlambat };
}

function showFormDetail(data) {
    const { id, judul, nama, nim, tglPinjam, tglKembali, status } = data;
    
    // Parsing tanggal
    const pinjamDate = parseIndonesianDate(tglPinjam);
    const kembaliDate = parseIndonesianDate(tglKembali);
    const today = new Date();
    today.setHours(0,0,0,0);
    
    // Hitung durasi total
    const durasiTotal = Math.ceil((kembaliDate.getTime() - pinjamDate.getTime()) / (1000 * 60 * 60 * 24));
    
    // Hitung progress untuk dipinjam (normal)
    const progressNormal = hitungProgressPerHari(pinjamDate, kembaliDate, today);
    
    // Format kode transaksi
    const trxNumber = String(id).padStart(4, '0');
    document.getElementById('formTrxCode').innerHTML = `#TRX-${trxNumber}`;
    document.getElementById('formJudulBuku').innerHTML = judul;
    document.getElementById('formNamaPeminjam').innerHTML = nama;
    document.getElementById('formNamaValue').innerHTML = nama;
    document.getElementById('formNimValue').innerHTML = nim;
    document.getElementById('formTglPinjam').innerHTML = tglPinjam;
    document.getElementById('formTglKembali').innerHTML = tglKembali;
    document.getElementById('formDurasi').innerHTML = `${durasiTotal} Hari`;
    
    const sisaElement = document.getElementById('formSisaHari');
    const statusBadge = document.getElementById('formStatusBadge');
    const progressTerlambatArea = document.getElementById('formProgressTerlambatArea');
    const progressDipinjamArea = document.getElementById('formProgressDipinjamArea');
    
    // Sembunyikan kedua area progress
    progressTerlambatArea.style.display = 'none';
    progressDipinjamArea.style.display = 'none';
    
    if(status === 'terlambat') {
        // Hitung keterlambatan
        const terlambat = hitungProgressTerlambat(kembaliDate, today, durasiTotal);
        const { hariTerlambat, persenTerlambat } = terlambat;
        
        statusBadge.innerHTML = 'Terlambat';
        statusBadge.className = 'status-badge-large badge-terlambat-form';
        
        // Tampilkan sisa hari (untuk terlambat, sisa hari = 0, tapi tunjukkan keterlambatan)
        if(hariTerlambat > 0) {
            sisaElement.innerHTML = `<span class="sisa-merah">Terlambat ${hariTerlambat} hari</span>`;
        } else {
            sisaElement.innerHTML = `<span class="sisa-merah">Hari terakhir (jatuh tempo hari ini)</span>`;
        }
        
        // Tampilkan progress terlambat dengan persen
        progressTerlambatArea.style.display = 'block';
        const persenBulat = Math.round(persenTerlambat);
        document.getElementById('formPersenTerlambat').innerHTML = `${persenBulat}%`;
        document.getElementById('formProgressFillTerlambat').style.width = `${persenBulat}%`;
        
        let descText = '';
        if(hariTerlambat > 0) {
            descText = `⚠️ Terlambat ${hariTerlambat} hari dari jadwal (${persenBulat}% dari durasi pinjaman)`;
        } else {
            descText = `⚠️ Batas pengembalian hari ini, segera kembalikan buku`;
        }
        document.getElementById('formTerlambatDesc').innerHTML = descText;
        
    } 
    else if(status === 'dipinjam') {
        // Menggunakan progress per hari dari tanggal pinjam hingga tanggal kembali
        const { durasi, hariBerjalan, sisaHari, persenProgress } = progressNormal;
        
        statusBadge.innerHTML = 'Dipinjam';
        statusBadge.className = 'status-badge-large badge-dipinjam-form';
        
        if(sisaHari > 0) {
            sisaElement.innerHTML = `<span class="sisa-normal">${sisaHari} Hari</span>`;
        } else {
            sisaElement.innerHTML = `<span class="sisa-normal">Jatuh tempo hari ini</span>`;
        }
        
        // Tampilkan progress masa peminjaman (biru) dengan persen berdasarkan hari yang sudah berjalan
        progressDipinjamArea.style.display = 'block';
        const persenBulat = Math.round(persenProgress);
        document.getElementById('formPersenDipinjam').innerHTML = `${persenBulat}%`;
        document.getElementById('formProgressFillDipinjam').style.width = `${persenBulat}%`;
        document.getElementById('formDipinjamDesc').innerHTML = `📅 ${hariBerjalan} dari ${durasi} hari terpakai • Sisa ${sisaHari} hari lagi`;
    } 
    else { // status kembali
        statusBadge.innerHTML = 'Dikembalikan';
        statusBadge.className = 'status-badge-large badge-kembali-form';
        sisaElement.innerHTML = `<span class="sisa-hijau">✔️ Selesai (sudah dikembalikan)</span>`;
    }
    
    const modalElement = document.getElementById('detailFormModal');
    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();
}

window.showFormDetail = showFormDetail;
</script>
</body>
</html>