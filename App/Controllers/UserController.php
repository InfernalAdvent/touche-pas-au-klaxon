<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Models\UserModel;

class UserController
{ 
    private function checkAdmin(): ?RedirectResponse
    {
        // session_start();
        //if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
          //  return new RedirectResponse($this->basePath . '/login');
        //}
        return null;
    }

    // Affichage de la liste
    public function users(): Response
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();

        ob_start();
        require __DIR__ . '/../../templates/users.php';
        $content = ob_get_clean();

        return new Response($content);
    }

} 