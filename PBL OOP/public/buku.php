<?php

require_once "../controllers/BukuController.php";

$buku = new BukuController();

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'create':
        $buku->create();
        break;

    case 'store':
        $buku->store();
        break;

    case 'edit':
        $buku->edit();
        break;

    case 'update':
        $buku->update();
        break;

    case 'delete':
        $buku->destroy();
        break;

    default:
        $buku->index();
        break;
}