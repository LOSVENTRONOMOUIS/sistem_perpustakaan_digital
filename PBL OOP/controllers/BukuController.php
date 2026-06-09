<?php

require_once "../models/Buku.php";
require_once "../models/Kategori.php";

class BukuController {

    private $buku;
    private $kategori;

    public function __construct(){

        $this->buku = new Buku();
        $this->kategori = new Kategori();
    }

    // =========================
    // HALAMAN BUKU
    // =========================
    public function index(){

        $books = $this->buku->getAllBooks();

        $totalBuku = $this->buku->totalBuku();

        $totalTersedia = $this->buku->totalTersedia();

        $totalHabis = $this->buku->totalHabis();

        require "../views/buku/index.php";
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create(){

        $kategori = $this->kategori->getAllKategori();

        require "../views/buku/tambah.php";
    }

    // =========================
    // SIMPAN
    // =========================
    public function store(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->buku->tambahBuku($_POST);

            header("Location: buku.php");
            exit;
        }
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(){

        $id = $_GET['id'];

        $book = $this->buku->getById($id);

        $kategori = $this->kategori->getAllKategori();

        require "../views/buku/edit_buku.php";
    }

    // =========================
    // UPDATE
    // =========================
    public function update(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->buku->updateBuku($_POST);

            header("Location: buku.php");
            exit;
        }
    }

    // =========================
    // HAPUS
    // =========================
    public function destroy(){

        $id = $_GET['id'];

        $this->buku->hapusBuku($id);

        header("Location: buku.php");
        exit;
    }
}