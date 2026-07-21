<!DOCTYPE html>
<html>

<head>
    <title>Gestion des préfixes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>

    <div class="container py-5">

        <a href="<?= base_url('admin/dashboard') ?>" class="back-link">← Retour au tableau de bord</a>

        <div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <div class="eyebrow">Administration</div>
                <h2 class="mb-0">Gestion des préfixes opérateurs</h2>
            </div>

            <a href="<?= base_url('admin/prefixes/create') ?>" class="btn btn-primary">
                Ajouter un préfixe
            </a>
        </div>

        <div class="card p-4 shadow-sm">
        <table class="table table-bordered mb-0">

            <thead>
                <tr>
                    <th>Préfixe</th>
                    <th>Opérateur</th>
                    <th>Action</th>
                </tr>
            </thead>


            <tbody>

                <?php foreach ($prefixes as $p): ?>

                    <tr>

                        <td>
                            <?= esc($p['valeur']) ?>
                        </td>


                        <td>
                            <?= esc($p['operateur']) ?>
                        </td>


                        <td>

                            <a class="btn btn-warning btn-sm"
                                href="<?= base_url('admin/prefixes/edit/' . $p['idPrefixes']) ?>">
                                Modifier
                            </a>


                            <a class="btn btn-danger btn-sm"
                                href="<?= base_url('admin/prefixes/delete/' . $p['idPrefixes']) ?>"
                                onclick="return confirm('Supprimer ?')">
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