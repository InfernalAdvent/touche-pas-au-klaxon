<?php
namespace App\Controllers;

use App\Models\TrajetModel;

class DashboardController extends BaseController
{
    
    public function index()
    {
        $this->checkLoggedIn();
        $userId = $_SESSION['user']['id'];
        $role = $_SESSION['user']['role'];

        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAvailable();


        require __DIR__ . '/../../templates/dashboard.php';
    }
}