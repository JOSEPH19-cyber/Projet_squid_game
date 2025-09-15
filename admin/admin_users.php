<?php
// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Récupérer les infos si l'utilisateur est connecté
if (is_admin()) {
    $user_name  = $_SESSION['user_name'] ?? null;
    $user_id    = $_SESSION['user_id'] ?? null;
    $user_email = $_SESSION['user_email'] ?? '';

    // Récupérer tous les utilisateurs
    $stmt = $pdo->prepare("SELECT user_id, user_name, user_email, registration_date FROM users WHERE is_admin = 0 ORDER BY registration_date DESC");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Voir les utlisateursa</title>
</head>
<body>
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
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['user_name']) ?></td>
                    <td><?= htmlspecialchars($user['user_email']) ?></td>
                    <td><?= htmlspecialchars($user['registration_date']) ?></td>
                    <td>
                        <a href="delete_user.php?id=<?= $user['user_id'] ?>" class="delete_btn">
                            <button type="button">Supprimer</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>