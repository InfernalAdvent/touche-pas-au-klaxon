<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\TrajetModel;


class TrajetController
{
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    public function trajets(): Response
    {
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAvailable();
        $basePath = $this->basePath;

        ob_start();
        require __DIR__ . '/../../templates/trajets.php';
        $content = ob_get_clean();

        return new Response($content);
    }
    public function details(int $id): Response
    {
        error_log("TrajetController::details called with id = $id");
        $trajetModel = new TrajetModel();
        $details = $trajetModel->findDetailsById($id);

        if (!$details) {
            return new Response("Trajet non trouvé", 404);
        }

        $basePath = $this->basePath;
        ob_start();
        require __DIR__ . '/../../templates/trajetdetails.php';
        $content = ob_get_clean();

        return new Response($content);
    }
    public function edit(int $id): Response
    {
        session_start();
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location: ' . $this->basePath . '/login');
            exit;
        }

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || $trajet['id_auteur'] != $userId) {
            return new Response('Accès refusé ou trajet introuvable', 403);
        }

        $basePath = $this->basePath;
        ob_start();
        require __DIR__ . '/../../templates/trajet_edit.php'; // à créer, formulaire d'édition
        $content = ob_get_clean();

        return new Response($content);
    }

    public function update(int $id): Response
    {
        session_start();
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location: ' . $this->basePath . '/login');
            exit;
        }

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || $trajet['id_auteur'] != $userId) {
            return new Response('Accès refusé ou trajet introuvable', 403);
        }

        // Exemple simplifié : on récupère $_POST (à valider strictement !)
        $data = [
            'date_depart' => $_POST['date_depart'] ?? $trajet['date_depart'],
            'date_arrivee' => $_POST['date_arrivee'] ?? $trajet['date_arrivee'],
            'places_disponibles' => $_POST['places_disponibles'] ?? $trajet['places_disponibles'],
            // ... autres champs si besoin
        ];

        $success = $trajetModel->update($id, $data);

        if ($success) {
            header('Location: ' . $this->basePath . '/dashboard');
            exit;
        } else {
            return new Response('Erreur lors de la mise à jour', 500);
        }
    }

    public function delete(int $id): Response
    {
        session_start();
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location: ' . $this->basePath . '/login');
            exit;
        }

        $trajetModel = new TrajetModel();
        $trajet = $trajetModel->findById($id);

        if (!$trajet || $trajet['id_auteur'] != $userId) {
            return new Response('Accès refusé ou trajet introuvable', 403);
        }

        $trajetModel->delete($id);

        header('Location: ' . $this->basePath . '/dashboard');
        exit;
    }
}
