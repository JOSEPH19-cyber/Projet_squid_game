<?php
require_once "../includes/config-db.php";

try {
    // Requête test avec alias entre backticks
    $stmt = $pdo->query("SELECT NOW() AS `current_time`");
    $row = $stmt->fetch();
    echo "Connexion réussie ! Heure serveur : " . $row['current_time'];
} catch(PDOException $e) {
    echo "La connexion fonctionne pas : " . $e->getMessage();
}
?>
