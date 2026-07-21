<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace Client - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow-sm mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="eyebrow">Espace client</div>
                <h2 class="mb-0">Bienvenue sur votre compte Mobile Money</h2>
                <p class="text-muted mb-0">Numéro connecté : <?= esc(session()->get('numeroTelephone')) ?></p>
            </div>
            <a href="<?= base_url('/') ?>" class="btn btn-outline-danger">Déconnexion</a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Solde -->
        <div class="col-md-4">
            <div class="card action-card h-100 p-4 accent-bar shadow-sm">
                <h4>Voir mon solde</h4>
                <p class="text-muted">Consultez votre solde disponible en temps réel.</p>
                <a href="<?= base_url('client/solde') ?>" class="btn btn-primary mt-auto">Voir mon solde</a>
            </div>
        </div>

        <!-- Historique -->
        <div class="col-md-4">
            <div class="card action-card h-100 p-4 accent-bar shadow-sm">
                <h4>Mes Transactions</h4>
                <p class="text-muted">Consultez l'historique complet de vos dépôts, retraits et transferts.</p>
                <a href="<?= base_url('client/historique') ?>" class="btn btn-info mt-auto">Voir mes opérations</a>
            </div>
        </div>

        <!-- Transfert Simple -->
        <div class="col-md-4">
            <div class="card action-card h-100 p-4 accent-bar shadow-sm">
                <h4>Faire un Transfert</h4>
                <p class="text-muted">Envoyez de l'argent instantanément vers un autre numéro.</p>
                <a href="<?= base_url('client/transfert') ?>" class="btn btn-success mt-auto">Transférer</a>
            </div>
        </div>

        <!-- Transfert Multiple -->
        <div class="col-md-4">
            <div class="card action-card h-100 p-4 accent-bar shadow-sm">
                <h4>Transfert Multiple</h4>
                <p class="text-muted">Divisez et envoyez un montant équitablement entre plusieurs numéros.</p>
                <a href="<?= base_url('client/transfert-multiple') ?>" class="btn btn-primary mt-auto">Envoi groupé</a>
            </div>
        </div>

        <!-- Dépôt -->
        <div class="col-md-4">
            <div class="card action-card h-100 p-4 accent-bar shadow-sm">
                <h4>Faire un Dépôt</h4>
                <p class="text-muted">Approvisionnez votre compte mobile money.</p>
                <a href="<?= base_url('client/depot') ?>" class="btn btn-warning mt-auto">Déposer</a>
            </div>
        </div>

        <!-- Retrait -->
        <div class="col-md-4">
            <div class="card action-card h-100 p-4 accent-bar shadow-sm">
                <h4>Faire un Retrait</h4>
                <p class="text-muted">Retirez de l'argent de votre compte mobile money.</p>
                <a href="<?= base_url('client/retrait') ?>" class="btn btn-danger mt-auto">Retirer</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>