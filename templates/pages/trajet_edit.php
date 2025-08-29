<?php
require __DIR__ . '/../session.php';
ob_start();
?>
<h1 class="custom-primary">Modifier trajet #<?= htmlspecialchars($trajet['id_trajet']) ?></h1>

<div class="text-center">
<form class="form-custom" action="/touche-pas-au-klaxon/public/trajet/update/<?= $trajet['id_trajet'] ?>" method="POST">
  <fieldset>
    <div class="row">
        <div class="mt-4">
            <label class="custom-primary">Date départ :</label>
            <input type="datetime-local" name="date_depart" value="<?= (new DateTime($trajet['date_depart']))->format('Y-m-d\TH:i') ?>" required>
        </div>
        <div class="mt-4">
            <label class="custom-primary">Date arrivée :</label>
            <input type="datetime-local" name="date_arrivee" value="<?= (new DateTime($trajet['date_arrivee']))->format('Y-m-d\TH:i') ?>" required>
        </div>
        <div class="mt-4">
            <label class="custom-primary">Places disponibles :</label>
            <input type="number" name="places_disponibles" value="<?= htmlspecialchars($trajet['places_disponibles']) ?>" min="0" required>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </div>

        <div class="mt-4">
            <a href="/touche-pas-au-klaxon/public">Retour à la liste des trajets</a>
        </div>
    </div>
    </fieldset>
</form>
                 
</div>

<?php
$content = ob_get_clean();
$title = "Modifier le trajet";

require __DIR__ . '/../layout.php';