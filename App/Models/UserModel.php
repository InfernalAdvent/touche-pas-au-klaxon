<?php
namespace App\Models;

use Core\DefaultModel;

class UserModel extends DefaultModel
{
    protected string $table = 'users';
    protected string $primaryKey = 'id_user';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email_user = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }
}
    