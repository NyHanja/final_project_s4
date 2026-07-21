<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon solde - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-3">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-3">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <?php $user = is_array($utilisateur) ? $utilisateur : (array) $utilisateur; ?>

                    <?php if (empty($user)): ?>
                        <p class="text-danger">Utilisateur introuvable (id invalide).</p>
                    <?php else: ?>
                        <h5 class="text-muted mb-1">
                            <?= esc($user['prenom'] ?? '') ?> <?= esc($user['nom'] ?? '') ?>
                        </h5>
                        <p class="text-muted small mb-4">
                            <?= esc($user['numeroTelephone'] ?? '') ?>
                        </p>

                        <p class="mb-1">Solde disponible</p>
                        <h1 class="display-5 fw-bold text-success">
                            <?= number_format($solde, 0, ',', ' ') ?> Ar
                        </h1>
                    <?php endif; ?>

                </div>
            </div>

            <div class="text-center mt-3">
                <a href="<?= base_url('client/dashboard') ?>" class="btn btn-outline-primary">Retour au tableau de bord</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>