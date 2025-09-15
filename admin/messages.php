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

    $stmt = $pdo->prepare("
    SELECT m.message_id, m.message, m.message_created_at, 
       u.user_name, u.user_email
    FROM messages m
    JOIN users u ON m.user_id = u.user_id
    ORDER BY m.message_created_at DESC;

    ");
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Supprimer un message
    if (isset($_GET['id'])) 
    {
        $id_to_delete = intval($_GET['id']);

        $traitement = $pdo->prepare("DELETE FROM messages WHERE message_id = :id");
        $traitement->execute([':id' => $id_to_delete]);

        if ($traitement->rowCount() > 0) 
        {
            echo "<script>
                    alert('Le message a été supprimé !');
                    window.location.href='messages.php';
                </script>";
            exit;
        }
        else 
        {
            echo "<script>
                alert('Ce message n\'existe pas ou a déjà été supprimé.');
                window.location.href='messages.php';
            </script>";
            exit;
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

<<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lire les messages</title>
</head>
<body>
    <main>
        <h1>Messages reçus</h1>

        <?php if (count($messages) > 0): ?>
            <?php foreach ($messages as $mes): ?>
                <section class="user_info">
                    <h2><?= htmlspecialchars($mes['user_name']) ?>, 
                        <?= htmlspecialchars($mes['user_email']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($mes['message'])) ?></p>
                    <small>Reçu le : <?= htmlspecialchars($mes['message_created_at']) ?></small><br>

                    <a href="messages.php?id=<?= urlencode($mes['message_id']) ?>" 
                       class="delete_btn"
                       onclick="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                       Supprimer
                    </a>
                </section>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun message trouvé.</p>
        <?php endif; ?>
    </main>
</body>
</html>