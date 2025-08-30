<?php
require __DIR__ . '/../session.php';
ob_start();
?>
    <h1 class="custom-primary">Connexion</h1>
    <form method="POST" action="/touche-pas-au-klaxon/public/login">
        <fieldset>
            <div class="row w-25 mt-2">
                <label class="custom-primary" for="email">Email :</label>
                <input type="email" name="email" required>

                <label class="custom-primary" for="password">Mot de passe :</label>
                <input type="password" name="password" required>

                <button class="btn btn-primary mt-4" type="submit">Se connecter</button>
            </div>
        </fieldset>
    </form>

<?php
$content = ob_get_clean();
$title = "Connexion";

require __DIR__ . '/../layout.php';