<?php
// Landing page publik — tidak memerlukan login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../controllers/LandingController.php";

$controller = new LandingController();

// Handle AJAX search
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    $controller->handleAjaxSearch();
    exit;
}

// Ambil semua data untuk halaman
$stats         = $controller->getStats();
$latestBooks   = $controller->getLatestBooks(8);
$popularBooks  = $controller->getPopularBooks(8);
$categories    = $controller->getAllCategories();

// Katalog awal (halaman 1, tanpa filter)
$catalogData   = $controller->getAllBooks([
    'keyword'  => $_GET['keyword']  ?? '',
    'kategori' => $_GET['kategori'] ?? '',
    'sort'     => $_GET['sort']     ?? 'terbaru',
    'page'     => $_GET['page']     ?? 1,
    'per_page' => 12,
]);

// Status login user
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['id']);
$namaUser   = $_SESSION['nama'] ?? '';
$roleUser   = $_SESSION['role'] ?? '';

require_once "../views/landing/index.php";
