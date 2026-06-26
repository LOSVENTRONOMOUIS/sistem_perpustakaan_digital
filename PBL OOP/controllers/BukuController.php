<?php

require_once __DIR__ . "/../models/Buku.php";
require_once __DIR__ . "/../models/Kategori.php";

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
    // SIMPAN (Dengan Upload Gambar)
    // =========================
    public function store(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $namaCover = NULL; // Default null jika tidak ada gambar

            // Cek apakah ada file cover yang diupload tanpa error
            if(isset($_FILES['cover']) && $_FILES['cover']['error'] === 0){
                $tmpFile = $_FILES['cover']['tmp_name'];
                $namaAsli = $_FILES['cover']['name'];
                
                // Bikin nama file unik pakai time() biar gak saling timpa
                $namaCover = time() . '_' . str_replace(' ', '_', $namaAsli);
                
                // Set folder tujuan untuk nyimpan gambar fisik
                $folderTujuan = "../assets/images/covers/";
                
                // Kalau foldernya belum ada, PHP bakal otomatis bikinin
                if (!is_dir($folderTujuan)) {
                    mkdir($folderTujuan, 0777, true);
                }

                $pathTujuan = $folderTujuan . $namaCover;

                // Pindahkan file dari memori sementara ke folder assets
                move_uploaded_file($tmpFile, $pathTujuan);
            }

            // Kirim data form ($_POST) dan nama file cover ke Model
            $this->buku->tambahBuku($_POST, $namaCover);

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
    // UPDATE (Dengan Upload Gambar)
    // =========================
    public function update(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $namaCover = ""; // Biarkan string kosong jika tidak mau update gambar

            // Cek jika saat diedit, admin juga masukin gambar baru
            if(isset($_FILES['cover']) && $_FILES['cover']['error'] === 0){
                $tmpFile = $_FILES['cover']['tmp_name'];
                $namaAsli = $_FILES['cover']['name'];
                
                $namaCover = time() . '_' . str_replace(' ', '_', $namaAsli);
                $folderTujuan = "../assets/images/covers/";
                
                if (!is_dir($folderTujuan)) {
                    mkdir($folderTujuan, 0777, true);
                }

                $pathTujuan = $folderTujuan . $namaCover;
                move_uploaded_file($tmpFile, $pathTujuan);
            }

            // Kirim ke Model (Model sudah diatur: jika $namaCover kosong, gambar lama tidak dihapus)
            $this->buku->updateBuku($_POST, $namaCover);

            header("Location: buku.php");
            exit;
        }
    }

    // =========================
    // HAPUS
    // =========================
    public function destroy(){
        $id = $_GET['id'];
        
        // (Opsional) Kalau mau gambar ikut kehapus dari folder saat data dihapus, logikanya ditaruh di Model.
        $this->buku->hapusBuku($id);

        header("Location: buku.php");
        exit;
    }
}