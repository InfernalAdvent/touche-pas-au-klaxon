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
    /**
     * Instance unique de PDO (ou null si non initialisée).
     *
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

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
            self::$pdo = new PDO(
                'mysql:host=localhost;dbname=touche_pas_au_klaxon;charset=utf8',
                'root',
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }
}
