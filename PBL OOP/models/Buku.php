<?php

require_once __DIR__ . "/../config/database.php";

class Buku extends Database {

    // =========================
    // AMBIL SEMUA BUKU
    // =========================
    public function getAll(){
        return $this->getAllBooks();
    }

    // AMBIL SEMUA BUKU
    // =========================
    public function getAllBooks(){
        $sql = "
            SELECT buku.*, kategori.nama_kategori
            FROM buku
            LEFT JOIN kategori ON buku.kategori = kategori.id
            ORDER BY buku.id DESC
        ";

        $query = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // =========================
    // TOTAL BUKU
    // =========================
    public function totalBuku(){
        $query = mysqli_query($this->conn, "SELECT * FROM buku");
        return mysqli_num_rows($query);
    }

    // =========================
    // TOTAL BUKU TERSEDIA
    // =========================
    public function totalTersedia(){
        $query = mysqli_query($this->conn, "SELECT * FROM buku WHERE stok > 0");
        return mysqli_num_rows($query);
    }

    // =========================
    // TOTAL BUKU HABIS
    // =========================
    public function totalHabis(){
        $query = mysqli_query($this->conn, "SELECT * FROM buku WHERE stok <= 0");
        return mysqli_num_rows($query);
    }

    // =========================
    // TAMBAH BUKU
    // =========================
    public function tambahBuku($data, $cover = null){

        $judul = mysqli_real_escape_string($this->conn, $data['judul']);
        $penulis = mysqli_real_escape_string($this->conn, $data['penulis']);
        $penerbit = mysqli_real_escape_string($this->conn, $data['penerbit']);
        $tahun = $data['tahun'];
        $stok = (int)$data['stok'];

        $kategori = !empty($data['kategori'])
            ? (int)$data['kategori']
            : "NULL";

        $coverValue = !empty($cover)
            ? "'$cover'"
            : "NULL";

        $status = ($stok > 0) ? "tersedia" : "habis";

        $sql = "
            INSERT INTO buku
            (
                judul,
                penulis,
                penerbit,
                tahun,
                stok,
                cover,
                kategori,
                status
            )
            VALUES
            (
                '$judul',
                '$penulis',
                '$penerbit',
                '$tahun',
                '$stok',
                $coverValue,
                $kategori,
                '$status'
            )
        ";

        return mysqli_query($this->conn, $sql);
    }

    // =========================
    // GET BUKU BERDASARKAN ID
    // =========================
    public function getById($id){

        $id = (int)$id;

        $sql = "
            SELECT buku.*, kategori.nama_kategori
            FROM buku
            LEFT JOIN kategori ON buku.kategori = kategori.id
            WHERE buku.id = '$id'
        ";

        $query = mysqli_query($this->conn, $sql);

        return mysqli_fetch_assoc($query);
    }

    // =========================
    // UPDATE BUKU
    // =========================
    public function updateBuku($data, $cover = null){

        $id = (int)$data['id'];

        $judul = mysqli_real_escape_string($this->conn, $data['judul']);
        $penulis = mysqli_real_escape_string($this->conn, $data['penulis']);
        $penerbit = mysqli_real_escape_string($this->conn, $data['penerbit']);
        $tahun = $data['tahun'];
        $stok = (int)$data['stok'];

        $kategori = !empty($data['kategori'])
            ? (int)$data['kategori']
            : "NULL";

        $status = ($stok > 0) ? "tersedia" : "habis";

        $sql = "
            UPDATE buku SET
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun = '$tahun',
                kategori = $kategori,
                stok = '$stok',
                status = '$status'
        ";

        if(!empty($cover)){
            $sql .= ", cover = '$cover'";
        }

        $sql .= " WHERE id = '$id'";

        return mysqli_query($this->conn, $sql);
    }

    // =========================
    // HAPUS BUKU
    // =========================
    public function hapusBuku($id){

        $id = (int)$id;

        return mysqli_query(
            $this->conn,
            "DELETE FROM buku WHERE id = '$id'"
        );
    }

    // =========================
    // BUKU TERBARU
    // =========================
    public function latestBook(){

        $sql = "
            SELECT buku.*, kategori.nama_kategori
            FROM buku
            LEFT JOIN kategori ON buku.kategori = kategori.id
            ORDER BY buku.id DESC
            LIMIT 5
        ";

        $query = mysqli_query($this->conn, $sql);

        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // =========================
    // CARI BUKU
    // =========================
    public function cariBuku($keyword){

        $keyword = mysqli_real_escape_string($this->conn, $keyword);

        $sql = "
            SELECT buku.*, kategori.nama_kategori
            FROM buku
            LEFT JOIN kategori ON buku.kategori = kategori.id
            WHERE
                buku.judul LIKE '%$keyword%'
                OR buku.penulis LIKE '%$keyword%'
                OR buku.penerbit LIKE '%$keyword%'
            ORDER BY buku.id DESC
        ";

        $query = mysqli_query($this->conn, $sql);

        return mysqli_fetch_all($query, MYSQLI_ASSOC);
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