<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon solde - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <?php if (!$utilisateur): ?>
                        <p class="text-danger">Utilisateur introuvable (id invalide).</p>
                    <?php else: ?>
                        <h5 class="text-muted mb-1">
                            <?= esc($utilisateur->prenom) ?> <?= esc($utilisateur->nom) ?>
                        </h5>
                        <p class="text-muted small mb-4">
                            <?= esc($utilisateur->numeroTelephone) ?>
                        </p>

                        <p class="mb-1">Solde disponible</p>
                        <h1 class="display-5 fw-bold text-success">
                            <?= number_format($solde, 0, ',', ' ') ?> Ar
                        </h1>
                    <?php endif; ?>

                </div>
            </div>

            <div class="text-center mt-3">
                <a href="/test/solde/1" class="btn btn-sm btn-outline-primary">Client A</a>
                <a href="/test/solde/2" class="btn btn-sm btn-outline-primary">Client B</a>
                <a href="/test/solde/3" class="btn btn-sm btn-outline-primary">Client C</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>