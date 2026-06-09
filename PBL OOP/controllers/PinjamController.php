<?php

require_once "../models/Pinjam.php";

class PinjamController
{
    private $pinjam;

    public function __construct()
    {
        $this->pinjam = new Pinjam();
    }

    public function index()
    {
        session_start();

        if (!isset($_SESSION['id']))
        {
            header("Location: login.php");
            exit;
        }

        $user_id = $_SESSION['id'];

        $data = $this->pinjam->getByUser($user_id);

        $totalPinjam   = $this->pinjam->countByUser($user_id);
        $totalDipinjam = $this->pinjam->countDipinjamByUser($user_id);
        $totalKembali  = $this->pinjam->countKembaliByUser($user_id);

        require "../views/pinjam/index.php";
    }
}