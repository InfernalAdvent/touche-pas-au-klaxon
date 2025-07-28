<?php
namespace App\Controllers;

use App\Models\AgenceModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AgenceController
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    private function checkAdmin(): ?RedirectResponse
    {
        // session_start();
        //if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
          //  return new RedirectResponse($this->basePath . '/login');
        //}
        return null;
    }

    // Affichage de la liste
    public function agences(): Response
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agences = $agenceModel->findAll();

        ob_start();
        require __DIR__ . '/../../templates/agences.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    // Ajout d'une agence
    public function add(Request $request): Response
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        if ($request->getMethod() === 'POST') {
            $nom = trim($request->request->get('nom_agence'));
            if ($nom) {
                $agenceModel = new AgenceModel();
                $agenceModel->insert(['nom_agence' => $nom]);
                return new RedirectResponse($this->basePath . '/agences');
            }
        }

        ob_start();
        require __DIR__ . '/../../templates/agence_add.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    // Édition d'une agence
    public function edit(Request $request, int $id): Response
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agence = $agenceModel->findById($id);

        if (!$agence) {
            return new Response('Agence introuvable', 404);
        }

        if ($request->getMethod() === 'POST') {
            $nom = trim($request->request->get('nom_agence'));
            if ($nom) {
                $agenceModel->update($id, ['nom_agence' => $nom]);
                return new RedirectResponse($this->basePath . '/agences');
            }
        }

        ob_start();
        require __DIR__ . '/../../templates/agence_edit.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    // Suppression d'une agence
    public function delete(int $id): Response
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $agenceModel = new AgenceModel();
        $agenceModel->delete($id);

        return new RedirectResponse($this->basePath . '/agences');
    }
}
