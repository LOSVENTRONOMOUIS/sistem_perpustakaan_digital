<?php
// Halaman detail buku publik — tidak memerlukan login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../controllers/LandingController.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$controller = new LandingController();
$buku = $controller->getBookById($id);

if (!$buku) {
    header("Location: index.php");
    exit;
}

// Status login user
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['id']);
$namaUser   = $_SESSION['nama'] ?? '';
$roleUser   = $_SESSION['role'] ?? '';

require_once "../views/landing/detail.php";
