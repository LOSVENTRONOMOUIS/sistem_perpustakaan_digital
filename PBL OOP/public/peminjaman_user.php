<?php

session_start();

require_once "../controllers/UserPeminjamanController.php";

$controller = new UserPeminjamanController();
$controller->index();