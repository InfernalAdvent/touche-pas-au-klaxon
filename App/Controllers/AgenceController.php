<?php
namespace App\Controllers;

use App\Models\AgenceModel;

/**
 * AgenceController
 * 
 * @package App\Controllers
 */
class AgenceController extends BaseController
{    
    /**
     * Permet d'afficher la liste des agences
     *
     * @return void
     */
    public function agences()
    {
        $this->checkAdmin();

        $agenceModel = new AgenceModel();
        $agences = $agenceModel->findAll();

        require __DIR__ . '/../../templates/pages/agences.php';
    }
    
    /**
     * Permet à un admin d'ajouter une agence
     *
     * @return void
     */
    public function add()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom_agence'] ?? '');
            if ($nom) {
                $agenceModel = new AgenceModel();

                $existing = $agenceModel->findByName($nom);
                if ($existing) {
                    $_SESSION['errors'][] = "Cette agence existe déjà.";
                    header('Location: /touche-pas-au-klaxon/public/agences');
                    exit;
            }
                $agenceModel->insert(['nom_agence' => $nom]);
                $_SESSION['success'][] = "L'agence a été ajoutée";
                header('Location: /touche-pas-au-klaxon/public/agences');
                exit;
            } else {
                $_SESSION['errors'][] = "Le nom de l'agence est requis.";
                header('Location: /touche-pas-au-klaxon/public/agences');
                exit;
            }
        }

        require __DIR__ . '/../../templates/pages/agences.php';
    }
    
    /**
     * Permet à un admin de supprimer une agence
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id)
    {
        $this->checkAdmin();

        $agenceModel = new AgenceModel();
        $agenceModel->delete($id);
        $_SESSION['success'][] = "L'agence a été supprimée";
        header('Location: /touche-pas-au-klaxon/public/agences');
        exit;
    }
}
