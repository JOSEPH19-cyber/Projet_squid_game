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
    if (isset($_POST['submit'])) 
    {
        $activity_title     = trim($_POST['title'] ?? '');
        $long_description   = trim($_POST['long_description'] ?? '');
        $short_description  = trim($_POST['short_description'] ?? '');
        $activity_price     = trim($_POST['price'] ?? '');
        $activity_url       = trim($_POST['url'] ?? '');
        $category           = trim($_POST['category'] ?? '');

        // Vérifier les champs obligatoires
        if (!empty($activity_title) && !empty($long_description) && !empty($short_description) && !empty($activity_url) && $category !== '') 
        {
            // Vérifier si l'activité existe déjà
            $check = $pdo->prepare("SELECT * FROM activities WHERE activity_title = :title");
            $check->bindParam(":title", $activity_title);
            $check->execute();
            $activity = $check->fetch();

            if (!$activity) 
            {
                if ($category == 1) {  
                    // PAYANTE
                    if ($activity_price >= 0) {
                        $stmt = $pdo->prepare("
                            INSERT INTO activities (activity_title, long_description, short_description, activity_price, activity_url, category) 
                            VALUES (:title, :long_description, :short_description, :price, :url, :category)
                        ");
                        $stmt->execute([
                            'title'            => $activity_title,
                            'long_description' => $long_description,
                            'short_description'=> $short_description,
                            'price'            => $activity_price,
                            'url'              => $activity_url,
                            'category'         => $category
                        ]);
                        echo "<script>alert(\"Activité payante enregistrée avec succès !\");</script>";
                    } else {
                        echo "<script>alert('Le prix doit être >= 0');</script>";
                    }

                } elseif ($category == 0) {  
                    // GRATUITE
                    $stmt = $pdo->prepare("
                        INSERT INTO activities (activity_title, long_description, short_description, activity_url, category) 
                        VALUES (:title, :long_description, :short_description, :url, :category)
                    ");
                    $stmt->execute([
                        'title'            => $activity_title,
                        'long_description' => $long_description,
                        'short_description'=> $short_description,
                        'url'              => $activity_url,
                        'category'         => $category
                    ]);
                    echo "<script>alert(\"Activité gratuite enregistrée avec succès !\");</script>";

                } else {
                    echo "<script>alert('Catégorie invalide !');</script>";
                }
            } else {
                echo "<script>alert('Cette activité existe déjà.');</script>";
            }
        } 
        else {
            echo "<script>alert('Veuillez remplir tous les champs obligatoires.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une activité</title>
</head>
<body>
    <h1>Ajouter une activité</h1>

    <form action="" method="post">
        <label for="title">Nom de l’activité :</label><br>
        <input type="text" name="title" id="title" required><br>

        <label for="long_description">Longue description :</label><br>
        <textarea name="long_description" id="long_description" required></textarea><br>

        <label for="short_description">Courte description :</label><br>
        <textarea name="short_description" id="short_description" required></textarea><br>

        <label for="price">Prix :</label><br>
        <input type="number" name="price" id="price" min="0" step="0.01"><br>

        <label for="image">Image URL :</label><br>
        <input type="text" name="url" id="image" required><br>

        <label for="category">Catégorie :</label><br>
        <select name="category" id="category" required>
            <option value="1">Payante</option>
            <option value="0">Gratuite</option>
        </select><br>

        <button type="submit" name="submit">Ajouter l’activité</button>
    </form>

</body>
</html>