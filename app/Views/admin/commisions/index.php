<!DOCTYPE html>
<html>

<head>

    <title>Commissions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

</head>


<body>


    <div class="container py-5">

        <a href="<?= base_url('admin/dashboard') ?>" class="back-link">← Retour au tableau de bord</a>

        <div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <div class="eyebrow">Administration</div>
                <h2 class="mb-0">
                    Commission des autres opérateurs
                </h2>
            </div>

            <a href="<?= base_url('admin/commissions/create') ?>" class="btn btn-primary">
                Ajouter commission
            </a>
        </div>


        <div class="card p-4 shadow-sm">
        <table class="table table-bordered mb-0">


            <thead>
            <tr>

                <th>
                    Opérateur
                </th>


                <th>
                    Pourcentage
                </th>


                <th>
                    Action
                </th>


            </tr>
            </thead>

            <tbody>
            <?php foreach ($commissions as $c): ?>


                <tr>


                    <td>

                        <?= $c['nom'] ?>

                    </td>


                    <td>

                        <?= $c['pourcentage'] ?> %

                    </td>



                    <td>


                        <a href="<?= base_url('admin/commissions/edit/' . $c['idCommissions']) ?>"
                            class="btn btn-warning btn-sm">

                            Modifier

                        </a>



                        <a href="<?= base_url('admin/commissions/delete/' . $c['idCommissions']) ?>"
                            class="btn btn-danger btn-sm">

                            Supprimer

                        </a>


                    </td>



                </tr>


            <?php endforeach; ?>
            </tbody>


        </table>
        </div>


    </div>


</body>

</html>