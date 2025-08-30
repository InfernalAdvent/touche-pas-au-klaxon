<?php
namespace App\Controllers;

use App\Models\AgenceModel;

class AgenceController extends BaseController
{
    // Affichage de la liste
    public function agences()
    {
        $this->checkAdmin();

        $agenceModel = new AgenceModel();
        $agences = $agenceModel->findAll();

        require __DIR__ . '/../../templates/pages/agences.php';
    }

    // Ajout d'une agence
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

    // Suppression d'une agence
    public function delete(int $id)
    {
        $this->checkAdmin();

        $agenceModel = new AgenceModel();
        $agenceModel->delete($id);

        header('Location: /touche-pas-au-klaxon/public/agences');
        exit;
    }
}
