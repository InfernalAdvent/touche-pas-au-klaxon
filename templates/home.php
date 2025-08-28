<?php
session_start(); // Toujours en haut avant tout HTML

// Récupération sécurisée des infos utilisateur si connecté
$userId = $_SESSION['user']['id'] ?? null;
$role = $_SESSION['user']['role'] ?? null;
$name = $_SESSION['user']['name'] ?? null;
$lastname = $_SESSION['user']['lastname'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Trajets proposés</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <nav>
        <p><strong>Touche pas au klaxon</strong></p>

        <?php if ($role === 'admin'): ?>
        <div class="admin-links">
            <a href="/touche-pas-au-klaxon/public/trajet/add">Trajets</a>
            <a href="/touche-pas-au-klaxon/public/agences">Agences</a>
            <a href="/touche-pas-au-klaxon/public/users">Utilisateurs</a>
        </div>
        <?php elseif ($role === 'user'): ?>
            <a href="/touche-pas-au-klaxon/public/trajet/add">Créer un trajet</a>
        <?php endif; ?>

        <?php if ($userId): ?>
            <p>Bonjour <?= htmlspecialchars($name) ?> <?= htmlspecialchars($lastname) ?></p>
            <a href="/touche-pas-au-klaxon/public/logout">Déconnexion</a>
        <?php else: ?>
            <a href="/touche-pas-au-klaxon/public/login">Se connecter</a>
        <?php endif; ?>
    </nav>
</header>

<h1>Trajets proposés</h1>
<table>
    <tr>
        <th>Départ</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Destination</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Places</th>
        <th></th>
    </tr>

    <?php foreach ($trajets as $trajet): ?>
        <?php 
        $depart = new DateTime($trajet['date_depart']);
        $arrivee = new DateTime($trajet['date_arrivee']);
        ?>
        <tr>
            <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
            <td><?= $depart->format('d/m/Y') ?></td>
            <td><?= $depart->format('H:i') ?></td>
            <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
            <td><?= $arrivee->format('d/m/Y') ?></td>
            <td><?= $arrivee->format('H:i') ?></td>
            <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
            <td>
                <?php if ($userId): ?>
                    <a href="/touche-pas-au-klaxon/public/trajet/<?= $trajet['id_trajet'] ?>">Infos</a>
                <?php endif; ?>

                <?php if ($role === 'admin' || ($userId && (int)$trajet['id_auteur'] === (int)$userId)): ?>
                    <a href="/touche-pas-au-klaxon/public/trajet/edit/<?= $trajet['id_trajet'] ?>">Modifier</a>
                    <a href="/touche-pas-au-klaxon/public/trajet/delete/<?= $trajet['id_trajet'] ?>" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<footer>
    <div>© 2025 - CENEF - MVC PHP</div>
</footer>
</body>
</html>
