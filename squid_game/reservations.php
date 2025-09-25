<?php
// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Récupérer les infos si l'utilisateur est connecté
if (is_logged()) {
    $user_name  = $_SESSION['user_name'] ?? null;
    $user_id    = $_SESSION['user_id'] ?? null;
    $user_email = $_SESSION['user_email'] ?? '';

    $stmt = $pdo->prepare("
    SELECT r.*, a.activity_title, a.activity_price, u.user_email
    FROM reservations r
    JOIN activities a ON r.activity_id = a.activity_id
    JOIN users u ON r.user_id = u.user_id
    WHERE r.user_id = :user_id
    ORDER BY r.reservation_date DESC, r.reservation_time DESC;
    ");
    $stmt->execute([':user_id' => $user_id]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
} 
else 
{
    echo "<script>
            alert(\"Vous n'êtes pas connecté. Veuillez vous connecter pour passer une réservation.\");
            window.location.href = '../connexion_inscription/connexion.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir vos réservations</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="table">
        <table>
            <caption>Mes réservations</caption>

            <thead>
                <tr>
                    <th>Nom et prénom</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Date de réservation</th>
                    <th>Heure de réservation</th>
                    <th>Activité choisie</th>
                    <th>Nombre</th>
                    <th>Prix</th>
                    <th>Prix total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($reservations) > 0): ?>
                    <?php foreach ($reservations as $res) : ?>
                        <tr>
                            <td data-label="Nom et prénom"><?= htmlspecialchars($res['full_name']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($res['user_email']) ?></td>
                            <td data-label="Numéro de téléphone"><?= htmlspecialchars($res['phone_number']) ?></td>
                            <td data-label="Date de réservation"><?= htmlspecialchars($res['reservation_date']) ?></td>
                            <td data-label="Heure de réservation"><?= htmlspecialchars($res['reservation_time']) ?></td>
                            <td data-label="Activité choisie"><?= htmlspecialchars($res['activity_title']) ?></td>
                            <td data-label="Nombre"><?= htmlspecialchars($res['number']) ?></td>
                            <td data-label="Prix"><?= htmlspecialchars($res['activity_price']) ?>$</td>
                            <td data-label="Prix total"><?= htmlspecialchars($res['activity_price'] * $res['number']) ?>$</td>
                            <td data-label="Action">
                                <a href="delete_reservation.php?id=<?= urlencode($res['reservation_id']) ?>" 
                                    class="delete_btn"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10"><em>Aucune réservation trouvée.</em></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
