<?php
// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Récupérer les infos si l'utilisateur est connecté
if(is_logged())
{
    $user_name  = $_SESSION['user_name'];
    $user_id    = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];
}

// Vérification de la soumission du formulaire
if(isset($_POST['submit']))
{
    // Récupérer et nettoyer les données
    $full_name       = trim($_POST['full_name']);
    $phone_number    = trim($_POST['telephone']);
    $activity_choice = trim($_POST['activities'] ?? '');
    $number          = trim($_POST['number']);
    $date            = trim($_POST['date']);
    $time            = trim($_POST['time']);

    // Vérifier que les champs ne sont pas vides
    if(!empty($full_name) && !empty($phone_number) && !empty($activity_choice) && !empty($number) && !empty($date) && !empty($time))
    {
        // Vérifier que l'activité existe
        $traitement = $pdo->prepare('SELECT * FROM activities WHERE activity_title = :activities');
        $traitement->execute(['activities' => $activity_choice]);
        $activity = $traitement->fetch();

        if($activity)
        {
            // Insérer la réservation dans la BDD
            $stmt = $pdo->prepare("INSERT INTO reservations (full_name, phone_number, activity_choice, number, reservation_date, reservation_time) 
                                   VALUES (:full_name, :telephone, :activities, :number, :date, :time)");
            $stmt->execute([
                'full_name'  => $full_name,
                'telephone'  => $phone_number,
                'activities' => $activity_choice,
                'number'     => $number,
                'date'       => $date,
                'time'       => $time
            ]);

            echo "<script>
                    alert('Réservation réussie !');
                    window.location.href = 'reservations.php';
                  </script>";
        }
        else
        {
            echo "<script>alert('Cette activité n’existe pas.');</script>";
        }
    }
    else
    {
        echo "<script>alert('Veuillez remplir tous les champs.');</script>";
    }
}
/*else
{
    // Accès direct au fichier interdit
    echo "<script>alert('Accès interdit.'); window.location.href='reservation.php';</script>";
}*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
   <div class="intro">
        <h1>Réservez vos activités  </h1>

        <p>
            Choisissez vos activités, indiquez vos coordonnée et la date souhaitée. 
            Un email de confirmation vous sera envoyé. 
        </p>
   </div>
   
   <form action="" method="post">
        <fieldset>
            <legend>Formulaire de Réservation</legend><br>

            <label for="full_name">Nom et prénom : </label><br>
            <input type="text" id="full_name" name="full_name" placeholder="Entrez votre nom et votre prénom" required><br>

            <label for="email">Addresse email : </label><br>
            <input type="email" id="email" name="email" placeholder="Entrez votre addresse e-mail" value="<?= htmlspecialchars($user_email ?? '') ?>" readonly required><br>

            <label for="telephone">Numéro de téléphone : </label><br>
            <input type="tel" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" required><br>

            <label for="date">Date de réservation : </label><br>
            <input type="date" id="date" name="date" required><br>

            <label for="time">Heure de réservation : </label><br>
            <input type="time" id="time" name="time" required><br>

            Choisissez une activité : <br>
            <select name="activities" id="activities">
                <optgroup label="activités">
                    <?php foreach($activity as $game) : ?>
                        <option value="<?= htmlspecialchars($game['activity_title'])?>">
                            <?= htmlspecialchars($game['activity_title'])?>
                        </option>
                    <?php endforeach;?>
                </optgroup>
            </select><br>

            <label for="number">Nombre des personnes : </label><br>
            <input type="number" id="number" name="number" placeholder="Entrez le nombre des personnes" required><br>

            <input type="checkbox" value="condition" name="condition" id="condition" required><label for="condition">J’accepte les conditions générales</label><br>

            <button type="submit" name="submit">Réservez</button>

        </fieldset>
    </form>
</body>
</html>
