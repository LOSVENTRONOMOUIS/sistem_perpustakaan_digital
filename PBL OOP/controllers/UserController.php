<?php

require_once "../models/User.php";

class UserController {

    private $user;

    public function __construct(){

        $this->user = new User();
    }

    // halaman anggota
    public function index(){

        $users = $this->user->getAllUsers();

        $totalAnggota = $this->user->countAnggota();

        require "../views/anggota/index.php";
    }

    // tambah
    public function store(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->user->tambahUser($_POST);

            header("Location: buku.php");
            exit;
        }
    }

    // edit
    public function update(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $this->user->updateUser($_POST);

            header("Location: anggota.php");
            exit;
        }
    }

    // hapus
    public function destroy(){

        $id = $_GET['id'];

        $this->user->hapusUser($id);

        header("Location: anggota.php");
        exit;
    }
}