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
    $user_name = $_SESSION['user_name'];
    $user_id = $_SESSION['user_id'];
    $user_email =  $_SESSION['user_email'];
}

//préparer et executer la requête pour les activités
$sql = "SELECT activity_url, activity_title, long_description FROM activities";
$stmt = $pdo->prepare($sql);
$stmt->execute();

//Récupérer les données des activités
$delices = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <main>
    <section class="activites">
        <?php foreach($delices as $delice) : ?>
            <article class="card">
                <img src="../<?= htmlspecialchars($delice['activity_url'])?>" alt="activité">
                <div class="card_description">
                    <h1><?= htmlspecialchars($delice['activity_title'])?></h1>
                    <p><?= htmlspecialchars($delice['long_description'])?></p>
                    <a href="reservation.php"><button>Réservez</button></a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>

   </main>

    
   <!-- Inclure le footer -->
   <?php require_once "../includes/footer.php"?>
</body>
</html>