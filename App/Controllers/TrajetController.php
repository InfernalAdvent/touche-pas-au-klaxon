<?php
namespace App\Controllers;

use App\Models\TrajetModel;

class TrajetController extends BaseController
{
    public function trajets()
    {
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAvailable();

        require __DIR__ . '/../../templates/trajets.php';
    }

    public function details(int $id)
    {   
        $this->checkLoggedIn();
        
        $trajetModel = new TrajetModel();
        $details = $trajetModel->findDetailsById($id);

        if (!$details) {
            http_response_code(404);
            echo "Trajet non trouvé";
            exit;
        }

        require __DIR__ . '/../../templates/trajetdetails.php';
    }

    public function edit(int $id)
    {
        $this->checkLoggedIn();

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || 
        (
            $trajet['id_auteur'] != $_SESSION['user']['id'] && 
            $_SESSION['user']['role'] !== 'admin'
        )) {
            http_response_code(403);
            echo "Accès refusé ou trajet introuvable";
            exit;
        }

        require __DIR__ . '/../../templates/trajet_edit.php';
    }

    public function update(int $id)
    {
        $this->checkLoggedIn();

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || 
        (
            $trajet['id_auteur'] != $_SESSION['user']['id'] && 
            $_SESSION['user']['role'] !== 'admin'
        )) {
            http_response_code(403);
            echo "Accès refusé ou trajet introuvable";
            exit;
        }

        $data = [
            'date_depart' => $_POST['date_depart'] ?? $trajet['date_depart'],
            'date_arrivee' => $_POST['date_arrivee'] ?? $trajet['date_arrivee'],
            'places_disponibles' => $_POST['places_disponibles'] ?? $trajet['places_disponibles'],
        ];

        if ($trajetModel->update($id, $data)) {
            header('Location: /touche-pas-au-klaxon/public/dashboard');
            exit;
        } else {
            http_response_code(500);
            echo "Erreur lors de la mise à jour";
            exit;
        }
    }

    public function delete(int $id)
    {
        $this->checkLoggedIn();

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || 
        (
            $trajet['id_auteur'] != $_SESSION['user']['id'] && 
            $_SESSION['user']['role'] !== 'admin'
        )) {
            http_response_code(403);
            echo "Accès refusé ou trajet introuvable";
            exit;
        }

        $trajetModel->delete($id);

        header('Location: /touche-pas-au-klaxon/public/dashboard');
        exit;
    }
}
