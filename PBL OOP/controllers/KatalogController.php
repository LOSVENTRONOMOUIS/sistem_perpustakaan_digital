<?php

require_once "../models/Buku.php";
require_once "../models/User.php"; // Tambahkan pemanggilan model User

class KatalogController {

    public function index()
    {
        // Catatan: Pastikan session_start() sudah dipanggil, 
        // entah itu di file router utama atau di baris ini jika belum ada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Inisiasi Model
        $bukuModel = new Buku();
        $userModel = new User();

        // 2. Ambil semua data Buku
        $bukuList = $bukuModel->getAllBooks();

        // 3. Ambil data User yang sedang login
        // Sesuaikan 'id' dengan nama key session yang kamu buat saat proses Login
        $currentUser = null;
        if (isset($_SESSION['id'])) { 
            $currentUser = $userModel->getById($_SESSION['id']);
        }

        // 4. Load View
        // Variabel $bukuList dan $currentUser sekarang siap digunakan di dalam index.php
        require_once "../views/katalog/index.php";
    }
}