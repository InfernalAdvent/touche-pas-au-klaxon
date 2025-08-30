<?php
namespace App\Controllers;

use App\Models\TrajetModel;

class TrajetController extends BaseController
{
    public function trajets()
    {
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAvailable();

        require __DIR__ . '/../../templates/pages/home.php';
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

        require __DIR__ . '/../../templates/pages/trajetdetails.php';
    }

    public function edit(int $id)
    {
        $this->checkLoggedIn();

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findWithAgencesById($id);

        if (!$trajet || 
        (
            $trajet['id_auteur'] != $_SESSION['user']['id'] && 
            $_SESSION['user']['role'] !== 'admin'
        )) {
            http_response_code(403);
            echo "Accès refusé ou trajet introuvable";
            exit;
        }

        require __DIR__ . '/../../templates/pages/trajet_edit.php';
    }

    public function update(int $id)
    {
        $this->checkLoggedIn();

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || 
            ($trajet['id_auteur'] != $_SESSION['user']['id'] && $_SESSION['user']['role'] !== 'admin')) {
            http_response_code(403);
            echo "Accès refusé ou trajet introuvable";
            exit;
        }

        // Récupération des valeurs POST
        $date_depart = $_POST['date_depart'] ?? $trajet['date_depart'];
        $date_arrivee = $_POST['date_arrivee'] ?? $trajet['date_arrivee'];
        $places_disponibles = $_POST['places_disponibles'] ?? $trajet['places_disponibles'];
        $places_totales = $_POST['places_totales'] ?? $trajet['places_totales'];

        // Vérification de la cohérence des dates
        if (strtotime($date_arrivee) < strtotime($date_depart)) {
            $_SESSION['errors'][] = "La date d'arrivée ne peut pas être antérieure à la date de départ.";
            header("Location: /touche-pas-au-klaxon/public/trajet/edit/$id");
            exit;
        }

        // Vérification de la cohérence des places
        if ($places_totales <= 0 || $places_disponibles < 0 || $places_disponibles > $places_totales) {
            $_SESSION['errors'][] = "Le nombre de places est invalide";
            header("Location: /touche-pas-au-klaxon/public/trajet/edit/$id");
            exit;
        }

        $data = [
            'date_depart' => $date_depart,
            'date_arrivee' => $date_arrivee,
            'places_disponibles' => $places_disponibles,
            'places_totales' => $places_totales
        ];

        if ($trajetModel->update($id, $data)) {
            header('Location: /touche-pas-au-klaxon/public');
            $_SESSION['success'][] = "Le trajet a été modifié";
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

        header('Location: /touche-pas-au-klaxon/public');
        exit;
    }

    public function add()
    {
        $this->checkLoggedIn();

        $agenceModel = new \App\Models\AgenceModel();
        $agences = $agenceModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_agence_depart = (int)($_POST['agence_depart'] ?? 0);
            $id_agence_arrivee = (int)($_POST['agence_arrivee'] ?? 0);
            $date_depart = $_POST['date_depart'] ?? '';
            $date_arrivee = $_POST['date_arrivee'] ?? '';
            $places_disponibles = (int)($_POST['places_disponibles'] ?? 0);
            $places_totales = (int)($_POST['places_totales'] ?? 0);

            // On convertit en timestamp pour comparer
            $ts_depart = strtotime($date_depart);
            $ts_arrivee = strtotime($date_arrivee);

            // Vérification des conditions
            $errors = [];

            if ($id_agence_depart === $id_agence_arrivee) {
                $errors[] = "L'agence de départ et d'arrivée doivent être différentes.";
            }

            if ($ts_depart === false || $ts_arrivee === false) {
                $errors[] = "Les dates fournies ne sont pas valides.";
            } elseif ($ts_arrivee <= $ts_depart) {
                $errors[] = "La date d'arrivée doit être postérieure à la date de départ.";
            }

            if ($places_totales <= 0 || $places_disponibles < 0 || $places_disponibles > $places_totales) {
                $errors[] = "Le nombre de places est invalide.";
            }

            if (empty($errors)) {
                $trajetModel = new TrajetModel();
                $trajetModel->insert([
                    'id_agence_depart' => $id_agence_depart,
                    'id_agence_arrivee' => $id_agence_arrivee,
                    'date_depart' => date('Y-m-d H:i:s', $ts_depart),
                    'date_arrivee' => date('Y-m-d H:i:s', $ts_arrivee),
                    'places_disponibles' => $places_disponibles,
                    "places_totales" => $places_totales,
                    'id_auteur' => $_SESSION['user']['id']
                ]);
                header('Location: /touche-pas-au-klaxon/public');
                exit;
            } else {
                $_SESSION['errors'] = $errors;
                header('Location: /touche-pas-au-klaxon/public/trajet/add'); 
                exit;
            }
        }

        require __DIR__ . '/../../templates/pages/trajets_add.php';
    }
}
