<?php
$currentUri = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-expand-lg custom-secondary" data-bs-theme="light">
  <div class="container-fluid">
    <a class="navbar-brand custom-primary" href="/touche-pas-au-klaxon/public">Touche pas au klaxon</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav ms-auto">
        <?php if ($role === 'admin'): ?>
            <li class="nav-item">
                <a class="btn btn-primary mx-2" href="/touche-pas-au-klaxon/public/users">Utilisateurs</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary mx-2" href="/touche-pas-au-klaxon/public/agences">Agences</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary mx-2" href="/touche-pas-au-klaxon/public/trajet/add">Trajets</a>
            </li>
        <?php elseif ($role === 'user'): ?>
            <li class="nav-item">
                <a class="btn btn-primary mx-2" href="/touche-pas-au-klaxon/public/trajet/add">Créer un trajet</a>
            </li>
        <?php endif; ?>
        
        <?php if ($userId): ?>
            <li class="nav-item d-flex align-items-center">
                <span class="mx-2">Bonjour <?= htmlspecialchars($name) ?> <?= htmlspecialchars($lastname) ?></span>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary mx-2" href="/touche-pas-au-klaxon/public/logout">Déconnexion</a>
            </li>
        <?php elseif (strpos($currentUri, '/login') === false): ?>
            <li class="nav-item">
                <a class="btn btn-primary mx-2" href="/touche-pas-au-klaxon/public/login">Se connecter</a>
            </li>
        <?php endif; ?>
      </ul> 
    </div>
  </div>
</nav>