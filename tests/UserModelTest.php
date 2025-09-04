<?php 

use PHPUnit\Framework\TestCase;
use App\Models\UserModel;

require_once 'App/Models/UserModel.php';

/**
 * Classe de tests PHPUnit pour le modèle UserModel
 *
 * Teste les méthodes CRUD (insert, update, delete) de UserModel
 * sur une base de données dédiée aux tests.
 * 
 * @package Tests
 */
class UserModelTest extends TestCase {
    /**
     * @var PDO Instance de la connexion PDO vers la base de test
     */
    private $pdo;

    /**
     * @var UserModel Instance du modèle UserModel à tester
     */
    private $userModel;

    /**
     * Configuration avant chaque test
     *
     * Initialise la connexion PDO vers la base de test,
     * crée une instance de UserModel et nettoie la table users.
     */
    protected function setUp(): void {
        $this->pdo = new PDO("mysql:host=localhost;dbname=phpunit_test;charset=utf8", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->userModel = new UserModel($this->pdo);

        $this->pdo->exec("TRUNCATE TABLE users");
    }

    /**
     * Test de l'insertion d'un utilisateur
     *
     * Insère un nouvel utilisateur et vérifie que le prénom
     * correspond à celui attendu dans la base de test.
     */
    public function testInsertUser(): void {
        $this->userModel->insert([
            'prenom_user' => 'Alice',
            'telephone_user' => '0123456789',
            'nom_user' => 'Dupont',
            'email_user' => 'alice.dupont@email.com',
            'password' => '12345',
            'role' => 'user'
        ]);

        $stmt = $this->pdo->query("SELECT * FROM users WHERE email_user='alice.dupont@email.com'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Alice', $user['prenom_user']);
    }

    /**
     * Test de la mise à jour d'un utilisateur
     *
     * Insère un utilisateur, modifie son prénom via update(),
     * puis vérifie que le changement a bien été pris en compte.
     */
    public function testUpdateUser(): void {
        $this->pdo->exec("INSERT INTO users (prenom_user, telephone_user, nom_user, email_user, password, role) 
                        VALUES ('Bob','0987654321', 'Martin', 'bob.martin@email.com', '12345', 'user')");
        
        $this->userModel->update(1, ['prenom_user' => 'Bobby']);

        $stmt = $this->pdo->query("SELECT * FROM users WHERE id_user=1");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Bobby', $user['prenom_user']);
    }

    /**
     * Test de la suppression d'un utilisateur
     *
     * Insère un utilisateur, le supprime via delete(),
     * puis vérifie qu'il n'existe plus dans la base.
     */
    public function testDeleteUser(): void {
        $this->pdo->exec("INSERT INTO users (prenom_user, telephone_user, nom_user, email_user, password, role) 
                        VALUES ('Charlie', '0112233445', 'Durand', 'charlie@example.com', 'secret', 'user')");

        $this->userModel->delete(1);

        $stmt = $this->pdo->query("SELECT * FROM users WHERE id_user=1");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($user);
    }
}
