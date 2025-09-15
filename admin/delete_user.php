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
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); 

        // supprimer un utilisateur
        $check = $pdo->prepare("DELETE FROM users WHERE user_id = :id");
        $check->execute([':id' => $id]);

        if ($check->rowCount() > 0) {
            echo "<script>
                alert(\"Utilisateur supprimé !\");
                window.location.href = 'admin_users.php';
              </script>";
        } else {
            echo "<script>
                alert(\"Cet utilisateur n'existe pas.\");
                window.location.href = 'admin_users.php';
              </script>";
        }
    }
    else {
        echo "<script>
            alert(\"ID d'utilisateur manquant.\");
            window.location.href = 'admin_users.php';
          </script>";
    }
}
