<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class UserController
{
    public function index()
    {
        return new Response("Hello user");
    }
} 