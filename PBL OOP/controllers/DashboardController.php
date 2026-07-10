<?php

require_once "../models/Buku.php";
require_once "../models/User.php";
require_once "../models/Peminjaman.php";
require_once "../models/Kategori.php";

class DashboardController {

    private $buku;
    private $user;
    private $peminjaman;
    private $kategori;

    public function __construct(){

        $this->buku = new Buku();
        $this->user = new User();
        $this->peminjaman = new Peminjaman();
        $this->kategori = new Kategori();

    }

    public function index(){

        $data = [

            'totalBuku' => $this->buku->totalBuku(),
            'totalAnggota' => $this->user->countAnggota(),
            'totalPeminjaman' => $this->peminjaman->totalPinjam(),
            'totalKategori' => $this->kategori->countKategori(),
            'totalPendapatanDenda' => $this->peminjaman->totalPendapatanDenda(),
            'statusDenda' => $this->peminjaman->statusDenda(),
            'chartDenda' => $this->peminjaman->pendapatanDendaHarian(),
            'aktivitas' => $this->peminjaman->aktivitas(),
            'buku' => $this->buku->latestBook()

        ];

        extract($data);

        require "../views/dashboard/index.php";
    }
}