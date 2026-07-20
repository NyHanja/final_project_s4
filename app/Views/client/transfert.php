<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Transfert - Mobile Money</title>
    <!-- Inclusion de Bootstrap (comme sur votre dashboard) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclusion des icônes Google si vous les utilisez -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <style>
        /* Vos styles personnalisés si nécessaire */
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
        <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary btn-sm">← Retour au Tableau de bord</a>
    </div>

    <!-- En-tête de la page -->
    <header class="mb-4">
        <h2 class="text-primary fw-bold">Faire un transfert</h2>
        <p class="text-muted">Envoyez de l'argent vers un autre numéro Mobile Money.</p>
    </header>

    <!-- Formulaire (Adapté en classes Bootstrap pour correspondre à votre style indépendant) -->
    <div class="card glass-card p-4 shadow-sm rounded-3" style="max-width: 500px;">
        <form method="post" action="<?= base_url('client/transfert') ?>">
            <?= csrf_field() ?>

            <!-- Numéro du destinataire -->
            <div class="mb-3">
                <label class="form-label text-muted fw-bold text-uppercase small">Numéro du destinataire</label>
                <input type="text" name="numeroTelephone" required class="form-control form-control-lg" placeholder="033 12 345 67">
            </div>

            <!-- Montant -->
            <div class="mb-3">
                <label class="form-label text-muted fw-bold text-uppercase small">Montant à transférer (Ar)</label>
                <input type="number" name="montant" min="1" required class="form-control form-control-lg" placeholder="0">
            </div>

            <!-- Case à cocher pour les frais -->
            <div class="form-check p-3 bg-white rounded border mb-4">
                <input type="checkbox" name="inclureFraisRetrait" value="1" id="inclureFrais" class="form-check-input ms-0 me-2">
                <label class="form-check-label" for="inclureFrais">
                    <span class="fw-bold d-block">Inclure les frais de retrait</span>
                    <span class="text-muted small">
                        Le destinataire pourra retirer la totalité sans frais supplémentaires. Uniquement disponible si le destinataire est chez le même opérateur que vous — ignoré sinon.
                    </span>
                </label>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                <span class="material-symbols-outlined">swap_horiz</span>
                Transférer
            </button>
        </form>

        <!-- Lien transfert multiple -->
        <a href="<?= base_url('client/transfert-multiple') ?>" class="btn btn-outline-secondary btn-sm w-100 mt-3 d-flex align-items-center justify-content-center gap-2">
            <span class="material-symbols-outlined" style="font-size: 18px;">group_add</span>
            Envoyer à plusieurs numéros
        </a>
    </div>

</div>
</body>
</html>