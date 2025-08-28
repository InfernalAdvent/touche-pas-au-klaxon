<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une agence</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Ajouter un trajet</h1>
    <form action="/touche-pas-au-klaxon/public/trajet/add" method="POST">
        <label>Agence de départ :
            <select name="agence_depart" required>
                <option value="">-- Choisir une agence --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= htmlspecialchars($agence['id_agence']) ?>"><?= htmlspecialchars($agence['nom_agence']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Date :
            <input type="datetime-local" name="date_depart" value="" required>
        </label>
        <label>Destination :
            <select name="agence_arrivee" required>
                <option value="">-- Choisir une agence --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= htmlspecialchars($agence['id_agence']) ?>"><?= htmlspecialchars($agence['nom_agence']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Date : 
            <input type="datetime-local" name="date_arrivee" value="" required>
        </label>
        <label>Places totales :
            <input type="number" name="places_totales" min="0" required>
        </label>
        <label>Places disponibles :
            <input type="number" name="places_disponibles" min="0" required>
        </label>
        <button type="submit">Ajouter</button>
    </form>
    <a href="/touche-pas-au-klaxon/public">Retour à la liste des trajets</a>
</body>
</html>
