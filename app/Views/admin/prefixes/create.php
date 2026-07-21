<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un préfixe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>
    <div class="container py-5">

        <a href="<?= base_url('admin/prefixes') ?>" class="back-link">← Retour aux préfixes</a>

        <div class="page-header">
            <div class="eyebrow">Administration</div>
            <h1>Ajouter un préfixe</h1>
        </div>

        <div class="card p-4 shadow-sm" style="max-width: 480px;">
            <form method="post" action="<?= base_url('admin/prefixes/store') ?>">

                <div class="mb-3">
                    <label class="form-label">Préfixe</label>
                    <input class="form-control" name="valeur" placeholder="033">
                </div>

                <div class="mb-3">
                    <label class="form-label">Opérateur</label>
                    <select class="form-control" name="idOperateurs">
                        <?php foreach ($operateurs as $o): ?>
                            <option value="<?= $o['idOperateurs'] ?>">
                                <?= $o['nom'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="<?= base_url('admin/prefixes') ?>" class="btn btn-secondary">Annuler</a>

            </form>
        </div>

    </div>
</body>

</html>
