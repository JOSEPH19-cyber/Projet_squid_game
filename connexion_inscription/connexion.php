<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <h1>Connexion</h1>

        <form action="traitement_connexion.php" method="post">
        
            <fieldset>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="submit">Se connecter</button>
            </fieldset>

            <p>
                <a href="inscription.php">Pas encore inscrit ? Créez un compte</a>
            </p>
       
        </form>

    </div>
    
</body>
</html>