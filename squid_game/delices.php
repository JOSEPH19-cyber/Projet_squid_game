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

//préparer et executer la requête pour les délices
$sql = $pdo->prepare("SELECT delice_url, category_type, delice_items FROM delices");
$sql->execute();

//Récupérer les données des activités
$delices = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Délices</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <!-- Inclure le header -->
   <?php require_once "../includes/header.php"?>

   <main>
    <section class="delices">
        <h1>Découvrez nos délices</h1>

        <?php foreach($delices as $delice) : ?>
            <article class="card">
                <img src="../<?= htmlspecialchars($delice['delice_url'])?>" alt="délice">
                <div class="card_description">
                    <h1><?= htmlspecialchars($delice['category_type'])?></h1>
                    <p><?= htmlspecialchars($delice['delice_items'])?></p>
                    <a href="../docs/Projet_Squid_Game_Menu.pdf" target="_blank"><button>Voir les prix</button></a>
                </div>
            </article>
        <?php endforeach; ?>
        
    </section>
   </main>

    
   <!-- Inclure le footer -->
   <?php require_once "../includes/footer.php"?>
</body>
</html>