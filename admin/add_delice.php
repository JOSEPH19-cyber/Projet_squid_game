<?php

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

//préparer et executer la requête pour les categories de délices
$sql = $pdo->prepare("SELECT delice_id, category_type FROM delices ");
$sql->execute();
$categories = $sql->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si l'admin est connecté
if (is_admin()) 
{
    if (isset($_POST['submit'])) 
    {
        $category_type = trim($_POST['category_type'] ?? '');
        $delice_type  = trim($_POST['delice_type'] ?? '');
        $delice_items  = trim($_POST['delice_items'] ?? '');
        $delice_url    = trim($_POST['delice_url'] ?? '');

        // Vérifier les champs obligatoires
        if (!empty($category_type) && !empty($delice_items) && !empty($delice_url) && $delice_type !== '') 
        {
            // Vérifier si les types des catégories existent déjà
            $check = $pdo->prepare("SELECT * FROM delices WHERE category_type = :category_type");
            $check->bindParam(":category_type", $category_type, PDO::PARAM_INT);
            $check->execute();
            $delices = $check->fetch();

            if (!$delices) 
            {
                if ($delice_type == 0 || $delice_type == 1) 
                {  
                    // PLAT ET BOISSON
                    $stmt = $pdo->prepare("
                        INSERT INTO delices (category_type, delice_type, delice_items, delice_url) 
                        VALUES (:category_type, :delice_type, :delice_items, :delice_url)
                    ");
                    $stmt->execute([
                        'category_type'   => $category_type,
                        'delice_type' => $delice_type,
                        'delice_items'=> $delice_items,
                        'delice_url'            => $delice_url,
                    ]);
                    echo "<script>alert(\"Cette catégorie a été enregistrée dans plat avec succès !\");</script>";

                } 
                else 
                {
                    echo "<script>alert('Catégorie invalide !');</script>";
                }
            } 
            else 
            {
                echo "<script>alert('Cette catégorie existe déjà.');</script>";
            }
        } 
        else 
        {
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
    <title>Ajouter une catégorie de délices</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <section class="auth-container">

        <h1>Ajouter une catégorie</h1>

        <form action="" method="post">

            <fieldset>

                <legend>Insertion</legend>
                
                <div class="form-group">
                    <label for="delice_type">Délices types :</label><br>
                    <select name="delice_type" id="delice_type" required>
                       <option value="0">Plat</option>
                       <option value="1">Boisson</option>
                    </select><br>
                </div>

                <div class="form-group">
                    <label for="category_type">Catégories types :</label><br>
                    <input type="text" name="category_type" id="category_type" required>
                </div>
                
                <div class="form-group">
                    <label for="delice_items">Délices items :</label><br>
                    <textarea id="delice_items" name="delice_items" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image URL :</label><br>
                    <input type="text" name="delice_url" id="image" required><br>
                </div>


                <button type="submit" name="submit">Ajouter la catégorie</button>
            </fieldset>
            
        </form>
    </section>

</body>
</html>