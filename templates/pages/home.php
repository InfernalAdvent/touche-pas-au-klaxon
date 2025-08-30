<?php
require __DIR__ . '/../components/session.php';
ob_start();
?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php 
        foreach ($_SESSION['success'] as $msg) {
            echo htmlspecialchars($msg) . "<br>";
        }
        $_SESSION['success'] = [];
        ?>
    </div>
<?php endif; ?>
<?php if ($userId) : ?>
    <h1 class="custom-primary">Trajets proposés</h1>
<?php else: ?> 
    <h1 class="custom-primary">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h1>
<?php endif; ?>
<table class="table table-bordered table-striped text-center my-4">
    <thead class="table-dark">
        <tr>
            <th class="text-light">Départ</th>
            <th class="text-light">Date</th>
            <th class="text-light">Heure</th>
            <th class="text-light">Destination</th>
            <th class="text-light">Date</th>
            <th class="text-light">Heure</th>
            <th class="text-light">Places</th>
            <?php if ($userId): ?>
            <th></th>
            <?php endif; ?>
        </tr>
    </thead>
    <?php foreach ($trajets as $trajet): 
        $depart = new DateTime($trajet['date_depart']);
        $arrivee = new DateTime($trajet['date_arrivee']);
    ?>
        <tr>
            <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
            <td><?= $depart->format('d/m/Y') ?></td>
            <td><?= $depart->format('H:i') ?></td>
            <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
            <td><?= $arrivee->format('d/m/Y') ?></td>
            <td><?= $arrivee->format('H:i') ?></td>
            <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
            
            <?php if ($userId): ?>
            <td>
                <i class="bi bi-eye custom-primary fs-4 btn-details" 
                    role="button"
                    title="Voir détails"
                    data-id="<?= $trajet['id_trajet'] ?>" 
                    data-bs-toggle="modal"
                    data-bs-target="#trajetDetails">
                </i>
            
                <?php if ($role === 'admin' || ($userId && (int)$trajet['id_auteur'] === (int)$userId)): ?>
                    <a href="/touche-pas-au-klaxon/public/trajet/edit/<?= $trajet['id_trajet'] ?>"><i class="bi bi-pencil-square custom-primary fs-4"></i></a>
                    <a href="/touche-pas-au-klaxon/public/trajet/delete/<?= $trajet['id_trajet'] ?>" onclick="return confirm('Confirmer la suppression ?');"><i class="bi bi-trash3 custom-primary fs-4"></i></a>
                <?php endif; ?>
            </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
    <div class="modal fade" id="trajetDetails" tabindex="-1" aria-labelledby="trajetDetailsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title custom-secondary" id="testModalLabel">Détails du trajet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Chargement...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
<?php
// Stockage du contenu dans une variable
$content = ob_get_clean();
$title = 'Trajets proposés';

// Inclusion du layout
require __DIR__ . '/../layout.php';
