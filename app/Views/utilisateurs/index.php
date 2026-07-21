<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body>

<div class="auth-shell">
    <div class="auth-card">
        <div class="brand-mark">Mobile Money</div>
        <h2>Espace Mobile Money</h2>
        <p class="subtitle">
            Entrez votre numéro de téléphone pour accéder à votre compte.
        </p>

        <!-- Affichage de l'erreur envoyée par le contrôleur -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <!-- Affichage du succès s'il y en a un -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= esc($success) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire qui pointe vers la méthode login du contrôleur -->
        <form action="<?= base_url('/login') ?>" method="POST">
            <?= csrf_field() ?> <!-- Protection Sécurité CSRF obligatoire dans CI4 -->

            <div class="mb-3">
                <label for="numeroTelephone" class="form-label">Numéro de téléphone</label>
                <input
                    type="text"
                    id="numeroTelephone"
                    name="numeroTelephone"
                    class="form-control form-control-lg"
                    placeholder="Ex: 0812345678 ou +243..."
                    required
                    autocomplete="off"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Se connecter</button>
        </form>
    </div>
</div>

</body>
</html>
