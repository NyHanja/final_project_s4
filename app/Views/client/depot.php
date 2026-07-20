<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Dépôt - Mobile Money</title>
    <!-- Inclusion de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclusion des icônes Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">

    <!-- Bouton Retour -->
    <div class="mb-4">
        <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> 
            Retour au tableau de bord
        </a>
    </div>

    <!-- En-tête -->
    <header class="mb-4">
        <h2 class="text-warning fw-bold">Faire un Dépôt</h2>
        <p class="text-muted">
            Approvisionnez instantanément votre compte Mobile Money. Aucun frais n'est appliqué sur les dépôts.
        </p>
    </header>

    <!-- Formulaire autonome -->
    <div class="card glass-card p-4 shadow-sm rounded-3" style="max-width: 450px;">
        <form method="post" action="<?= base_url('client/depot') ?>">
            <?= csrf_field() ?>

            <!-- Montant -->
            <div class="mb-3">
                <label for="montant" class="form-label text-muted fw-bold text-uppercase small">Montant à déposer (Ar)</label>
                <input type="number" name="montant" id="montant" min="1" required class="form-control form-control-lg" placeholder="Ex: 5000">
            </div>

            <!-- Date de l'opération (Optionnelle, le contrôleur prend la date du jour si vide) -->
            <div class="mb-4">
                <label for="dateOperation" class="form-label text-muted fw-bold text-uppercase small">Date de l'opération (Optionnel)</label>
                <input type="datetime-local" name="dateOperation" id="dateOperation" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
                <div class="form-text">Laissez par défaut pour utiliser l'heure actuelle.</div>
            </div>

            <!-- Bouton Valider -->
            <button type="submit" class="btn btn-warning text-dark btn-lg w-100 d-flex align-items-center justify-content-center gap-2 fw-bold">
                <span class="material-symbols-outlined">payments</span>
                Confirmer le dépôt
            </button>
        </form>
    </div>

</div>
</body>
</html>