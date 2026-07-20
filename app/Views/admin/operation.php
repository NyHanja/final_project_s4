<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Toutes les Opérations - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="mb-4">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary btn-sm">← Retour</a>
            <h1 class="mt-2">Historique Global des Opérations</h1>
        </div>
        <div class="card p-4 shadow-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Montant (Brut)</th>
                        <th>Frais Prélevés</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Source</th>
                        <th>Destinataire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($operations)): foreach($operations as $op): ?>
                    <tr>
                        <td><?= $op['idOperations'] ?></td>
                        <td><?= number_format($op['montant'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td><?= number_format($op['fraisAppliques'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td><?= $op['dateOperation'] ?></td>
                        <td><?= $op['idTypesOperations'] ?></td>
                        <td><?= $op['idSource'] ?></td>
                        <td><?= $op['idDestinataire'] ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="7" class="text-center">Aucune transaction enregistrée.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>