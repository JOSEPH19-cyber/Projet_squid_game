<?php
// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

//vérifier si l'utilisateur est connecté
if(is_logged())
{
    clean_session();
}

//ramèner vers la page d'accueil
header('location: ../squid_game/index.php');
exit;
?>
