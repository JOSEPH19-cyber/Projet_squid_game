<?php

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Vérifier si l'admin est connecté
if (is_admin()) 
{
    if(isset($_GET['id']))
    {
        $id = intval($_GET['id']); 
        
        // supprimer la réservation
        $check = $pdo->prepare("DELETE FROM reservations WHERE reservation_id = :id");
        $check->execute([':id' => $id ]);

        if ($check->rowCount() > 0) {
            echo "<script>
                alert(\"Réservation supprimée !\");
                window.location.href = 'admin_reservation.php';
              </script>";
        } else {
            echo "<script>
                alert(\"Cette réservation n'existe pas.\");
                window.location.href = 'admin_reservation.php';
              </script>";
        }
    }
    else
    {
        echo "<script>
            alert(\"ID de réservation manquant.\");
            window.location.href = 'admin_reservation.php';
          </script>";
    }
}
