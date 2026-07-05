<?php
// public/konfirmasi_pembayaran.php

require_once "../config/database.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$kode = $_GET['kode'] ?? '';

if (empty($kode)) {
    die("Kode konfirmasi tidak valid.");
}

// Ambil detail denda berdasarkan kode konfirmasi
// Buat class koneksi karena Database abstract
class DBConnection extends Database {
    public function getConnection() {
        return $this->conn;
    }
}
$db = new DBConnection();
$conn = $db->getConnection();

$query = "SELECT d.*, b.judul, b.harga, p.kondisi_buku, u.nama, u.email
          FROM denda d
          JOIN peminjaman p ON d.peminjaman_id = p.id
          JOIN buku b ON p.buku_id = b.id
          JOIN users u ON d.user_id = u.id
          WHERE d.kode_konfirmasi = ? AND d.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $kode, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$denda_list = $result->fetch_all(MYSQLI_ASSOC);

if (empty($denda_list)) {
    die("Data konfirmasi tidak ditemukan atau Anda tidak memiliki akses.");
}

$user_nama = $denda_list[0]['nama'];
$user_email = $denda_list[0]['email'] ?? '';
$status = $denda_list[0]['status'];
$metode = $denda_list[0]['metode_pembayaran'];
$tanggal = $denda_list[0]['created_at'] ?? $denda_list[0]['tanggal_bayar'];

$total_bayar = 0;
foreach ($denda_list as $item) {
    $total_bayar += $item['jumlah_denda'];
}

// Render view
require_once "../views/dashboard/konfirmasi_pembayaran.php";
?>
