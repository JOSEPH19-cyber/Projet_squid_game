<?php

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions de session/utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer le message
    $message = trim($_POST['message'] ?? '');

    // Vérifier si l'utilisateur est connecté
    if (is_logged()) {
        $user_id = $_SESSION['user_id'] ?? null;

        if (!empty($message)) {
            if (strlen($message) <= 1000) {
                // Insérer le message dans la BDD
                $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (:user_id, :message)");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':message', $message, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "<script>alert('Message envoyé avec succèes !');</script>";
                } else {
                    echo "<script>alert('Erreur lors de l\'envoi du message.');</script>";
                }
            } else {
                echo "<script>alert('Veuillez limiter la taille du message (1000 caractères max) !');</script>";
            }
        } else {
            echo "<script>alert('Le message ne peut pas être vide !');</script>";
        }
    } else {
        echo "<script>alert('Veuillez vous connecter pour envoyer ce message !');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
     <!-- Inclure le header -->
    <?php require_once "../includes/header.php"?>

    <main class="contact-page">
        <!-- Titre principal -->
        <h1 class="contact-title">Informations de contact</h1>

        <!-- Bloc infos générales -->
        <section class="contact-info">
            <div class="contact-item">
                <i class="fa-solid fa-envelope contact-icon"></i>
                <p class="contact-label">Email</p>
                <p class="contact-value">contact@squidgamepark.com</p>
            </div>
            <div class="contact-item">
                <i class="fa-solid fa-phone contact-icon"></i>
                <p class="contact-label">Téléphone</p>
                <p class="contact-value">+243 900 000 000</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt contact-icon"></i>
                <p class="contact-label">Adresse</p>
                <p class="contact-value">123 Rue imaginaire, Kinshasa RDC</p>
            </div>
        </section>

        <!-- Bloc réseaux sociaux -->
        <section class="social-links">
            <div class="social-item">
                <i class="fab fa-facebook social-icon"></i>
                <p class="social-label">Facebook</p>
                <p class="social-value">Squigamepark</p>
            </div>
            <div class="social-item">
                <i class="fab fa-instagram social-icon"></i>
                <p class="social-label">Instagram</p>
                <p class="social-value">SquigameparkRDC</p>
            </div>
            <div class="social-item">
                <i class="fab fa-twitter social-icon"></i>
                <p class="social-label">Twitter</p>
                <p class="social-value">Squigamepark</p>
            </div>
            <div class="social-item">
                <i class="fab fa-youtube social-icon"></i>
                <p class="social-label">Youtube</p>
                <p class="social-value">SquigameparkRDC</p>
            </div>
        </section>

        <!-- Bloc formulaire / message -->
        <form action="" method="post">
            <textarea name="message" id="message" class="message-textarea" placeholder="Laissez un message" required></textarea>
            <button class="contact-btn" type="submit" name="submit">Envoyer</button>
        </form>

        <script src="../assets/script.js"></script>
</body>
</html>