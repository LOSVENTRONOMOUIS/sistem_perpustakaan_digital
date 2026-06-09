<?php

require_once "../models/Peminjaman.php";

class UserPeminjamanController {

    private $peminjaman;

    public function __construct()
    {
        $this->peminjaman = new Peminjaman();
    }

    public function index()
    {
        $idAnggota = $_SESSION['id'];

        $dataPeminjaman = $this->peminjaman->getByUser($idAnggota);

        require "../views/user/peminjaman.php";
    }
}