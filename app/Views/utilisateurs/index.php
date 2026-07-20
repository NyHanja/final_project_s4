<?php
    echo WRITEPATH . 'database.db';
    echo '<br>';

    var_dump(file_exists(WRITEPATH . 'database.db'));

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mobile Money</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #666;
            font-weight: 600;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #0056b3;
        }
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Espace Mobile Money</h2>
    <p style="text-align: center; color: #777; font-size: 14px; margin-bottom: 25px;">
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
        
        <div class="form-group">
            <label for="numeroTelephone">Numéro de téléphone</label>
            <input 
                type="text" 
                id="numeroTelephone" 
                name="numeroTelephone" 
                placeholder="Ex: 0812345678 ou +243..." 
                required
                autocomplete="off"
            >
        </div>

        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>