<?php
require __DIR__ . '/session.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Touche pas au klaxon' ?></title>
    <link rel="stylesheet" href="/touche-pas-au-klaxon/public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <header>
        <div class="container my-4">
            <?php require __DIR__ . '/components/header.php'; ?>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mt-4">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="text-center mt-auto py-3">
        <?php require __DIR__ . '/components/footer.php'; ?>
    </footer>

    <script src="/touche-pas-au-klaxon/public/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-details').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');
                    fetch(`/touche-pas-au-klaxon/public/trajet/${id}`)
                        .then(res => res.text())
                        .then(html => {
                            document.querySelector('#trajetDetails .modal-body').innerHTML = html;
                        })
                        .catch(err => {
                            document.querySelector('#trajetDetails .modal-body').innerHTML = "<p class='text-danger'>Erreur de chargement</p>";
                        });
                });
            });
        });
    </script>
</body>
</html>
