<?php

require_once "../models/Peminjaman.php";

class PeminjamanController {

    private $pinjam;

    public function __construct()
    {
        $this->pinjam = new Peminjaman();
    }

    // ==========================
    // INDEX
    // ==========================
    public function index()
    {
        $data = $this->pinjam->getAll();

        $totalPinjam = $this->pinjam->totalPinjam();
        $totalDipinjam = $this->pinjam->totalDipinjam();
        $totalKembali = $this->pinjam->totalKembali();

        require "../views/peminjaman/index.php";
    }

    // ==========================
    // CREATE
    // ==========================
    public function create()
    {
        require "../views/peminjaman/tambah.php";
    }

    // ==========================
    // STORE AJAX
    // ==========================
    public function store()
    {
        header('Content-Type: application/json');

        try {

            if(empty($_POST)){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Data kosong'
                ]);
                exit;
            }

            $this->pinjam->tambah($_POST);

            echo json_encode([
                'status' => 'success',
                'message' => 'Peminjaman berhasil'
            ]);

        } catch(Exception $e){

            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }

    // ==========================
    // EDIT
    // ==========================
    public function edit()
    {
        $pinjam = $this->pinjam->getById($_GET['id']);

        // Ganti baris 78 menjadi ini:
        require "../views/peminjaman/edit.php"; 
    }

    // ==========================
    // UPDATE
    // ==========================
    public function update()
    {
        $this->pinjam->update($_POST);

        // Ganti header() dengan script JS ini
        echo "<script>window.location.href = 'peminjaman.php';</script>";
        exit;
    }

    // ==========================
    // DELETE
    // ==========================
    public function destroy()
    {
        $this->pinjam->hapus($_GET['id']);

        // Ganti header() dengan script JS ini
        echo "<script>window.location.href = 'peminjaman.php';</script>";
        exit;
    }
}
