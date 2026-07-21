<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Frais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="page-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="back-link">← Retour au tableau de bord</a>
            <div class="eyebrow">Administration</div>
            <h1>Configuration des Paliers de Frais</h1>
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
                        <td><?= number_format($f['montantMin'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td><?= number_format($f['montantMax'] / 100, 2, ',', ' ') ?> MGA</td>
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