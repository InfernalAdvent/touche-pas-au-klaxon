<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    // Affichage de la liste
    public function users()
    {
        $this->checkAdmin();

        $userModel = new UserModel();
        $users = $userModel->findAll();

        require __DIR__ . '/../../templates/users.php';
    }
}
