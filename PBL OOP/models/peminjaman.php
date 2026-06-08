<?php

require_once "../config/database.php";

class Peminjaman extends Database {

    // semua data
    public function getAll(){

        $query = mysqli_query($this->conn,"
        SELECT peminjaman.*,
               users.nama,
               buku.judul
        FROM peminjaman
        JOIN users ON peminjaman.user_id = users.id
        JOIN buku ON peminjaman.buku_id = buku.id
        ORDER BY peminjaman.id DESC
        ");

        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    // total pinjam
    public function totalPinjam(){

        $query = mysqli_query($this->conn,"
        SELECT * FROM peminjaman
        ");

        return mysqli_num_rows($query);
    }

    // dipinjam
    public function totalDipinjam(){

        $query = mysqli_query($this->conn,"
        SELECT * FROM peminjaman
        WHERE status='dipinjam'
        ");

        return mysqli_num_rows($query);
    }

    // dikembalikan
    public function totalKembali(){

        $query = mysqli_query($this->conn,"
        SELECT * FROM peminjaman
        WHERE status='dikembalikan'
        ");

        return mysqli_num_rows($query);
    }

    // tambah
    public function tambah($data){

        $user_id = $data['user_id'];
        $buku_id = $data['buku_id'];
        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];
        $status = $data['status'];

        mysqli_query($this->conn,"
        INSERT INTO peminjaman
        (user_id,buku_id,tanggal_pinjam,tanggal_kembali,status)

        VALUES
        ('$user_id','$buku_id','$tanggal_pinjam',
        '$tanggal_kembali','$status')
        ");
    }

    // ambil by id
    public function getById($id){

        $query = mysqli_query($this->conn,"
        SELECT * FROM peminjaman
        WHERE id='$id'
        ");

        return mysqli_fetch_assoc($query);
    }

    // update
    public function update($data){

        $id = $data['id'];

        mysqli_query($this->conn,"
        UPDATE peminjaman SET

        user_id='".$data['user_id']."',
        buku_id='".$data['buku_id']."',
        tanggal_pinjam='".$data['tanggal_pinjam']."',
        tanggal_kembali='".$data['tanggal_kembali']."',
        status='".$data['status']."'

        WHERE id='$id'
        ");
    }

    // hapus
    public function hapus($id){

        mysqli_query($this->conn,"
        DELETE FROM peminjaman
        WHERE id='$id'
        ");
    }

    // =========================
    // AKTIVITAS TERBARU
    // =========================
    public function aktivitas(){

        $query = mysqli_query($this->conn,"
        SELECT peminjaman.*,
               users.nama,
               buku.judul

        FROM peminjaman

        JOIN users
        ON peminjaman.user_id = users.id

        JOIN buku
        ON peminjaman.buku_id = buku.id

        ORDER BY peminjaman.id DESC

        LIMIT 5
        ");

        return mysqli_fetch_all(
            $query,
            MYSQLI_ASSOC
        );
    }
}