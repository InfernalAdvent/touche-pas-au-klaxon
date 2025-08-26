<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
    <header>
    <nav>
        <span><strong>Touche pas au klaxon</strong></span>
        <a href="/touche-pas-au-klaxon/public/login">Se connecter</a>
    </nav>
    <header>
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
            $depart = new Datetime($trajet['date_depart']);
            $arrivee = new Datetime($trajet['date_arrivee']);
            ?>
        <tr>
        <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
        <td><?= $depart->format('d/m/Y') ?></td>
        <td><?= $depart->format('H:i') ?></td>
        <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
        <td><?= $arrivee->format('d/m/Y') ?></td>
        <td><?= $arrivee->format('H:i') ?></td>
        <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
    </tr>

        <?php endforeach; ?>
    </table>
    <footer>
        <div>© 2025 - CENEF - MVC PHP</div>
    </footer>
</body>
</html>
