<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TrajetModel;

class DashboardController
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function index(): Response
    {

        session_start();
        if (!isset($_SESSION['user'])) {
            return new RedirectResponse($this->basePath . '/login');
        }

        $userId = $_SESSION['user']['id'];
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAvailable();
        $basePath = $this->basePath;

        ob_start();
        require __DIR__ . '/../../templates/dashboard.php';
        $content = ob_get_clean();

        return new Response($content);
    }
}