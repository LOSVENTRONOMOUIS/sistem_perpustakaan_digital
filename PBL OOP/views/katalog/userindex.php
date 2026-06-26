<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke public/katalog.php jika file view ini diakses langsung
if (!isset($bukuList)) {
    header("Location: ../../public/katalog.php");
    exit;
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['id'])) {
    header("Location: ../../public/login.php");
    exit;
}
// Gunakan $currentUser jika ada, jika tidak fallback ke $_SESSION
$namaUser = $currentUser['nama'] ?? $_SESSION['nama'] ?? 'Mahasiswa';
$emailUser = $currentUser['email'] ?? $_SESSION['email'] ?? 'Library User';
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
  min-height:100vh;
  overflow-x:hidden;
}

/* Animasi */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    animation: slideInRight 0.3s ease-out;
}

.toast-notification.hide {
    animation: slideOutRight 0.3s ease-out forwards;
}

.toast-card {
    background: white;
    border-radius: 16px;
    padding: 16px 20px;
    min-width: 320px;
    max-width: 450px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 15px;
    border-left: 5px solid;
}

.toast-success {
    border-left-color: #28a745;
}
.toast-success .toast-icon {
    background: #e8f5e9;
    color: #28a745;
}

.toast-error {
    border-left-color: #dc3545;
}
.toast-error .toast-icon {
    background: #fee;
    color: #dc3545;
}

.toast-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.toast-content {
    flex: 1;
}

.toast-title {
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 4px;
}

.toast-message {
    font-size: 13px;
    color: #6c757d;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #999;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s;
}

.toast-close:hover {
    background: #f0f0f0;
    color: #333;
}

@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}

.navbar{
  height:75px;
  border-radius:0 0 20px 20px;
  z-index:1020;
  animation: slideInLeft 0.5s ease;
}

.content{
  padding:30px;
  transition:0.3s;
  animation: fadeInUp 0.6s ease;
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
  transition: all 0.3s ease;
}

.nav-link-custom:hover,
.nav-link-custom.active{
  background:#0d6efd;
  color:white !important;
  transform: translateX(5px);
}

.section-box{
  background:white;
  border-radius:24px;
  padding:25px;
  box-shadow:0 10px 25px rgba(0,0,0,0.05);
  border:1px solid #f0f2f5;
  transition: all 0.3s ease;
  animation: fadeInUp 0.6s ease;
}

.section-box:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.pinjam-header{
  margin-bottom:25px;
  animation: slideInLeft 0.5s ease;
}

.pinjam-header h3{
  font-size:1.35rem;
  font-weight:700;
  border-left:5px solid #0d6efd;
  padding-left:18px;
  margin:0;
  color:#1e293b;
}

/* ========== FILTER STYLING ========== */
.filter-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}

.filter-btn {
    padding: 8px 20px;
    border-radius: 30px;
    border: 2px solid #e2e8f0;
    background: white;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.filter-btn:hover {
    border-color: #0d6efd;
    color: #0d6efd;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: #0d6efd;
    border-color: #0d6efd;
    color: white;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.filter-btn .badge-count {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.filter-btn:not(.active) .badge-count {
    background: #e2e8f0;
    color: #475569;
}

.filter-btn.active .badge-count {
    background: rgba(255,255,255,0.3);
    color: white;
}

/* Tabel Styling */
.table-responsive {
    overflow-x: auto;
    border-radius: 16px;
}

.pinjam-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

.pinjam-table thead th {
    background: #f8fafc;
    padding: 16px 16px;
    font-weight: 600;
    font-size: 13px;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 10;
}

.pinjam-table thead th:first-child {
    border-top-left-radius: 12px;
}

.pinjam-table thead th:last-child {
    border-top-right-radius: 12px;
}

.pinjam-table tbody tr {
    transition: all 0.2s ease;
    animation: slideInRight 0.4s ease;
    animation-fill-mode: both;
}

.pinjam-table tbody tr:hover {
    background-color: #f8fafc;
    transform: scale(1.01);
}

.pinjam-table tbody td {
    padding: 16px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}

.pinjam-table tbody tr.hidden-row {
    display: none;
}

/* Status Badge */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.status-pill:hover {
    transform: translateY(-1px);
}

.status-pill i {
    font-size: 12px;
}

.status-pill-primary {
    background-color: #dbeafe;
    color: #1e40af;
    box-shadow: 0 2px 6px rgba(30, 64, 175, 0.1);
}

.status-pill-danger {
    background-color: #fee2e2;
    color: #991b1b;
    box-shadow: 0 2px 6px rgba(153, 27, 27, 0.1);
}

.status-pill-success {
    background-color: #dcfce7;
    color: #166534;
    box-shadow: 0 2px 6px rgba(22, 101, 52, 0.1);
}

.status-pill-secondary {
    background-color: #e5e7eb;
    color: #4b5563;
    box-shadow: 0 2px 6px rgba(75, 85, 99, 0.1);
}

.s-dipinjam {
    background-color: #fef3c7;
    color: #92400e;
    box-shadow: 0 2px 6px rgba(146, 64, 14, 0.1);
}

.s-dipinjam i {
    color: #b45309;
}

.s-terlambat {
    background-color: #fee2e2;
    color: #991b1b;
    box-shadow: 0 2px 6px rgba(153, 27, 27, 0.1);
}

.s-terlambat i {
    color: #dc2626;
}

.s-kembali {
    background-color: #dcfce7;
    color: #166534;
    box-shadow: 0 2px 6px rgba(22, 101, 52, 0.1);
}

.s-kembali i {
    color: #059669;
}

.s-batal {
    background-color: #e5e7eb;
    color: #4b5563;
    box-shadow: 0 2px 6px rgba(75, 85, 99, 0.1);
}

.s-batal i {
    color: #6b7280;
}

/* Tombol Aksi */
.btn-lihat {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    background: #2563eb;
    color: white;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 1px 6px rgba(37, 99, 235, 0.15);
    white-space: nowrap;
    margin-right: 10px;
    margin-bottom: 8px;
}

.btn-lihat i {
    font-size: 13px;
    color: white;
}

.btn-lihat:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
}

.btn-batalkan {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    background: #fcd34d;
    color: #1f2937;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 1px 6px rgba(252, 211, 77, 0.15);
    white-space: nowrap;
}

.btn-batalkan i {
    font-size: 14px;
    color: #1f2937;
}

.btn-batalkan:hover {
    background: #fbbf24;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(252, 211, 77, 0.2);
}

.btn-batalkan:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

.action-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Modal Detail Styling */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    transform: scale(0.95);
    opacity: 0;
}

.modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
}

.modal-form-container .modal-content {
    border-radius: 28px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.modal-header-form {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: white;
    padding: 20px 28px;
    text-align: center;
}

.modal-header-form h3 {
    font-weight: 700;
    font-size: 1.3rem;
    margin: 0;
}

.modal-header-form .trx-code-form {
    font-size: 0.7rem;
    opacity: 0.7;
    margin: 5px 0 0 0;
    font-family: monospace;
}

.modal-body-form {
    padding: 24px 28px;
    background: #ffffff;
}

.form-group-box {
    margin-bottom: 18px;
}

.form-group-box label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #64748b;
    margin-bottom: 6px;
    display: block;
}

.form-control-custom {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 10px 16px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #1e293b;
    width: 100%;
    min-height: 48px;
}

.row-2cols {
    display: flex;
    gap: 16px;
    margin-bottom: 18px;
}
.row-2cols .form-group-box {
    flex: 1;
    margin-bottom: 0;
}

.judul-section {
    margin-bottom: 20px;
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

/* Progress Bar */
.progress-box-warning, .progress-box-info {
    border-radius: 14px;
    padding: 12px 16px;
    margin-top: 4px;
    margin-bottom: 18px;
}

.progress-box-warning {
    background: #fef2f2;
    border: 1px solid #fee2e2;
}

.progress-box-info {
    background: #f0f9ff;
    border: 1px solid #bddfff;
}

.progress-header-warning, .progress-header-info {
    font-size: 0.7rem;
    font-weight: 700;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
}

.progress-header-warning { color: #b91c1c; }
.progress-header-info { color: #0c6b9e; }

.progress-bar-bg-custom {
    background: #e2e8f0;
    border-radius: 40px;
    height: 6px;
    overflow: hidden;
}

.progress-fill-red-custom {
    background: linear-gradient(90deg, #ef4444, #dc2626);
    height: 100%;
    border-radius: 40px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.progress-fill-blue-custom {
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    height: 100%;
    border-radius: 40px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.status-section {
    margin-top: 8px;
}

.status-label-custom {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #64748b;
    margin-bottom: 8px;
    display: block;
}

.status-badge-large {
    display: inline-block;
    padding: 8px 28px;
    border-radius: 40px;
    font-size: 0.85rem;
    font-weight: 700;
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
.badge-batal-form {
    background: #e2e3e5;
    color: #383d41;
    border: 1px solid #d6d8db;
}

.modal-footer-form {
    padding: 16px 28px 24px 28px;
    background: white;
    border-top: 1px solid #edf2f7;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
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
    transition: all 0.3s ease;
}

.btn-tutup-form:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

/* Alert Empty */
.alert-empty {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 20px;
    animation: fadeInUp 0.6s ease;
}

.alert-empty i {
    font-size: 60px;
    color: #adb5bd;
    margin-bottom: 20px;
}

/* Counter Info */
.counter-info {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: #f1f5f9;
    border-radius: 30px;
    font-size: 13px;
    color: #475569;
    margin-left: 12px;
}

.counter-info strong {
    color: #0d6efd;
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #0d6efd;
    border-radius: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-container {
        padding: 10px;
        gap: 6px;
    }
    .filter-btn {
        padding: 6px 14px;
        font-size: 12px;
    }
    .pinjam-table tbody td {
        padding: 12px 10px;
        font-size: 13px;
    }
    .action-group {
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
    }
    .btn-lihat, .btn-batalkan {
        padding: 4px 12px;
        font-size: 11px;
        margin-right: 0;
    }
    .btn-batalkan i {
        font-size: 12px;
    }
    .row-2cols {
        flex-direction: column;
        gap: 10px;
    }
    .modal-body-form {
        padding: 16px;
    }
}
/* Katalog Specific CSS */
.search-input-group{ display:flex; align-items:center; background:#f8f9fa; border:1px solid #e2e8f0; border-radius:40px; padding:8px 16px; gap:8px; transition:0.3s; }
.search-input-group:focus-within { border-color:#0d6efd; box-shadow:0 0 0 3px rgba(13,110,253,0.1); }
.search-input-group input{ border:none; background:transparent; outline:none; font-size:13px; width:220px; }
.search-input-group i{ color:#64748b; }
.pinjam-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; }
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
<a href="../views/auth/profile.php"><img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle"></a>
</div>
</nav>

<!-- SIDEBAR -->
<<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" style="width:280px;" data-bs-backdrop="false">
<div class="offcanvas-header border-bottom">
    <h4 class="fw-bold text-primary"><i class="bi bi-book-half"></i> Digital Library</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>
<div class="offcanvas-body d-flex flex-column">
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3">
        <h5 class="fw-bold mb-0"><?= htmlspecialchars($_SESSION['nama'] ?? 'Mahasiswa'); ?></h5>
        <small class="text-muted"><?= htmlspecialchars($_SESSION['nim'] ?? 'Library User'); ?></small>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link-custom" href="dashboard_anggota.php"><i class="bi bi-grid-fill me-2"></i>Dashboard</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="peminjaman_user.php"><i class="bi bi-journal-check me-2"></i>Peminjaman</a></li>
        <li class="nav-item"><a class="nav-link-custom active " href="katalog.php"><i class="bi bi-book-half me-2"></i>Katalog</a></li>
    </ul>
    <div class="mt-auto border-top pt-3">
        <a href="../public/logout.php" class="btn btn-danger w-100 rounded-4"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>
</div>
</div>




<!-- MAIN CONTENT --><div class="content" id="mainContent">

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

        <div class="filter-container" id="categoryFilter">
            <button class="filter-btn active" data-cat="all">Semua</button>
            <?php 
            if(isset($bukuList) && !empty($bukuList)) {
                // UBAH 'kategori' MENJADI 'nama_kategori' DI SINI
                 $categories = array_unique(array_column($bukuList, 'nama_kategori'));
        
            foreach($categories as $cat): 
            // Tambahkan pengecekan agar tidak mencetak tombol kosong
            if(!empty($cat)): 
            ?>
            <button class="filter-btn" data-cat="<?= strtolower($cat); ?>"><?= htmlspecialchars($cat); ?></button>
            <?php 
            endif;
            endforeach; 
             }
            ?>
        </div>

        <div class="filter-container" id="statusFilter">
            <button class="filter-btn active" data-stat="all">Semua Status</button>
            <button class="filter-btn" data-stat="tersedia">Tersedia</button>
            <button class="filter-btn" data-stat="terbatas">Terbatas</button>
            <button class="filter-btn" data-stat="habis">Habis</button>
        </div>

        <div id="emptyState" class="alert-empty" style="display: none;">
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
                                onclick="pinjamBuku('<?= $buku['id']; ?>', '<?= addslashes(htmlspecialchars($buku['judul'])); ?>', '<?= addslashes(htmlspecialchars($buku['penulis'])); ?>')">
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
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['id'] ?? $_SESSION['user_id'] ?? 1); ?>">
        <input type="hidden" name="status" value="dipinjam">

        <div class="form-row">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="inputEmail" value="<?= htmlspecialchars($emailUser); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Nama Peminjam</label>
                <input type="text" id="inputNama" value="<?= htmlspecialchars($namaUser); ?>" readonly>
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

document.querySelectorAll('#categoryFilter .filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#categoryFilter .filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentCategory = this.getAttribute('data-cat');
        filterBooks();
    });
});
document.querySelectorAll('#statusFilter .filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#statusFilter .filter-btn').forEach(b => b.classList.remove('active'));
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
    formData.append('action', 'pinjam');
    fetch('katalog.php', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.status === 'success') {
            const namaPeminjam = document.getElementById('inputNama').value || "Mahasiswa";
            
            document.getElementById('bigNotifBookName').innerText = `📖 "${currentBook.judul}"`;
            document.getElementById('bigNotifUser').innerText = `Peminjam: ${namaPeminjam} • Selamat membaca!`;
            
            document.getElementById('bigNotifCenter').classList.add('show');
        } else {
            alert("Gagal memproses peminjaman: " + (data.message || "Kesalahan tidak diketahui"));
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