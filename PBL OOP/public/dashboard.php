<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    header("Location: dashboard_anggota.php");
    exit;
}

require_once "../controllers/DashboardController.php";

$dashboard = new DashboardController();

$dashboard->index();