<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Models\UserModel;

class LoginController
{   
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function login(): Response
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email =$_POST['email'] ?? '';
            $password= $_POST['password'] ?? '';

            if(empty($email) || empty($password)) {
                return new Response("Veuillez remplir tous les champs", 400);
            }
            $userModel = new UserModel();
            $user = $userModel->verifyPassword($email, $password);

            if($user) {
                $_SESSION['user'] = [
                    'id' => $user['id_user'],
                    'name' => $user['prenom_user'],
                    'email'=> $user['email_user'],
                    'role'=> $user['role']
                ];
                

                if($user['role'] === 'admin') {
                    return new RedirectResponse($this->basePath . '/admin/dashboard');
                } else {
                    return new RedirectResponse($this->basePath . '/dashboard');
                }
            } else {
                return new Response("Email ou mot de passe incorrect.", 401);
            }
        } else {
             ob_start();
                require __DIR__ . '/../../templates/login.php';
                $content = ob_get_clean();

                return new Response($content);
        }
    }

    public function logout(): Response
    {
        session_start();
        session_destroy();
        return new RedirectResponse($this->basePath . '/');
    }
} 