<?php
// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Récupérer les infos si l'utilisateur est connecté
if (is_admin()) 
{
    $user_name  = $_SESSION['user_name'] ?? null;
    $user_id    = $_SESSION['user_id'] ?? null;
    $user_email = $_SESSION['user_email'] ?? '';

    // Récupérer tous les utilisateurs
    $stmt = $pdo->prepare("SELECT user_id, user_name, user_email, registration_date FROM users WHERE is_admin = 1 ORDER BY registration_date DESC");
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Supprimer un administrateur
    if(isset($_GET['id']))
    {
        $id_to_delete = intval($_GET['id']);

        if ($id_to_delete !== $user_id)
        {
            $traitement = $pdo->prepare("DELETE FROM users WHERE user_id = :id AND is_admin = 1");
            $traitement->execute([':id' => $id_to_delete]);

            if ($traitement->rowCount() > 0)
            {
                echo "<script>alert('Administrateur supprimé !'); window.location.href='settings.php';</script>";
                exit;
            }
        }
        else{
            echo "<script>alert('Vous ne pouvez pas vous supprimer !'); window.location.href='settings.php';</script>";
            exit;
        }
    }

    //Insérer un administrateur
    if(isset($_POST['submit']))
    {
        // Récupérer les données envoyées par le formulaire
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Vérifier que les champs ne sont pas vides
        if(!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password))
        {
            // Vérifier que les mots de passe correspondent
            if($password === $confirm_password)
            {
                // Vérifier si l’email existe déjà
                $emailCheckStmt = $pdo->prepare("SELECT user_id FROM users WHERE user_email = :email");
                $emailCheckStmt->bindParam(":email", $email);
                $emailCheckStmt->execute();
                $user = $emailCheckStmt->fetch();

                if($user) 
                {
                    echo "<script>alert('Cet administrateur existe déjà.');</script>";
                }
                else
                {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (user_name, user_email, user_password, is_admin) VALUES (:username, :email, :password, 1)");
                    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword]);

                    echo "<script>
                            alert('Insertion réussie !');
                        </script>";
                }
            }
            else
            {
                echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
            }
        }
        else
        {
            echo "<script>alert('Veuillez remplir tous les champs.');</script>";
        }
    }

}
else
{
    echo "<script>
            alert(\"Vous n'êtes pas connecté. Veuillez vous connecter pour acceder à cette page.\");
            window.location.href = '../connexion_inscription/connexion.php';
          </script>";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres administrateurs</title>
</head>
<body>
    <h1>Gestion des administrateurs</h1>

    <!-- Liste des admins -->
    <h2>Liste des administrateurs</h2>

    <section class="table">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date d’inscription</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['user_name']) ?></td>
                    <td><?= htmlspecialchars($admin['user_email']) ?></td>
                    <td><?= htmlspecialchars($admin['registration_date']) ?></td>
                    <td>
                        <?php if ($admin['user_id'] !== $user_id): ?>
                            <a href="settings.php?id=<?= $admin['user_id'] ?>" class="delete_btn">
                                <button type="button">Supprimer</button>
                            </a>
                        <?php else: ?>
                            <em>(vous-même)</em>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section>
        <!-- Ajouter un admin -->
        <h2>Ajouter un administrateur</h2>

        <form method="post" action="">

            <fieldset>
            <legend>Insertion</legend>

                <label for="username">Nom d'utilisateur : </label><br>
                <input type="text" id="username" name="username" required><br>

                <label for="email">Adresse e-mail : </label><br>
                <input type="email" id="email" name="email" required><br>

                <label for="password">Mot de passe : </label><br>
                <input type="password" id="password" name="password" required><br>

                <label for="confirm_password">Confirmer le mot de passe : </label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br>

                <button type="submit" name="submit">Ajouter</button>
            </fieldset>
        </form>

    </section>
</body>
</html>