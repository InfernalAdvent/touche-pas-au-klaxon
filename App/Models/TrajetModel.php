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
                t.id_auteur,
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

   public function findDetailsById(int $id): ?array
    {
        $sql = "SELECT u.prenom_user, u.nom_user, u.telephone_user, u.email_user, t.places_totales
                FROM {$this->table} t
                JOIN users u ON t.id_auteur = u.id_user
                WHERE t.id_trajet = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }
    public function findByUser(int $userId): array
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
            WHERE id_auteur = :userId
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
