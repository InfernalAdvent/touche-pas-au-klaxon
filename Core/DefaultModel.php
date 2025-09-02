<?php
namespace Core;

use Core\Database;
use PDO;

/**
 * Classe abstraite DefaultModel
 *
 * Fournit des méthodes génériques pour interagir avec une table SQL
 * Doit être étendue par des modèles concrets
 *
 * @package Core
 */
abstract class DefaultModel
{
    
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    /**
     * Constructeur
     *
     * Initialise la connexion à la base de données.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupère tous les enregistrements de la table
     *
     * @return array Liste des enregistrements
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un enregistrement
     *
     * @param int $id Identifiant de l’enregistrement
     * @return array|null Tableau associatif représentant l’enregistrement, ou null si non trouvé
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Supprime un enregistrement
     *
     * @param int $id Identifiant de l’enregistrement
     * @return bool True si la suppression a réussi, False sinon
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Met à jour un enregistrement
     *
     * @param int   $id   Identifiant de l’enregistrement
     * @param array $data Données à mettre à jour (clé = colonne, valeur = nouvelle valeur)
     * @return bool True si la mise à jour a réussi, False sinon
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $fields_sql = implode(', ', $fields);

        $sql = "UPDATE {$this->table} SET $fields_sql WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);

        $data['id'] = $id;

        return $stmt->execute($data);
    }

    /**
     * Insère un nouvel enregistrement dans la table
     *
     * @param array $data Données à insérer (clé = colonne, valeur = valeur à insérer)
     * @return int ID de l’enregistrement inséré
     */
    public function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $columns_sql = implode(', ', $columns);
        $placeholders_sql = implode(', ', $placeholders);

        $sql = "INSERT INTO {$this->table} ($columns_sql) VALUES ($placeholders_sql)";
        $stmt = $this->db->prepare($sql);

        $stmt->execute($data);

        return (int)$this->db->lastInsertId();
    }
}
