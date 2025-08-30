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
    <h1 class="custom-primary text-center">Liste des agences</h1>
    <div class="d-flex justify-content-center mt-4">
        <ul class="list-group w-25">
            <?php foreach ($agences as $agence): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($agence['nom_agence']) ?>
                <a class="btn btn-danger" href="/touche-pas-au-klaxon/public/agences/delete/<?= $agence['id_agence'] ?>" onclick="return confirm('Supprimer cette agence ?')">Supprimer</a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <form action="/touche-pas-au-klaxon/public/agences/add" method="POST" class="w-25">
            <fieldset>
                <div class="form-group mb-2">
                    <label class="custom-secondary mb-2" for="nom_agence">Ajouter une agence :</label>
                    
                    <div class="d-flex">
                        <input 
                            class="form-control me-2" 
                            type="text" 
                            id="nom_agence" 
                            name="nom_agence" 
                            required
                        >
                        <button class="btn btn-success" type="submit">Valider</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

    <div class="mt-4 mb-2 text-center">
        <a class="btn btn-primary" href="/touche-pas-au-klaxon/public">Retour à la liste des trajets</a>
    </div>
    
<?php
$content = ob_get_clean();
$title = "Liste des agences";

require __DIR__ . '/../layout.php';