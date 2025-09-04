<?php 

namespace App\Models;

use Core\DefaultModel;

/**
 * Modèle de la table 'trajets'
 * 
 * Fournit les méthodes propres à la gestion des trajets
 * en plus des opérations héritées de DefaultModel
 * 
 * @package App\Models 
 */
class TrajetModel extends DefaultModel
{
    protected string $table = 'trajets';
    protected string $primaryKey = 'id_trajet';
    
    /**
     * Recherche tous les trajets disponibles avec des places restantes
     *
     * @return array<int, array<string, mixed>>
     */
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
            WHERE t.date_depart >= NOW()
            AND t.places_disponibles > 0
            ORDER BY t.date_depart ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
   
   /**
    * Recherche les détails du trajet (avec l'information de l'auteur)
    *
    * @param  int $id
    * @return array<string, mixed>
    */
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
    
    /**
     * Recherche un trajet par son id avec les informations des agences
     *
     * @param  int $id
     * @return array<string, mixed>
     */
    public function findWithAgencesById(int $id): ?array
    {
        $sql = "
            SELECT 
                t.id_trajet,
                t.id_auteur,
                t.date_depart,
                t.date_arrivee,
                t.places_disponibles,
                t.places_totales,
                ad.nom_agence AS agence_depart,
                aa.nom_agence AS agence_arrivee
            FROM {$this->table} t
            JOIN agences ad ON t.id_agence_depart = ad.id_agence
            JOIN agences aa ON t.id_agence_arrivee = aa.id_agence
            WHERE t.{$this->primaryKey} = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}
