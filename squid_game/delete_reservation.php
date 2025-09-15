<?php

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Vérifier si l'admin est connecté
if (is_logged()) {
    if(isset($_GET['id'])) {
        $id = intval($_GET['id']); 
        $user_id = $_SESSION['user_id'];

        // supprimer la réservation de l'utilisateur connecté
        $check = $pdo->prepare("DELETE FROM reservations 
                                WHERE reservation_id = :id 
                                AND user_id = :user_id");
        $check->execute([':id' => $id, ':user_id' => $user_id]);

        if ($check->rowCount() > 0) {
            echo "<script>
                alert('Votre réservation a été supprimée !');
                window.location.href = 'reservations.php';
            </script>";
        } else {
            echo "<script>
                alert('Vous ne pouvez pas supprimer cette réservation.');
                window.location.href = 'reservations.php';
            </script>";
        }
    }
}
