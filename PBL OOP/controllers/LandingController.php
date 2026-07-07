<?php

require_once __DIR__ . "/../config/database.php";

/**
 * LandingController
 * Controller untuk halaman landing page publik.
 * Tidak memerlukan session/login.
 */
class LandingController extends Database {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->conn;
        if (!$this->db) {
            die(json_encode(['success' => false, 'message' => 'Koneksi database gagal']));
        }
    }

    // ======================================================
    // STATISTIK PERPUSTAKAAN (untuk section stats)
    // ======================================================
    public function getStats() {
        $stats = [];

        // Total buku
        $r = mysqli_query($this->db, "SELECT COUNT(*) as total FROM buku");
        $stats['total_buku'] = $r ? (int)mysqli_fetch_assoc($r)['total'] : 0;

        // Total kategori
        $r = mysqli_query($this->db, "SELECT COUNT(*) as total FROM kategori");
        $stats['total_kategori'] = $r ? (int)mysqli_fetch_assoc($r)['total'] : 0;

        // Total penulis unik
        $r = mysqli_query($this->db, "SELECT COUNT(DISTINCT penulis) as total FROM buku");
        $stats['total_penulis'] = $r ? (int)mysqli_fetch_assoc($r)['total'] : 0;

        // Total peminjaman (semua waktu)
        $r = mysqli_query($this->db, "SELECT COUNT(*) as total FROM peminjaman");
        $stats['total_peminjaman'] = $r ? (int)mysqli_fetch_assoc($r)['total'] : 0;

        return $stats;
    }

    // ======================================================
    // SEMUA BUKU + PAGINATION + FILTER + SORT
    // ======================================================
    public function getAllBooks($params = []) {
        $keyword  = isset($params['keyword'])  ? mysqli_real_escape_string($this->db, trim($params['keyword'])) : '';
        $kategori = isset($params['kategori']) ? mysqli_real_escape_string($this->db, $params['kategori']) : '';
        $penulis  = isset($params['penulis'])  ? mysqli_real_escape_string($this->db, trim($params['penulis'])) : '';
        $sort     = isset($params['sort'])     ? $params['sort'] : 'terbaru';
        $page     = isset($params['page'])     ? max(1, (int)$params['page']) : 1;
        $per_page = isset($params['per_page']) ? (int)$params['per_page'] : 12;

        $where = "WHERE 1=1";

        if (!empty($keyword)) {
            $where .= " AND (b.judul LIKE '%$keyword%' OR b.penulis LIKE '%$keyword%' OR b.penerbit LIKE '%$keyword%')";
        }
        if (!empty($kategori)) {
            $kat_escaped = mysqli_real_escape_string($this->db, $kategori);
            $where .= " AND k.nama_kategori = '$kat_escaped'";
        }
        if (!empty($penulis)) {
            $where .= " AND b.penulis LIKE '%$penulis%'";
        }

        $order = "b.id DESC";
        switch ($sort) {
            case 'az':      $order = "b.judul ASC";  break;
            case 'za':      $order = "b.judul DESC"; break;
            case 'populer': $order = "total_pinjam DESC, b.id DESC"; break;
            case 'terbaru': default: $order = "b.id DESC"; break;
        }

        // Count total untuk pagination
        $count_query = "SELECT COUNT(*) as total 
                        FROM buku b
                        LEFT JOIN kategori k ON b.kategori = k.id
                        $where";
        $count_result = mysqli_query($this->db, $count_query);
        $total_records = $count_result ? (int)mysqli_fetch_assoc($count_result)['total'] : 0;
        $total_pages   = $per_page > 0 ? (int)ceil($total_records / $per_page) : 1;
        $offset        = ($page - 1) * $per_page;

        // Query buku
        $query = "SELECT b.*, k.nama_kategori,
                         COUNT(p.id) as total_pinjam
                  FROM buku b
                  LEFT JOIN kategori k ON b.kategori = k.id
                  LEFT JOIN peminjaman p ON b.id = p.buku_id
                  $where
                  GROUP BY b.id
                  ORDER BY $order
                  LIMIT $per_page OFFSET $offset";

        $result = mysqli_query($this->db, $query);
        $books  = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['kategori_nama'] = $row['nama_kategori'] ?? 'Umum';
                $row['cover_bg']      = $this->getCoverBg($row['kategori_nama']);
                $row['cover_emoji']   = $this->getCoverEmoji($row['kategori_nama']);
                $books[] = $row;
            }
        }

        return [
            'books'         => $books,
            'total_records' => $total_records,
            'total_pages'   => $total_pages,
            'current_page'  => $page,
            'per_page'      => $per_page,
        ];
    }

    // ======================================================
    // BUKU TERBARU (untuk section featured)
    // ======================================================
    public function getLatestBooks($limit = 8) {
        $limit  = (int)$limit;
        $query  = "SELECT b.*, k.nama_kategori,
                          COUNT(p.id) as total_pinjam
                   FROM buku b
                   LEFT JOIN kategori k ON b.kategori = k.id
                   LEFT JOIN peminjaman p ON b.id = p.buku_id
                   GROUP BY b.id
                   ORDER BY b.id DESC
                   LIMIT $limit";
        $result = mysqli_query($this->db, $query);
        $books  = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['kategori_nama'] = $row['nama_kategori'] ?? 'Umum';
                $row['cover_bg']      = $this->getCoverBg($row['kategori_nama']);
                $row['cover_emoji']   = $this->getCoverEmoji($row['kategori_nama']);
                $books[] = $row;
            }
        }
        return $books;
    }

    // ======================================================
    // BUKU POPULER (berdasarkan jumlah peminjaman)
    // ======================================================
    public function getPopularBooks($limit = 8) {
        $limit  = (int)$limit;
        $query  = "SELECT b.*, k.nama_kategori,
                          COUNT(p.id) as total_pinjam
                   FROM buku b
                   LEFT JOIN kategori k ON b.kategori = k.id
                   LEFT JOIN peminjaman p ON b.id = p.buku_id
                   GROUP BY b.id
                   ORDER BY total_pinjam DESC, b.id DESC
                   LIMIT $limit";
        $result = mysqli_query($this->db, $query);
        $books  = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['kategori_nama'] = $row['nama_kategori'] ?? 'Umum';
                $row['cover_bg']      = $this->getCoverBg($row['kategori_nama']);
                $row['cover_emoji']   = $this->getCoverEmoji($row['kategori_nama']);
                $books[] = $row;
            }
        }
        return $books;
    }

    // ======================================================
    // SEMUA KATEGORI (beserta jumlah buku per kategori)
    // ======================================================
    public function getAllCategories() {
        $query  = "SELECT k.id, k.nama_kategori,
                          COUNT(b.id) as jumlah_buku
                   FROM kategori k
                   LEFT JOIN buku b ON k.id = b.kategori
                   GROUP BY k.id
                   ORDER BY jumlah_buku DESC, k.nama_kategori ASC";
        $result = mysqli_query($this->db, $query);
        $cats   = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['icon']  = $this->getCategoryIcon($row['nama_kategori']);
                $row['color'] = $this->getCategoryColor($row['nama_kategori']);
                $cats[] = $row;
            }
        }
        return $cats;
    }

    // ======================================================
    // DETAIL BUKU BY ID
    // ======================================================
    public function getBookById($id) {
        $id     = (int)$id;
        $query  = "SELECT b.*, k.nama_kategori,
                          COUNT(p.id) as total_pinjam
                   FROM buku b
                   LEFT JOIN kategori k ON b.kategori = k.id
                   LEFT JOIN peminjaman p ON b.id = p.buku_id
                   WHERE b.id = $id
                   GROUP BY b.id
                   LIMIT 1";
        $result = mysqli_query($this->db, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $row['kategori_nama'] = $row['nama_kategori'] ?? 'Umum';
            $row['cover_bg']      = $this->getCoverBg($row['kategori_nama']);
            $row['cover_emoji']   = $this->getCoverEmoji($row['kategori_nama']);
            return $row;
        }
        return null;
    }

    // ======================================================
    // AJAX: SEARCH REALTIME
    // ======================================================
    public function handleAjaxSearch() {
        header('Content-Type: application/json; charset=utf-8');
        $keyword  = isset($_GET['q']) ? mysqli_real_escape_string($this->db, trim($_GET['q'])) : '';
        $kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($this->db, $_GET['kategori']) : '';
        $sort     = isset($_GET['sort'])     ? $_GET['sort'] : 'terbaru';
        $page     = isset($_GET['page'])     ? max(1, (int)$_GET['page']) : 1;
        $per_page = 12;

        $result = $this->getAllBooks([
            'keyword'  => $keyword,
            'kategori' => $kategori,
            'sort'     => $sort,
            'page'     => $page,
            'per_page' => $per_page,
        ]);

        echo json_encode(['success' => true] + $result);
    }

    // ======================================================
    // HELPER: Cover Background per Kategori
    // ======================================================
    private function getCoverBg($kategori) {
        $map = [
            'Pemrograman'      => 'linear-gradient(135deg, #dbeafe, #bfdbfe)',
            'Teknologi'        => 'linear-gradient(135deg, #dbeafe, #bfdbfe)',
            'Informatika'      => 'linear-gradient(135deg, #dbeafe, #bfdbfe)',
            'Bisnis'           => 'linear-gradient(135deg, #fef3c7, #fde68a)',
            'Manajemen'        => 'linear-gradient(135deg, #fef3c7, #fde68a)',
            'Akuntansi'        => 'linear-gradient(135deg, #d1fae5, #a7f3d0)',
            'Sejarah'          => 'linear-gradient(135deg, #d1fae5, #a7f3d0)',
            'Pendidikan'       => 'linear-gradient(135deg, #e0e7ff, #c7d2fe)',
            'Psikologi'        => 'linear-gradient(135deg, #fce7f3, #fbcfe8)',
            'Sains'            => 'linear-gradient(135deg, #fef9c3, #fef08a)',
            'Hukum'            => 'linear-gradient(135deg, #fee2e2, #fecaca)',
            'Sistem Informasi' => 'linear-gradient(135deg, #dbeafe, #bfdbfe)',
            'Robotic'          => 'linear-gradient(135deg, #d1fae5, #a7f3d0)',
            'Umum'             => 'linear-gradient(135deg, #f3f4f6, #e5e7eb)',
        ];
        return $map[$kategori] ?? 'linear-gradient(135deg, #f3f4f6, #e5e7eb)';
    }

    // ======================================================
    // HELPER: Cover Emoji per Kategori
    // ======================================================
    private function getCoverEmoji($kategori) {
        $map = [
            'Pemrograman'      => '💻',
            'Teknologi'        => '📘',
            'Informatika'      => '🖥️',
            'Bisnis'           => '📊',
            'Manajemen'        => '📋',
            'Akuntansi'        => '🧾',
            'Sejarah'          => '📗',
            'Pendidikan'       => '🎓',
            'Psikologi'        => '🧠',
            'Sains'            => '🔬',
            'Hukum'            => '⚖️',
            'Sistem Informasi' => '🗃️',
            'Robotic'          => '🤖',
            'Umum'             => '📔',
        ];
        return $map[$kategori] ?? '📔';
    }

    // ======================================================
    // HELPER: Kategori Icon (Bootstrap Icons class)
    // ======================================================
    private function getCategoryIcon($kategori) {
        $map = [
            'Pemrograman'      => 'bi-code-slash',
            'Teknologi'        => 'bi-cpu',
            'Informatika'      => 'bi-pc-display',
            'Bisnis'           => 'bi-bar-chart-line',
            'Manajemen'        => 'bi-briefcase',
            'Akuntansi'        => 'bi-calculator',
            'Sejarah'          => 'bi-hourglass-split',
            'Pendidikan'       => 'bi-mortarboard',
            'Psikologi'        => 'bi-brain',
            'Sains'            => 'bi-eyedropper',
            'Hukum'            => 'bi-shield-check',
            'Sistem Informasi' => 'bi-diagram-3',
            'Robotic'          => 'bi-robot',
            'Umum'             => 'bi-book',
        ];
        return $map[$kategori] ?? 'bi-book';
    }

    // ======================================================
    // HELPER: Kategori Color (Tailwind classes)
    // ======================================================
    private function getCategoryColor($kategori) {
        $map = [
            'Pemrograman'      => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
            'Teknologi'        => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
            'Informatika'      => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
            'Bisnis'           => ['bg' => '#fef3c7', 'text' => '#b45309', 'border' => '#fde68a'],
            'Manajemen'        => ['bg' => '#fef3c7', 'text' => '#b45309', 'border' => '#fde68a'],
            'Akuntansi'        => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
            'Sejarah'          => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
            'Pendidikan'       => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'border' => '#c7d2fe'],
            'Psikologi'        => ['bg' => '#fce7f3', 'text' => '#9d174d', 'border' => '#fbcfe8'],
            'Sains'            => ['bg' => '#fef9c3', 'text' => '#854d0e', 'border' => '#fef08a'],
            'Hukum'            => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fecaca'],
            'Sistem Informasi' => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'border' => '#93c5fd'],
            'Robotic'          => ['bg' => '#d1fae5', 'text' => '#065f46', 'border' => '#a7f3d0'],
        ];
        return $map[$kategori] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'border' => '#e5e7eb'];
    }
}
