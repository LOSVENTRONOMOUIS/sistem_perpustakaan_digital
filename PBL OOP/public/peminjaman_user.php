<?php

session_start();

// Cek login
if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../controllers/UserPinjamController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $controller = new PeminjamanController();
    $user_id = $_SESSION['user_id'];

    if(isset($_POST['create'])){
        $buku_id = $_POST['buku_id'] ?? 0;
        $result = $controller->createPeminjaman($user_id, $buku_id);
        
        if($result['success']){
            $_SESSION['toast'] = ['success' => $result['message']];
        } else {
            $_SESSION['toast'] = ['error' => $result['message']];
        }
        
        header("Location: peminjaman.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $controller = new PeminjamanController();
    $controller->handleAjaxRequest();
    exit;
}

$controller = new PeminjamanController();
$dataPeminjaman = $controller->getPeminjamanByUser($_SESSION['user_id']);

if (!is_array($dataPeminjaman)) {
    $dataPeminjaman = [];
}

require_once "../models/Buku.php";
$bukuModel = new Buku();
$daftarBuku = $bukuModel->getAll();

$totalDipinjam = 0;
$totalTerlambat = 0;
$totalKembali = 0;
$totalBatal = 0;
$peminjamanTableHtml = '';
$no = 1;

foreach ($dataPeminjaman as $d) {
    $statusClass = 'status-pill-secondary';
    $statusIcon = 'bi-question-circle';
    $statusLabel = 'Unknown';

    switch ($d['status'] ?? '') {
        case 'dipinjam':
            $statusClass = 'status-pill-primary';
            $statusIcon = 'bi-book';
            $statusLabel = 'Dipinjam';
            $totalDipinjam++;
            break;
        case 'terlambat':
            $statusClass = 'status-pill-danger';
            $statusIcon = 'bi-exclamation-triangle-fill';
            $statusLabel = 'Terlambat';
            $totalTerlambat++;
            break;
        case 'kembali':
            $statusClass = 'status-pill-success';
            $statusIcon = 'bi-check-circle-fill';
            $statusLabel = 'Dikembalikan';
            $totalKembali++;
            break;
        case 'batal':
            $statusClass = 'status-pill-secondary';
            $statusIcon = 'bi-x-circle-fill';
            $statusLabel = 'Dibatalkan';
            $totalBatal++;
            break;
    }

    $dataStatus = htmlspecialchars($d['status'] ?? 'all', ENT_QUOTES, 'UTF-8');
    $judul = htmlspecialchars($d['judul'] ?? '-', ENT_QUOTES, 'UTF-8');
    $nama = htmlspecialchars($d['nama'] ?? '-', ENT_QUOTES, 'UTF-8');
    $tglPinjam = htmlspecialchars($d['tglPinjam'] ?? '-', ENT_QUOTES, 'UTF-8');
    $tglKembali = htmlspecialchars($d['tglKembali'] ?? '-', ENT_QUOTES, 'UTF-8');
    $id = (int)($d['id'] ?? 0);
    $escapedTitle = addslashes($d['judul'] ?? '');

    $actionButton = '';
    if (($d['status'] ?? '') === 'dipinjam' || ($d['status'] ?? '') === 'terlambat') {
        $actionButton = "<button class=\"btn-batalkan\" onclick=\"batalkanPeminjaman($id, '$escapedTitle')\"><i class=\"bi bi-x-circle-fill\"></i> Batalkan</button>";
    }

    $peminjamanTableHtml .= '<tr data-status="' . $dataStatus . '">';
    $peminjamanTableHtml .= '<td>' . $no++ . '</td>';
    $peminjamanTableHtml .= '<td><strong>' . $judul . '</strong></td>';
    $peminjamanTableHtml .= '<td>' . $nama . '</td>';
    $peminjamanTableHtml .= '<td>' . $tglPinjam . '</td>';
    $peminjamanTableHtml .= '<td>' . $tglKembali . '</td>';
    $peminjamanTableHtml .= '<td><span class="status-pill ' . $statusClass . '"><i class="bi ' . $statusIcon . '"></i> ' . $statusLabel . '</span></td>';
    $peminjamanTableHtml .= '<td><button class="btn-lihat" onclick="showDetail(' . $id . ')"><i class="bi bi-eye"></i> Lihat</button> ' . $actionButton . '</td>';
    $peminjamanTableHtml .= '</tr>';
}

if (empty($peminjamanTableHtml)) {
    $peminjamanTableHtml = '<tr><td colspan="7" class="text-center py-4">Belum ada data peminjaman.</td></tr>';
}

$totalSemua = count($dataPeminjaman);

$toastMessage = '';
$toastType = '';
if(isset($_SESSION['toast'])) {
    $toastType = isset($_SESSION['toast']['success']) ? 'success' : 'error';
    $toastMessage = $_SESSION['toast'][$toastType];
    unset($_SESSION['toast']);
}

// Sambungkan ke view peminjaman user
require_once "../views/peminjaman/userindex.php";
?>