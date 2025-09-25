<?php

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions de session/utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Vérifier si l'admin est connecté
if(is_admin()) {
    $user_name = $_SESSION['user_name'] ?? null;
    $user_id   = $_SESSION['user_id'] ?? null;
    $user_email= $_SESSION['user_email'] ?? '';


    // Préparer et exécuter la requête pour les activités payantes
    $paid_activity = $pdo->prepare("SELECT activity_id, activity_url, activity_title, long_description, activity_price FROM activities WHERE category = 1");
    $paid_activity->execute();
    $activities_1 = $paid_activity->fetchAll(PDO::FETCH_ASSOC);

    // Préparer et exécuter la requête pour les activités gratuites
    $free_activity = $pdo->prepare("SELECT activity_id, activity_url, activity_title, long_description FROM activities WHERE category = 0");
    $free_activity->execute();
    $activities_2 = $free_activity->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Gestion des Activités</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Inclure le header -->
   <?php require "admin_header.php"?>

<main>
    
    <h1>Gestion des activités</h1>

    <section class="paid_activity">
        <h2>Activités payantes</h2>

        <?php foreach($activities_1 as $activity_1) : ?>
            <article class="card">
                <img src="../<?= htmlspecialchars($activity_1['activity_url']) ?>" alt="activité">
                <div class="card_description">
                    <h3><?= htmlspecialchars($activity_1['activity_title']) ?></h3>
                    <p><?= htmlspecialchars($activity_1['long_description']) ?></p>
                    <h4><?= htmlspecialchars($activity_1['activity_price']) ?>$</h4>
                    <a href="delete_activity.php?id=<?= $activity_1['activity_id'] ?>">
                        <button class="delete_btn">Supprimer</button>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <section class="free_activity">
        <h2>Activités gratuites</h2>

        <?php foreach($activities_2 as $activity_2) : ?>
            <article class="card">
                <img src="../<?= htmlspecialchars($activity_2['activity_url']) ?>" alt="activité">
                <div class="card_description">
                    <h3><?= htmlspecialchars($activity_2['activity_title']) ?></h3>
                    <p><?= htmlspecialchars($activity_2['long_description']) ?></p>
                    <a href="delete_activity.php?id=<?= $activity_2['activity_id'] ?>">
                        <button class="delete_btn">Supprimer</button>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <div class="add_activity_container">
        <a href="add_activity.php"><button class="add_activity_btn">Ajouter une activité</button></a>
    </div>

</main>
    
    <script src="admin.js"></script>
</body>
</html>
