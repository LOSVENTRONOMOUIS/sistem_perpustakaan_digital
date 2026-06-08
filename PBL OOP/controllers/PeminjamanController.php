<?php

require_once "../models/Peminjaman.php";

class PeminjamanController {

    private $pinjam;

    public function __construct(){

        $this->pinjam = new Peminjaman();
    }

    // halaman utama
    public function index(){

        $data = $this->pinjam->getAll();

        $totalPinjam = $this->pinjam->totalPinjam();

        $totalDipinjam = $this->pinjam->totalDipinjam();

        $totalKembali = $this->pinjam->totalKembali();

        require "../views/peminjaman/index.php";
    }

    // halaman tambah
    public function create(){

        require "../views/peminjaman/tambah.php";
    }

    // simpan
    public function store(){

        $this->pinjam->tambah($_POST);

        header("Location: /peminjaman.php");
    }

    // edit
    public function edit(){

        $pinjam = $this->pinjam->getById($_GET['id']);

        require "../views/peminjaman/edit.php";
    }

    // update
    public function update(){

        $this->pinjam->update($_POST);

        header("Location: peminjaman.php");
    }

    // hapus
    public function destroy(){

        $this->pinjam->hapus($_GET['id']);

        header("Location: peminjaman.php");
    }
}