<?php
// models/PeminjamanUser.php
// Model untuk mengelola data peminjaman (untuk user dan admin)

require_once "../config/database.php";

class PeminjamanUser extends Database {
    
    public function __construct() {
    parent::__construct();
}

    // ==================== METHOD DASAR (CORE METHODS) ====================
    
    /**
     * Ambil peminjaman by user_id (untuk user)
     */
    public function getByUserId($user_id){
        $stmt = $this->conn->prepare("
            SELECT peminjaman.*,
                   buku.judul,
                   buku.penulis
            FROM peminjaman
            JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.user_id = ?
            ORDER BY peminjaman.id DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Ambil peminjaman aktif by user_id (masih dipinjam)
     */
    public function getActiveByUserId($user_id){
        $stmt = $this->conn->prepare("
            SELECT peminjaman.*,
                   buku.judul,
                   buku.penulis
            FROM peminjaman
            JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.user_id = ? 
            AND peminjaman.status = 'dipinjam'
            ORDER BY peminjaman.tanggal_pinjam DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Ambil riwayat peminjaman by user_id (sudah dikembalikan/dibatalkan)
     */
    public function getHistoryByUserId($user_id){
        $stmt = $this->conn->prepare("
            SELECT peminjaman.*,
                   buku.judul,
                   buku.penulis
            FROM peminjaman
            JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.user_id = ? 
            AND (peminjaman.status = 'dikembalikan' OR peminjaman.status = 'dibatalkan')
            ORDER BY peminjaman.id DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Ambil peminjaman by id (tanpa join)
     */
    public function getById($id){
        $stmt = $this->conn->prepare("
            SELECT * FROM peminjaman WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Ambil detail peminjaman lengkap (dengan data user dan buku)
     */
    public function getDetailById($id){
        $stmt = $this->conn->prepare("
            SELECT peminjaman.*,
                   users.nama,
                   users.email,
                   buku.judul,
                   buku.penulis
            FROM peminjaman
            JOIN users ON peminjaman.user_id = users.id
            JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ==================== CRUD METHODS ====================
    
    /**
     * CREATE - Menambah peminjaman baru
     */
    public function create($data){
        $user_id = $data['user_id'];
        $buku_id = $data['buku_id'];
        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];
        $status = $data['status'];

        $stmt = $this->conn->prepare("
            INSERT INTO peminjaman
            (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iisss", $user_id, $buku_id, $tanggal_pinjam, $tanggal_kembali, $status);
        
        if($stmt->execute()){
            return $this->conn->insert_id;
        }
        return false;
    }

    /**
     * CREATE (alias) - tambah peminjaman baru
     */
    public function tambah($data){
        return $this->create($data);
    }

    /**
     * UPDATE - Mengupdate data peminjaman
     */
    public function update($data){
        $stmt = $this->conn->prepare("
            UPDATE peminjaman SET
            user_id = ?,
            buku_id = ?,
            tanggal_pinjam = ?,
            tanggal_kembali = ?,
            status = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            "iisssi",
            $data['user_id'],
            $data['buku_id'],
            $data['tanggal_pinjam'],
            $data['tanggal_kembali'],
            $data['status'],
            $data['id']
        );
        return $stmt->execute();
    }

    /**
     * UPDATE STATUS - Mengupdate status peminjaman menjadi dikembalikan
     */
    public function updateStatusToReturned($id, $tanggal_pengembalian = null, $denda = 0){
        if (!$tanggal_pengembalian) {
            $tanggal_pengembalian = date('Y-m-d');
        }
        
        $stmt = $this->conn->prepare("
            UPDATE peminjaman SET 
            status = 'dikembalikan',
            tanggal_pengembalian = ?,
            denda = ?
            WHERE id = ?
        ");
        $stmt->bind_param("sii", $tanggal_pengembalian, $denda, $id);
        return $stmt->execute();
    }

    /**
     * UPDATE STATUS (alias) - proses pengembalian buku dengan denda
     */
    public function kembalikan($id, $tanggal_pengembalian = null, $denda = 0){
        return $this->updateStatusToReturned($id, $tanggal_pengembalian, $denda);
    }

    /**
     * UPDATE STATUS - Mengupdate status peminjaman menjadi dibatalkan
     */
    public function updateStatusToCancelled($id){
        $stmt = $this->conn->prepare("
            UPDATE peminjaman SET 
            status = 'dibatalkan'
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * UPDATE STATUS (alias) - proses pembatalan peminjaman
     */
    public function batalkan($id){
        return $this->updateStatusToCancelled($id);
    }

    /**
     * DELETE (SOFT DELETE) - Menghapus peminjaman (soft delete dengan mengubah status)
     */
    public function softDelete($id){
        $stmt = $this->conn->prepare("
            UPDATE peminjaman SET 
            status = 'dihapus'
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * DELETE (HARD DELETE) - Menghapus permanen peminjaman dari database
     */
    public function hardDelete($id){
        $stmt = $this->conn->prepare("
            DELETE FROM peminjaman WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * DELETE (alias) - hapus peminjaman
     */
    public function hapus($id){
        return $this->hardDelete($id);
    }

    // ==================== VALIDATION METHODS ====================

    /**
     * Cek apakah user sudah meminjam buku tertentu dan masih dipinjam
     */
    public function cekPeminjamanAktif($user_id, $buku_id){
        $stmt = $this->conn->prepare("
            SELECT * FROM peminjaman 
            WHERE user_id = ? 
            AND buku_id = ? 
            AND status = 'dipinjam'
        ");
        $stmt->bind_param("ii", $user_id, $buku_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Ambil data peminjaman aktif untuk buku tertentu
     */
    public function getPeminjamanAktif($user_id, $buku_id){
        $stmt = $this->conn->prepare("
            SELECT * FROM peminjaman 
            WHERE user_id = ? 
            AND buku_id = ? 
            AND status = 'dipinjam'
            LIMIT 1
        ");
        $stmt->bind_param("ii", $user_id, $buku_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Total peminjaman aktif untuk seorang user
     */
    public function totalPinjamUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total FROM peminjaman 
            WHERE user_id = ? 
            AND status = 'dipinjam'
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    /**
     * Cek batas peminjaman (maksimal 3 buku)
     */
    public function cekBatasPeminjaman($user_id, $batas = 3){
        $totalDipinjam = $this->totalPinjamUser($user_id);
        return $totalDipinjam >= $batas;
    }

    /**
     * Cek apakah user memiliki buku yang terlambat
     * Menghitung dari tanggal pinjam + 14 hari (masa peminjaman)
     */
    public function cekUserTerlambat($user_id){
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM peminjaman 
            WHERE user_id = ? 
            AND status = 'dipinjam' 
            AND DATE_ADD(tanggal_pinjam, INTERVAL 14 DAY) < CURDATE()
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ($result['total'] ?? 0) > 0;
    }

    /**
     * Hitung denda untuk satu peminjaman (jika telat kembali)
     */
    public function hitungDenda($id, $denda_per_hari = 2000){
        $peminjaman = $this->getById($id);
        
        if (!$peminjaman || $peminjaman['status'] != 'dipinjam') {
            return 0;
        }
        
        $batas_kembali = date('Y-m-d', strtotime($peminjaman['tanggal_pinjam'] . ' +14 days'));
        $tanggal_sekarang = date('Y-m-d');
        
        if ($tanggal_sekarang <= $batas_kembali) {
            return 0;
        }
        
        $selisih_hari = (strtotime($tanggal_sekarang) - strtotime($batas_kembali)) / (60 * 60 * 24);
        return ceil($selisih_hari) * $denda_per_hari;
    }

    /**
     * Hitung total denda untuk semua peminjaman aktif user
     */
    public function hitungTotalDendaUser($user_id, $denda_per_hari = 2000){
        $activeLoans = $this->getActiveByUserId($user_id);
        $totalDenda = 0;
        
        foreach ($activeLoans as $loan) {
            $batas_kembali = date('Y-m-d', strtotime($loan['tanggal_pinjam'] . ' +14 days'));
            $tanggal_sekarang = date('Y-m-d');
            
            if ($tanggal_sekarang > $batas_kembali) {
                $selisih_hari = (strtotime($tanggal_sekarang) - strtotime($batas_kembali)) / (60 * 60 * 24);
                $totalDenda += ceil($selisih_hari) * $denda_per_hari;
            }
        }
        
        return $totalDenda;
    }

    // ==================== METHOD UNTUK DASHBOARD USER ====================

    /**
     * Hitung jumlah buku yang terlambat per user
     */
    public function countLateBooksByUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM peminjaman 
            WHERE user_id = ? 
            AND status = 'dipinjam' 
            AND DATE_ADD(tanggal_pinjam, INTERVAL 14 DAY) < CURDATE()
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    /**
     * Hitung total hari keterlambatan per user
     */
    public function totalLateDaysByUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT SUM(GREATEST(0, DATEDIFF(CURDATE(), DATE_ADD(tanggal_pinjam, INTERVAL 14 DAY)))) as total_days
            FROM peminjaman 
            WHERE user_id = ? 
            AND status = 'dipinjam' 
            AND DATE_ADD(tanggal_pinjam, INTERVAL 14 DAY) < CURDATE()
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return max(0, (int)($result['total_days'] ?? 0));
    }

    /**
     * Hitung total denda per user (untuk dashboard)
     */
    public function totalFineByUser($user_id, $fine_per_day = 2000){
        $totalLateDays = $this->totalLateDaysByUser($user_id);
        return $totalLateDays * $fine_per_day;
    }

    /**
     * Ambil semua buku yang terlambat detailnya
     */
    public function getLateBooksDetailByUser($user_id, $fine_per_day = 2000){
        $stmt = $this->conn->prepare("
            SELECT 
                peminjaman.id,
                peminjaman.buku_id,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali,
                buku.judul,
                buku.penulis,
                DATE_ADD(peminjaman.tanggal_pinjam, INTERVAL 14 DAY) as batas_kembali,
                GREATEST(0, DATEDIFF(CURDATE(), DATE_ADD(peminjaman.tanggal_pinjam, INTERVAL 14 DAY))) as late_days
            FROM peminjaman
            JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.user_id = ? 
            AND peminjaman.status = 'dipinjam' 
            AND DATE_ADD(peminjaman.tanggal_pinjam, INTERVAL 14 DAY) < CURDATE()
            ORDER BY peminjaman.tanggal_kembali ASC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $books = [];
        while($row = $result->fetch_assoc()) {
            $row['late_days'] = max(0, (int)$row['late_days']);
            $row['fine_amount'] = $row['late_days'] * $fine_per_day;
            $books[] = $row;
        }
        
        return $books;
    }

    /**
     * Ambil peminjaman aktif yang terlambat (untuk warning banner)
     */
    public function getActiveBorrowedByUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT peminjaman.*,
                   buku.judul,
                   buku.penulis,
                   buku.cover,
                   CASE 
                       WHEN DATE_ADD(peminjaman.tanggal_pinjam, INTERVAL 14 DAY) < CURDATE() THEN 'terlambat'
                       ELSE 'normal'
                   END as status_pinjam
            FROM peminjaman
            JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.user_id = ? 
            AND peminjaman.status = 'dipinjam'
            ORDER BY peminjaman.tanggal_kembali ASC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ==================== METHOD UNTUK ADMIN ====================
    
    /**
     * Semua data peminjaman (join dengan users dan buku) untuk admin
     */
    public function getAll(){
        $query = mysqli_query($this->conn,"
            SELECT peminjaman.*,
                   users.nama,
                   users.nim,
                   buku.judul
            FROM peminjaman
            JOIN users ON peminjaman.user_id = users.id
            JOIN buku ON peminjaman.buku_id = buku.id
            ORDER BY peminjaman.id DESC
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * Total semua peminjaman
     */
    public function totalPinjam(){
        $query = mysqli_query($this->conn, "SELECT * FROM peminjaman");
        return mysqli_num_rows($query);
    }

    /**
     * Total yang masih dipinjam
     */
    public function totalDipinjam(){
        $query = mysqli_query($this->conn,"
            SELECT * FROM peminjaman WHERE status='dipinjam'
        ");
        return mysqli_num_rows($query);
    }

    /**
     * Total yang sudah dikembalikan
     */
    public function totalKembali(){
        $query = mysqli_query($this->conn,"
            SELECT * FROM peminjaman WHERE status='dikembalikan'
        ");
        return mysqli_num_rows($query);
    }

    /**
     * Total yang dibatalkan
     */
    public function totalDibatalkan(){
        $query = mysqli_query($this->conn,"
            SELECT * FROM peminjaman WHERE status='dibatalkan'
        ");
        return mysqli_num_rows($query);
    }

    /**
     * Aktivitas terbaru (5 data terakhir) untuk admin dashboard
     */
    public function aktivitas(){
        $query = mysqli_query($this->conn,"
            SELECT peminjaman.*,
                   users.nama,
                   buku.judul
            FROM peminjaman
            JOIN users ON peminjaman.user_id = users.id
            JOIN buku ON peminjaman.buku_id = buku.id
            ORDER BY peminjaman.id DESC
            LIMIT 5
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ==================== METHOD TAMBAHAN ====================
    
    /**
     * Hitung total peminjaman per user (untuk user dashboard)
     */
    public function totalPeminjamanByUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total FROM peminjaman WHERE user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    /**
     * Hitung total peminjaman yang sudah selesai (dikembalikan) per user
     */
    public function totalCompletedByUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total FROM peminjaman 
            WHERE user_id = ? AND status = 'dikembalikan'
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    /**
     * Hitung total peminjaman yang dibatalkan per user
     */
    public function totalCancelledByUser($user_id){
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total FROM peminjaman 
            WHERE user_id = ? AND status = 'dibatalkan'
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }
}
?>