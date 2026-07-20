<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-4 shadow-sm mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Tableau de bord administrateur</h2>
                <p class="text-muted mb-0">Gestion du système Mobile Money</p>
            </div>
            <a href="<?= base_url('/') ?>" class="btn btn-outline-danger">Déconnexion</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 p-4 border-start border-primary border-4 shadow-sm">
                <h4>Vue Globale</h4>
                <p class="text-muted">Gestion complète du système.</p>
                <a href="<?= base_url('admin/operations') ?>" class="btn btn-primary mt-auto">Voir l'historique</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 p-4 border-start border-success border-4 shadow-sm">
                <h4>Gain Total</h4>
                <p class="text-muted">Montant cumulé des frais appliqués.</p>
                <div class="fs-4 fw-bold text-success"><?= number_format($gain ?? 0, 2) ?> Ar</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 p-4 border-start border-info border-4 shadow-sm">
                <h4>Grille Tarifaire</h4>
                <p class="text-muted">Configuration des frais.</p>
                <a href="<?= base_url('admin/frais') ?>" class="btn btn-info mt-auto">Gérer les frais</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 p-4 border-start border-warning border-4 shadow-sm">
                <h4>Configurations</h4>
                <p class="text-muted">Types de transactions autorisées.</p>
                <a href="<?= base_url('admin/types-operations') ?>" class="btn btn-warning mt-auto">Voir les types</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 p-4 border-start border-danger border-4 shadow-sm">
                <h4>Préfixes</h4>
                <p class="text-muted">Gestion des numéros et opérateurs.</p>
                <a href="<?= base_url('admin/prefixes') ?>" class="btn btn-danger mt-auto">Gérer les préfixes</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>