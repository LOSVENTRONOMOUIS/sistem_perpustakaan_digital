<?php

require_once "../models/Buku.php";

class BukuController {

    private $buku;

    public function __construct(){

        $this->buku = new Buku();
    }

    // ======================
    // HALAMAN BUKU
    // ======================
    public function index(){

        $books = $this->buku->getAllBooks();

        $totalBuku = $this->buku->totalBuku();

        $totalTersedia = $this->buku->totalTersedia();

        $totalHabis = $this->buku->totalHabis();

        require "../views/buku/index.php";
    }

    // ======================
    // HALAMAN TAMBAH
    // ======================
    public function create(){

        require "../views/buku/tambah.php";
    }

    // ======================
    // SIMPAN BUKU
    // ======================
    public function store(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->buku->tambahBuku($_POST);

            header("Location: /pbl2/public/buku.php");
            exit;
        }
    }

    // ======================
    // HALAMAN EDIT
    // ======================
    public function edit(){

        $id = $_GET['id'];

        $book = $this->buku->getById($id);

        require "../views/buku/edit_buku.php";
    }

    // ======================
    // UPDATE BUKU
    // ======================
    public function update(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->buku->updateBuku($_POST);

            header("Location: /pbl2/public/buku.php");
            exit;
        }
    }

    // ======================
    // HAPUS BUKU
    // ======================
    public function destroy(){

        if(isset($_GET['id'])){

            $id = $_GET['id'];

            $this->buku->hapusBuku($id);

            header("Location: /pbl2/public/buku.php");
            exit;
        }
    }
}