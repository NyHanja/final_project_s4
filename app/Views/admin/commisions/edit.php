<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Commission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Modifier une Commission</h2>

        <form method="post" action="<?= base_url('admin/commisions/update/' . $commission['idCommissions']) ?>">
            <div class="mb-3">
                <label class="form-label">Opérateur</label>
                <select class="form-control" name="idOperateurs" required>
                    <?php foreach ($operateurs as $o): ?>
                        <option value="<?= $o['idOperateurs'] ?>"
                                <?= ($commission['idOperateurs'] == $o['idOperateurs']) ? 'selected' : '' ?>>
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
                       value="<?= $commission['pourcentage'] ?>"
                       step="0.01" 
                       min="0" 
                       max="100" 
                       required>
            </div>

            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="<?= base_url('admin/commissions') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
