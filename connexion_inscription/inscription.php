<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Inscription</h1>

        <form action="traitement_inscription.php" method="POST">
            <fieldset>
            
                <div class="form-group">
                    <label for="username">Nom d'utilisateur : </label><br>
                    <input type="text" id="username" name="username" required><br>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail : </label><br>
                    <input type="email" id="email" name="email" required><br>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe : </label><br>
                    <input type="password" id="password" name="password" required><br>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe : </label><br>
                    <input type="password" id="confirm_password" name="confirm_password" required><br>
                </div>
            
                <button type="submit" name="submit">S’inscrire</button>
            </fieldset>

            <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
        </form>

    </div>
</body>
</html>
