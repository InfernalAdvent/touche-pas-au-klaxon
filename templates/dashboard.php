<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes trajets</title>
</head>
<body>
    <h1>Mes trajets</h1>
    <table>
        <tr>
            <th>Départ</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($trajets as $trajet): ?>
            <?php 
            $depart = new DateTime($trajet['date_depart']);
            $arrivee = new DateTime($trajet['date_arrivee']);
            ?>
        <tr>
            <td><a href="/touche-pas-au-klaxon/public/trajet/<?= $trajet['id_trajet'] ?>">
                <?= htmlspecialchars($trajet['agence_depart']) ?>
            </a></td>
            <td><?= $depart->format('d/m/Y') ?></td>
            <td><?= $depart->format('H:i') ?></td>
            <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
            <td><?= $arrivee->format('d/m/Y') ?></td>
            <td><?= $arrivee->format('H:i') ?></td>
            <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
            <td>
            <?php if ($role === 'admin' || (int)$trajet['id_auteur'] === (int)$userId): ?>
                <a href="/touche-pas-au-klaxon/public/trajet/edit/<?= $trajet['id_trajet'] ?>">Modifier</a>
                <a href="/touche-pas-au-klaxon/public/trajet/delete/<?= $trajet['id_trajet'] ?>" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
            <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
