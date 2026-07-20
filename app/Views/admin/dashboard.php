```php
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Mobile Money</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .dashboard-card {
            border-radius: 15px;
            transition: transform 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .gain-card {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
        }

        .operator-card {
            border-left: 5px solid #198754;
        }

        .title {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <!-- HEADER -->
        <div class="card p-4 shadow-sm mb-4 dashboard-card">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h2 class="title">
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
                <div class="card h-100 p-4 shadow-sm dashboard-card border-start border-primary border-4">

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

                <div class="card p-4 shadow-sm dashboard-card gain-card">

                    <h4 class="mb-3">
                        Gains par opérateur
                    </h4>


                    <div class="row g-3">


                        <?php if (!empty($gains)): ?>

                            <?php foreach ($gains as $g): ?>

                                <div class="col-md-6">

                                    <div class="card text-dark p-3 operator-card shadow-sm">

                                        <h5>
                                            <?= esc($g['operateur']) ?>
                                        </h5>


                                        <div class="fs-3 fw-bold text-success">

                                            <?= number_format($g['gain'], 2) ?> Ar

                                        </div>


                                        <small class="text-muted">
                                            Gain généré
                                        </small>

                                    </div>

                                </div>

                            <?php endforeach; ?>


                        <?php else: ?>

                            <p>
                                Aucun gain enregistré.
                            </p>

                        <?php endif; ?>


                    </div>

                </div>

            </div>





            <!-- FRAIS -->
            <div class="col-md-4">

                <div class="card h-100 p-4 shadow-sm dashboard-card border-start border-info border-4">

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

                <div class="card h-100 p-4 shadow-sm dashboard-card border-start border-warning border-4">


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

                <div class="card h-100 p-4 shadow-sm dashboard-card border-start border-danger border-4">


                    <h4>
                        Préfixes
                    </h4>


                    <p class="text-muted">
                        Gestion des numéros et opérateurs.
                    </p>


                    <a href="<?= base_url('admin/prefixes') ?>">
                        Gestion des préfixes
                    </a>

                    <a href="<?= base_url('admin/commissions') ?>">
                        Gestion des commissions
                    </a>


                </div>

            </div>


        </div>

    </div>


</body>

</html>
```