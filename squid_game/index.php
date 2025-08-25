<?php
// Gestion de l'affichage des erreurs 
error_reporting(0);
ini_set('display_errors', 0);

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
    $user_email =  $_SESSION['user_email'] ?? null;
}

//préparer et executer la requête pour les activités
$sql = $pdo->prepare("SELECT activity_url, activity_title, short_description FROM activities");
$sql->execute();

//Récupérer les données des activités
$slides = $sql->fetchAll(PDO::FETCH_ASSOC);

//préparer et executer la requête pour les délices
$delight = $pdo->prepare("SELECT delice_url, category_type FROM delices");
$delight->execute();

//Récupérer les données des délices
$delices = $delight->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <!-- Inclure le header -->
   <?php require_once "../includes/header.php"?>

   <main>
    <section class="activites">
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

    <section class="reservation">
        <h1>Réservez vos activités en ligne !</h1>

        <p>Gagnez du temps; réservez vos jeux préférés dès maintenant !</p>

        <p><a href="reservation.php">Réservez maintenant</a></p>

    </section>

    <section class="apropos">
        <h1>À propos du Parc SQUID GAME</h1>

        <p>
            Bienvenue au Parc SQUID GAME, un espace unique dédié au divertissement et à 
            l’aventure ! Inspiré de l’univers des jeux populaires, notre parc propose une 
            expérience immersive où petits et grands peuvent relever des défis amusants, 
            sportifs et stratégiques. Ici, chaque activité est conçue pour mêler adrénaline, 
            réflexion et esprit d’équipe, dans une ambiance sécurisée et conviviale. Que vous 
            soyez en famille, entre amis ou en groupe scolaire, vous trouverez des attractions 
            adaptées à tous les âges et tous les niveaux. En plus des jeux, profitez de nos espaces 
            de restauration et de détente pour savourer des plats variés et recharger vos batteries. 
            Notre objectif est simple : vous offrir des souvenirs inoubliables et une expérience de 
            loisirs hors du commun. Osez relever le défi et plongez dans l’aventure SQUID GAME !
            Le parc est ouvert de 8h à 18h
        </p>
    </section>

   </main>

   <!-- Inclure le footer -->
   <?php require_once "../includes/footer.php"?>
</body>
</html>