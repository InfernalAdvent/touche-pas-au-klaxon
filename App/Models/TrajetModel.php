<?php 

namespace App\Models;

use Core\DefaultModel;

class TrajetModel extends DefaultModel
{
    protected string $table = 'trajets';
    protected string $primaryKey = 'id_trajet';

    public function findAvailable(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE places_disponibles > 0");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function decrementPlacesDisponibles(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET places_disponibles = places_disponibles - 1
            WHERE {$this->primaryKey} = :id AND places_disponibles > 0
        ");
        return $stmt->execute(['id' => $id]);
    }
}