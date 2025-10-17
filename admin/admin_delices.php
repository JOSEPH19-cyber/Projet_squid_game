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


    //préparer et executer la requête pour les plats
    $plats = $pdo->prepare("SELECT delice_id, delice_url, category_type, delice_items FROM delices WHERE delice_type = 0");
    $plats->execute();
    $delices_1 = $plats->fetchAll(PDO::FETCH_ASSOC);

    //préparer et executer la requête pour les boissons
    $boissons = $pdo->prepare("SELECT delice_id, delice_url, category_type, delice_items FROM delices WHERE delice_type = 1");
    $boissons->execute();
    $delices_2 = $boissons->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Gestion des délices</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Inclure le header -->
   <?php require "admin_header.php"?>

<main>
    
    <h1>Gestion des délices</h1>

    <section class="paid_activity">
        <h2>Plats</h2>

        <?php foreach($delices_1 as $delice_1) : ?>
            <article class="card">
                <img src="../<?= htmlspecialchars($delice_1['delice_url']) ?>" alt="délice">
                <div class="card_description">
                    <h3><?= htmlspecialchars($delice_1['category_type']) ?></h3>
                    <p><?= htmlspecialchars($delice_1['delice_items']) ?></p>
                    <h4></h4>
                    <a href="delete_delice.php?id=<?= $delice_1['delice_id'] ?>">
                        <button class="delete_btn">Supprimer</button>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <section class="paid_activity">
        <h2>Boissons</h2>

        <?php foreach($delices_2 as $delice_2) : ?>
            <article class="card">
                <img src="../<?= htmlspecialchars($delice_2['delice_url']) ?>" alt="délice">
                <div class="card_description">
                    <h3><?= htmlspecialchars($delice_2['category_type']) ?></h3>
                    <p><?= htmlspecialchars($delice_2['delice_items']) ?></p>
                    <h4></h4>
                    <a href="delete_delice.php?id=<?= $delice_2['delice_id'] ?>">
                        <button class="delete_btn">Supprimer</button>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    

    <div class="add_activity_container">
        <a href="add_delice.php"><button class="add_activity_btn">Ajouter une catégorie</button></a>
    </div>

</main>
    
    <script src="admin.js"></script>
</body>
</html>
