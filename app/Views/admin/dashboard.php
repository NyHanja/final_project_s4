
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Mobile Money</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>

    <div class="container py-5">

        <!-- HEADER -->
        <div class="card p-4 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="eyebrow">Espace administrateur</div>
                    <h2 class="mb-0">
                        Tableau de bord administrateur
                    </h2>

                    <p class="text-muted mb-0">
                        Gestion du système Mobile Money
                    </p>
                </div>


                <a href="<?= base_url('/') ?>" class="btn btn-outline-danger">
                    Déconnexion
                </a>

            </div>
        </div>



        <div class="row g-4">


            <!-- OPERATIONS -->
            <div class="col-md-4">
                <div class="card action-card h-100 p-4 shadow-sm accent-bar">

                    <h4>
                        Vue Globale
                    </h4>

                    <p class="text-muted">
                        Gestion complète du système.
                    </p>

                    <a href="<?= base_url('admin/operations') ?>" class="btn btn-primary mt-auto">

                        Voir l'historique

                    </a>

                </div>
            </div>



            <!-- GAINS PAR OPERATEUR -->
            <div class="col-md-8">

                <div class="card p-4 shadow-sm summary-card">

                    <h4 class="mb-3">
                        Gains par opérateur
                    </h4>


                    <div class="row g-3">


                        <?php if (!empty($gains)): ?>

                            <?php foreach ($gains as $g): ?>

                                <div class="col-md-6">

                                    <div class="card stat-card text-dark p-3 shadow-sm">

                                        <div class="stat-label"><?= esc($g['operateur']) ?></div>

                                        <div class="stat-value">

                                            <?= number_format($g['gain'], 2) ?> Ar

                                        </div>


                                        <small class="text-muted">
                                            Gain généré
                                        </small>

                                    </div>

                                </div>

                            <?php endforeach; ?>


                        <?php else: ?>

                            <p class="text-white-50 mb-0">
                                Aucun gain enregistré.
                            </p>

                        <?php endif; ?>


                    </div>

                </div>

            </div>





            <!-- FRAIS -->
            <div class="col-md-4">

                <div class="card action-card h-100 p-4 shadow-sm accent-bar">

                    <h4>
                        Grille Tarifaire
                    </h4>

                    <p class="text-muted">
                        Configuration des frais.
                    </p>


                    <a href="<?= base_url('admin/frais') ?>" class="btn btn-info mt-auto">

                        Gérer les frais

                    </a>

                </div>

            </div>





            <!-- TYPES OPERATIONS -->
            <div class="col-md-4">

                <div class="card action-card h-100 p-4 shadow-sm accent-bar">


                    <h4>
                        Configurations
                    </h4>


                    <p class="text-muted">
                        Types de transactions autorisées.
                    </p>


                    <a href="<?= base_url('admin/types-operations') ?>" class="btn btn-warning mt-auto">

                        Voir les types

                    </a>


                </div>

            </div>





            <!-- PREFIXES -->
            <div class="col-md-4">

                <div class="card action-card h-100 p-4 shadow-sm accent-bar">


                    <h4>
                        Préfixes
                    </h4>


                    <p class="text-muted">
                        Gestion des numéros et opérateurs.
                    </p>


                    <div class="d-flex flex-column gap-2 mt-auto">
                        <a href="<?= base_url('admin/prefixes') ?>" class="btn btn-outline-primary btn-sm">
                            Gestion des préfixes
                        </a>

                        <a href="<?= base_url('admin/commissions') ?>" class="btn btn-outline-primary btn-sm">
                            Gestion des commissions
                        </a>
                    </div>


                </div>

            </div>


        </div>

    </div>


</body>

</html>
```