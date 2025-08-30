<?php
require __DIR__ . '/../session.php';
ob_start();
?>

<h1 class="custom-primary text-center">Liste des utilisateurs</h1>
    <div class="d-flex justify-content-center mt-4">
        <ul class="list-group w-50">
            <?php foreach ($users as $user): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($user['prenom_user']) ?>
                <?= htmlspecialchars($user['nom_user']) ?>,
                <?= htmlspecialchars($user['telephone_user']) ?>,
                <?= htmlspecialchars($user['email_user']) ?>,
                <?= htmlspecialchars($user['role']) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

<div class="mt-4 pt-4 text-center">
    <a class="btn btn-primary" href="/touche-pas-au-klaxon/public">Retour à la liste des trajets</a>
</div>

<?php
$content = ob_get_clean();
$title = "Liste des utilisateurs";

require __DIR__ . '/../layout.php';