<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {
        return new Response("Hello world");
    }
}