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
}

//préparer et executer la requête pour les activités
$sql = "SELECT activity_url, activity_title, short_description FROM activities";
$stmt = $pdo->prepare($sql);
$stmt->execute();

//Récupérer les données des activités
$slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

//préparer et executer la requête pour les délices
$delight = "SELECT delice_url, category_type FROM delices";
$request = $pdo->prepare($delight);
$request->execute();

//Récupérer les données des délices
$delices = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
   <?php require_once "../includes/header.php"?>

   <main>
    <section class="activities">
        <h1>Découvrez nos activités</h1>

        <button class="carousel-btn prev">←</button>

        <div class="carousel">
            <?php foreach($slides as $slide) : ?>
                <article class="activity_card">
                    <img src="../<?=htmlspecialchars($slide['activity_url'])?>" alt="activités">
                    <h2><?= htmlspecialchars($slide['activity_title'])?></h2>
                    <p><?= htmlspecialchars($slide['short_description'])?></p>

                    <button class="btn-details">En savoir plus</button>
                </article>
            <?php endforeach; ?>
        </div>

        <button class="carousel-btn next">→</button>

        <div class="see-all">
            <a href="activites.php" class="btn-all">Voir toutes les activités</a>
        </div>
    </section>

    <section class="delices">
        <h1>Découvrez nos délices</h1>

        <button class="carousel-btn prev">←</button>
        
        <div class="carousel">
            <?php foreach($delices as $delice) : ?>
                <article>
                    <img src="../<?= htmlspecialchars($delice['delice_url'])?>" alt="délices">
                    <h2><?= htmlspecialchars($delice['category_type'])?></h2>

                    <p>
                        Savourez nos délices soigneusement sélectionnés pour éveiller vos papilles. 
                        Chaque catégorie vous offre une expérience gustative unique et mémorable.
                    </p>
                </article>
            <?php endforeach; ?>
        </div>

        <button class="carousel-btn next">→</button>

        <div class="see-all">
            <a href="delices.php" class="btn-all">Voir toutes les délices</a>
        </div>
    </section>

   </main>
</body>
</html>