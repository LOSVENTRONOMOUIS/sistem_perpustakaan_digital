<?php

require_once "../models/Buku.php";
require_once "../models/Peminjaman.php";

class UserDashController {

    private $buku;
    private $peminjaman;

    public function __construct(){

        $this->buku = new Buku();
        $this->peminjaman = new Peminjaman();

    }

    public function index(){

        // Total buku
        $totalBuku = $this->buku->totalBuku();

        // Semua buku untuk katalog dashboard
        $semuaBuku = $this->buku->getAllBooks();

        // Riwayat pinjam user yang login
        $riwayatPinjam = $this->peminjaman->getByUser(
            $_SESSION['id']
        );

        require "../views/user/index.php";
    }
}