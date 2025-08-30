<?php
// templates/bootstrap.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId   = $_SESSION['user']['id']   ?? null;
$role     = $_SESSION['user']['role'] ?? null;
$name     = $_SESSION['user']['name'] ?? null;
$lastname = $_SESSION['user']['lastname'] ?? null;
