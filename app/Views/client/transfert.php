<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Transfert - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="mb-4">
        <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary btn-sm">← Retour au tableau de bord</a>
        <h1 class="mt-2">Faire un transfert</h1>
    </div>

    <div class="card p-4 shadow-sm">
        <form method="post" action="<?= base_url('client/transfert') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="numeroTelephone" class="form-label">Numéro du destinataire</label>
                <input type="text" class="form-control" id="numeroTelephone" name="numeroTelephone" required>
            </div>
            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" class="form-control" id="montant" name="montant" min="1" required>
            </div>
            <div class="mb-3">
                <label for="dateOperation" class="form-label">Date</label>
                <input type="datetime-local" class="form-control" id="dateOperation" name="dateOperation" value="<?= date('Y-m-d\TH:i') ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Valider le transfert</button>
        </form>
    </div>
</div>
</body>
</html>
