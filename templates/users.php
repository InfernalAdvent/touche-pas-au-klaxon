<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= htmlspecialchars($user['prenom_user']) ?>
                <?= htmlspecialchars($user['nom_user']) ?>,
                <?= htmlspecialchars($user['telephone_user']) ?>,
                <?= htmlspecialchars($user['email_user']) ?>,
                <?= htmlspecialchars($user['role']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
