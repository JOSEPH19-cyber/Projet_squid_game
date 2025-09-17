<?php
require_once "../includes/config-db.php";
require_once "../includes/util.php";
init_session();

if (is_admin()) {

    function qOne($pdo, $sql, $params = []) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function qAll($pdo, $sql, $params = []) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Statistiques
    $totalActivities = (int)(qOne($pdo, "SELECT COUNT(*) AS cnt FROM activities")['cnt'] ?? 0);
    $mostBookedActivity = qOne($pdo, "
        SELECT a.activity_title, COUNT(r.reservation_id) AS total_res
        FROM reservations r
        JOIN activities a ON r.activity_id = a.activity_id
        GROUP BY a.activity_id
        ORDER BY total_res DESC
        LIMIT 1
    ");
    $categoriesDelices = qAll($pdo, "SELECT DISTINCT category_type FROM delices");
    $popularCategoryManual = "Gastronomie congolaise";
    $totalReservations = (int)(qOne($pdo, "SELECT COUNT(*) AS cnt FROM reservations")['cnt'] ?? 0);
    $topUserByReservations = qOne($pdo, "
        SELECT u.user_name, COUNT(r.reservation_id) AS total_res
        FROM reservations r
        JOIN users u ON r.user_id = u.user_id
        GROUP BY u.user_id
        ORDER BY total_res DESC
        LIMIT 1
    ");
    $totalUsers = (int)(qOne($pdo, "SELECT COUNT(*) AS cnt FROM users")['cnt'] ?? 0);
    $mostActiveUser = $topUserByReservations;

    $last3Activities = qAll($pdo, "SELECT activity_title FROM activities ORDER BY activity_created_at DESC LIMIT 3");
    $last3Reservations = qAll($pdo, "
        SELECT r.full_name, a.activity_title, r.reservation_date
        FROM reservations r
        JOIN activities a ON r.activity_id = a.activity_id
        ORDER BY r.reservation_date DESC, r.reservation_time DESC
        LIMIT 3
    ");
    $last3Users = qAll($pdo, "SELECT user_name FROM users ORDER BY registration_date DESC LIMIT 3");

} else {
    header("Location: ../connexion_inscription/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar">
    <div class="dashboard_logo"><h2>LOGO</h2></div>
    <nav class="nav-links">
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i>Accueil</a></li>
            <li><a href="admin_activities.php"><i class="fas fa-gamepad"></i> Activités</a></li>
            <li><a href=""><i class="fas fa-utensils"></i> Délices</a></li>
            <li><a href="admin_reservation.php"><i class="fas fa-calendar-alt"></i> Réservations</a></li>
            <li><a href="admin_users.php"><i class="fas fa-users"></i> Utilisateurs</a></li>
            <li><a href="settings.php"><i class="fas fa-cog"></i> Paramètres</a></li>
            <li><a href="../connexion_inscription/deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
    </nav>
</aside>

<!-- Contenu principal -->
<main class="dashboard">
<header class="dashboard-header">
    <h1>Tableau de bord Administrateur</h1>
</header>

<!-- Statistiques rapides -->
<section class="stats">
    <div class="stat-card">
        <h3>Activités</h3>
        <p class="stat-value"><?= $totalActivities ?></p>
        <small>Activité la plus réservée : <?= $mostBookedActivity['activity_title'] ?? '-' ?></small>
    </div>

    <div class="stat-card">
        <h3>Catégories des délices</h3>
        <p class="stat-value"><?= count($categoriesDelices) ?></p>
        <small>Catégorie la plus populaire : <?= $popularCategoryManual ?></small>
    </div>

    <div class="stat-card">
        <h3>Réservations</h3>
        <p class="stat-value"><?= $totalReservations ?></p>
        <small>Utilisateur avec le plus de réservations : <?= $topUserByReservations['user_name'] ?? '-' ?></small>
    </div>

    <div class="stat-card">
        <h3>Utilisateurs</h3>
        <p class="stat-value"><?= $totalUsers ?></p>
        <small>Utilisateur le plus actif : <?= $mostActiveUser['user_name'] ?? '-' ?></small>
    </div>
</section>

<!-- Contenu détaillé -->
<section class="dashboard-content">

    <!-- 3 dernières activités -->
    <div class="card">
        <h2>3 Dernières activités ajoutées</h2>
        <ul>
            <?php foreach($last3Activities as $act): ?>
                <li><?= $act['activity_title'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- 3 Dernières réservations -->
    <div class="card">
        <h2>3 Dernières réservations</h2>
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Activité</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($last3Reservations as $res): ?>
                <tr>
                    <td><?= $res['full_name'] ?></td>
                    <td><?= $res['activity_title'] ?></td>
                    <td><?= $res['reservation_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- 3 derniers utilisateurs -->
    <div class="card">
        <h2>3 Nouveaux utilisateurs</h2>
        <ul>
            <?php foreach($last3Users as $user): ?>
                <li><?= $user['user_name'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

</section>
</main>
</body>
</html>
