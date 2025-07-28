<?php
namespace Core;

use Core\Database;
use PDO;

abstract class DefaultModel
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupère tous les enregistrements
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un enregistrement par son ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Supprime un enregistrement par son ID
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

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
    public function insert(array $data): int
    {
        // Récupère les colonnes et prépare les placeholders
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $columns_sql = implode(', ', $columns);
        $placeholders_sql = implode(', ', $placeholders);

        $sql = "INSERT INTO {$this->table} ($columns_sql) VALUES ($placeholders_sql)";
        $stmt = $this->db->prepare($sql);

        // Exécute la requête
        $stmt->execute($data);

        // Retourne l'ID inséré (pratique pour récupérer la ressource)
        return (int)$this->db->lastInsertId();
    }

}
