<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace Client - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card p-4 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Bienvenue sur votre compte Mobile Money</h2>
                    <p class="text-muted mb-0">Numéro connecté : <?= session()->get('numeroTelephone') ?></p>
                </div>
                <a href="<?= base_url('/') ?>" class="btn btn-outline-danger">Déconnexion</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 p-4 border-start border-primary border-4 shadow-sm">
                    <h4>Mes Transactions</h4>
                    <p class="text-muted">Consultez l'historique complet de vos dépôts, retraits et transferts.</p>
                    <a href="<?= base_url('client/operations') ?>" class="btn btn-primary mt-auto">Voir mes opérations</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4 border-start border-success border-4 shadow-sm">
                    <h4>Faire un Transfert</h4>
                    <p class="text-muted">Envoyez de l'argent instantanément vers un autre numéro valide.</p>
                    <button class="btn btn-success mt-auto" disabled>Bientôt disponible</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>