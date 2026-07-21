<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types d'Opérations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="page-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="back-link">← Retour au tableau de bord</a>
            <div class="eyebrow">Administration</div>
            <h1>Types de Transactions Actifs</h1>
        </div>
        <div class="card p-4 shadow-sm" style="max-width: 500px;">
            <ul class="list-group">
                <?php if(!empty($types)): foreach($types as $t): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= esc($t['libelle']) ?>
                        <span class="badge bg-secondary rounded-pill">ID: <?= $t['idTypesOperations'] ?></span>
                    </li>
                <?php endforeach; else: ?>
                    <li class="list-group-item text-center">Aucun type d'opération actif.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types d'Opérations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="page-header">
            <a href="<?= base_url('admin/dashboard') ?>" class="back-link">← Retour au tableau de bord</a>
            <div class="eyebrow">Administration</div>
            <h1>Types de Transactions Actifs</h1>
        </div>
        <div class="card p-4 shadow-sm" style="max-width: 500px;">
            <ul class="list-group">
                <?php if(!empty($types)): foreach($types as $t): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= esc($t['libelle']) ?>
                        <span class="badge bg-secondary rounded-pill">ID: <?= $t['idTypesOperations'] ?></span>
                    </li>
                <?php endforeach; else: ?>
                    <li class="list-group-item text-center">Aucun type d'opération actif.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>