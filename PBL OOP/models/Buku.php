<?php

require_once "../config/database.php";

class Buku extends Database {

    // ambil semua buku
    public function getAllBooks(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM buku ORDER BY id DESC"
        );

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }

    // total buku
    public function totalBuku(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM buku"
        );

        return mysqli_num_rows($query);
    }

    // total tersedia
    public function totalTersedia(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM buku WHERE stok > 0"
        );

        return mysqli_num_rows($query);
    }

    // total habis
    public function totalHabis(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM buku WHERE stok <= 0"
        );

        return mysqli_num_rows($query);
    }

    // tambah buku
    public function tambahBuku($data){

    $judul     = htmlspecialchars($data['judul']);
    $penulis   = htmlspecialchars($data['penulis']);
    $penerbit  = htmlspecialchars($data['penerbit']);
    $tahun     = htmlspecialchars($data['tahun']);
    $kategori  = htmlspecialchars($data['kategori']);
    $stok      = htmlspecialchars($data['stok']);
    $status    = htmlspecialchars($data['status']);

    mysqli_query(
        $this->conn,
        "INSERT INTO buku
        (judul, penulis, penerbit, tahun, kategori, stok, status)

        VALUES

        ('$judul','$penulis','$penerbit',
        '$tahun','$kategori','$stok','$status')"
    );
}
    // ambil berdasarkan id
    public function getById($id){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM buku
             WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    // update buku
    public function updateBuku($data){

        $id     = $data['id'];
        $judul  = htmlspecialchars($data['judul']);
        $stok   = htmlspecialchars($data['stok']);

        mysqli_query(
            $this->conn,
            "UPDATE buku
             SET judul='$judul',
                 stok='$stok'
             WHERE id='$id'"
        );
    }

    // hapus buku
    public function hapusBuku($id){

        mysqli_query(
            $this->conn,
            "DELETE FROM buku
             WHERE id='$id'"
        );
    }

    // buku terbaru
    public function latestBook(){

        $query = mysqli_query($this->conn,"
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