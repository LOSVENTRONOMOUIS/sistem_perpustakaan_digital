<?php
// controllers/PeminjamanController.php
require_once "../models/userpeminjaman.php";
require_once "../models/Buku.php";

class PeminjamanController {

    private $pinjam;
    private $buku;

    public function __construct(){
        $this->pinjam = new PeminjamanUser();
        $this->buku = new Buku();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ================ METHOD UNTUK MENGAMBIL DATA PEMINJAMAN ================
    public function getPeminjamanByUser($user_id){
        $allPeminjaman = $this->pinjam->getByUserId($user_id);
        $result = [];
        
        foreach($allPeminjaman as $p){
            // PERBAIKAN: Gunakan status dari database untuk batal/kembali
            if($p['status'] == 'batal' || $p['status'] == 'dibatalkan') {
                $status = 'batal';
            } elseif($p['status'] == 'kembali' || $p['status'] == 'dikembalikan') {
                $status = 'kembali';
            } elseif($p['status'] == 'dihapus') {
                $status = 'dihapus';
            } else {
                $status = $this->hitungStatus($p['tanggal_kembali'], $p['status']);
            }
            
            $result[] = [
                'id' => $p['id'],
                'judul' => $p['judul'],
                'nama' => $_SESSION['nama'] ?? 'User',
                'email' => $_SESSION['email'] ?? '-',
                'tglPinjam' => $this->formatDate($p['tanggal_pinjam']),
                'tglKembali' => $this->formatDate($p['tanggal_kembali']),
                'status' => $status,
                'denda' => $p['denda'] ?? 0
            ];
        }
        
        return $result;
    }
    
    // Method untuk mendapatkan detail peminjaman (non-AJAX)
    public function getDetailPeminjamanById($id){
        return $this->pinjam->getDetailById($id);
    }
    
    // Helper: hitung status peminjaman
    private function hitungStatus($tanggal_kembali, $status){
        // PERBAIKAN: Cek status dari database terlebih dahulu
        if($status == 'dikembalikan' || $status == 'kembali'){
            return 'kembali';
        }
        
        if($status == 'dibatalkan' || $status == 'batal'){
            return 'batal';
        }
        
        if($status == 'dihapus'){
            return 'dihapus';
        }
        
        $today = new DateTime();
        $kembali = new DateTime($tanggal_kembali);
        
        if($today > $kembali){
            return 'terlambat';
        }
        
        return 'dipinjam';
    }
    
    // Helper: format tanggal ke format Indonesia
    private function formatDate($date){
        if(!$date || $date == '0000-00-00') return '-';
        
        $timestamp = strtotime($date);
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        $hari = date('d', $timestamp);
        $bulanIndex = (int)date('m', $timestamp) - 1;
        $tahun = date('Y', $timestamp);
        
        return $hari . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
    }
    
    // Helper format tanggal untuk output
    private function formatTanggal($date){
        return $this->formatDate($date);
    }
    
    // Helper hitung status peminjaman (alias)
    private function hitungStatusPeminjaman($tanggal_kembali, $status){
        return $this->hitungStatus($tanggal_kembali, $status);
    }

    // ==================== CRUD METHODS ====================
    
    /**
     * CREATE - Method untuk menambah peminjaman baru
     * @param int $user_id ID user yang meminjam
     * @param int $buku_id ID buku yang dipinjam
     * @return array ['success' => bool, 'message' => string, 'id' => int]
     */
    public function createPeminjaman($user_id, $buku_id){
        $buku = $this->buku->getById($buku_id);

        if(!$buku){
            return [
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ];
        }

        if($buku['stok'] <= 0){
            return [
                'success' => false,
                'message' => 'Stok buku habis'
            ];
        }
        
        // Cek apakah user memiliki buku yang terlambat
        $cekTerlambat = $this->pinjam->cekUserTerlambat($user_id);
        if ($cekTerlambat) {
            return [
                'success' => false,
                'message' => 'Anda memiliki buku yang terlambat dikembalikan. Silakan kembalikan terlebih dahulu.'
            ];
        }
        
        // Cek apakah user sedang meminjam buku yang sama
        if ($this->pinjam->cekPeminjamanAktif($user_id, $buku_id)) {
            $existing = $this->pinjam->getPeminjamanAktif($user_id, $buku_id);
            $tanggalPinjam = $this->formatTanggal($existing['tanggal_pinjam']);
            return [
                'success' => false,
                'message' => "Anda sedang meminjam buku ini (sejak $tanggalPinjam). Silakan kembalikan terlebih dahulu."
            ];
        }
        
        // Cek batas maksimal peminjaman (3 buku)
        if ($this->pinjam->cekBatasPeminjaman($user_id, 3)) {
            return [
                'success' => false,
                'message' => 'Batas peminjaman maksimal 3 buku'
            ];
        }

        $tanggal_pinjam = date('Y-m-d');
        $tanggal_kembali = date('Y-m-d', strtotime('+14 days'));

        $data = [
            'user_id' => $user_id,
            'buku_id' => $buku_id,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
            'status' => 'dipinjam'
        ];

        $id = $this->pinjam->tambah($data);
        
        if($id){
            $this->buku->kurangiStok($buku_id, 1);
            return [
                'success' => true,
                'message' => 'Peminjaman berhasil',
                'id' => $id
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal menambahkan peminjaman'
        ];
    }

    /**
     * UPDATE - Method untuk mengupdate status peminjaman (mengembalikan buku)
     * @param int $id ID peminjaman
     * @return array ['success' => bool, 'message' => string, 'denda' => int]
     */
    public function updatePeminjamanToReturned($id){
        $peminjaman = $this->pinjam->getById($id);

        if(!$peminjaman){
            return [
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ];
        }
        
        if($peminjaman['user_id'] != $_SESSION['user_id']){
            return [
                'success' => false,
                'message' => 'Anda tidak memiliki akses'
            ];
        }
        
        if($peminjaman['status'] != 'dipinjam'){
            return [
                'success' => false,
                'message' => 'Buku sudah dikembalikan/dibatalkan'
            ];
        }
        
        // Hitung denda jika terlambat
        $denda = 0;
        $tanggal_kembali_seharusnya = $peminjaman['tanggal_kembali'];
        $tanggal_kembali_aktual = date('Y-m-d');
        
        if ($tanggal_kembali_aktual > $tanggal_kembali_seharusnya) {
            $selisih_hari = (strtotime($tanggal_kembali_aktual) - strtotime($tanggal_kembali_seharusnya)) / (60 * 60 * 24);
            $denda = $selisih_hari * 2000; // Denda Rp 2000 per hari
        }

        // Menggunakan method kembalikan yang sudah ada di model
        $result = $this->pinjam->kembalikan($id, $tanggal_kembali_aktual, $denda);
        
        if($result){
            $this->buku->tambahStok($peminjaman['buku_id'], 1);
            
            $message = 'Buku berhasil dikembalikan';
            if ($denda > 0) {
                $message .= '. Denda yang harus dibayar: Rp ' . number_format($denda, 0, ',', '.');
            }
            
            return [
                'success' => true,
                'message' => $message,
                'denda' => $denda
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal mengembalikan buku'
        ];
    }

    /**
     * UPDATE - Method untuk mengupdate status peminjaman menjadi dibatalkan
     * @param int $id ID peminjaman
     * @return array ['success' => bool, 'message' => string]
     */
    public function updatePeminjamanToCancelled($id){
        $peminjaman = $this->pinjam->getById($id);

        if(!$peminjaman){
            return [
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ];
        }
        
        if($peminjaman['user_id'] != $_SESSION['user_id']){
            return [
                'success' => false,
                'message' => 'Anda tidak memiliki akses'
            ];
        }
        
        // Hanya status 'dipinjam' yang bisa dibatalkan
        if($peminjaman['status'] != 'dipinjam'){
            return [
                'success' => false,
                'message' => 'Peminjaman dengan status "' . $peminjaman['status'] . '" tidak dapat dibatalkan'
            ];
        }

        // Menggunakan method batalkan yang sudah ada di model
        $result = $this->pinjam->batalkan($id);
        
        if($result){
            $this->buku->tambahStok($peminjaman['buku_id'], 1);
            return [
                'success' => true,
                'message' => 'Peminjaman berhasil dibatalkan'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal membatalkan peminjaman'
        ];
    }

    /**
     * DELETE - Method untuk menghapus peminjaman (menggunakan method hapus yang sudah ada)
     * @param int $id ID peminjaman
     * @return array ['success' => bool, 'message' => string]
     */
    public function deletePeminjaman($id){
        $peminjaman = $this->pinjam->getById($id);

        if(!$peminjaman){
            return [
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ];
        }
        
        if($peminjaman['user_id'] != $_SESSION['user_id']){
            return [
                'success' => false,
                'message' => 'Anda tidak memiliki akses'
            ];
        }
        
        // Hanya status 'dipinjam' yang bisa dihapus
        if($peminjaman['status'] != 'dipinjam'){
            return [
                'success' => false,
                'message' => 'Peminjaman dengan status "' . $peminjaman['status'] . '" tidak dapat dihapus'
            ];
        }

        // Menggunakan method hapus yang sudah ada di model
        $result = $this->pinjam->hapus($id);
        
        if($result){
            $this->buku->tambahStok($peminjaman['buku_id'], 1);
            return [
                'success' => true,
                'message' => 'Peminjaman berhasil dihapus'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Gagal menghapus peminjaman'
        ];
    }

    // ==================== PROSES PEMINJAMAN VIA AJAX ====================
    
    public function prosesPinjam(){
        $buku_id = $_POST['buku_id'] ?? null;
        $user_id = $_POST['user_id'] ?? ($_SESSION['user_id'] ?? 0);
        $nama = $_POST['nama'] ?? ($_SESSION['nama'] ?? 'User');
        
        if (!$buku_id) {
            echo json_encode(['success' => false, 'message' => 'Data buku tidak lengkap']);
            exit;
        }
        
        // Cek apakah user memiliki buku yang terlambat
        $cekTerlambat = $this->pinjam->cekUserTerlambat($user_id);
        if ($cekTerlambat) {
            echo json_encode([
                'success' => false, 
                'message' => 'Anda memiliki buku yang terlambat dikembalikan. Silakan kembalikan terlebih dahulu.'
            ]);
            exit;
        }
        
        $buku = $this->buku->getById($buku_id);
        if (!$buku) {
            echo json_encode(['success' => false, 'message' => 'Buku tidak ditemukan']);
            exit;
        }
        
        if ($buku['stok'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'Stok buku habis']);
            exit;
        }
        
        // Cek apakah user sedang meminjam buku yang sama
        if ($this->pinjam->cekPeminjamanAktif($user_id, $buku_id)) {
            $existing = $this->pinjam->getPeminjamanAktif($user_id, $buku_id);
            $tanggalPinjam = $this->formatTanggal($existing['tanggal_pinjam']);
            echo json_encode([
                'success' => false, 
                'message' => "Anda sedang meminjam buku ini (sejak $tanggalPinjam). Silakan kembalikan terlebih dahulu."
            ]);
            exit;
        }
        
        // Cek batas maksimal peminjaman (3 buku)
        if ($this->pinjam->cekBatasPeminjaman($user_id, 3)) {
            echo json_encode(['success' => false, 'message' => 'Batas peminjaman maksimal 3 buku']);
            exit;
        }
        
        // CREATE - Tambah peminjaman baru
        $tanggal_pinjam = date('Y-m-d');
        $tanggal_kembali = date('Y-m-d', strtotime('+14 days'));
        
        // Kurangi stok
        $this->buku->kurangiStok($buku_id, 1);
        
        $data = [
            'user_id' => $user_id,
            'buku_id' => $buku_id,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
            'status' => 'dipinjam'
        ];
        
        $peminjaman_id = $this->pinjam->tambah($data);
        
        echo json_encode([
            'success' => true,
            'message' => 'Peminjaman berhasil',
            'data' => [
                'peminjaman_id' => $peminjaman_id,
                'buku' => $buku,
                'user_nama' => $nama,
                'tanggal_pinjam' => $this->formatTanggal($tanggal_pinjam),
                'tanggal_kembali' => $this->formatTanggal($tanggal_kembali)
            ]
        ]);
        exit;
    }
    
    // ==================== PROSES UPDATE STATUS VIA AJAX ====================
    
    public function prosesUpdateToReturned(){
        $id = $_POST['id'] ?? null;
        
        if ($id) {
            $result = $this->updatePeminjamanToReturned($id);
            echo json_encode($result);
            exit;
        }
        
        echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
        exit;
    }
    
    public function prosesUpdateToCancelled(){
        $id = $_POST['id'] ?? null;
        
        if ($id) {
            $result = $this->updatePeminjamanToCancelled($id);
            echo json_encode($result);
            exit;
        }
        
        echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
        exit;
    }
    
    // ==================== PROSES DELETE VIA AJAX ====================
    
    public function prosesDeletePeminjaman(){
        $id = $_POST['id'] ?? null;
        
        if ($id) {
            $result = $this->deletePeminjaman($id);
            echo json_encode($result);
            exit;
        }
        
        echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
        exit;
    }
    
    // ==================== GET DETAIL PEMINJAMAN VIA AJAX ====================
    
    public function getDetailPeminjaman(){
        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
            exit;
        }
        
        $detail = $this->pinjam->getDetailById($id);
        
        if(!$detail || $detail['user_id'] != $_SESSION['user_id']){
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses']);
            exit;
        }
        
        $status = $this->hitungStatusPeminjaman($detail['tanggal_kembali'], $detail['status']);
        
        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $detail['id'],
                'judul' => $detail['judul'],
                'nama' => $detail['nama'],
                'email' => $detail['email'] ?? '-',
                'tanggal_pinjam' => $this->formatTanggal($detail['tanggal_pinjam']),
                'tanggal_kembali' => $this->formatTanggal($detail['tanggal_kembali']),
                'status' => $status,
                'denda' => $detail['denda'] ?? 0,
                'tanggal_pengembalian' => $detail['tanggal_pengembalian'] ?? null
            ]
        ]);
        exit;
    }
    
    // ==================== HANDLE ALL AJAX REQUESTS ====================
    
    public function handleAjaxRequest(){
        // Bersihkan output buffer agar JSON bersih
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        
        $action = $_POST['action'] ?? '';
        
        switch($action) {
            case 'get_detail':
                $this->getDetailPeminjaman();
                break;
            case 'kembalikan':
                $this->prosesUpdateToReturned();
                break;
            case 'batalkan':
                $this->prosesUpdateToCancelled();
                break;
            case 'hapus':
                $this->prosesDeletePeminjaman();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal: ' . $action]);
                exit;
        }
    }
    
    // ==================== METHOD TAMBAHAN UNTUK MODEL ====================
    
    /**
     * Method untuk mendapatkan semua peminjaman (untuk admin)
     */
    public function getAllPeminjaman(){
        return $this->pinjam->getAll();
    }
    
    /**
     * Method untuk mendapatkan peminjaman berdasarkan ID (tanpa cek user)
     */
    public function getPeminjamanById($id){
        return $this->pinjam->getById($id);
    }
}