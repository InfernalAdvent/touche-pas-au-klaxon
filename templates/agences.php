<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des agences</title>
</head>
<body>
    <h1>Liste des agences</h1>
    <a href="/touche-pas-au-klaxon/public/agences/add">Ajouter une agence</a>
    <ul>
        <?php foreach ($agences as $agence): ?>
            <li>
                <?= htmlspecialchars($agence['nom_agence']) ?>
                <a href="/touche-pas-au-klaxon/public/agences/delete/<?= $agence['id_agence'] ?>" onclick="return confirm('Supprimer cette agence ?')">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
