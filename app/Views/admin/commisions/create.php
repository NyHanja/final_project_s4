<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Commission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <a href="<?= base_url('admin/commissions') ?>" class="back-link">← Retour aux commissions</a>
        <div class="eyebrow">Administration</div>
        <h2 class="mb-4">Ajouter une Commission</h2>

        <div class="card p-4 shadow-sm" style="max-width: 480px;">
        <form method="post" action="<?= base_url('admin/commisions/store') ?>">
            <div class="mb-3">
                <label class="form-label">Opérateur</label>
                <select class="form-control" name="idOperateurs" required>
                    <option value="">-- Sélectionner un opérateur --</option>
                    <?php foreach ($operateurs as $o): ?>
                        <option value="<?= $o['idOperateurs'] ?>">
                            <?= $o['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Pourcentage (%)</label>
                <input type="number" 
                       class="form-control" 
                       name="pourcentage" 
                       step="0.01" 
                       min="0" 
                       max="100" 
                       required>
            </div>

            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="<?= base_url('admin/commissions') ?>" class="btn btn-secondary">Annuler</a>
        </form>
        </div>
    </div>
</body>
</html>
