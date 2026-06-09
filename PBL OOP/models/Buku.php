<?php

require_once "../config/database.php";

class Buku extends Database {

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

    return mysqli_fetch_all(
        $query,
        MYSQLI_ASSOC
    );
}

    // =========================
    // TOTAL BUKU
    // =========================
    public function totalBuku(){

        $query = mysqli_query($this->conn,"
        SELECT * FROM buku
        ");

        return mysqli_num_rows($query);
    }

    // =========================
    // TOTAL TERSEDIA
    // =========================
    public function totalTersedia(){

        $query = mysqli_query($this->conn,"
        SELECT * FROM buku
        WHERE stok > 0
        ");

        return mysqli_num_rows($query);
    }

    // =========================
    // TOTAL HABIS
    // =========================
    public function totalHabis(){

        $query = mysqli_query($this->conn,"
        SELECT * FROM buku
        WHERE stok <= 0
        ");

        return mysqli_num_rows($query);
    }

    // =========================
    // TAMBAH BUKU
    // =========================
    public function tambahBuku($data){

    $judul = $data['judul'];
    $penulis = $data['penulis'];
    $penerbit = $data['penerbit'];
    $tahun = $data['tahun'];

    $kategori = $data['kategori'];

    $stok = $data['stok'];

    $status = ($stok > 0)
    ? 'tersedia'
    : 'habis';

    mysqli_query($this->conn, "

    INSERT INTO buku
    (
        judul,
        penulis,
        penerbit,
        tahun,
        kategori,
        stok,
        status
    )

    VALUES
    (
        '$judul',
        '$penulis',
        '$penerbit',
        '$tahun',
        '$kategori',
        '$stok',
        '$status'
    )

    ");
}
    // =========================
    // GET BY ID
    // =========================
    public function getById($id){

        $query = mysqli_query($this->conn, "

        SELECT *
        FROM buku
        WHERE id='$id'

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

        $status = ($stok > 0)
        ? 'tersedia'
        : 'habis';

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
    // HAPUS
    // =========================
    public function hapusBuku($id){

        mysqli_query($this->conn, "

        DELETE FROM buku
        WHERE id='$id'

        ");
    }

    // =========================
    // BUKU TERBARU
    // =========================
    public function latestBook(){

        $query = mysqli_query($this->conn, "

        SELECT *
        FROM buku
        ORDER BY id DESC
        LIMIT 5

        ");

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }
}