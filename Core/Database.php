<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function getInstance() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=touche_pas_au_klaxon;charset=utf8',
                    'root',
                    '', 
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}