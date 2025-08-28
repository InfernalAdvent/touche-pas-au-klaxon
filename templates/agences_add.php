<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une agence</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Ajouter une agence</h1>
    <form action="/touche-pas-au-klaxon/public/agences/add" method="POST">
        <label>Nom de l'agence :
            <input type="text" name="nom_agence" value="" required>
        </label>
        <button type="submit">Valider</button>
    </form>
    <a href="/touche-pas-au-klaxon/public/agences">Retour</a>
</body>
</html>
