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

    <!-- Formulaire de filtre -->
    <div class="card p-3 shadow-sm mb-4">
        <form method="get" action="<?= base_url('client/historique') ?>" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Du</label>
                <input type="date" name="dateDebut" class="form-control"
                       value="<?= esc($filtres['dateDebut'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Au</label>
                <input type="date" name="dateFin" class="form-control"
                       value="<?= esc($filtres['dateFin'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Type d'opération</label>
                <select name="idTypesOperations" class="form-select">
                    <option value="">Tous</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type['idTypesOperations'] ?>"
                            <?= (($filtres['idTypesOperations'] ?? '') == $type['idTypesOperations']) ? 'selected' : '' ?>>
                            <?= esc($type['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                <a href="<?= base_url('client/historique') ?>" class="btn btn-outline-secondary">Réinitialiser</a>
            </div>

        </form>
    </div>

    <!-- Résultats -->
    <div class="card p-4 shadow-sm">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date & Heure</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Frais Payés</th>
                    <th>Rôle dans l'opération</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($operations)): foreach ($operations as $op): ?>
                    <tr>
                        <td><?= esc($op['dateOperation']) ?></td>
                        <td><?= esc($op['typeLibelle']) ?></td>
                        <td class="fw-bold"><?= number_format($op['montant'], 0, ',', ' ') ?> Ar</td>
                        <td class="text-danger"><?= number_format($op['fraisAppliques'], 0, ',', ' ') ?> Ar</td>
                        <td>
                            <?php if ((int) ($op['idSource'] ?? 0) === (int) session()->get('idUtilisateur')): ?>
                                <span class="badge bg-warning text-dark">Expéditeur</span>
                            <?php else: ?>
                                <span class="badge bg-success">Bénéficiaire</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center text-muted">Aucune opération pour ces critères.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>