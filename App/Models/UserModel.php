<?php
namespace App\Models;

use Core\DefaultModel;

/**
 * Modèle de la table 'users'
 * 
 * Fournit les méthodes propres à la gestion des utilisateurs
 * en plus des opérations héritées de DefaultModel
 * 
 * @package App\Models
 */
class UserModel extends DefaultModel
{
    protected string $table = 'users';
    protected string $primaryKey = 'id_user';
    
    /**
     * Recherche un utilisateur par son email
     *
     * @param  string $email
     * @return array
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email_user = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }    
    /**
     * Vérifie si le mot de passe correspond à l'email de l'utilisateur
     *
     * @param  string $email
     * @param  string $password
     * @return array[]
     */
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return null;
        }

        if ($password === $user['password']) {
            return $user;
        }

        return null;
    }
}
    