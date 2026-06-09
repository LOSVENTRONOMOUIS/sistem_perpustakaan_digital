<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['role'] != 'anggota'){
    header("Location: dashboard_anggota.php");
    exit;
}

require_once "../controllers/UserDashController.php";

$dashboard = new UserDashController();
$dashboard->index();