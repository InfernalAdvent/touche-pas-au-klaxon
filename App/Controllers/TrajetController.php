<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\TrajetModel;


class TrajetController
{
    public function trajets(): Response
    {
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->findAvailable();

        ob_start();
        require __DIR__ . '/../../templates/trajets.php';
        $content = ob_get_clean();

        return new Response($content);
    }
}
