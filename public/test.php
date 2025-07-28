<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\UserModel;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$userModel = new UserModel();

echo "<h2>Test findByEmail()</h2>";
print_r($userModel->findByEmail('sophie.dubois@email.fr'));

echo "<h2>Test verifyPassword() avec bon mot de passe</h2>";
// Remplace 'leMotDePasseCorrect' par le vrai mot de passe en clair (avant hash)
$result = $userModel->verifyPassword('sophie.dubois@email.fr', '12345'); 
var_dump($result !== null ? "Mot de passe correct" : "Mot de passe incorrect");

echo "<h2>Test verifyPassword() avec mauvais mot de passe</h2>";
$result = $userModel->verifyPassword('sophie.dubois@email.fr', 'mauvaismdp'); 
var_dump($result !== null ? "Mot de passe correct" : "Mot de passe incorrect");
