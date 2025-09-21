<?php

//Inclure la BDD
require_once "../includes/config-db.php";

//Inclure les fonctions de session/utilitaires
require_once "../includes/util.php";

//Démarrer la session
init_session();

//Récupérer les infos si l'utilisateur est connecté
if(is_logged())
{
    $user_name = $_SESSION['user_name'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    $user_email =  $_SESSION['user_email'] ?? '';
}

//préparer et executer la requête pour les activités payantes
$paid_activity = $pdo->prepare("SELECT activity_url, activity_title, long_description, activity_price FROM activities WHERE category = 1");
$paid_activity->execute();
$activities_1 = $paid_activity->fetchAll(PDO::FETCH_ASSOC);

//préparer et executer la requête pour les activités non payantes
$free_activity = $pdo->prepare("SELECT activity_url, activity_title, long_description FROM activities WHERE category = 0");
$free_activity->execute();
$activities_2 = $free_activity->fetchAll(PDO::FETCH_ASSOC);

// Fonction utilitaire pour générer un id propre basé sur le titre
function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text); 
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text); 
    $text = trim($text, '-');
    $text = strtolower($text);
    return !empty($text) ? $text : 'activite';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <!-- Inclure le header -->
   <?php require_once "../includes/header.php"?>

   <main>

    <h1>Découvrez nos activités</h1>

    <section class="paid_activity">
        <h2>Activités payantes</h2>

        <?php foreach($activities_1 as $activity_1) : 
            $id = "activite-" . slugify($activity_1['activity_title']);
        ?>
            <article class="card" id="<?= htmlspecialchars($id) ?>">
                <img src="../<?= htmlspecialchars($activity_1['activity_url'])?>" alt="activité">
                <div class="card_description">
                    <h3><?= htmlspecialchars($activity_1['activity_title'])?></h3>
                    <p><?= htmlspecialchars($activity_1['long_description'])?></p>
                    <h4><?= htmlspecialchars($activity_1['activity_price'])?>$</h4>
                    <a href="reservation.php"><button>Réservez</button></a>
                </div>
            </article>
        <?php endforeach; ?>
        
    </section>

    <section class="free_activity">
        <h2>Activités gratuites</h2>

        <?php foreach($activities_2 as $activity_2) : 
            $id = "activite-" . slugify($activity_2['activity_title']);
        ?>
            <article class="card" id="<?= htmlspecialchars($id) ?>">
                <img src="../<?= htmlspecialchars($activity_2['activity_url'])?>" alt="activité">
                <div class="card_description">
                    <h3><?= htmlspecialchars($activity_2['activity_title'])?></h3>
                    <p><?= htmlspecialchars($activity_2['long_description'])?></p>
                </div>
            </article>
        <?php endforeach; ?>
        
    </section>
   </main>

    
   <!-- Inclure le footer -->
   <?php require_once "../includes/footer.php"?>

   <script src="../assets/script.js"></script>
</body>
</html>
