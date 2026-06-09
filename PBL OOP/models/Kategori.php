<?php

require_once "../config/database.php";

class Kategori extends Database {

    // =========================
    // AMBIL SEMUA
    // =========================
    public function getAllKategori(){

        $query = mysqli_query($this->conn, "

        SELECT *
        FROM kategori

        ORDER BY id DESC

        ");

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }

    // =========================
    // TOTAL KATEGORI
    // =========================
    public function countKategori(){

        $query = mysqli_query($this->conn, "

        SELECT * FROM kategori

        ");

        return mysqli_num_rows($query);
    }

    // =========================
    // TAMBAH
    // =========================
    public function tambahKategori($data){

        $nama_kategori = $data['nama_kategori'];

        mysqli_query($this->conn, "

        INSERT INTO kategori
        (nama_kategori)

        VALUES
        ('$nama_kategori')

        ");
    }

    // =========================
    // UPDATE
    // =========================
    public function updateKategori($data){

        $id = $data['id'];

        $nama_kategori = $data['nama_kategori'];

        mysqli_query($this->conn, "

        UPDATE kategori SET

        nama_kategori='$nama_kategori'

        WHERE id='$id'

        ");
    }

    // =========================
    // HAPUS
    // =========================
    public function hapusKategori($id){

        mysqli_query($this->conn, "

        DELETE FROM kategori
        WHERE id='$id'

        ");
    }
}