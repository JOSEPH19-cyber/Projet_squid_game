<?php
// Gestion de l'affichage des erreurs  
error_reporting(0);
ini_set('display_errors', 0);

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session()
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir vos réservations</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <table>
        <caption>Mes réservations</caption>

        <thead>
            <tr>
                <th>Nom et prénom</th>
                <th>Adresse email</th>
                <th>numero de téléphone</th>
                <th>Date de réservation</th>
                <th>Heure de réservation</th>
                <th>Activité choisie</th>
                <th>nombre</th>
                <th>Il sera vide on va placer le message de suppression à l'intérieur</th>
            </tr>
        </thead>

        <tbody>
            
        </tbody>
    </table>
</body>
</html>