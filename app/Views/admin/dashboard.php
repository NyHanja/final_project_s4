<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tableau de Bord Administrateur</h1>
            <a href="<?= base_url('/') ?>" class="btn btn-danger">Déconnexion</a>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3">
                    <h3>Vue Globale</h3>
                    <p>Gestion complète du système.</p>
                    <a href="<?= base_url('admin/operations') ?>" class="text-white">Voir l'historique →</a>
                </div>
            </div>
                <div class="card bg-primary text-white p-3">
                    <h3>Gain Total</h3>
                    <p><?= number_format($gain, 2) ?> Ar</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white p-3">
                    <h3>Grille Tarifaire</h3>
                    <p>Configuration des frais.</p>
                    <a href="<?= base_url('admin/frais') ?>" class="text-white">Gérer les frais →</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark p-3">
                    <h3>Configurations</h3>
                    <p>Types de transactions autorisées.</p>
                    <a href="<?= base_url('admin/types-operations') ?>" class="text-dark">Voir les types →</a>
                </div>
            </div>
        </div>
        <a href="<?= base_url('admin/prefixes') ?>">
    Gestion des préfixes
</a>
    </div>
</body>
</html>