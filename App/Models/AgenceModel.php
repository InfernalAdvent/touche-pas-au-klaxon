<?php 

namespace App\Models;

use Core\DefaultModel;

class AgenceModel extends DefaultModel
{
    protected string $table = 'agences';
    protected string $primaryKey = 'id_agence';

    public function findByName(string $name): array 
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nom_agence LIKE :name");
        $stmt->execute(['name' => "%{$name}%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}