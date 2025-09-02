<?php
namespace App\Controllers;

use App\Models\UserModel;

/**
 * LoginController
 *
 * @package App\Controllers
 */
class LoginController extends BaseController
{       
    /**
     * Permet la connexion de l'utilisateur
     *
     * @return void
     */
    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                echo "Veuillez remplir tous les champs";
                http_response_code(400);
                return;
            }

            $userModel = new UserModel();
            $user = $userModel->verifyPassword($email, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id_user'],
                    'name' => $user['prenom_user'],
                    'lastname' => $user['nom_user'],
                    'email'=> $user['email_user'],
                    'role'=> $user['role']
                ];

                if ($user['role'] === 'admin') {
                    header('Location: /touche-pas-au-klaxon/public');
                } else {
                    header('Location: /touche-pas-au-klaxon/public');
                }
                exit;
            } else {
                echo "Email ou mot de passe incorrect.";
                http_response_code(401);
            }
        } else {
            require __DIR__ . '/../../templates/pages/login.php';
        }
    }
    
    /**
     * Permet la déconnexion de l'utilisateur
     *
     * @return void
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /touche-pas-au-klaxon/public');
        exit;
    }
}
