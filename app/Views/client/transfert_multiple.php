<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi Multiple - Mobile Money</title>
    <!-- Inclusion de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>
<div class="container py-5">

    <!-- Bouton Retour -->
    <a href="<?= base_url('client/transfert') ?>" class="back-link">← Retour au transfert simple</a>

    <!-- En-tête -->
    <header class="mb-4">
        <div class="eyebrow">Espace client</div>
        <h2>Envoi multiple</h2>
        <p class="text-muted">
            Le montant total est divisé équitablement entre tous les numéros. Réservé aux numéros de notre réseau.
        </p>
    </header>

    <!-- Formulaire autonome -->
    <div class="card p-4 shadow-sm rounded-3" style="max-width: 500px;">
        <form method="post" action="<?= base_url('client/transfert-multiple') ?>" id="formMultiple">
            <?= csrf_field() ?>

            <!-- Montant total -->
            <div class="mb-3">
                <label class="form-label text-muted fw-bold text-uppercase small">Montant total à répartir (Ar)</label>
                <input type="number" name="montantTotal" min="1" required class="form-control form-control-lg" placeholder="0">
            </div>

            <!-- Liste des destinataires -->
            <div class="mb-3">
                <label class="form-label text-muted fw-bold text-uppercase small">
                    Destinataires (même opérateur uniquement)
                </label>

                <div id="listeNumeros" class="d-flex flex-column gap-2">
                    <!-- Numéro 1 -->
                    <div class="d-flex gap-2 numero-ligne">
                        <input type="text" name="numeros[]" required class="form-control" placeholder="033 12 345 67">
                        <button type="button" class="btn btn-outline-danger btn-supprimer-numero" style="width: 40px;" title="Retirer">&times;</button>
                    </div>
                    <!-- Numéro 2 -->
                    <div class="d-flex gap-2 numero-ligne">
                        <input type="text" name="numeros[]" required class="form-control" placeholder="037 98 765 43">
                        <button type="button" class="btn btn-outline-danger btn-supprimer-numero" style="width: 40px;" title="Retirer">&times;</button>
                    </div>
                </div>

                <!-- Bouton ajouter -->
                <button type="button" id="btnAjouterNumero" class="btn btn-link btn-sm p-0 mt-2 text-decoration-none">
                    + Ajouter un numéro
                </button>
            </div>

            <!-- Paragraphe pour l'aperçu du calcul -->
            <p id="apercuMontant" class="text-primary small fw-bold mb-3"></p>

            <!-- Option frais de retrait -->
            <div class="form-check p-3 bg-white rounded border mb-4">
                <input type="checkbox" name="inclureFraisRetrait" value="1" id="inclureFrais" class="form-check-input ms-0 me-2">
                <label class="form-check-label" for="inclureFrais">
                    <span class="fw-bold d-block">Inclure les frais de retrait</span>
                    <span class="text-muted small">
                        Chaque destinataire pourra retirer sa part sans frais supplémentaires.
                    </span>
                </label>
            </div>

            <!-- Bouton envoyer -->
            <button type="submit" class="btn btn-primary btn-lg w-100">
                Envoyer à tous
            </button>
        </form>
    </div>

</div>

<!-- Script dynamique -->
<script>
(function () {
    const listeNumeros   = document.getElementById('listeNumeros');
    const btnAjouter     = document.getElementById('btnAjouterNumero');
    const inputMontant   = document.querySelector('input[name="montantTotal"]');
    const apercuMontant  = document.getElementById('apercuMontant');

    function creerLigneNumero() {
        const ligne = document.createElement('div');
        ligne.className = 'd-flex gap-2 numero-ligne';
        ligne.innerHTML = `
            <input type="text" name="numeros[]" required class="form-control" placeholder="033 12 345 67">
            <button type="button" class="btn btn-outline-danger btn-supprimer-numero" style="width: 40px;" title="Retirer">&times;</button>
        `;
        return ligne;
    }

    function majApercu() {
        const nombre = listeNumeros.querySelectorAll('.numero-ligne').length;
        const montant = parseInt(inputMontant.value || '0', 10);

        if (nombre > 0 && montant > 0) {
            const part = Math.floor(montant / nombre);
            apercuMontant.textContent = `Chaque destinataire recevra environ ${part.toLocaleString('fr-FR')} Ar (avant frais).`;
        } else {
            apercuMontant.textContent = '';
        }
    }

    function majBoutonsSuppression() {
        const lignes = listeNumeros.querySelectorAll('.numero-ligne');
        lignes.forEach(ligne => {
            const btn = ligne.querySelector('.btn-supprimer-numero');
            btn.disabled = lignes.length <= 2;
            btn.classList.toggle('opacity-30', lignes.length <= 2);
            btn.classList.toggle('disabled', lignes.length <= 2);
        });
    }

    btnAjouter.addEventListener('click', () => {
        listeNumeros.appendChild(creerLigneNumero());
        majBoutonsSuppression();
        majApercu();
    });

    listeNumeros.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-supprimer-numero');
        if (!btn || btn.disabled) return;
        btn.closest('.numero-ligne').remove();
        majBoutonsSuppression();
        majApercu();
    });

    listeNumeros.addEventListener('input', majApercu);
    inputMontant.addEventListener('input', majApercu);

    majBoutonsSuppression();
})();
</script>
</body>
</html>
