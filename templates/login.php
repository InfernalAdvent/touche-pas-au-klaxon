<!-- views/Login.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Connexion</h1>
    <form method="POST" action="/touche-pas-au-klaxon/public/login">
        <label for="email">Email :</label>
        <input type="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
