<?php
namespace App\Controllers;

use App\Models\UserModel;

/**
 * Controller gérant les actions liée aux utilisateurs
 * en utilisant les functions du BaseController
 * 
 * @package App\Controllers
 */
class UserController extends BaseController
{    
    /**
     * Permet à un admin de récupérer la liste des utilisateurs
     *
     * @return void
     */
    public function users()
    {
        $this->checkAdmin();

        $userModel = new UserModel();
        $users = $userModel->findAll();

        require __DIR__ . '/../../templates/pages/users.php';
    }
}
