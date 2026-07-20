<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Frais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="mb-4">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary btn-sm">← Retour</a>
            <h1 class="mt-2">Configuration des Paliers de Frais</h1>
        </div>
        <div class="card p-4 shadow-sm">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Montant Minimum</th>
                        <th>Montant Maximum</th>
                        <th>Valeur des Frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($frais)): foreach($frais as $f): ?>
                    <tr>
                        <td><?= $f['idFrais'] ?></td>
                        <td><?= number_format($f['montant1'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td><?= number_format($f['montant2'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td><?= number_format($f['valeurFrais'] / 100, 2, ',', ' ') ?> MGA</td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center">Aucun palier tarifaire configuré.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>