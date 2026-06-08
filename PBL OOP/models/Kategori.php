<?php

require_once "../config/database.php";

class Kategori extends Database {

    // semua kategori
    public function getAllKategori(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM kategori
             ORDER BY id DESC"
        );

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }

    // total kategori
    public function countKategori(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM kategori"
        );

        return mysqli_num_rows($query);
    }

    // tambah kategori
    public function tambahKategori($data){

        $nama = htmlspecialchars(
            $data['nama_kategori']
        );

        mysqli_query(
            $this->conn,
            "INSERT INTO kategori(nama_kategori)
             VALUES('$nama')"
        );
    }

    // detail kategori
    public function getById($id){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM kategori
             WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    // update kategori
    public function updateKategori($data){

        $id = $data['id'];

        $nama = htmlspecialchars(
            $data['nama_kategori']
        );

        mysqli_query(
            $this->conn,
            "UPDATE kategori SET
             nama_kategori='$nama'
             WHERE id='$id'"
        );
    }

    // hapus kategori
    public function hapusKategori($id){

        mysqli_query(
            $this->conn,
            "DELETE FROM kategori
             WHERE id='$id'"
        );
    }
}