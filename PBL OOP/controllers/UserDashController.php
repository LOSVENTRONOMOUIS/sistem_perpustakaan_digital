<?php
// controllers/UserDashboardController.php

require_once "../models/Buku.php";
require_once "../models/userpeminjaman.php";
require_once "../models/User.php";
require_once "../config/database.php";

class UserDashController extends Database {
    private $buku;
    private $peminjaman;
    private $user;
    private $denda_per_hari = 2000;
    private $user_id;
    private $user_nama;
    private $user_nim;
    
    public function __construct() {
        $this->buku = new Buku();
        $this->peminjaman = new PeminjamanUser();
        $this->user = new User();

        parent::__construct();
        
        // PERBAIKAN: Cek apakah session sudah aktif
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // VALIDASI SESSION
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
        
        $this->user_id = $_SESSION['user_id'];
        
        // CEK APAKAH USER ID VALID
        if (!$this->isValidUser($this->user_id)) {
            session_destroy();
            header("Location: login.php?error=invalid_user");
            exit();
        }
        
        // Ambil data dari database
        $userData = $this->getUserData($this->user_id);
        if ($userData) {
            $this->user_nama = $userData['nama'];
            $this->user_nim = $userData['nim'] ?? '';
            $_SESSION['nama'] = $this->user_nama;
            $_SESSION['nim'] = $this->user_nim;
        } else {
            session_destroy();
            header("Location: login.php?error=user_not_found");
            exit();
        }
    }
    
    private function isValidUser($user_id) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    
    private function getUserData($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getDashboardData() {
        return [
            'totalKoleksi' => $this->getTotalKoleksi(),
            'totalDipinjam' => $this->getTotalDipinjam(),
            'totalTerlambat' => $this->getTotalTerlambat(),
            'bukuPopuler' => $this->getBukuPopuler(6),
            'user_nama' => $this->user_nama,
            'user_nim' => $this->user_nim,
            'is_locked' => $this->isLocked(),
            'total_late_days' => $this->getTotalLateDays(),
            'total_denda' => $this->getTotalDenda(),
            'late_books_detail' => $this->getLateBooksDetail()
        ];
    }
    
    public function getTotalKoleksi() {
        return $this->buku->totalBuku();
    }
    
    public function getTotalDipinjam() {
        return $this->peminjaman->totalDipinjam();
    }
    
    public function getTotalTerlambat() {
        return count($this->getLateBooksDetail());
    }
    
    public function isLocked() {
        return count($this->getLateBooksDetail()) > 0;
    }
    
    public function getTotalLateDays() {
        return $this->peminjaman->totalLateDaysByUser($this->user_id);
    }
    
    public function getTotalDenda() {
        return $this->peminjaman->totalFineByUser($this->user_id, $this->denda_per_hari);
    }
    
    public function getLateBooksDetail() {
        return $this->peminjaman->getLateBooksDetailByUser($this->user_id, $this->denda_per_hari);
    }
    
    public function getBukuPopuler($limit = 6) {
        return $this->buku->getPopularBooks($limit);
    }
    
    public function searchBooks() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $keyword = $_POST['keyword'] ?? '';
            $books = $this->buku->searchBooksDashboard($keyword);
            
            foreach ($books as &$book) {
                $book['bg'] = $this->getCoverBg($book['kategori_id'] ?? 1);
                $book['cover'] = $this->getCoverEmoji($book['kategori_id'] ?? 1);
            }
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'books' => $books]);
            exit;
        }
    }
    
    // ==================== CEK STATUS DENDA TERBARU (UNTUK AUTO-REFRESH) ====================
    
    public function getLatestDendaStatus() {
        $user_id = $this->user_id;
        
        // Cek apakah masih ada buku yang belum dibayar (unpaid)
        $query = "SELECT 
                    SUM(CASE WHEN d.status = 'unpaid' THEN 1 ELSE 0 END) as unpaid_count,
                    SUM(CASE WHEN d.status = 'pending' THEN 1 ELSE 0 END) as pending_count
                  FROM denda d 
                  JOIN peminjaman p ON d.peminjaman_id = p.id 
                  WHERE d.user_id = ? AND p.status = 'dipinjam'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        echo json_encode([
            'success' => true,
            'has_unpaid' => ($row['unpaid_count'] ?? 0) > 0,
            'all_waiting' => ($row['unpaid_count'] ?? 0) == 0 && ($row['pending_count'] ?? 0) > 0
        ]);
        exit;
    }
    
    // ==================== AMBIL DATA BUKU TERBARU ====================
    
    public function getLatestBooksData() {
        $user_id = $this->user_id;
        
        $query = "SELECT 
                    b.id as buku_id,
                    b.judul,
                    b.penulis,
                    b.kategori_id,
                    p.id,
                    p.tanggal_pinjam,
                    p.tanggal_kembali,
                    d.status as denda_status,
                    d.kode_konfirmasi,
                    d.jumlah_denda
                  FROM peminjaman p
                  JOIN buku b ON p.buku_id = b.id
                  LEFT JOIN denda d ON p.id = d.peminjaman_id
                  WHERE p.user_id = ? 
                  AND p.status = 'dipinjam'
                  AND (p.tanggal_kembali < CURDATE() OR p.kondisi_buku = 'rusak')
                  ORDER BY p.tanggal_kembali ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = $result->fetch_all(MYSQLI_ASSOC);
        
        // Hitung late_days untuk setiap buku
        $today = new DateTime();
        foreach($books as &$book) {
            $jatuh_tempo = new DateTime($book['tanggal_kembali']);
            if ($today > $jatuh_tempo) {
                $diff = $today->diff($jatuh_tempo);
                $book['late_days'] = $diff->days;
            } else {
                $book['late_days'] = 0;
            }
        }
        
        echo json_encode([
            'success' => true,
            'books' => $books
        ]);
        exit;
    }
    
    // ==================== PEMBAYARAN DENDA ====================
    
    public function processFinePayment() {
        // Pastikan request adalah AJAX POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }
        
        $book_ids = $_POST['book_ids'] ?? '';
        $method = $_POST['method'] ?? '';
        $total = $_POST['total'] ?? 0;
        
        if (empty($book_ids) || empty($method)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            exit;
        }
        
        $user_id = $this->user_id;
        $denda_per_hari = $this->denda_per_hari;
        
        // DEBUG: Log data yang diterima
        error_log("=== PROCESSING PAYMENT ===");
        error_log("Book IDs: " . $book_ids);
        error_log("Method: " . $method);
        error_log("Total: " . $total);
        error_log("User ID: " . $user_id);
        
        // PERBAIKAN 1: Eksekusi DDL di luar transaksi agar tidak terjadi implicit commit
        try {
            $this->ensureDendaTable();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Gagal menyiapkan sistem denda: ' . $e->getMessage()]);
            exit;
        }
        
        try {
            $this->conn->begin_transaction();
            
            $bookIdArray = explode(',', $book_ids);
            $successCount = 0;
            
            // PERBAIKAN 2: Buat 1 Kode Konfirmasi untuk seluruh keranjang pembayaran ini
            $kode_konfirmasi = strtoupper(substr(md5(uniqid($user_id . time() . rand(), true)), 0, 10));
            
            foreach ($bookIdArray as $book_id) {
                // PERBAIKAN 3: Gunakan tanggal_kembali dari database untuk validasi keterlambatan yang konsisten
                 $query = "SELECT p.*, b.harga, p.kondisi_buku,
                           DATEDIFF(NOW(), p.tanggal_kembali) as late_days
                           FROM peminjaman p
                           JOIN buku b ON p.buku_id = b.id
                           WHERE p.user_id = ? AND p.buku_id = ? 
                           AND p.status = 'dipinjam'
                           AND (p.tanggal_kembali < NOW() OR p.kondisi_buku = 'rusak')";
                 
                 $stmt = $this->conn->prepare($query);
                 $stmt->bind_param("ii", $user_id, $book_id);
                 $stmt->execute();
                 $result = $stmt->get_result();
                 $peminjaman = $result->fetch_assoc();
                 
                 // DEBUG: Log hasil query
                 error_log("Checking book_id: " . $book_id . ", user_id: " . $user_id);
                 error_log("Peminjaman found: " . ($peminjaman ? "YES (ID: " . $peminjaman['id'] . ", late_days: " . $peminjaman['late_days'] . ")" : "NO"));
                 
                 if ($peminjaman) {
                     $late_days = max(0, (int)$peminjaman['late_days']);
                     $fine_amount = $late_days * $denda_per_hari;
                     
                     if (isset($peminjaman['kondisi_buku']) && strtolower($peminjaman['kondisi_buku']) == 'rusak') {
                         if ($late_days > 0) {
                             $fine_amount += (int)$peminjaman['harga']; // Gabungan jika rusak + telat
                         } else {
                             $fine_amount = (int)$peminjaman['harga']; // Ganti buku saja jika rusak saja
                         }
                     } else {
                         // Jika tidak rusak tapi masuk ke sini (berarti telat), pastikan minimal denda 1 hari
                         if ($late_days == 0) {
                             $late_days = 1;
                             $fine_amount = $late_days * $denda_per_hari;
                         }
                     }
                    
                    // PERUBAHAN: Untuk pembayaran tunai, status = 'pending', untuk online = 'lunas'
                    $status = ($method == 'tunai') ? 'pending' : 'lunas';
                    
                    // Insert ke tabel denda
                    $query = "INSERT INTO denda (peminjaman_id, user_id, jumlah_denda, status, metode_pembayaran, kode_konfirmasi, tanggal_bayar, created_at)
                              VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("iidsss", $peminjaman['id'], $user_id, $fine_amount, $status, $method, $kode_konfirmasi);
                    
                    if ($stmt->execute()) {
                        $successCount++;
                        
                        // PERUBAHAN: Untuk pembayaran online langsung update status peminjaman
                        // Untuk tunai, TIDAK update status dulu, menunggu konfirmasi admin
                        if ($method != 'tunai') {
                            // Update status peminjaman jadi dikembalikan
                            $query = "UPDATE peminjaman 
                                      SET status = 'dikembalikan', tanggal_pengembalian = NOW()
                                      WHERE id = ?";
                            $stmt = $this->conn->prepare($query);
                            $stmt->bind_param("i", $peminjaman['id']);
                            $stmt->execute();
                            
                            // Update stok buku
                            $query = "UPDATE buku SET stok = stok + 1 WHERE id = ?";
                            $stmt = $this->conn->prepare($query);
                            $stmt->bind_param("i", $book_id);
                            $stmt->execute();
                        }
                        
                        error_log("Successfully processed book_id: " . $book_id . ", peminjaman_id: " . $peminjaman['id'] . ", status: " . $status);
                    } else {
                        error_log("Failed to insert denda for book_id: " . $book_id);
                    }
                } else {
                    error_log("No active late loan found for book_id: " . $book_id . ", user_id: " . $user_id);
                }
            }
            
            if ($successCount > 0) {
                // PERUBAHAN: Hanya unlock user jika pembayaran online (bukan tunai)
                if ($method != 'tunai') {
                    // Cek apakah user masih punya buku telat yang lain
                    $query = "SELECT COUNT(*) as total FROM peminjaman 
                              WHERE user_id = ? AND status = 'dipinjam' 
                              AND tanggal_kembali < NOW()";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $remaining_late = $result->fetch_assoc()['total'];
                    
                    // Jika tidak ada lagi buku terlambat, unlock user
                    if ($remaining_late == 0) {
                        $query = "UPDATE users SET is_locked = 0 WHERE id = ?";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        error_log("User " . $user_id . " has been UNLOCKED");
                    }
                } else {
                    error_log("Payment method is TUNAI - User " . $user_id . " remains LOCKED until admin confirmation");
                }
                
                $this->conn->commit();
                
                $message = ($method == 'tunai') 
                    ? 'Pembayaran dicatat! Silakan konfirmasi ke petugas perpustakaan dengan menunjukkan kode berikut.' 
                    : 'Pembayaran berhasil! Terima kasih. Akses Anda telah dipulihkan.';
                
                echo json_encode([
                    'success' => true,
                    'message' => $message,
                    'kode_konfirmasi' => $kode_konfirmasi,
                    'jumlah_buku' => $successCount,
                    'status' => ($method == 'tunai') ? 'pending' : 'success'
                ]);
            } else {
                throw new Exception("Buku yang Anda pilih belum melewati batas waktu (belum ada denda) atau sudah dikembalikan.");
            }
            
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Payment Error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    private function ensureDendaTable() {
        // Cek apakah tabel denda ada
        $query = "SHOW TABLES LIKE 'denda'";
        $result = $this->conn->query($query);
        if ($result->num_rows == 0) {
            // Buat tabel denda
            $sql = "CREATE TABLE IF NOT EXISTS denda (
                id INT PRIMARY KEY AUTO_INCREMENT,
                peminjaman_id INT NOT NULL,
                user_id INT NOT NULL,
                jumlah_denda DECIMAL(10,2) NOT NULL,
                status ENUM('pending', 'lunas', 'unpaid') DEFAULT 'unpaid',
                metode_pembayaran VARCHAR(50),
                kode_konfirmasi VARCHAR(50),
                tanggal_bayar DATETIME,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_user_id (user_id),
                INDEX idx_kode_konfirmasi (kode_konfirmasi),
                FOREIGN KEY (peminjaman_id) REFERENCES peminjaman(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";
            $this->conn->query($sql);
        } else {
            // Cek apakah kolom kode_konfirmasi ada, jika tidak tambahkan
            $query = "SHOW COLUMNS FROM denda LIKE 'kode_konfirmasi'";
            $result = $this->conn->query($query);
            if ($result->num_rows == 0) {
                $this->conn->query("ALTER TABLE denda ADD COLUMN kode_konfirmasi VARCHAR(50) AFTER metode_pembayaran");
            }
            
            // Cek apakah kolom status memiliki nilai 'unpaid'
            $query = "SHOW COLUMNS FROM denda LIKE 'status'";
            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (strpos($row['Type'], 'unpaid') === false) {
                    $this->conn->query("ALTER TABLE denda MODIFY COLUMN status ENUM('pending', 'lunas', 'unpaid') DEFAULT 'unpaid'");
                }
            }
        }
    }
    
    // ==================== HANDLE AJAX REQUESTS ====================
    
    public function handleAjaxRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'search') {
                $this->searchBooks();
                exit;
            }
            
            if ($action === 'pay_fine') {
                $this->processFinePayment();
                exit;
            }
            
            if ($action === 'get_latest_denda_status') {
                $this->getLatestDendaStatus();
                exit;
            }
            
            if ($action === 'get_latest_books_data') {
                $this->getLatestBooksData();
                exit;
            }
        }
    }
    
    // ==================== HELPER FUNCTIONS ====================
    
    private function getCoverBg($kategori) {
        $bgColors = [
            1 => '#d4e8f4', 2 => '#d4e8f4', 3 => '#fde8d8',
            4 => '#e8f4d4', 5 => '#f4d4e8', 6 => '#f4f0d4'
        ];
        return $bgColors[$kategori] ?? '#d4eaf4';
    }
    
    private function getCoverEmoji($kategori) {
        $emojis = [1 => '📘', 2 => '📘', 3 => '📙', 4 => '📗', 5 => '📕', 6 => '📒'];
        return $emojis[$kategori] ?? '📔';
    }
}
?>