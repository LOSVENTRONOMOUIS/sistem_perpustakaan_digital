<?php
// models/Buku.php
require_once "../config/database.php";

class Buku extends Database {

    // ==================== METHOD UNTUK DASHBOARD ====================
    
    // ambil semua buku (alias untuk getAllBooks)
    public function getAll(){
        return $this->getAllBooks();
    }
    
    // =========================
    // AMBIL SEMUA BUKU
    // =========================
    public function getAllBooks(){
        $query = mysqli_query($this->conn, "
            SELECT buku.*,
                   kategori.nama_kategori
            FROM buku
            LEFT JOIN kategori
            ON buku.kategori = kategori.id
            ORDER BY buku.id DESC
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ambil semua buku untuk katalog dengan join kategori
    public function getAllBooksForKatalog(){
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            ORDER BY buku.id DESC
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ambil 4 buku terbaru untuk dashboard
    public function getLatestBooks($limit = 4){
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            ORDER BY buku.id DESC LIMIT $limit
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // =========================
    // TOTAL BUKU
    // =========================
    public function totalBuku(){
        $query = mysqli_query($this->conn, "
            SELECT * FROM buku
        ");
        return mysqli_num_rows($query);
    }

    // =========================
    // TOTAL TERSEDIA
    // =========================
    public function totalTersedia(){
        $query = mysqli_query($this->conn, "
            SELECT * FROM buku
            WHERE stok > 0
        ");
        return mysqli_num_rows($query);
    }

    // =========================
    // TOTAL HABIS
    // =========================
    public function totalHabis(){
        $query = mysqli_query($this->conn, "
            SELECT * FROM buku
            WHERE stok <= 0
        ");
        return mysqli_num_rows($query);
    }

    // =========================
    // BUKU TERBARU
    // =========================
    public function latestBook(){
        $query = mysqli_query($this->conn, "
            SELECT buku.*,
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            ORDER BY buku.id DESC
            LIMIT 5
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ==================== METHOD UNTUK KATALOG ====================

    /**
     * GET ALL CATEGORIES FROM DATABASE
     * Mengambil semua kategori dari tabel kategori
     */
    public function getAllCategories(){
        $query = mysqli_query($this->conn, "
            SELECT id, nama_kategori 
            FROM kategori 
            ORDER BY nama_kategori ASC
        ");
        
        if (!$query) {
            return [];
        }
        
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * GET CATEGORY NAME BY ID
     */
    public function getCategoryNameById($id){
        $stmt = $this->conn->prepare("SELECT nama_kategori FROM kategori WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['nama_kategori'] : 'Umum';
    }

    /**
     * GET CATEGORY ID BY NAME
     */
    public function getCategoryIdByName($name){
        $stmt = $this->conn->prepare("SELECT id FROM kategori WHERE nama_kategori = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }

    // cari buku dengan filter (keyword, kategori_id, status)
    public function searchBooks($keyword = '', $kategori_id = null, $status = null){
        $sql = "SELECT buku.*, kategori.nama_kategori 
                FROM buku 
                LEFT JOIN kategori ON buku.kategori = kategori.id 
                WHERE 1=1";
        
        // Filter keyword (judul atau penulis)
        if (!empty($keyword)) {
            $keyword = mysqli_real_escape_string($this->conn, $keyword);
            $sql .= " AND (buku.judul LIKE '%$keyword%' OR buku.penulis LIKE '%$keyword%')";
        }
        
        // Filter kategori - sekarang menggunakan ID dari tabel kategori
        if ($kategori_id && $kategori_id != 'all') {
            $kategori_id = mysqli_real_escape_string($this->conn, $kategori_id);
            $sql .= " AND buku.kategori = '$kategori_id'";
        }
        
        // Filter status (berdasarkan stok)
        if ($status && $status != 'all') {
            if ($status == 'tersedia') {
                $sql .= " AND buku.stok > 0";
            } elseif ($status == 'terbatas') {
                $sql .= " AND buku.stok > 0 AND buku.stok <= 3";
            } elseif ($status == 'habis') {
                $sql .= " AND buku.stok = 0";
            }
        }
        
        $sql .= " ORDER BY buku.id DESC";
        $query = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // cari buku untuk dashboard (limit 10)
    public function searchBooksDashboard($keyword){
        $keyword = mysqli_real_escape_string($this->conn, $keyword);
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            WHERE buku.judul LIKE '%$keyword%' 
               OR buku.penulis LIKE '%$keyword%' 
            ORDER BY buku.id DESC 
            LIMIT 10
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // get buku berdasarkan kategori
    public function getBooksByCategoryId($kategori_id){
        $kategori_id = mysqli_real_escape_string($this->conn, $kategori_id);
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            WHERE buku.kategori = '$kategori_id' 
            ORDER BY buku.id DESC
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // get buku yang tersedia (stok > 0)
    public function getAvailableBooks(){
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            WHERE buku.stok > 0 
            ORDER BY buku.id DESC
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // hitung total buku berdasarkan kategori
    public function countBooksByCategoryId($kategori_id){
        $kategori_id = mysqli_real_escape_string($this->conn, $kategori_id);
        $query = mysqli_query($this->conn, "
            SELECT COUNT(*) as total 
            FROM buku 
            WHERE kategori = '$kategori_id'
        ");
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    // ==================== METHOD UNTUK ADMIN ====================

    // =========================
    // TAMBAH BUKU
    // =========================
    public function tambahBuku($data){
        $judul = htmlspecialchars($data['judul']);
        $penulis = htmlspecialchars($data['penulis']);
        $penerbit = htmlspecialchars($data['penerbit']);
        $tahun = htmlspecialchars($data['tahun']);
        $kategori = htmlspecialchars($data['kategori']);
        $stok = htmlspecialchars($data['stok']);
        $cover = htmlspecialchars($data['cover'] ?? '');
        
        $status = ($stok > 0) ? 'tersedia' : 'habis';

        mysqli_query($this->conn, "
            INSERT INTO buku
            (judul, penulis, penerbit, tahun, kategori, stok, status, cover)
            VALUES
            ('$judul','$penulis','$penerbit','$tahun','$kategori','$stok','$status','$cover')
        ");
    }

    // =========================
    // GET BY ID
    // =========================
    public function getById($id){
        $query = mysqli_query($this->conn, "
            SELECT buku.*,
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id 
            WHERE buku.id='$id'
        ");
        return mysqli_fetch_assoc($query);
    }

    // =========================
    // UPDATE BUKU
    // =========================
    public function updateBuku($data){
        $id = $data['id'];
        $judul = htmlspecialchars($data['judul']);
        $penulis = htmlspecialchars($data['penulis']);
        $penerbit = htmlspecialchars($data['penerbit']);
        $tahun = htmlspecialchars($data['tahun']);
        $kategori = $data['kategori'];
        $stok = htmlspecialchars($data['stok']);
        
        $status = ($stok > 0) ? 'tersedia' : 'habis';

        mysqli_query($this->conn, "
            UPDATE buku SET 
                judul='$judul',
                penulis='$penulis',
                penerbit='$penerbit',
                tahun='$tahun',
                kategori='$kategori',
                stok='$stok',
                status='$status'
            WHERE id='$id'
        ");
    }

    // =========================
    // HAPUS BUKU
    // =========================
    public function hapusBuku($id){
        mysqli_query($this->conn, "
            DELETE FROM buku
            WHERE id='$id'
        ");
    }

    // update status buku berdasarkan stok (otomatis)
    public function updateStatusByStock($id){
        $query = mysqli_query($this->conn, "SELECT stok FROM buku WHERE id='$id'");
        $book = mysqli_fetch_assoc($query);
        
        if (!$book) {
            return false;
        }
        
        if ($book['stok'] <= 0) {
            $status = 'habis';
        } elseif ($book['stok'] <= 3) {
            $status = 'terbatas';
        } else {
            $status = 'tersedia';
        }
        
        mysqli_query($this->conn, "UPDATE buku SET status='$status' WHERE id='$id'");
        return $status;
    }

    // ==================== METHOD UNTUK PEMINJAMAN ====================

    // kurangi stok buku (saat dipinjam)
    public function kurangiStok($id, $jumlah = 1){
        $query = mysqli_query($this->conn, "SELECT stok FROM buku WHERE id='$id'");
        $book = mysqli_fetch_assoc($query);
        
        if (!$book) {
            return false;
        }
        
        $newStock = $book['stok'] - $jumlah;
        $status = ($newStock > 0) ? 'tersedia' : 'habis';
        
        mysqli_query($this->conn, "UPDATE buku SET stok='$newStock', status='$status' WHERE id='$id'");
        
        return $newStock;
    }

    // tambah stok buku (saat pengembalian)
    public function tambahStok($id, $jumlah = 1){
        $query = mysqli_query($this->conn, "SELECT stok FROM buku WHERE id='$id'");
        $book = mysqli_fetch_assoc($query);
        
        if (!$book) {
            return false;
        }
        
        $newStock = $book['stok'] + $jumlah;
        $status = ($newStock > 0) ? 'tersedia' : 'habis';
        
        mysqli_query($this->conn, "UPDATE buku SET stok='$newStock', status='$status' WHERE id='$id'");
        
        return $newStock;
    }

    // ==================== METHOD TAMBAHAN UNTUK DASHBOARD ====================

    // ambil buku paling populer (paling banyak dipinjam)
    public function getPopularBooks($limit = 4){
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori, 
                   COUNT(peminjaman.buku_id) as total_pinjam
            FROM buku
            LEFT JOIN kategori ON buku.kategori = kategori.id
            LEFT JOIN peminjaman ON buku.id = peminjaman.buku_id
            GROUP BY buku.id
            ORDER BY total_pinjam DESC
            LIMIT $limit
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ambil buku paling populer berdasarkan stok (alternatif jika tidak ada data peminjaman)
    public function getPopularBooksByStock($limit = 4){
        $query = mysqli_query($this->conn, "
            SELECT buku.*, 
                   kategori.nama_kategori 
            FROM buku 
            LEFT JOIN kategori ON buku.kategori = kategori.id
            ORDER BY buku.stok DESC 
            LIMIT $limit
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
}
?>