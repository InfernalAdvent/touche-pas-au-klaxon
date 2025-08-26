<?php
namespace App\Controllers;

class BaseController
{
     protected function checkLoggedIn()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /touche-pas-au-klaxon/public/login');
            exit;
        }
    }
    protected function checkAdmin()
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /touche-pas-au-klaxon/public/dashboard');
            exit;
        }
    }
}
