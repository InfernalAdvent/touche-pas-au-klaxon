<?php 

namespace App\Models;

use Core\DefaultModel;

class TrajetModel extends DefaultModel
{
    protected string $table = 'trajets';
    protected string $primaryKey = 'id_trajet';

    public function findAvailable(): array
    {
         $sql = "
            SELECT 
                t.id_trajet,
                t.date_depart,
                t.date_arrivee,
                t.places_disponibles,
                ad.nom_agence AS agence_depart,
                aa.nom_agence AS agence_arrivee
            FROM {$this->table} t
            JOIN agences ad ON t.id_agence_depart = ad.id_agence
            JOIN agences aa ON t.id_agence_arrivee = aa.id_agence
            WHERE t.places_disponibles > 0
        ";
        $stmt = $this->db->query($sql);
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