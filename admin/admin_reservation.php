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
    SELECT r.*, a.activity_title, a.activity_price, u.user_email
    FROM reservations r
    JOIN activities a ON r.activity_id = a.activity_id
    JOIN users u ON r.user_id = u.user_id
    ORDER BY r.reservation_date DESC, r.reservation_time DESC;
    ");
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Les réservations</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="table">
        <table>
            <caption>Les réservations</caption>

            <thead>
                <tr>
                    <th>Nom et prénom</th>
                    <th>Email</th>
                    <th>Numero de téléphone</th>
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
                <?php foreach ($reservations as $res) : ?>
                    <tr>
                        <td><?= htmlspecialchars($res['full_name']) ?></td>
                        <td><?= htmlspecialchars($res['user_email']) ?></td>
                        <td><?= htmlspecialchars($res['phone_number']) ?></td>
                        <td><?= htmlspecialchars($res['reservation_date']) ?></td>
                        <td><?= htmlspecialchars($res['reservation_time']) ?></td>
                        <td><?= htmlspecialchars($res['activity_title']) ?></td>
                        <td><?= htmlspecialchars($res['number']) ?></td>
                        <td><?= htmlspecialchars($res['activity_price']) ?></td>
                        <td><?= htmlspecialchars($res['activity_price'] * $res['number']) ?> $</td>
                        <td>
                            <a href="delete_reservation.php?id=<?= urlencode($res['reservation_id']) ?>" 
                                class="delete_btn"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>