<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>

    <form action="traitement_connexion.php" method="post">
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" name="submit">Se connecter</button>
    </form>

    <p>
        <a href="password_forget.php">Mot de passe oublié ?</a><br>
        <a href="inscription.php">Pas encore inscrit ? Créez un compte</a>
    </p>
</body>
</html>