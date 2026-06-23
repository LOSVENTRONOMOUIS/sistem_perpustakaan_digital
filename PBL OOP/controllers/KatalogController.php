<?php

require_once "../config/database.php";

class KatalogController extends Database {

    private $db;

    public function __construct() {

        parent::__construct();

        $this->db = $this->conn;

        if (!$this->db) {
            die(json_encode([
                'success' => false,
                'message' => 'Koneksi database gagal'
            ]));
        }
    }
    
    public function handleRequest() {
        try {
            // 🔥 Mulai session untuk akses data user
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            
            if (!$isAjax && $_SERVER['REQUEST_METHOD'] === 'POST') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Invalid request']);
                return;
            }
            
            $action = isset($_POST['action']) ? $_POST['action'] : '';
            
            if (empty($action)) {
                echo json_encode(['success' => false, 'message' => 'Action tidak ditemukan']);
                return;
            }
            
            switch($action) {
                case 'pinjam':
                    $this->prosesPinjam();
                    break;
                case 'filter':
                    $this->filterBooks();
                    break;
                case 'cek_status_peminjaman':
                    $this->cekStatusPeminjaman();
                    break;
                case 'cek_denda':
                    $this->cekDendaUser();
                    break;
                case 'cek_jumlah_peminjaman':
                    $this->cekJumlahPeminjaman();
                    break;
                default:
                    echo json_encode(['success' => false, 'message' => 'Invalid action: ' . $action]);
            }
            
        } catch (Exception $e) {
            error_log("HandleRequest error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Cek jumlah peminjaman aktif user (maksimal 3)
     */
    private function cekJumlahPeminjaman() {
        try {
            $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : ($_SESSION['user_id'] ?? 0);
            
            if ($user_id <= 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'User ID tidak valid'
                ]);
                return;
            }
            
            $query = "SELECT COUNT(*) as jumlah_pinjam 
                      FROM peminjaman 
                      WHERE user_id = $user_id 
                      AND status = 'dipinjam'";
            
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal mengecek jumlah peminjaman'
                ]);
                return;
            }
            
            $row = mysqli_fetch_assoc($result);
            $jumlah_pinjam = (int)$row['jumlah_pinjam'];
            $max_pinjam = 3;
            $sisa_kuota = $max_pinjam - $jumlah_pinjam;
            
            echo json_encode([
                'success' => true,
                'jumlah_pinjam' => $jumlah_pinjam,
                'max_pinjam' => $max_pinjam,
                'sisa_kuota' => $sisa_kuota,
                'bisa_pinjam' => $sisa_kuota > 0
            ]);
            
        } catch (Exception $e) {
            error_log("CekJumlahPeminjaman error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Cek apakah user sedang meminjam buku tertentu
     */
    private function cekStatusPeminjaman() {
        try {
            $buku_id = isset($_POST['buku_id']) ? (int)$_POST['buku_id'] : 0;
            $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : ($_SESSION['user_id'] ?? 0);
            
            if ($buku_id <= 0 || $user_id <= 0) {
                echo json_encode(['is_pinjam' => false]);
                return;
            }
            
            $query = "SELECT p.*, b.judul 
                      FROM peminjaman p 
                      JOIN buku b ON p.buku_id = b.id 
                      WHERE p.user_id = $user_id 
                      AND p.buku_id = $buku_id 
                      AND p.status = 'dipinjam'
                      ORDER BY p.tanggal_pinjam DESC 
                      LIMIT 1";
            
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                echo json_encode(['is_pinjam' => false]);
                return;
            }
            
            if (mysqli_num_rows($result) > 0) {
                $peminjaman = mysqli_fetch_assoc($result);
                echo json_encode([
                    'is_pinjam' => true,
                    'data' => [
                        'tanggal_pinjam' => $peminjaman['tanggal_pinjam'],
                        'tanggal_kembali' => $peminjaman['tanggal_kembali']
                    ]
                ]);
            } else {
                echo json_encode(['is_pinjam' => false]);
            }
            
        } catch (Exception $e) {
            error_log("CekStatusPeminjaman error: " . $e->getMessage());
            echo json_encode(['is_pinjam' => false]);
        }
    }
    
    /**
     * Cek apakah user memiliki denda atau buku terlambat
     */
    private function cekDendaUser() {
        try {
            $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : ($_SESSION['user_id'] ?? 0);
            
            if ($user_id <= 0) {
                echo json_encode(['has_denda' => false]);
                return;
            }
            
            // Cek apakah user memiliki buku yang terlambat
            $query = "SELECT COUNT(*) as jumlah_terlambat 
                      FROM peminjaman 
                      WHERE user_id = $user_id 
                      AND status = 'dipinjam' 
                      AND tanggal_kembali < CURDATE()";
            
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                echo json_encode(['has_denda' => false]);
                return;
            }
            
            $row = mysqli_fetch_assoc($result);
            
            if ($row['jumlah_terlambat'] > 0) {
                $message = "Anda memiliki " . $row['jumlah_terlambat'] . " buku yang terlambat dikembalikan";
                echo json_encode([
                    'has_denda' => true,
                    'message' => $message,
                    'jumlah_terlambat' => $row['jumlah_terlambat']
                ]);
            } else {
                echo json_encode(['has_denda' => false]);
            }
            
        } catch (Exception $e) {
            error_log("CekDendaUser error: " . $e->getMessage());
            echo json_encode(['has_denda' => false]);
        }
    }
    
    private function prosesPinjam() {
        try {
            // 🔥 Ambil user_id dari SESSION jika tidak dikirim via POST
            $buku_id = isset($_POST['buku_id']) ? (int)$_POST['buku_id'] : 0;
            $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : ($_SESSION['user_id'] ?? 0);
            
            if ($buku_id <= 0 || $user_id <= 0) {
                throw new Exception('Data tidak lengkap. User ID: ' . $user_id . ', Buku ID: ' . $buku_id);
            }
            
            // 🔥 CEK JUMLAH PEMINJAMAN AKTIF (MAKSIMAL 3)
            $cekJumlahQuery = "SELECT COUNT(*) as jumlah_pinjam 
                               FROM peminjaman 
                               WHERE user_id = $user_id 
                               AND status = 'dipinjam'";
            
            $jumlahResult = mysqli_query($this->db, $cekJumlahQuery);
            
            if (!$jumlahResult) {
                throw new Exception('Gagal mengecek jumlah peminjaman');
            }
            
            $jumlahData = mysqli_fetch_assoc($jumlahResult);
            $jumlah_pinjam = (int)$jumlahData['jumlah_pinjam'];
            $max_pinjam = 3;
            
            if ($jumlah_pinjam >= $max_pinjam) {
                throw new Exception("Anda sudah mencapai batas maksimal peminjaman ($max_pinjam buku). Silakan kembalikan beberapa buku terlebih dahulu.");
            }
            
            // 🔥 Cek apakah user memiliki buku yang terlambat
            $cekTerlambatQuery = "SELECT COUNT(*) as jumlah_terlambat 
                                  FROM peminjaman 
                                  WHERE user_id = $user_id 
                                  AND status = 'dipinjam' 
                                  AND tanggal_kembali < CURDATE()";
            
            $terlambatResult = mysqli_query($this->db, $cekTerlambatQuery);
            
            if ($terlambatResult) {
                $terlambat = mysqli_fetch_assoc($terlambatResult);
                if ($terlambat['jumlah_terlambat'] > 0) {
                    throw new Exception('Anda memiliki buku yang terlambat dikembalikan. Silakan kembalikan terlebih dahulu.');
                }
            }
            
            // 🔥 Cek apakah user sedang meminjam buku yang sama
            $check_query = "SELECT id, tanggal_pinjam, tanggal_kembali, status 
                           FROM peminjaman 
                           WHERE user_id = $user_id 
                           AND buku_id = $buku_id 
                           AND status = 'dipinjam'";
            
            $check_result = mysqli_query($this->db, $check_query);
            
            if (!$check_result) {
                throw new Exception('Error checking existing loan: ' . mysqli_error($this->db));
            }
            
            if (mysqli_num_rows($check_result) > 0) {
                $existing_loan = mysqli_fetch_assoc($check_result);
                $tanggal_pinjam_existing = date('d/m/Y', strtotime($existing_loan['tanggal_pinjam']));
                
                throw new Exception("Anda sedang meminjam buku ini (sejak $tanggal_pinjam_existing). Silakan kembalikan terlebih dahulu.");
            }
            
            // 🔥 Cek stok buku (gunakan tabel 'buku' bukan 'books')
            $query = "SELECT stok, judul FROM buku WHERE id = $buku_id";
            $result = mysqli_query($this->db, $query);
            
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Buku tidak ditemukan');
            }
            
            $buku = mysqli_fetch_assoc($result);
            
            if ($buku['stok'] <= 0) {
                throw new Exception('Stok buku habis');
            }
            
            // Mulai transaksi
            mysqli_begin_transaction($this->db);
            
            // Insert peminjaman
            $tanggal_pinjam = date('Y-m-d');
            $tanggal_kembali = date('Y-m-d', strtotime('+14 days'));
            
            $query = "INSERT INTO peminjaman (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status) 
                      VALUES ($user_id, $buku_id, '$tanggal_pinjam', '$tanggal_kembali', 'dipinjam')";
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                throw new Exception('Gagal menyimpan data peminjaman: ' . mysqli_error($this->db));
            }
            
            $peminjaman_id = mysqli_insert_id($this->db);
            
            // Update stok buku (kurangi 1)
            $query = "UPDATE buku SET stok = stok - 1 WHERE id = $buku_id AND stok > 0";
            $result = mysqli_query($this->db, $query);
            
            if (!$result || mysqli_affected_rows($this->db) == 0) {
                throw new Exception('Gagal mengupdate stok buku');
            }
            
            // Commit transaksi
            mysqli_commit($this->db);
            
            echo json_encode([
                'success' => true,
                'message' => 'Buku berhasil dipinjam',
                'data' => [
                    'peminjaman_id' => $peminjaman_id,
                    'buku' => $buku['judul'],
                    'tanggal_pinjam' => date('d/m/Y', strtotime($tanggal_pinjam)),
                    'tanggal_kembali' => date('d/m/Y', strtotime($tanggal_kembali)),
                    'sisa_kuota' => $max_pinjam - ($jumlah_pinjam + 1)
                ]
            ]);
            
        } catch (Exception $e) {
            if (isset($this->db) && $this->db) {
                mysqli_rollback($this->db);
            }
            
            error_log("ProsesPinjam error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Filter Buku dengan JOIN ke tabel kategori
     */
    private function filterBooks() {
        try {
            $keyword = isset($_POST['keyword']) ? mysqli_real_escape_string($this->db, trim($_POST['keyword'])) : '';
            $category = isset($_POST['category']) ? mysqli_real_escape_string($this->db, $_POST['category']) : 'all';
            $status = isset($_POST['status']) ? mysqli_real_escape_string($this->db, $_POST['status']) : 'all';
            
            // 🔥 Query dengan JOIN ke tabel kategori
            $query = "SELECT buku.*, kategori.nama_kategori 
                      FROM buku 
                      LEFT JOIN kategori ON buku.kategori = kategori.id 
                      WHERE 1=1";
            
            // Filter keyword
            if (!empty($keyword)) {
                $query .= " AND (buku.judul LIKE '%$keyword%' OR buku.penulis LIKE '%$keyword%')";
            }
            
            // Filter kategori - cari ID dari nama kategori
            if ($category !== 'all' && !empty($category)) {
                $kategori_id = $this->getCategoryIdFromName($category);
                if ($kategori_id) {
                    $query .= " AND buku.kategori = '$kategori_id'";
                }
            }
            
            // Filter status
            if ($status !== 'all') {
                if ($status === 'tersedia') {
                    $query .= " AND buku.stok > 3";
                } elseif ($status === 'terbatas') {
                    $query .= " AND buku.stok BETWEEN 1 AND 3";
                } elseif ($status === 'habis') {
                    $query .= " AND buku.stok = 0";
                }
            }
            
            $query .= " ORDER BY buku.judul ASC";
            
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                throw new Exception('Error query: ' . mysqli_error($this->db));
            }
            
            $books = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Gunakan nama_kategori dari join, atau fallback ke getCategoryName
                $kategori_nama = $row['nama_kategori'] ?? $this->getCategoryName($row['kategori']);
                $row['bg'] = $this->getCoverBg($kategori_nama);
                $row['cover'] = $this->getCoverEmoji($kategori_nama);
                $row['kategori'] = $kategori_nama;
                $books[] = $row;
            }
            
            echo json_encode([
                'success' => true,
                'books' => $books,
                'count' => count($books)
            ]);
            
        } catch (Exception $e) {
            error_log("FilterBooks error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'books' => []
            ]);
        }
    }
    
    /**
     * Ambil semua buku dengan JOIN kategori
     */
    public function getAllBooks() {
        try {
            $query = "SELECT buku.*, kategori.nama_kategori 
                      FROM buku 
                      LEFT JOIN kategori ON buku.kategori = kategori.id 
                      ORDER BY buku.judul ASC";
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                return [];
            }
            
            $books = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Gunakan nama_kategori dari join, atau fallback ke getCategoryName
                $row['kategori'] = $row['nama_kategori'] ?? $this->getCategoryName($row['kategori']);
                $books[] = $row;
            }
            return $books;
            
        } catch (Exception $e) {
            error_log("GetAllBooks error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Ambil semua kategori dari database
     */
    public function getAllCategories() {
        try {
            $query = "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC";
            $result = mysqli_query($this->db, $query);
            
            if (!$result) {
                return ['Pemrograman', 'Teknologi', 'Bisnis', 'Sejarah', 'Psikologi', 'Sains'];
            }
            
            $categories = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row['nama_kategori'];
            }
            
            // Jika tidak ada kategori di database, gunakan default
            if (empty($categories)) {
                return ['Pemrograman', 'Teknologi', 'Bisnis', 'Sejarah', 'Psikologi', 'Sains'];
            }
            
            return $categories;
            
        } catch (Exception $e) {
            error_log("GetAllCategories error: " . $e->getMessage());
            return ['Pemrograman', 'Teknologi', 'Bisnis', 'Sejarah', 'Psikologi', 'Sains'];
        }
    }
    
    /**
     * Get category ID from name
     */
    private function getCategoryIdFromName($nama_kategori) {
        $query = "SELECT id FROM kategori WHERE nama_kategori = '$nama_kategori' LIMIT 1";
        $result = mysqli_query($this->db, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['id'];
        }
        return null;
    }
    
    /**
     * Get category name from ID (fallback jika tidak ada join)
     */
    private function getCategoryName($kategori_id) {
        if (!$kategori_id) return 'Umum';
        
        $query = "SELECT nama_kategori FROM kategori WHERE id = '$kategori_id' LIMIT 1";
        $result = mysqli_query($this->db, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['nama_kategori'];
        }
        
        // Fallback untuk kategori lama
        $kategori_map = [
            '1' => 'Pemrograman',
            '2' => 'Teknologi',
            '3' => 'Bisnis',
            '4' => 'Sejarah',
            '5' => 'Psikologi',
            '6' => 'Sains'
        ];
        return isset($kategori_map[(string)$kategori_id]) ? $kategori_map[(string)$kategori_id] : 'Umum';
    }
    
    /**
     * Get cover background color based on category
     */
    private function getCoverBg($kategori) {
        $bgColors = [
            'Pemrograman' => '#d4e8f4',
            'Teknologi' => '#d4e8f4',
            'Bisnis' => '#fde8d8',
            'Sejarah' => '#e8f4d4',
            'Psikologi' => '#f4d4e8',
            'Sains' => '#f4f0d4',
            'Informatika' => '#d4e8f4',
            'Robotic' => '#e8f4d4',
            'Umum' => '#d4eaf4'
        ];
        return isset($bgColors[$kategori]) ? $bgColors[$kategori] : '#d4eaf4';
    }
    
    /**
     * Get cover emoji based on category
     */
    private function getCoverEmoji($kategori) {
        $emojis = [
            'Teknologi' => '📘',
            'Bisnis' => '📙',
            'Sejarah' => '📗',
            'Psikologi' => '📕',
            'Sains' => '📒',
            'Informatika' => '📘',
            'Robotic' => '🤖',
            'Umum' => '📔'
        ];
        return isset($emojis[$kategori]) ? $emojis[$kategori] : '📔';
    }
    
    /**
     * Fungsi untuk mengembalikan buku (update stok + denda)
     * Dipanggil dari peminjaman.php
     */
    public function kembalikanBuku($peminjaman_id) {
        try {
            mysqli_begin_transaction($this->db);
            
            // Ambil data peminjaman
            $query = "SELECT * FROM peminjaman WHERE id = $peminjaman_id AND status = 'dipinjam'";
            $result = mysqli_query($this->db, $query);
            
            if (!$result || mysqli_num_rows($result) == 0) {
                return ['success' => false, 'message' => 'Data peminjaman tidak ditemukan'];
            }
            
            $peminjaman = mysqli_fetch_assoc($result);
            
            // Hitung denda jika terlambat
            $denda = 0;
            $tanggal_kembali_seharusnya = $peminjaman['tanggal_kembali'];
            $tanggal_kembali_aktual = date('Y-m-d');
            
            if ($tanggal_kembali_aktual > $tanggal_kembali_seharusnya) {
                $selisih_hari = (strtotime($tanggal_kembali_aktual) - strtotime($tanggal_kembali_seharusnya)) / (60 * 60 * 24);
                $denda = $selisih_hari * 2000; // Denda Rp 2000 per hari
            }
            
            // Update status peminjaman
            $updateQuery = "UPDATE peminjaman 
                           SET status = 'dikembalikan', 
                               tanggal_pengembalian = '$tanggal_kembali_aktual',
                               denda = $denda
                           WHERE id = $peminjaman_id";
            
            $result = mysqli_query($this->db, $updateQuery);
            
            if (!$result) {
                throw new Exception('Gagal mengupdate status peminjaman');
            }
            
            // Tambah stok buku (+1)
            $updateStok = "UPDATE buku SET stok = stok + 1 WHERE id = " . $peminjaman['buku_id'];
            $result = mysqli_query($this->db, $updateStok);
            
            if (!$result) {
                throw new Exception('Gagal mengupdate stok buku');
            }
            
            mysqli_commit($this->db);
            
            return [
                'success' => true,
                'message' => 'Buku berhasil dikembalikan',
                'denda' => $denda
            ];
            
        } catch (Exception $e) {
            mysqli_rollback($this->db);
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Fungsi untuk membatalkan peminjaman (rollback stok)
     * Dipanggil dari peminjaman.php
     */
    public function batalkanPeminjaman($peminjaman_id) {
        try {
            mysqli_begin_transaction($this->db);
            
            // Ambil data peminjaman
            $query = "SELECT * FROM peminjaman WHERE id = $peminjaman_id AND status = 'dipinjam'";
            $result = mysqli_query($this->db, $query);
            
            if (!$result || mysqli_num_rows($result) == 0) {
                return ['success' => false, 'message' => 'Data peminjaman tidak ditemukan'];
            }
            
            $peminjaman = mysqli_fetch_assoc($result);
            
            // Update status menjadi dibatalkan
            $updateQuery = "UPDATE peminjaman SET status = 'dibatalkan' WHERE id = $peminjaman_id";
            $result = mysqli_query($this->db, $updateQuery);
            
            if (!$result) {
                throw new Exception('Gagal membatalkan peminjaman');
            }
            
            // Kembalikan stok buku (+1)
            $updateStok = "UPDATE buku SET stok = stok + 1 WHERE id = " . $peminjaman['buku_id'];
            $result = mysqli_query($this->db, $updateStok);
            
            if (!$result) {
                throw new Exception('Gagal mengupdate stok buku');
            }
            
            mysqli_commit($this->db);
            
            return ['success' => true, 'message' => 'Peminjaman berhasil dibatalkan'];
            
        } catch (Exception $e) {
            mysqli_rollback($this->db);
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
}

?>