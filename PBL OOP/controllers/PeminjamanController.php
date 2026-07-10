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

        // Enrich each row with its latest denda data
        foreach($data as &$row) {
            $row['denda'] = $this->pinjam->getDendaByPeminjamanId($row['id']);
        }
        unset($row);

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
        $denda = $this->pinjam->getDendaByPeminjamanId($_GET['id']);
        
        $is_late = false;
        if($pinjam['status'] == 'dipinjam' && strtotime($pinjam['tanggal_kembali']) < strtotime(date('Y-m-d'))) {
            $is_late = true;
        }

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

    // ==========================
    // UPDATE DENDA STATUS (AJAX)
    // ==========================
    public function updateDendaStatus()
    {
        header('Content-Type: application/json');

        try {
            $denda_id = $_POST['denda_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if(!$denda_id || !$status) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Data tidak lengkap'
                ]);
                exit;
            }

            // Validate status value
            $allowed = ['pending', 'lunas', 'unpaid'];
            if(!in_array($status, $allowed)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Status tidak valid'
                ]);
                exit;
            }

            $this->pinjam->updateDendaStatus($denda_id, $status);

            echo json_encode([
                'status' => 'success',
                'message' => 'Status denda berhasil diperbarui'
            ]);

        } catch(Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }
}
