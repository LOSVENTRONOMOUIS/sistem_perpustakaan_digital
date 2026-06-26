<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once "../controllers/UserDashController.php";

$dashboardController = new UserDashController();

$dashboardController->handleAjaxRequest();

$data = $dashboardController->getDashboardData();
$totalKoleksi = $data['totalKoleksi'];
$totalDipinjam = $data['totalDipinjam'];
$totalTerlambat = $data['totalTerlambat'];
$bukuPopuler = $data['bukuPopuler'];
$user_nama = $data['user_nama'];
$user_nim = $data['user_nim'];
$is_locked = $data['is_locked'];
$total_late_days = $data['total_late_days'];
$total_denda = $data['total_denda'];
$late_books_detail = $data['late_books_detail'];
$denda_per_hari = 2000;

$bukuPopuler = array_slice($bukuPopuler, 0, 4);

function getBadgeText($book){
    if ($book['stok'] <= 0) return 'Habis';
    if ($book['stok'] <= 3) return $book['stok'] . ' Tersisa';
    return 'Tersedia';
}

function getBadgeClass($book){
    if ($book['stok'] <= 0) return 'badge-habis';
    if ($book['stok'] <= 3) return 'badge-terbatas';
    return 'badge-tersedia';
}

function getCoverBg($kategori_id){
    $bgColors = [1 => '#d4e8f4', 2 => '#d4e8f4', 3 => '#fde8d8', 4 => '#e8f4d4', 5 => '#f4d4e8', 6 => '#f4f0d4'];
    return $bgColors[$kategori_id] ?? '#d4eaf4';
}

function getCoverEmoji($kategori_id){
    $emojis = [1 => '📘', 2 => '📘', 3 => '📙', 4 => '📗', 5 => '📕', 6 => '📒'];
    return $emojis[$kategori_id] ?? '📔';
}

function formatRupiah($amount){
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function formatDate($date){
    if(!$date) return '-';
    $timestamp = strtotime($date);
    return date('d F Y', $timestamp);
}

$lis_locked = $is_locked;

require_once "../views/dashboard/userindex.php";
?>