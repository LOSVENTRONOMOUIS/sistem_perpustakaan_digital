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

        $user = $this->user->login($email);

        if($user){

            if(password_verify($password,$user['password'])){

                $_SESSION['id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // ADMIN
                if($user['role'] == 'admin'){

                    header("Location: dashboard.php");
                    exit;

                }

                // ANGGOTA
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

        header('Location: login.php');
        exit;

    }

}