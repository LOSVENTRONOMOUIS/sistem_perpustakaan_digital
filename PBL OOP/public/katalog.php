<?php
session_start();

// Cek login
if(!isset($_SESSION['user_id']) && !isset($_SESSION['id'])) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['success' => false, 'message' => 'Sesi berakhir, silakan login ulang']);
        exit;
    }
    header("Location: login.php");
    exit;
}

require_once "../controllers/KatalogController.php";

$controller = new KatalogController();

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $controller->handleRequest();
    exit;
}

$bukuList = $controller->getAllBooks();

$user_id = $_SESSION['user_id'] ?? $_SESSION['id'];

// Cek apakah user terkunci karena denda (terlambat)
$is_locked = $controller->isUserLocked($user_id);

// Auto-trigger modal pinjam jika ada parameter buku_id dari landing page
$autoPinjamBuku = null;
if (!empty($_GET['buku_id'])) {
    $target_id = (int)$_GET['buku_id'];
    foreach ($bukuList as $b) {
        if ((int)$b['id'] === $target_id) {
            $autoPinjamBuku = $b;
            break;
        }
    }
}

$currentUser = [
    'id'    => $_SESSION['id'] ?? '',
    'nama'  => $_SESSION['nama'] ?? '',
    'email' => $_SESSION['email'] ?? ''
];

require_once "../views/katalog/userindex.php";
?>