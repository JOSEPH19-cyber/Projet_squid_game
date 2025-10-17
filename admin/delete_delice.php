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

        // supprimer l'activité 
        $check = $pdo->prepare("DELETE FROM delices WHERE delice_id = :id");
        $check->execute([':id' => $id ]);

        if ($check->rowCount() > 0) {
            echo "<script>
                alert(\"Catégorie supprimée !\");
                window.location.href = 'admin_delices.php';
              </script>";
        } else {
            echo "<script>
                alert(\"Cette activité n'existe pas.\");
                window.location.href = 'admin_delices.php';
              </script>";
        }
    }
    else
    {
        echo "<script>
            alert(\"ID d'activité manquant.\");
            window.location.href = 'admin_delices.php';
          </script>";
    }
}
