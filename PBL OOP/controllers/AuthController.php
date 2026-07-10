<?php

require_once "../models/User.php";

class AuthController {

    private $user;

    public function __construct(){

        $this->user = new User();

    }

    public function login(){

        session_start();

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Simpan buku_id dari POST jika ada (dikirim dari form login landing page)
        $buku_id_post = isset($_POST['buku_id']) ? (int)$_POST['buku_id'] : 0;

        $user = $this->user->login($email);

        if($user){

            if(password_verify($password,$user['password'])){

                $_SESSION['id'] = $user['id'];
                $_SESSION['user_id'] = $user['id']; // <-- DITAMBAHKAN AGAR CONTROLLER ANGGOTA BISA BACA
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // CEK REDIRECT KONTEKS BUKU (dari landing page)
                // Prioritas: POST buku_id > SESSION redirect_after_login
                if ($buku_id_post > 0 && $user['role'] === 'anggota') {
                    // Redirect ke katalog dengan buku yang dipilih
                    header("Location: katalog.php?buku_id=" . $buku_id_post);
                    exit;
                }

                if (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login']) && $user['role'] === 'anggota') {
                    $redirect = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    header("Location: " . $redirect);
                    exit;
                }

                // ADMIN
                if($user['role'] == 'admin'){

                    header("Location: dashboard.php");
                    exit;

                }

                // ANGGOTA (default redirect)
                if($user['role'] == 'anggota'){

                    header("Location: dashboard_anggota.php");
                    exit;

                }

            }

        }

        echo "
        <script>
            alert('Email atau Password Salah');
            window.location='login.php';
        </script>
        ";

    }

    public function logout(){

        session_start();
        session_destroy();

        header('Location: index.php');
        exit;

    }

}