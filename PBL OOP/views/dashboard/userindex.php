
<?php
/**
 * VIEW TEMPLATE: User Dashboard
 * Data disiapkan oleh public/dashboard_anggota.php
 * @var bool $is_locked
 * @var string $user_nama
 * @var string $user_nim
 * @var int $totalKoleksi
 * @var int $totalDipinjam
 * @var int $totalTerlambat
 * @var array $bukuPopuler
 */

if (!isset($is_locked)) {
  header('Location: ../../public/dashboard_anggota.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Sistem Perpustakaan Digital <?= $is_locked ? '- Akses Terkunci' : '' ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ==================== CSS ==================== */
:root{
  --bg:#f4f7fe;
  --card-bg:#ffffff;
  --text:#1a1a1a;
  --text-muted:#6c757d;
  --sidebar-width: 280px;
  --navbar-height: 75px;
}

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background: <?= $is_locked ? '#0f0f1a' : 'var(--bg)' ?>;
  font-family:'Poppins','DM Sans',sans-serif;
  min-height:100vh;
  overflow-x:hidden;
  transition: all 0.3s ease;
  color: <?= $is_locked ? '#e0e0e0' : '#333' ?>;
}

.navbar{
  height: var(--navbar-height);
  border-radius:0 0 20px 20px;
  position:fixed;
  top:0;
  left:0;
  right:0;
  z-index:1000;
  background: <?= $is_locked ? 'linear-gradient(135deg, #16213e, #0f0f1a)' : 'white' ?> !important;
  border-bottom: <?= $is_locked ? '2px solid #ef4444' : 'none' ?>;
  box-shadow: <?= $is_locked ? '0 4px 20px rgba(239, 68, 68, 0.2)' : '0 2px 10px rgba(0,0,0,0.05)' ?>;
}

.navbar .fw-bold {
  color: <?= $is_locked ? '#ffffff' : '#0d6efd' ?>;
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  z-index: 1040;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}

.sidebar-overlay.show {
  opacity: 1;
  visibility: visible;
}

.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: var(--sidebar-width);
  height: 100vh;
  background: <?= $is_locked ? '#16213e' : 'white' ?>;
  box-shadow: 2px 0 20px rgba(0,0,0,0.1);
  z-index: 1050;
  transform: translateX(-100%);
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
}

.sidebar.show {
  transform: translateX(0);
}

.sidebar-header {
  padding: 20px;
  border-bottom: 1px solid <?= $is_locked ? '#ef4444' : '#e9ecef' ?>;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.sidebar-header h4 {
  margin: 0;
  font-size: 1.2rem;
  color: <?= $is_locked ? '#ef4444' : '#0d6efd' ?>;
}

.sidebar-body {
  flex: 1;
  padding: 20px;
  overflow-y: auto;
}

.sidebar-footer {
  padding: 20px;
  border-top: 1px solid <?= $is_locked ? '#2a2a3e' : '#e9ecef' ?>;
}

.sidebar-close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: <?= $is_locked ? '#ef4444' : '#6c757d' ?>;
  transition: all 0.2s ease;
}

.sidebar-close-btn:hover {
  color: #0d6efd;
  transform: rotate(90deg);
}

.nav-link-custom{
  padding: 14px 18px;
  border-radius: 14px;
  color: <?= $is_locked ? '#c0c0c0' : '#444' ?>;
  font-weight: 500;
  margin-bottom: 8px;
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.nav-link-custom:not(.disabled-nav):hover,
.nav-link-custom:not(.disabled-nav).active{
  background: <?= $is_locked ? '#ef4444' : '#0d6efd' ?>;
  color: white !important;
  transform: translateX(5px);
}

.nav-link-custom.disabled-nav {
  background: <?= $is_locked ? '#2a2a3e' : '#e9ecef' ?>;
  color: <?= $is_locked ? '#6c6c8c' : '#adb5bd' ?> !important;
  cursor: not-allowed;
  opacity: 0.7;
}

.content{
  margin-top: var(--navbar-height);
  padding: 30px;
  transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  min-height: calc(100vh - var(--navbar-height));
}

@media (min-width: 992px) {
  body.sidebar-open .sidebar {
    transform: translateX(0);
  }
  body.sidebar-open .content {
    margin-left: var(--sidebar-width);
  }
  .sidebar-overlay {
    display: none;
  }
}

@media (max-width: 991px) {
  body.sidebar-open {
    overflow: hidden;
  }
  .content {
    margin-left: 0;
  }
}

.sidebar-toggle {
  background: transparent;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: <?= $is_locked ? '#ef4444' : '#0d6efd' ?>;
  padding: 8px;
  border-radius: 8px;
  transition: all 0.2s ease;
}

.sidebar-toggle:hover {
  background: rgba(0,0,0,0.05);
  transform: scale(1.05);
}

.card-dashboard{
  border: none;
  border-radius: 24px;
  padding: 25px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  background: <?= $is_locked ? '#1e1e2e' : 'white' ?>;
  height: 100%;
  min-height: 180px;
  display: flex;
  flex-direction: column;
  animation: fadeInUp 0.5s ease-out;
  border: <?= $is_locked ? '1px solid #2a2a3e' : 'none' ?>;
}

.card-dashboard:hover{
  transform: translateY(-5px);
  <?php if($is_locked): ?>
  border-color: #ef4444;
  box-shadow: 0 15px 35px rgba(239, 68, 68, 0.15);
  <?php else: ?>
  box-shadow: 0 15px 35px rgba(0,0,0,0.1);
  <?php endif; ?>
}

.card-dashboard.locked-card {
  background: linear-gradient(135deg, #7f1a1a, #991b1b);
  color: white;
  border: 2px solid #ef4444;
}

.card-dashboard.locked-card .stat-value,
.card-dashboard.locked-card .stat-label {
  color: white;
}

.icon-box{
  width: 55px;
  height: 55px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 24px;
  margin-bottom: 16px;
  transition: transform 0.2s ease;
}

.card-dashboard:hover .icon-box {
  transform: scale(1.05);
}

.bg-blue{background:linear-gradient(135deg, #0d6efd, #0a58ca);}
.bg-green{background:linear-gradient(135deg, #198754, #146c43);}
.bg-orange{background:linear-gradient(135deg, #fd7e14, #e06a0c);}
.bg-red{background:linear-gradient(135deg, #dc2626, #7f1a1a);}

.stat-value{
  font-size: 32px;
  font-weight: 700;
  color: <?= $is_locked ? '#ffffff' : '#1a1a2e' ?>;
  margin-bottom: 5px;
}

.stat-label{
  font-size: 14px;
  color: <?= $is_locked ? '#a0a0b0' : '#6c757d' ?>;
  font-weight: 500;
}

.action-badge{
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: <?= $is_locked ? 'rgba(239, 68, 68, 0.2)' : '#fff3cd' ?>;
  color: <?= $is_locked ? '#fecaca' : '#856404' ?>;
  padding: 6px 12px;
  border-radius: 30px;
  font-size: 11px;
  font-weight: 600;
  margin-top: 10px;
  width: fit-content;
  border: <?= $is_locked ? '1px solid #fca5a5' : '1px solid #ffecb5' ?>;
  cursor: default;
}

.warning-banner {
  background: linear-gradient(135deg, #991b1b, #7f1a1a);
  color: white;
  border-radius: 20px;
  padding: 20px 25px;
  margin-bottom: 25px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 15px;
  border: 1px solid #ef4444;
  animation: fadeInUp 0.5s ease-out;
}

.btn-warning-light {
  background: rgba(255,255,255,0.2);
  border: 1px solid rgba(255,255,255,0.3);
  color: white;
  border-radius: 30px;
  padding: 10px 25px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.btn-warning-light:hover {
  background: rgba(255,255,255,0.3);
  transform: scale(1.02);
}

.table-box{
  background: <?= $is_locked ? '#1a1a2e' : 'white' ?>;
  border-radius: 24px;
  padding: 25px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  border: <?= $is_locked ? '1px solid #2a2a3e' : '1px solid #f0f2f5' ?>;
  animation: fadeInUp 0.5s ease-out 0.1s backwards;
}

.book-list-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.book-list-item {
  display: flex;
  gap: 15px;
  padding: 12px;
  background: <?= $is_locked ? '#252540' : '#f8f9fa' ?>;
  border-radius: 16px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid <?= $is_locked ? '#3a3a5e' : '#e9ecef' ?>;
  cursor: pointer;
  animation: cardFadeIn 0.4s ease-out backwards;
}

.book-list-item:not(.disabled-book):hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  border-color: <?= $is_locked ? '#ef4444' : '#0d6efd' ?>;
}

.book-icon {
  width: 55px;
  height: 75px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  flex-shrink: 0;
}

.book-detail h6 {
  font-size: 14px;
  font-weight: 700;
  margin-bottom: 4px;
  color: <?= $is_locked ? '#e0e0e0' : '#333' ?>;
}

.book-detail p {
  font-size: 11px;
  color: <?= $is_locked ? '#9ca3af' : '#6c757d' ?>;
  margin-bottom: 6px;
}

.badge-custom {
  font-size: 10px;
  padding: 4px 10px;
  border-radius: 20px;
  font-weight: 600;
}

.badge-tersedia {
  background: <?= $is_locked ? '#14532d' : '#d4edda' ?>;
  color: <?= $is_locked ? '#86efac' : '#276432' ?>;
}
.badge-habis {
  background: <?= $is_locked ? '#7f1a1a' : '#f8d7da' ?>;
  color: <?= $is_locked ? '#fecaca' : '#842029' ?>;
}
.badge-terbatas {
  background: <?= $is_locked ? '#78350f' : '#fff3cd' ?>;
  color: <?= $is_locked ? '#fde68a' : '#856404' ?>;
}

.locked-message {
  text-align: center;
  padding: 60px 20px;
  background: <?= $is_locked ? 'linear-gradient(135deg, #1e1e2e, #0f0f1a)' : 'linear-gradient(135deg, #fef2f2, #fee2e2)' ?>;
  border-radius: 24px;
  border: 2px solid #dc2626;
}

.locked-message i {
  font-size: 80px;
  color: #ef4444;
  margin-bottom: 20px;
}

.locked-message h5 {
  color: <?= $is_locked ? '#fecaca' : '#991b1b' ?>;
}

.modal-content {
  background: <?= $is_locked ? '#1a1a2e' : 'white' ?>;
  border: <?= $is_locked ? '1px solid #ef4444' : 'none' ?>;
  border-radius: 24px;
}

.modal-header {
  background: linear-gradient(135deg, #dc2626, #991b1b);
  color: white;
  border-radius: 24px 24px 0 0;
}

/* ========== STYLE UNTUK FINE ITEM CARD ========== */
.fine-item-card {
  background: <?= $is_locked ? '#252540' : 'white' ?>;
  border-radius: 20px;
  padding: 20px;
  margin-bottom: 16px;
  border: 2px solid <?= $is_locked ? '#3a3a5e' : '#e9ecef' ?>;
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
}

.fine-item-card:hover:not(.waiting-confirmation) {
  border-color: #dc3545;
  box-shadow: 0 8px 20px rgba(220, 53, 69, 0.15);
  transform: translateX(5px);
}

.fine-item-card.selected {
  border-color: #dc3545;
  background: <?= $is_locked ? '#2e2e50' : '#fff5f5' ?>;
  box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2);
}

.fine-item-card.selected::before {
  content: '✓';
  position: absolute;
  top: -10px;
  right: -10px;
  width: 30px;
  height: 30px;
  background: #dc3545;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 18px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* Status Menunggu Konfirmasi */
.fine-item-card.waiting-confirmation {
    border-color: #ffc107;
    background: <?= $is_locked ? '#2e2e50' : '#fffef5' ?>;
    cursor: default;
    opacity: 0.95;
}

.fine-item-card.waiting-confirmation:hover {
    transform: none;
    box-shadow: none;
}

.custom-checkbox {
  width: 24px;
  height: 24px;
  border-radius: 6px;
  border: 2px solid #dc3545;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: <?= $is_locked ? '#252540' : 'white' ?>;
  transition: all 0.2s;
  cursor: pointer;
}

.custom-checkbox.checked {
  background: #dc3545;
  color: white;
}

/* Status icon untuk buku yang menunggu konfirmasi */
.status-waiting-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #fff3cd;
    border: 2px solid #ffc107;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.status-badge-waiting {
    background: #ffc107;
    color: #856404;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.payment-card {
  border: 2px solid <?= $is_locked ? '#3a3a5e' : '#e9ecef' ?>;
  border-radius: 16px;
  padding: 15px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  background: <?= $is_locked ? '#252540' : 'white' ?>;
}

.payment-card:hover {
  transform: translateY(-5px);
  border-color: #0d6efd;
}

.payment-card.selected {
  border-color: #0d6efd;
  background: <?= $is_locked ? '#2e2e50' : '#e7f1ff' ?>;
}

.payment-card i {
  font-size: 32px;
  margin-bottom: 8px;
  display: block;
}

.payment-card.selected i {
  color: #0d6efd;
}

.qr-code-box {
  background: <?= $is_locked ? '#252540' : 'white' ?>;
  border-radius: 20px;
  padding: 30px;
  text-align: center;
  border: 2px dashed <?= $is_locked ? '#3a3a5e' : '#e9ecef' ?>;
}

.qr-placeholder {
  width: 200px;
  height: 200px;
  background: <?= $is_locked ? '#1a1a2e' : '#f8f9fa' ?>;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
}

.qr-placeholder i {
  font-size: 80px;
  color: #adb5bd;
}

.total-box {
  background: linear-gradient(135deg, #dc3545, #991b1b);
  border-radius: 20px;
  padding: 25px;
  color: white;
  text-align: center;
}

.total-amount {
  font-size: 32px;
  font-weight: 800;
  margin: 10px 0;
}

.btn-pay {
  background: linear-gradient(135deg, #dc3545, #991b1b);
  border: none;
  border-radius: 40px;
  padding: 14px 30px;
  font-weight: 700;
  font-size: 16px;
  transition: all 0.3s ease;
}

.btn-pay:hover {
  transform: scale(1.02);
  box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
}

.btn-pay:disabled {
  opacity: 0.5;
  transform: none;
}

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
.toast-error {
  border-left-color: #dc3545;
}
.toast-warning {
  border-left-color: #ffc107;
}

@keyframes slideInRight {
  from { opacity: 0; transform: translateX(100px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes slideOutRight {
  from { opacity: 1; transform: translateX(0); }
  to { opacity: 0; transform: translateX(100px); }
}

.input-group {
  border-radius: 40px;
  overflow: hidden;
}

.input-group-text {
  border: 1px solid <?= $is_locked ? '#3a3a5e' : '#e9ecef' ?>;
  border-right: none;
  background: <?= $is_locked ? '#252540' : 'white' ?>;
  color: <?= $is_locked ? '#9ca3af' : '#6c757d' ?>;
}

.form-control {
  border: 1px solid <?= $is_locked ? '#3a3a5e' : '#e9ecef' ?>;
  border-left: none;
  background: <?= $is_locked ? '#252540' : 'white' ?>;
  color: <?= $is_locked ? '#e0e0e0' : '#333' ?>;
}

.form-control:focus {
  box-shadow: none;
  border-color: #ef4444;
  background: <?= $is_locked ? '#2e2e50' : 'white' ?>;
}

.form-control::placeholder {
  color: <?= $is_locked ? '#6c6c8c' : '#adb5bd' ?>;
}

<?php if($is_locked): ?>
.text-muted {
  color: #9ca3af !important;
}
.text-primary {
  color: #ef4444 !important;
}
.btn-outline-primary {
  color: #ef4444;
  border-color: #ef4444;
}
.btn-outline-primary:hover {
  background: #ef4444;
  border-color: #ef4444;
  color: white;
}
.border-1 {
  border-color: #3a3a5e !important;
}
small, .small {
  color: #9ca3af !important;
}
.card .text-muted,
.table-box .text-muted {
  color: #9ca3af !important;
}
.locked-message .btn-danger {
  background: #ef4444;
  border-color: #ef4444;
}
.modal-body .text-muted {
  color: #9ca3af !important;
}
.warning-banner i,
.total-box i,
.qr-placeholder i,
.payment-card i,
.btn-pay i,
.action-badge i,
.locked-message i,
.modal-header i,
.total-box .bi,
.total-box i.bi-receipt,
.total-box i.bi-info-circle {
    color: white !important;
}
.payment-card i {
    color: #ef4444 !important;
}
.payment-card.selected i {
    color: #0d6efd !important;
}
.payment-card.selected .fw-semibold {
    color: #0d6efd !important;
}
.warning-banner .bi-exclamation-octagon-fill {
    color: #fecaca !important;
}
.btn-pay i.bi-lock-fill,
.btn-pay i.bi-cash-stack,
.btn-pay i.bi-credit-card {
    color: white !important;
}
.total-box .total-amount {
    color: white !important;
}
.fine-item-card .custom-checkbox i {
    color: white !important;
}
.fine-item-card.selected .custom-checkbox i {
    color: white !important;
}
.card-dashboard .icon-box i {
    color: white !important;
}
.sidebar .nav-link-custom i {
    color: inherit !important;
}
.sidebar .nav-link-custom.active i {
    color: white !important;
}
.navbar .bi-bell {
    color: #ffffff !important;
}
<?php endif; ?>

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

@keyframes cardFadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 768px){
  .content{
    padding: 15px;
  }
  .book-list-grid {
    grid-template-columns: 1fr;
  }
  .stat-value {
    font-size: 24px;
  }
  .icon-box {
    width: 45px;
    height: 45px;
    font-size: 20px;
  }
  .total-amount {
    font-size: 24px;
  }
  .qr-placeholder {
    width: 150px;
    height: 150px;
  }
}
</style>
</head>
<body>

<!-- Sidebar Overlay untuk mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h4 class="fw-bold mb-0">
      <i class="bi bi-book-half"></i> Digital Library
    </h4>
    <button class="sidebar-close-btn" id="closeSidebarBtn">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
  <div class="sidebar-body">
    <div class="text-center mb-4">
      <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="110" class="mb-3" <?php if($is_locked): ?>style="filter: drop-shadow(0 0 10px rgba(239,68,68,0.5));"<?php endif; ?>>
      <h5 class="fw-bold mb-0" style="color: <?= $is_locked ? '#ffffff' : '#1a1a2e' ?>"><?= htmlspecialchars($user_nama) ?></h5>
      <small class="text-muted"><?= htmlspecialchars($user_nim) ?></small>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link-custom <?= $is_locked ? 'disabled-nav' : 'active' ?>" href="dashboard_anggota.php" <?= $is_locked ? 'onclick="showLockAlert(); return false;"' : '' ?>>
          <i class="bi bi-grid-fill me-2"></i>Dashboard
          <?php if($is_locked): ?><span class="ms-2"><i class="bi bi-lock-fill"></i></span><?php endif; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link-custom <?= $is_locked ? 'disabled-nav' : '' ?>" href="../views/peminjaman/userindex.php" <?= $is_locked ? 'onclick="showLockAlert(); return false;"' : '' ?>>
          <i class="bi bi-journal-check me-2"></i>Peminjaman
          <?php if($is_locked): ?><span class="ms-2"><i class="bi bi-lock-fill"></i></span><?php endif; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link-custom <?= $is_locked ? 'disabled-nav' : '' ?>" href="katalog.php" <?= $is_locked ? 'onclick="showLockAlert(); return false;"' : '' ?>>
          <i class="bi bi-book-half me-2"></i>Katalog
          <?php if($is_locked): ?><span class="ms-2"><i class="bi bi-lock-fill"></i></span><?php endif; ?>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidebar-footer">
    <a href="../public/logout.php" class="btn btn-danger w-100 rounded-4" onclick="return confirmLogout()">
      <i class="bi bi-box-arrow-right me-2"></i>Logout
    </a>
  </div>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-light shadow-sm px-4">
  <div class="d-flex align-items-center">
    <button class="sidebar-toggle" type="button" id="openSidebarBtn">
      <i class="bi bi-list fs-3"></i>
    </button>
    <h4 class="ms-3 mt-2 fw-bold" style="color: <?= $is_locked ? '#ffffff' : '#0d6efd' ?>;">📚 Dashboard Perpustakaan</h4>
  </div>
  <div class="d-flex align-items-center gap-3">
    <i class="bi bi-bell fs-5"></i>
    <a href="../views/auth/profile.php">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="45" class="rounded-circle">
    </a>
  </div>
</nav>

<!-- MAIN CONTENT -->
<div class="content" id="mainContent">

<div class="mb-4">
<h1 class="fw-bold" style="color: <?= $is_locked ? '#ffffff' : '#0d6efd' ?>;">👋 Welcome Back, <?= htmlspecialchars($user_nama) ?>!</h1>
<p class="text-muted">
<i class="bi bi-building"></i> Sistem Perpustakaan Digital Modern — Temukan dan pinjam buku favorit Anda
</p>
</div>

<!-- WARNING BANNER jika user terlambat -->
<?php if($is_locked && !empty($late_books_detail)): ?>
<div class="warning-banner">
    <i class="bi bi-exclamation-octagon-fill fs-2"></i>
    <div class="warning-content flex-grow-1">
        <h5>⚠️ AKSES DIBLOKIR - KETERLAMBATAN PENGEMBALIAN</h5>
        <p>Anda memiliki <strong><?= $totalTerlambat ?></strong> buku yang terlambat dikembalikan dengan total denda <strong><?= formatRupiah($total_denda) ?></strong></p>
    </div>
    <button class="btn-warning-light" onclick="openFinePaymentModal()">
        <i class="bi bi-calculator-fill"></i> Lihat & Bayar Denda
    </button>
</div>
<?php endif; ?>

<!-- CARD STATISTIK -->
<div class="row g-4 mb-4">
<div class="col-md-4">
    <div class="card-dashboard">
        <div class="icon-box bg-blue">
            <i class="bi bi-book-fill"></i>
        </div>
        <div class="stat-value"><?= number_format($totalKoleksi) ?></div>
        <div class="stat-label">Total Koleksi Buku</div>
    </div>
</div>
<div class="col-md-4">
    <div class="card-dashboard">
        <div class="icon-box bg-green">
            <i class="bi bi-journal-check"></i>
        </div>
        <div class="stat-value"><?= number_format($totalDipinjam) ?></div>
        <div class="stat-label">Dipinjam Aktif</div>
    </div>
</div>
<div class="col-md-4">
    <div class="card-dashboard <?= $is_locked ? 'locked-card' : '' ?>">
        <div class="icon-box <?= $is_locked ? 'bg-red' : 'bg-orange' ?>">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="stat-value"><?= $totalTerlambat ?></div>
        <div class="stat-label">Terlambat</div>
        <div class="action-badge">
            <i class="bi <?= $is_locked ? 'bi-lock-fill' : 'bi-clock-history' ?>"></i>
            <?= $is_locked ? 'AKSES TERKUNCI' : 'Perlu Tindakan' ?>
        </div>
    </div>
</div>
</div>

<!-- BUKU PALING DIMINATI -->
<div class="table-box">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold" style="color: <?= $is_locked ? '#ffffff' : '#1a1a2e' ?>;"><i class="bi bi-trophy-fill text-warning"></i> Buku Paling Diminati</h4>
    <a href="katalog.php" class="btn btn-sm btn-outline-primary rounded-4 <?= $is_locked ? 'disabled' : '' ?>" <?= $is_locked ? 'onclick="showLockAlert(); return false;"' : '' ?>>
        Lihat Semua <i class="bi bi-arrow-right"></i>
    </a>
</div>

<!-- Search Box -->
<div class="mb-4">
    <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input type="text" id="searchBookInput" class="form-control" placeholder="Cari buku favorit..." <?= $is_locked ? 'disabled' : '' ?>>
    </div>
</div>

<?php if(!$is_locked): ?>
<div class="book-list-grid" id="bookGrid">
    <?php if(empty($bukuPopuler)): ?>
    <div class="text-center text-muted py-4">Belum ada data buku</div>
    <?php else: ?>
    <?php $i=0; foreach($bukuPopuler as $book): $i++; ?>
    <div class="book-list-item" style="animation-delay: <?= $i*0.05 ?>s" onclick="window.location.href='katalog.php'">
        <div class="book-icon" style="background: <?= getCoverBg($book['kategori_id'] ?? 1); ?>;">
            <?= getCoverEmoji($book['kategori_id'] ?? 1); ?>
        </div>
        <div class="book-detail">
            <h6><?= htmlspecialchars($book['judul']); ?></h6>
            <p><?= htmlspecialchars($book['penulis']); ?></p>
            <span class="badge-custom <?= getBadgeClass($book); ?>">
                <?= getBadgeText($book); ?>
            </span>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="locked-message">
    <i class="bi bi-lock-fill"></i>
    <h5 class="fw-bold mb-3">⚠️ AKSES DITOLAK</h5>
    <p>Anda tidak dapat mengakses Katalog Buku karena memiliki keterlambatan pengembalian.</p>
    <button class="btn btn-danger rounded-4" onclick="openFinePaymentModal()">
        <i class="bi bi-cash-stack"></i> Lihat & Bayar Denda
    </button>
</div>
<?php endif; ?>

<div id="noBookResult" class="text-center text-muted py-4 d-none">
    <i class="bi bi-emoji-frown" style="font-size: 48px;"></i>
    <p class="mt-2">Buku tidak ditemukan</p>
</div>

</div>

</div>

<!-- MODAL DETAIL DENDA & PEMBAYARAN -->
<div class="modal fade" id="finePaymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-calculator-fill me-2"></i>Detail Denda & Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    
                    <!-- KIRI: Daftar Buku -->
                    <div class="col-lg-7">
                        <div class="border rounded-4 p-3 mb-3" style="background: <?= $is_locked ? '#252540' : '#f8f9fa' ?>;">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                <h6 class="fw-bold mb-0" style="color: <?= $is_locked ? '#ffffff' : '#333' ?>;">
                                    <i class="bi bi-journal-bookmark-fill text-danger me-2"></i>
                                    Daftar Buku Terlambat
                                </h6>
                                <div class="d-flex gap-2">
                                    <?php 
                                    $hasUnpaidBooks = false;
                                    foreach($late_books_detail as $book) {
                                        if(($book['denda_status'] ?? '') !== 'pending') {
                                            $hasUnpaidBooks = true;
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if($is_locked && $hasUnpaidBooks): ?>
                                    <button class="btn btn-sm btn-outline-danger rounded-4" onclick="selectAllBooks()">
                                        <i class="bi bi-check-all"></i> Pilih Semua
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary rounded-4" onclick="deselectAllBooks()">
                                        <i class="bi bi-x-circle"></i> Hapus Semua
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> 
                                <?= $hasUnpaidBooks ? 'Centang checkbox untuk memilih buku yang akan dibayar' : 'Semua buku sudah dalam proses konfirmasi pembayaran' ?>
                            </small>
                        </div>
                        
                        <div id="fineBooksList">
                            <?php if(empty($late_books_detail)): ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-emoji-smile fs-1 text-success"></i>
                                    <h5 class="mt-3" style="color: <?= $is_locked ? '#ffffff' : '#333' ?>;">🎉 Tidak ada buku yang terlambat!</h5>
                                    <p class="text-muted">Semua peminjaman Anda dalam status baik.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($late_books_detail as $index => $book): 
                                    $fine_amount = $book['late_days'] * $denda_per_hari;
                                    $denda_status = $book['denda_status'] ?? 'unpaid';
                                    $is_waiting_confirmation = ($denda_status === 'pending');
                                    $kode_konfirmasi = $book['kode_konfirmasi'] ?? '';
                                ?>
                                <div class="fine-item-card <?= $is_waiting_confirmation ? 'waiting-confirmation' : '' ?>" 
                                     data-id="<?= $book['buku_id'] ?>" 
                                     data-peminjaman-id="<?= $book['id'] ?>" 
                                     data-late-days="<?= $book['late_days'] ?>" 
                                     data-denda-status="<?= $denda_status ?>"
                                     onclick="<?= !$is_waiting_confirmation && $is_locked ? 'toggleSelectFineBook(this, event)' : '' ?>">
                                    
                                    <div class="d-flex align-items-start gap-3">
                                        <?php if($is_waiting_confirmation): ?>
                                            <div class="status-waiting-icon">
                                                <i class="bi bi-hourglass-split" style="font-size: 18px; color: #ffc107;"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="custom-checkbox" id="fineCheckbox_<?= $book['buku_id'] ?>">
                                                <i class="bi bi-check-lg" style="font-size: 14px;"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="book-icon-small" style="width: 50px; height: 60px; background: <?= getCoverBg($book['kategori_id'] ?? 1); ?>; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                                            <?= getCoverEmoji($book['kategori_id'] ?? 1); ?>
                                        </div>
                                        
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                <h6 class="fw-bold mb-2" style="color: <?= $is_locked ? '#ffffff' : '#1a1a2e' ?>;">
                                                    <?= htmlspecialchars($book['judul']) ?>
                                                </h6>
                                                <?php if($is_waiting_confirmation): ?>
                                                    <span class="status-badge-waiting">
                                                        <i class="bi bi-clock-history"></i> Menunggu Konfirmasi Admin
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-exclamation-triangle"></i> Belum Dibayar
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted">📅 Jatuh Tempo:</small>
                                                    <div class="fw-semibold" style="color: <?= $is_locked ? '#e0e0e0' : '#333' ?>;"><?= formatDate($book['tanggal_kembali']) ?></div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">⏰ Terlambat:</small>
                                                    <div class="fw-semibold text-danger"><?= $book['late_days'] ?> Hari</div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="badge bg-warning text-dark">Denda/hari: <?= formatRupiah($denda_per_hari) ?></span>
                                                <strong class="<?= $is_waiting_confirmation ? 'text-warning' : 'text-danger' ?> fs-5" id="fineAmount_<?= $book['buku_id'] ?>">
                                                    <?= $is_waiting_confirmation ? 'Menunggu Konfirmasi' : formatRupiah($fine_amount) ?>
                                                </strong>
                                            </div>
                                            
                                            <?php if($is_waiting_confirmation && $kode_konfirmasi): ?>
                                            <div class="mt-2 pt-2 border-top">
                                                <small class="text-muted">
                                                    <i class="bi bi-upc-scan"></i> Kode Konfirmasi: 
                                                    <code class="fw-bold"><?= htmlspecialchars($kode_konfirmasi) ?></code>
                                                    <a href="konfirmasi_pembayaran.php?kode=<?= $kode_konfirmasi ?>" class="btn btn-link btn-sm p-0 ms-2" target="_blank">
                                                        <i class="bi bi-eye"></i> Detail
                                                    </a>
                                                </small>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- KANAN: Total & Pembayaran -->
                    <div class="col-lg-5">
                        <?php
                        $allWaiting = true;
                        $anyUnpaid = false;
                        foreach($late_books_detail as $book) {
                            $denda_status = $book['denda_status'] ?? 'unpaid';
                            if($denda_status !== 'pending') {
                                $allWaiting = false;
                                $anyUnpaid = true;
                            }
                        }
                        ?>
                        
                        <?php if($allWaiting && !empty($late_books_detail)): ?>
                            <div class="text-center p-4 border rounded-4" style="background: <?= $is_locked ? '#252540' : '#fff3cd' ?>;">
                                <div class="status-waiting-icon mx-auto" style="width: 60px; height: 60px;">
                                    <i class="bi bi-hourglass-split" style="font-size: 30px; color: #ffc107;"></i>
                                </div>
                                <h5 class="mt-3 fw-bold text-warning">Menunggu Konfirmasi Admin</h5>
                                <p class="mb-0">Semua buku yang terlambat sudah dalam proses konfirmasi pembayaran.</p>
                                <small class="text-muted">Silakan tunggu admin mengkonfirmasi pembayaran Anda.</small>
                                <hr>
                                <?php 
                                $firstKode = $late_books_detail[0]['kode_konfirmasi'] ?? '';
                                if($firstKode):
                                ?>
                                <a href="konfirmasi_pembayaran.php?kode=<?= $firstKode ?>" class="btn btn-warning rounded-4 mt-2">
                                    <i class="bi bi-eye"></i> Lihat Status Pembayaran
                                </a>
                                <?php endif; ?>
                            </div>
                        <?php elseif($anyUnpaid): ?>
                            <div class="total-box mb-4">
                                <i class="bi bi-receipt fs-2" style="color: white;"></i>
                                <h6 class="mb-2" style="color: white;">Total Yang Akan Dibayar</h6>
                                <div class="total-amount" id="totalFineAmountDisplay" style="color: white;">Rp 0</div>
                                <small style="color: rgba(255,255,255,0.7);"><i class="bi bi-info-circle" style="color: rgba(255,255,255,0.7);"></i> Denda akan terus bertambah setiap hari</small>
                            </div>
                            
                            <div class="border rounded-4 p-3 mb-3" style="background: <?= $is_locked ? '#252540' : '#f8f9fa' ?>;">
                                <h6 class="fw-bold mb-3" style="color: <?= $is_locked ? '#ffffff' : '#333' ?>;"><i class="bi bi-credit-card text-primary me-2"></i>Pilih Metode Pembayaran</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="payment-card" data-method="qris" onclick="selectPaymentMethod('qris')">
                                            <i class="bi bi-qr-code-scan"></i>
                                            <div class="fw-semibold">QRIS</div>
                                            <small class="text-muted">Scan QR Code</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-card" data-method="transfer" onclick="selectPaymentMethod('transfer')">
                                            <i class="bi bi-building"></i>
                                            <div class="fw-semibold">Transfer Bank</div>
                                            <small class="text-muted">BCA/BRI/Mandiri</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-card" data-method="ewallet" onclick="selectPaymentMethod('ewallet')">
                                            <i class="bi bi-phone"></i>
                                            <div class="fw-semibold">E-Wallet</div>
                                            <small class="text-muted">OVO/GoPay/DANA</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="payment-card" data-method="tunai" onclick="selectPaymentMethod('tunai')">
                                            <i class="bi bi-cash-stack"></i>
                                            <div class="fw-semibold">Tunai</div>
                                            <small class="text-muted">Di perpustakaan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="qr-code-box mb-3" id="paymentDetailBox">
                                <div class="qr-placeholder" id="qrPlaceholder">
                                    <i class="bi bi-qr-code"></i>
                                </div>
                                <h6 class="fw-bold" id="paymentTitle" style="color: <?= $is_locked ? '#ffffff' : '#333' ?>;">Scan QR Code untuk membayar</h6>
                                <p class="text-muted small mb-0" id="paymentDesc">Gunakan aplikasi mobile banking atau e-wallet</p>
                            </div>
                            
                            <button class="btn btn-pay w-100" id="payFineButton" onclick="processFinePayment()" disabled>
                                <i class="bi bi-lock-fill me-2"></i> Pilih Buku Terlebih Dahulu
                            </button>
                        <?php else: ?>
                            <div class="text-center p-4 border rounded-4" style="background: <?= $is_locked ? '#252540' : '#d4edda' ?>;">
                                <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                                <h5 class="mt-2 fw-bold text-success">Tidak Ada Denda</h5>
                                <p class="mb-0">Semua peminjaman Anda dalam status baik.</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-clock-history"></i> <?= date('j/n/Y') ?>
                            </small>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ==================== SIDEBAR ====================
let isSidebarOpen = false;
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const openBtn = document.getElementById('openSidebarBtn');
const closeBtn = document.getElementById('closeSidebarBtn');
const body = document.body;

function openSidebar() {
    sidebar.classList.add('show');
    overlay.classList.add('show');
    body.classList.add('sidebar-open');
    isSidebarOpen = true;
    if (window.innerWidth < 992) body.style.overflow = 'hidden';
}

function closeSidebar() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    body.classList.remove('sidebar-open');
    isSidebarOpen = false;
    if (window.innerWidth < 992) body.style.overflow = '';
}

function initSidebarState() {
    if (window.innerWidth >= 992) overlay.style.display = 'none';
    else { overlay.style.display = ''; closeSidebar(); }
}

if (openBtn) openBtn.addEventListener('click', openSidebar);
if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
if (overlay) overlay.addEventListener('click', closeSidebar);
document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && isSidebarOpen) closeSidebar(); });
window.addEventListener('resize', initSidebarState);
initSidebarState();

// ==================== DATA DARI PHP ====================
let lateBooks = <?php echo json_encode($late_books_detail); ?>;
const isLocked = <?php echo json_encode($is_locked); ?>;
const dendaPerHari = <?php echo $denda_per_hari; ?>;

let selectedFineBooks = new Set();
let selectedPaymentMethod = null;
let statusCheckInterval = null;

// ==================== FUNGSI UMUM ====================
function formatRupiah(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

function formatDate(dateString) {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function showToast(title, message, type = 'success', duration = 4000) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toastId = 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    const icons = { success: '✓', error: '✕', warning: '⚠', info: 'ℹ' };
    const icon = icons[type] || 'ℹ';
    
    const toastHTML = `
        <div id="${toastId}" class="toast-notification">
            <div class="toast-card toast-${type}">
                <div class="toast-icon" style="width: 40px; height: 40px; background: ${type === 'success' ? '#e8f5e9' : type === 'error' ? '#fee' : '#fff8e7'}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title fw-bold">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-notification').remove()">×</button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHTML);
    setTimeout(() => { const toast = document.getElementById(toastId); if (toast) toast.remove(); }, duration);
}

// ==================== AUTO CHECK STATUS ====================
function startStatusCheck() {
    if (statusCheckInterval) clearInterval(statusCheckInterval);
    
    statusCheckInterval = setInterval(function() {
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'action=get_latest_denda_status'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.has_unpaid === false && data.all_waiting === true) {
                if (statusCheckInterval) clearInterval(statusCheckInterval);
                showToast('✅ Status Berubah', 'Pembayaran Anda sedang diproses admin', 'success', 3000);
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(error => console.log('Check status error:', error));
    }, 5000);
}

// ==================== FUNGSI PEMBAYARAN DENDA ====================
function openFinePaymentModal() {
    selectedFineBooks.clear();
    selectedPaymentMethod = null;
    updateFineTotal();
    updatePayButton();
    
    document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('selected'));
    
    const modal = new bootstrap.Modal(document.getElementById('finePaymentModal'));
    modal.show();
}

function toggleSelectFineBook(element, event) {
    if (event.target.closest('.custom-checkbox')) event.stopPropagation();
    
    const bookId = element.dataset.id;
    const checkbox = document.getElementById('fineCheckbox_' + bookId);
    
    if (selectedFineBooks.has(bookId)) {
        selectedFineBooks.delete(bookId);
        element.classList.remove('selected');
        if (checkbox) checkbox.classList.remove('checked');
    } else {
        selectedFineBooks.add(bookId);
        element.classList.add('selected');
        if (checkbox) checkbox.classList.add('checked');
    }
    
    updateFineTotal();
    updatePayButton();
}

function selectAllBooks() {
    document.querySelectorAll('.fine-item-card:not(.waiting-confirmation)').forEach(card => {
        const bookId = card.dataset.id;
        if (!selectedFineBooks.has(bookId)) {
            selectedFineBooks.add(bookId);
            card.classList.add('selected');
            const checkbox = document.getElementById('fineCheckbox_' + bookId);
            if (checkbox) checkbox.classList.add('checked');
        }
    });
    updateFineTotal();
    updatePayButton();
}

function deselectAllBooks() {
    selectedFineBooks.clear();
    document.querySelectorAll('.fine-item-card').forEach(card => {
        card.classList.remove('selected');
        const checkbox = document.getElementById('fineCheckbox_' + card.dataset.id);
        if (checkbox) checkbox.classList.remove('checked');
    });
    updateFineTotal();
    updatePayButton();
}

function updateFineTotal() {
    let total = 0;
    selectedFineBooks.forEach(bookId => {
        const book = lateBooks.find(b => b.buku_id == bookId);
        if (book) {
            const lateDays = parseInt(book.late_days) || 0;
            total += lateDays * dendaPerHari;
        }
    });
    const totalDisplay = document.getElementById('totalFineAmountDisplay');
    if (totalDisplay) totalDisplay.innerHTML = formatRupiah(total);
}

function updatePayButton() {
    const payButton = document.getElementById('payFineButton');
    if (payButton) {
        if (selectedFineBooks.size > 0 && selectedPaymentMethod) {
            let total = 0;
            selectedFineBooks.forEach(bookId => {
                const book = lateBooks.find(b => b.buku_id == bookId);
                if (book) {
                    const lateDays = parseInt(book.late_days) || 0;
                    total += lateDays * dendaPerHari;
                }
            });
            payButton.disabled = false;
            payButton.innerHTML = '<i class="bi bi-cash-stack me-2"></i> Bayar ' + formatRupiah(total);
        } else if (selectedFineBooks.size > 0) {
            payButton.disabled = true;
            payButton.innerHTML = '<i class="bi bi-credit-card me-2"></i> Pilih Metode Pembayaran';
        } else {
            payButton.disabled = true;
            payButton.innerHTML = '<i class="bi bi-lock-fill me-2"></i> Pilih Buku Terlebih Dahulu';
        }
    }
}

function selectPaymentMethod(method) {
    selectedPaymentMethod = method;
    
    document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('selected'));
    const selectedCard = document.querySelector(`.payment-card[data-method="${method}"]`);
    if (selectedCard) selectedCard.classList.add('selected');
    
    const qrPlaceholder = document.getElementById('qrPlaceholder');
    const paymentTitle = document.getElementById('paymentTitle');
    const paymentDesc = document.getElementById('paymentDesc');
    
    if (qrPlaceholder && paymentTitle && paymentDesc) {
        switch(method) {
            case 'qris':
                qrPlaceholder.innerHTML = '<i class="bi bi-qr-code" style="color: #ef4444;"></i>';
                paymentTitle.innerHTML = 'Scan QR Code untuk membayar';
                paymentDesc.innerHTML = 'Gunakan aplikasi mobile banking atau e-wallet';
                break;
            case 'transfer':
                qrPlaceholder.innerHTML = '<i class="bi bi-building" style="color: #ef4444;"></i>';
                paymentTitle.innerHTML = 'Transfer Bank';
                paymentDesc.innerHTML = 'BCA: 1234567890 a.n Perpustakaan Digital<br>BRI: 0987654321 a.n Perpustakaan Digital';
                break;
            case 'ewallet':
                qrPlaceholder.innerHTML = '<i class="bi bi-phone" style="color: #ef4444;"></i>';
                paymentTitle.innerHTML = 'Pembayaran E-Wallet';
                paymentDesc.innerHTML = 'OVO/GoPay/DANA: 081234567890';
                break;
            case 'tunai':
                qrPlaceholder.innerHTML = '<i class="bi bi-cash-stack" style="color: #ef4444;"></i>';
                paymentTitle.innerHTML = 'Pembayaran Tunai';
                paymentDesc.innerHTML = 'Silakan datang ke petugas perpustakaan untuk membayar denda';
                break;
        }
    }
    
    updatePayButton();
}

function processFinePayment() {
    if (selectedFineBooks.size === 0) {
        showToast('⚠️ Peringatan', 'Pilih buku terlebih dahulu!', 'warning');
        return;
    }
    
    if (!selectedPaymentMethod) {
        showToast('⚠️ Peringatan', 'Pilih metode pembayaran terlebih dahulu!', 'warning');
        return;
    }
    
    let totalDenda = 0;
    const bookTitles = [];
    const bookData = [];
    
    selectedFineBooks.forEach(bookId => {
        const book = lateBooks.find(b => b.buku_id == bookId);
        if (book) {
            const lateDays = parseInt(book.late_days) || 0;
            totalDenda += lateDays * dendaPerHari;
            bookTitles.push(book.judul);
            bookData.push({
                id: book.buku_id,
                late_days: lateDays,
                judul: book.judul
            });
        }
    });
    
    if (selectedPaymentMethod === 'tunai') {
        Swal.fire({
            title: '💰 Pembayaran Tunai',
            html: `
                <div style="text-align: left;">
                    <p><strong>Total Denda:</strong> ${formatRupiah(totalDenda)}</p>
                    <p><strong>Buku:</strong> ${bookTitles.join(', ')}</p>
                    <hr>
                    <p><i class="bi bi-info-circle"></i> Instruksi Pembayaran:</p>
                    <ol style="text-align: left;">
                        <li>Klik "Bayar" untuk mendapatkan kode konfirmasi</li>
                        <li>Datang ke petugas perpustakaan</li>
                        <li>Tunjukkan kode konfirmasi kepada petugas</li>
                        <li>Lakukan pembayaran tunai</li>
                        <li>Petugas akan memverifikasi dan memulihkan akses Anda</li>
                    </ol>
                    <p class="text-muted mt-2"><i class="bi bi-info-circle"></i> Halaman akan otomatis refresh setelah status berubah.</p>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                const bookIds = bookData.map(b => b.id).join(',');
                processPaymentToServer(bookIds, selectedPaymentMethod, totalDenda);
            }
        });
    } else {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `
                <p><strong>Total:</strong> ${formatRupiah(totalDenda)}</p>
                <p><strong>Metode:</strong> ${selectedPaymentMethod.toUpperCase()}</p>
                <p><strong>Buku:</strong> ${bookTitles.join(', ')}</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bayar Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                const bookIds = bookData.map(b => b.id).join(',');
                processPaymentToServer(bookIds, selectedPaymentMethod, totalDenda);
            }
        });
    }
}

function processPaymentToServer(bookIds, method, total) {
    const payButton = document.getElementById('payFineButton');
    const originalText = payButton ? payButton.innerHTML : '';
    if (payButton) {
        payButton.disabled = true;
        payButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Memproses...';
    }
    
    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `action=pay_fine&book_ids=${bookIds}&method=${method}&total=${total}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (method === 'tunai') {
                startStatusCheck();
                const modal = bootstrap.Modal.getInstance(document.getElementById('finePaymentModal'));
                if (modal) modal.hide();
                showToast('⏳ Menunggu Konfirmasi', 'Status pembayaran akan diperbarui otomatis', 'info', 5000);
                
                Swal.fire({
                    title: '💰 Menunggu Konfirmasi Petugas',
                    html: `
                        <div style="text-align: left;">
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill"></i> ${data.message}
                            </div>
                            <div class="alert alert-info mt-3" style="background: #e3f2fd;">
                                <strong>Kode Konfirmasi Anda:</strong><br>
                                <code style="font-size: 28px; font-weight: bold; letter-spacing: 2px;">${data.kode_konfirmasi}</code>
                            </div>
                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <strong>Langkah Selanjutnya:</strong>
                                <ol class="mt-2" style="text-align: left;">
                                    <li>Simpan kode konfirmasi di atas</li>
                                    <li>Datang ke petugas perpustakaan</li>
                                    <li>Tunjukkan kode ini dan lakukan pembayaran tunai</li>
                                    <li>Petugas akan memverifikasi dan memulihkan akses Anda</li>
                                </ol>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Simpan Kode',
                    confirmButtonColor: '#ffc107',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`konfirmasi_pembayaran.php?kode=${data.kode_konfirmasi}&status=pending`, '_blank');
                    }
                });
            } else {
                Swal.fire({
                    title: '✅ Pembayaran Berhasil',
                    html: `<p>${data.message}</p><p>Akses Anda telah dipulihkan.</p>`,
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload();
                });
            }
        } else {
            Swal.fire({
                title: '❌ Pembayaran Gagal',
                text: data.message,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            if (payButton) {
                payButton.disabled = false;
                payButton.innerHTML = originalText;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: '❌ Error',
            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
            icon: 'error'
        });
        if (payButton) {
            payButton.disabled = false;
            payButton.innerHTML = originalText;
        }
    });
}

// ==================== FUNGSI LAINNYA ====================
function showLockAlert() {
    Swal.fire({
        title: '⚠️ AKSES DITOLAK!',
        text: 'Anda memiliki buku yang terlambat dikembalikan. Silahkan selesaikan kewajiban Anda terlebih dahulu untuk mengakses fitur ini.',
        icon: 'warning',
        confirmButtonColor: '#dc3545'
    });
}

function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php';
        }
    });
    return false;
}

// ==================== SEARCH BUKU ====================
let searchTimeout;
const searchInput = document.getElementById('searchBookInput');

if(searchInput && !isLocked) {
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const keyword = e.target.value;
        
        searchTimeout = setTimeout(() => {
            if (keyword.trim() === '') {
                location.reload();
                return;
            }
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `action=search&keyword=${encodeURIComponent(keyword)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) updateBookGrid(data.books);
            })
            .catch(error => console.error('Error:', error));
        }, 300);
    });
}

function updateBookGrid(books) {
    const grid = document.getElementById('bookGrid');
    const noResultDiv = document.getElementById('noBookResult');
    
    if (books.length === 0) {
        if (grid) grid.innerHTML = '';
        if (noResultDiv) noResultDiv.classList.remove('d-none');
        return;
    }
    
    if (noResultDiv) noResultDiv.classList.add('d-none');
    if (grid) {
        grid.style.opacity = '0';
        grid.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            grid.innerHTML = books.map((book, index) => {
                const badgeText = book.stok <= 0 ? 'Habis' : (book.stok <= 3 ? book.stok + ' Tersisa' : 'Tersedia');
                const badgeClass = book.stok <= 0 ? 'badge-habis' : (book.stok <= 3 ? 'badge-terbatas' : 'badge-tersedia');
                
                return `
                <div class="book-list-item" style="animation-delay: ${index * 0.05}s" onclick="window.location.href='katalog.php'">
                    <div class="book-icon" style="background: ${book.bg || '#d4eaf4'};">${book.cover || '📔'}</div>
                    <div class="book-detail">
                        <h6>${escapeHtml(book.judul)}</h6>
                        <p>${escapeHtml(book.penulis)}</p>
                        <span class="badge-custom ${badgeClass}">${badgeText}</span>
                    </div>
                </div>
                `;
            }).join('');
            
            grid.style.opacity = '1';
            grid.style.transform = 'translateY(0)';
            grid.style.transition = 'all 0.3s ease';
        }, 200);
    }
}

// Ekspose fungsi ke global
window.showLockAlert = showLockAlert;
window.confirmLogout = confirmLogout;
window.openFinePaymentModal = openFinePaymentModal;
window.toggleSelectFineBook = toggleSelectFineBook;
window.selectAllBooks = selectAllBooks;
window.deselectAllBooks = deselectAllBooks;
window.selectPaymentMethod = selectPaymentMethod;
window.processFinePayment = processFinePayment;
</script>

</body>
</html>