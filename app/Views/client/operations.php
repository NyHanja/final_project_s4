<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Opérations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="mb-4">
            <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary btn-sm">← Retour au Tableau de bord</a>
            <h1 class="mt-2">Mon Historique Personnel</h1>
        </div>

        <div class="card p-4 shadow-sm">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Montant</th>
                        <th>Frais Payés</th>
                        <th>Rôle dans l'opération</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($operations)): foreach($operations as $op): ?>
                    <tr>
                        <td><?= $op['dateOperation'] ?></td>
                        <td class="fw-bold"><?= number_format($op['montant'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td class="text-danger"><?= number_format($op['fraisAppliques'] / 100, 2, ',', ' ') ?> MGA</td>
                        <td>
                            <?php if($op['idSource'] == session()->get('idUtilisateur')): ?>
                                <span class="badge bg-warning text-dark">Expéditeur</span>
                            <?php else: ?>
                                <span class="badge bg-success">Bénéficiaire</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center text-muted">Vous n'avez effectué aucune transaction pour le moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>