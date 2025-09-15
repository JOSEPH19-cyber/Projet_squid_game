<?php

// Inclure les fonctions de session/utilitaires
require_once "../includes/util.php";

// initialise la session de manière sécurisée
init_session(); 

// Vérification de la soumission du formulaire
if(isset($_POST['submit'])) {

    // Récupérer et nettoyer les données
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérification que les champs ne sont pas vides
    if(!empty($email) && !empty($password)) {

        // Connexion à la base
        require_once "../includes/config-db.php";

        // Vérifier si l'email existe
        $query = $pdo->prepare("SELECT * FROM users WHERE user_email = :email");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();

        if($user) {
            // Vérification du mot de passe
            if(password_verify($password, $user['user_password'])) {

                // Stocker les infos dans la session
                $_SESSION['user_id']   = $user['user_id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['rank']      = $user['is_admin'];
                $_SESSION['user_email'] = $user['user_email'];

                // Redirection vers la page d'accueil ou le dashboard
                if($_SESSION['rank']  == 1)
                {
                    header("Location: ../admin/dashboard.php");
                    exit;
                }
                else
                {
                    header("Location: ../squid_game/index.php");
                    exit;
                }

            } else {
                // Mot de passe incorrect
                echo "<script>alert('Mot de passe ou email incorrect.'); window.location.href='connexion.php';</script>";
            }
        } else {
            // Email non trouvé
            echo "<script>alert('Mot de passe ou email incorrect.'); window.location.href='connexion.php';</script>";
        }

    } else {
        // Champs vides
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href='connexion.php';</script>";
    }

} else {
    // Accès direct au fichier interdit
    echo "<script>alert('Accès interdit.'); window.location.href='connexion.php';</script>";
}
?>
