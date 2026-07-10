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
    // TOTAL PENDAPATAN DENDA
    // ======================
    public function totalPendapatanDenda(){

        $query = mysqli_query($this->conn, "
            SELECT SUM(jumlah_denda) as total FROM denda WHERE status = 'lunas'
        ");
        $result = mysqli_fetch_assoc($query);
        return $result['total'] ? $result['total'] : 0;
    }


    // ======================
    // PENDAPATAN DENDA HARIAN
    // ======================
    public function pendapatanDendaHarian(){
        $query = mysqli_query($this->conn, "
            SELECT DATE(tanggal_bayar) as tanggal, SUM(jumlah_denda) as total 
            FROM denda 
            WHERE status = 'lunas' AND tanggal_bayar IS NOT NULL
            GROUP BY DATE(tanggal_bayar)
            ORDER BY DATE(tanggal_bayar) ASC
            LIMIT 7
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ======================
    // STATUS DENDA (UNTUK CHART BULAT)
    // ======================
    public function statusDenda(){
        $query = mysqli_query($this->conn, "
            SELECT status, SUM(jumlah_denda) as total 
            FROM denda 
            GROUP BY status
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
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

    $tanggal_pinjam  = $data['tanggal_pinjam'];
    $tanggal_kembali = $data['tanggal_kembali'];
    $status          = $data['status'];
    $kondisi_buku    = $data['kondisi_buku'] ?? 'baik';

    mysqli_query($this->conn,"
        UPDATE peminjaman SET
            tanggal_pinjam='$tanggal_pinjam',
            tanggal_kembali='$tanggal_kembali',
            status='$status',
            kondisi_buku='$kondisi_buku'
        WHERE id='$id'
    ");

    // Only process after the book has been returned
    if($status == 'dikembalikan'){

        $q = mysqli_query($this->conn,"
            SELECT p.*, b.harga
            FROM peminjaman p
            JOIN buku b ON b.id = p.buku_id
            WHERE p.id='$id'
        ");

        $pinjam = mysqli_fetch_assoc($q);

        $cek = mysqli_query($this->conn,"
            SELECT id
            FROM denda
            WHERE peminjaman_id='$id'
            LIMIT 1
        ");

        // Book is damaged
        if($kondisi_buku == 'rusak'){

            if(mysqli_num_rows($cek) == 0){

                mysqli_query($this->conn,"
                    INSERT INTO denda
                    (
                        peminjaman_id,
                        user_id,
                        jumlah_denda,
                        status,
                        kode_konfirmasi
                    )
                    VALUES
                    (
                        '$id',
                        '{$pinjam['user_id']}',
                        '{$pinjam['harga']}',
                        'unpaid',
                        '$kode'
                    )
                ");

            }

        }
        // Book is in good condition
        else{

            mysqli_query($this->conn,"
                DELETE FROM denda
                WHERE peminjaman_id='$id'
                AND status <> 'lunas'
            ");

        }

    }

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

    // ======================
    // GET DENDA BY PEMINJAMAN ID (single latest)
    // ======================
    public function getDendaByPeminjamanId($peminjaman_id){
        $peminjaman_id = mysqli_real_escape_string($this->conn, $peminjaman_id);
        $query = mysqli_query($this->conn, "
            SELECT * FROM denda
            WHERE peminjaman_id = '$peminjaman_id'
            ORDER BY id DESC
            LIMIT 1
        ");
        return mysqli_fetch_assoc($query);
    }

    // ======================
    // GET ALL DENDA BY PEMINJAMAN ID
    // ======================
    public function getAllDendaByPeminjamanId($peminjaman_id){
        $peminjaman_id = mysqli_real_escape_string($this->conn, $peminjaman_id);
        $query = mysqli_query($this->conn, "
            SELECT * FROM denda
            WHERE peminjaman_id = '$peminjaman_id'
            ORDER BY id DESC
        ");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // ======================
    // UPDATE DENDA STATUS
    // ======================
    public function updateDendaStatus($denda_id, $status){
        $denda_id = mysqli_real_escape_string($this->conn, $denda_id);
        $status = mysqli_real_escape_string($this->conn, $status);

        // If status is lunas, set tanggal_bayar to now
        if($status == 'lunas'){
            mysqli_query($this->conn, "
                UPDATE denda SET
                status = '$status',
                tanggal_bayar = NOW()
                WHERE id = '$denda_id'
            ");
        } else {
            mysqli_query($this->conn, "
                UPDATE denda SET
                status = '$status',
                tanggal_bayar = NULL
                WHERE id = '$denda_id'
            ");
        }
    }
}