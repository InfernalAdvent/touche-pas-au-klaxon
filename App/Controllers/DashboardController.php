<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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

        $name = $_SESSION['user']['name'] ?? 'Utilisateur';

        $content = "<h1>Bienvenue, $name !</h1><p>Vous êtes connecté.</p>";
        return new Response($content);
    }
}
