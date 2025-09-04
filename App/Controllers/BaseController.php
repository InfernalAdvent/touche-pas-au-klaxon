<?php
namespace App\Controllers;

/**
 * Controller gérant le login et le role des utilisateurs
 * 
 * @package App\Controllers
 */
class BaseController
{     
     /**
      * Permet de vérifier que l'utilisateur s'est connecté
      *
      * @return void
      */
     protected function checkLoggedIn()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /touche-pas-au-klaxon/public/login');
            exit;
        }
    }    
    /**
     * Permet de vérifier si l'utilisateur est admin
     *
     * @return void
     */
    protected function checkAdmin()
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /touche-pas-au-klaxon/public');
            exit;
        }
    }
}
