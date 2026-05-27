<?php

require_once "../config/database.php";

class Dashboard extends Database {

    // total buku
    public function totalBuku(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM buku"
        );

        return mysqli_num_rows($query);
    }

    // total anggota
    public function totalAnggota(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM anggota"
        );

        return mysqli_num_rows($query);
    }

    // total peminjaman
    public function totalPeminjaman(){

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM peminjaman"
        );

        return mysqli_num_rows($query);
    }
}