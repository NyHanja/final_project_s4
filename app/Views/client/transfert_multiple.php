<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi Multiple - Mobile Money</title>
    <!-- Inclusion de Bootstrap (identique au dashboard) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclusion des icônes Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">

    <!-- Bouton Retour -->
    <div class="mb-4">
        <a href="<?= base_url('client/transfert') ?>" class="btn btn-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> 
            Retour au transfert simple
        </a>
    </div>

    <!-- En-tête -->
    <header class="mb-4">
        <h2 class="text-primary fw-bold">Envoi multiple</h2>
        <p class="text-muted">
            Le montant total est divisé équitablement entre tous les numéros. Réservé aux numéros de notre réseau.
        </p>
    </header>

    <!-- Formulaire autonome -->
    <div class="card glass-card p-4 shadow-sm rounded-3" style="max-width: 500px;">
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
                        <button type="button" class="btn btn-outline-danger btn-supprimer-numero d-flex align-items-center justify-content-center" style="width: 40px;" title="Retirer">
                            <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                        </button>
                    </div>
                    <!-- Numéro 2 -->
                    <div class="d-flex gap-2 numero-ligne">
                        <input type="text" name="numeros[]" required class="form-control" placeholder="037 98 765 43">
                        <button type="button" class="btn btn-outline-danger btn-supprimer-numero d-flex align-items-center justify-content-center" style="width: 40px;" title="Retirer">
                            <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                        </button>
                    </div>
                </div>

                <!-- Bouton ajouter -->
                <button type="button" id="btnAjouterNumero" class="btn btn-link btn-sm p-0 mt-2 text-decoration-none d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined" style="font-size: 18px;">add_circle</span>
                    Ajouter un numéro
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
            <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                <span class="material-symbols-outlined">group_add</span>
                Envoyer à tous
            </button>
        </form>
    </div>

</div>

<!-- Votre script dynamique adapté à Bootstrap -->
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
            <button type="button" class="btn btn-outline-danger btn-supprimer-numero d-flex align-items-center justify-content-center" style="width: 40px;" title="Retirer">
                <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
            </button>
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