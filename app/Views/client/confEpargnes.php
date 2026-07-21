

</html>
    <!-- En-tête -->
    <header class="mb-4">
        <h2 class="text-warning fw-bold">Faire un Dépôt</h2>
        <p class="text-muted">
            Approvisionnez instantanément votre compte Mobile Money. Aucun frais n'est appliqué sur les dépôts.
        </p>
    </header>

    <!-- Formulaire autonome -->
    <div class="card glass-card p-4 shadow-sm rounded-3" style="max-width: 450px;">
        <form method="post" action="<?= base_url('client/epargnes') ?>">
            <?= csrf_field() ?>

            <!-- Montant -->
            <div class="mb-3">
                <label for="montant" class="form-label text-muted fw-bold text-uppercase small">Montant à déposer (Ar)</label>
                <input type="number" name="pourcentages" id="montant" min="1" required class="form-control form-control-lg" placeholder="Ex: 5000" value="<?=$conf['pourcentage']?> ?>">
            </div>
            <input type="hidden" name="idUtilisateur" value='<?= $conf['idUtilisateur'] ?>'>
            <input type="hidden" name="id" value='<?= $conf['idConfigEpargnes'] ?>'>

            <!-- Date de l'opération (Optionnelle, le contrôleur prend la date du jour si vide) -->
    

            <!-- Bouton Valider -->
            <button type="submit" class="btn btn-warning text-dark btn-lg w-100 d-flex align-items-center justify-content-center gap-2 fw-bold">
                <span class="material-symbols-outlined">payments</span>
                Confirmer le dépôt
            </button>
        </form>
    </div>

</div>
</body>
</html>