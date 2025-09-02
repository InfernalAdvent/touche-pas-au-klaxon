<?php
namespace Core;

use PDO;
use PDOException;

/**
 * Classe Database
 *
 * Gère la connexion à la base de données via PDO en utilisant
 * le pattern Singleton (une seule instance partagée).
 *
 * @package Core
 */
class Database {
    private static $pdo;

    /**
     * Retourne l’instance unique de PDO.
     * Si aucune connexion n’existe, elle est créée.
     *
     * @return PDO Instance PDO connectée à la base de données
     *
     * @throws PDOException Si la connexion échoue
     */
    public static function getInstance(): PDO {
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
