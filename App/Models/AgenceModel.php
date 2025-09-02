<?php 

namespace App\Models;

use Core\DefaultModel;

/**
 * Modèle pour la table 'agences'
 * 
 * Fournit les méthodes propres à la table sql agences
 * en plus des opérations héritées de DefaultModel 
 * 
 * @package App\Models
 */
class AgenceModel extends DefaultModel
{
    protected string $table = 'agences';
    protected string $primaryKey = 'id_agence';
    
    /**
     * Recherche les agences où le nom correspond
     *
     * @param  string $name
     * @return array[] tableau avec le nom des agences
     */
    public function findByName(string $name): array 
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nom_agence LIKE :name");
        $stmt->execute(['name' => "%{$name}%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}