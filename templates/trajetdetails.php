<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du trajet</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Détails du trajet</h1>
    <p><strong>Nom :</strong> <?= htmlspecialchars($details['prenom_user']) ?> <?= htmlspecialchars($details['nom_user']) ?></p>
    <p><strong>Téléphone :</strong> <?= htmlspecialchars($details['telephone_user']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($details['email_user']) ?></p>
    <p><strong>Places totales :</strong> <?= htmlspecialchars($details['places_totales']) ?></p>

    <a href="/touche-pas-au-klaxon/public">Retour à la liste des trajets</a>
</body>
</html>
