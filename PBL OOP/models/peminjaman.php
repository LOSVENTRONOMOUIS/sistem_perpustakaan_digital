<?php

require_once "../config/database.php";

class Peminjaman extends Database {

    public function __construct(){
        parent::__construct();
    }

    // ======================
    // AMBIL SEMUA DATA
    // ======================
    public function getAll(){

        $query = mysqli_query($this->conn, "
            SELECT 
                peminjaman.*, 
                users.nama, 
                users.email, 
                buku.judul, 
                buku.penulis,
                -- Deteksi apakah telat (1 = Telat, 0 = Aman)
                (CASE WHEN peminjaman.status = 'dipinjam' AND peminjaman.tanggal_kembali < CURDATE() THEN 1 ELSE 0 END) as is_late

            FROM peminjaman
            LEFT JOIN users ON peminjaman.user_id = users.id
            LEFT JOIN buku ON peminjaman.buku_id = buku.id

            -- Urutkan yang telat (1) di paling atas, baru setelahnya diurutkan dari ID terbaru
            ORDER BY is_late DESC, peminjaman.id DESC
        ");

        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ======================
    // TOTAL SEMUA
    // ======================
    public function totalPinjam(){

        $query = mysqli_query($this->conn, "
            SELECT * FROM peminjaman
        ");

        return mysqli_num_rows($query);
    }

    // ======================
    // TOTAL DIPINJAM
    // ======================
    public function totalDipinjam(){

        $query = mysqli_query($this->conn, "
            SELECT * FROM peminjaman
            WHERE status='dipinjam'
        ");

        return mysqli_num_rows($query);
    }

    // ======================
    // TOTAL KEMBALI
    // ======================
    public function totalKembali(){

        $query = mysqli_query($this->conn, "
            SELECT * FROM peminjaman
            WHERE status='dikembalikan'
        ");

        return mysqli_num_rows($query);
    }

    // ======================
    // TAMBAH PEMINJAMAN
    // ======================
    public function tambah($data){

        $user_id = $data['user_id'];
        $buku_id = $data['buku_id'];

        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];

        $status = $data['status'];
        $kondisi_buku = 'baik';

        mysqli_query($this->conn, "

            INSERT INTO peminjaman
            (
                user_id,
                buku_id,
                tanggal_pinjam,
                tanggal_kembali,
                status,
                kondisi_buku
            )

            VALUES
            (
                '$user_id',
                '$buku_id',
                '$tanggal_pinjam',
                '$tanggal_kembali',
                '$status',
                '$kondisi_buku'
            )

        ");

        // kurangi stok buku
        mysqli_query($this->conn, "
            UPDATE buku
            SET stok = stok - 1
            WHERE id='$buku_id'
        ");
    }

    // ======================
    // GET BY ID
    // ======================
    public function getById($id){
        $query = mysqli_query($this->conn, "
            SELECT 
                peminjaman.*, 
                users.nama, 
                buku.judul
            FROM peminjaman
            LEFT JOIN users ON peminjaman.user_id = users.id
            LEFT JOIN buku ON peminjaman.buku_id = buku.id
            WHERE peminjaman.id='$id'
        ");

        return mysqli_fetch_assoc($query);
    }

    // ======================
    // UPDATE
    // ======================
    public function update($data){

        $id = $data['id'];

        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];

        $status = $data['status'];
        $kondisi_buku = $data['kondisi_buku'] ?? 'baik';

        mysqli_query($this->conn, "

            UPDATE peminjaman SET

            tanggal_pinjam='$tanggal_pinjam',
            tanggal_kembali='$tanggal_kembali',
            status='$status',
            kondisi_buku='$kondisi_buku'

            WHERE id='$id'

        ");
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id){

        mysqli_query($this->conn, "

            DELETE FROM peminjaman
            WHERE id='$id'

        ");
    }
public function aktivitas(){

    $query = mysqli_query($this->conn, "

        SELECT
            peminjaman.*,
            users.nama,
            buku.judul

        FROM peminjaman

        LEFT JOIN users
        ON peminjaman.user_id = users.id

        LEFT JOIN buku
        ON peminjaman.buku_id = buku.id

        ORDER BY peminjaman.id DESC

        LIMIT 10

    ");

    return mysqli_fetch_all(
        $query,
        MYSQLI_ASSOC
    );
}
    // ======================
    // DATA USER TERTENTU
    // ======================
    public function getByUser($user_id){

        $query = mysqli_query($this->conn, "

            SELECT
                peminjaman.*,
                buku.judul,
                buku.penulis

            FROM peminjaman

            LEFT JOIN buku
            ON peminjaman.buku_id = buku.id

            WHERE peminjaman.user_id='$user_id'

            ORDER BY peminjaman.id DESC

        ");

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }
}