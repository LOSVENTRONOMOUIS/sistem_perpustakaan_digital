<?php

require_once "../models/Kategori.php";

class KategoriController {

    private $kategori;

    public function __construct(){

        $this->kategori = new Kategori();
    }

    // halaman kategori
    public function index(){

        $kategori = $this->kategori->getAllKategori();

        $totalKategori = $this->kategori->countKategori();

        require "../views/kategori/index.php";
    }

    // tambah
    public function store(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->kategori->tambahKategori($_POST);

            header("Location: kategori.php");
            exit;
        }
    }

    // update
    public function update(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->kategori->updateKategori($_POST);

            header("Location: kategori.php");
            exit;
        }
    }

    // hapus
    public function destroy(){

        $id = $_GET['id'];

        $this->kategori->hapusKategori($id);

        header("Location: kategori.php");
        exit;
    }
}