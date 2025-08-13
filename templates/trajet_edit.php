<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier trajet</title>
</head>
<body>
    <h1>Modifier trajet #<?= htmlspecialchars($trajet['id_trajet']) ?></h1>
    <form action="/touche-pas-au-klaxon/public/trajet/update/<?= $trajet['id_trajet'] ?>" method="POST">
        <label>Date départ : <input type="datetime-local" name="date_depart" value="<?= (new DateTime($trajet['date_depart']))->format('Y-m-d\TH:i') ?>" required></label><br>
        <label>Date arrivée : <input type="datetime-local" name="date_arrivee" value="<?= (new DateTime($trajet['date_arrivee']))->format('Y-m-d\TH:i') ?>" required></label><br>
        <label>Places disponibles : <input type="number" name="places_disponibles" value="<?= htmlspecialchars($trajet['places_disponibles']) ?>" min="0" required></label><br>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="/touche-pas-au-klaxon/public/dashboard">Retour au dashboard</a>
</body>
</html>
