<?php
require __DIR__ . '/../session.php';
ob_start();
?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger w-50 mx-auto text-start">
        <ul class="mb-0">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<h1 class="custom-primary text-center mb-2">Ajouter un trajet</h1>

<div class="text-center">
<form class="form-custom" action="/touche-pas-au-klaxon/public/trajet/add" method="POST">
  <fieldset>
    <div class="row">
        <div>
            <label for="agence_depart" class="form-label mt-2 custom-primary">Agence de départ</label>
            <select class="form-select w-25 mx-auto" name="agence_depart" required>
                <option value="">-- Choisir une agence --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= htmlspecialchars($agence['id_agence']) ?>">
                        <?= htmlspecialchars($agence['nom_agence']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mt-4">
            <label class="custom-primary">Date départ :</label>
            <input type="datetime-local" name="date_depart" required>
        </div>
        <div>
            <label for="agence_arrivee" class="form-label mt-4 custom-primary">Destination</label>
            <select class="form-select w-25 mx-auto" name="agence_arrivee" required>
                <option value="">-- Choisir une agence --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= htmlspecialchars($agence['id_agence']) ?>">
                        <?= htmlspecialchars($agence['nom_agence']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mt-4">
            <label class="custom-primary">Date arrivée :</label>
            <input type="datetime-local" name="date_arrivee" required>
        </div>
        <div class="mt-4">
            <label class="custom-primary">Places totales :</label>
            <input type="number" name="places_totales" min="0" required>
        </div>
        
        <div class="mt-4">
        <label class="custom-primary">Places disponibles :</label>
            <input type="number" name="places_disponibles" min="0" required>
        </div>
        
        <div class="mt-4">
        <button class="btn btn-success" type="submit">Valider</button>
        </div>
    </fieldset>
<div class="mt-4 pt-4 text-center">
    <a class="btn btn-primary" href="/touche-pas-au-klaxon/public">Retour à la liste des trajets</a>
</div>
</div>

<?php
$content = ob_get_clean();
$title = "Ajouter un trajet";

require __DIR__ . '/../layout.php';
