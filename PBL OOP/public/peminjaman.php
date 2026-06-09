<?php

require_once "../controllers/PeminjamanController.php";

// Pindahkan logika routing ke sini
$controller = new PeminjamanController();
$action = $_GET['action'] ?? 'index';

if(method_exists($controller, $action)){
    $controller->$action();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Action tidak ditemukan'
    ]);
}