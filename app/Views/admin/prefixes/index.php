<!DOCTYPE html>
<html>

<head>
    <title>Gestion des préfixes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">


        <h2>Gestion des préfixes opérateurs</h2>

        <a href="<?= base_url('admin/prefixes/create') ?>" class="btn btn-primary mb-3">
            Ajouter un préfixe
        </a>


        <table class="table table-bordered bg-white">

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

</body>

</html>