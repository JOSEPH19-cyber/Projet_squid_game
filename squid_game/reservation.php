<?php

// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";


// Démarrer la session
init_session();

// Récupérer les infos si l'utilisateur est connecté
if (is_logged()) 
{
    $user_name  = $_SESSION['user_name'] ?? null;
    $user_id    = $_SESSION['user_id'] ?? null;
    $user_email = $_SESSION['user_email'] ?? '';

    // Préparer et exécuter la requête pour récupérer les activités
    $sql = $pdo->prepare("SELECT activity_id, activity_title FROM activities WHERE category = 1");
    $sql->execute();

    // Récupérer les données des activités
    $games = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Vérification de la soumission du formulaire
    if (isset($_POST['submit'])) {

        // Récupérer et nettoyer les données
        $full_name    = trim($_POST['full_name'] ?? '');
        $phone_number = trim($_POST['telephone'] ?? '');
        $activity_id  = intval($_POST['activities'] ?? 0);
        $number       = intval($_POST['number'] ?? 0);
        $date         = trim($_POST['date'] ?? '');
        $time         = trim($_POST['time'] ?? '');

        // Vérifier que les champs ne sont pas vides
        if (!empty($full_name) && !empty($phone_number) && $activity_id > 0 && !empty($number) && !empty($date) && !empty($time)) 
        {
            // Vérifier que l'activité existe
            $traitement = $pdo->prepare("SELECT * FROM activities WHERE activity_id = :id");
            $traitement->bindParam(":id", $activity_id, PDO::PARAM_INT);
            $traitement->execute();
            $activity = $traitement->fetch();

            // Vérifier si la date entrée par l'utilisateur est valide
            $now       = new DateTime();
            $user_date = new DateTime($date . ' ' . $time);

            // Vérifier plage horaire (08:00 - 18:00)
            $heure = DateTime::createFromFormat('H:i', $time);
            $debut = DateTime::createFromFormat('H:i', '08:00');
            $fin   = DateTime::createFromFormat('H:i', '18:00');

            if ($activity && 
                $user_date >= $now && 
                $heure >= $debut && 
                $heure <= $fin &&
                $number > 0 &&
                $number <= 20) 
            {
                // Insérer la réservation dans la BDD
                $stmt = $pdo->prepare("INSERT INTO reservations 
                    (full_name, phone_number, activity_id, user_id, number, reservation_date, reservation_time) 
                    VALUES (:full_name, :telephone, :activity_id, :user_id, :number, :date, :time)");

                $stmt->execute([
                    'full_name'   => $full_name,
                    'telephone'   => $phone_number,
                    'activity_id' => $activity_id,
                    'user_id'     => $user_id,
                    'number'      => $number,
                    'date'        => $user_date->format('Y-m-d'),
                    'time'        => $heure->format('H:i')
                ]);

                echo "<script>
                        alert('Réservation réussie !');
                        window.location.href = 'reservations.php';
                    </script>";
            } 
            else 
            {
                if (!$activity) {
                    echo "<script>alert('Activité non trouvée.');</script>";
                } elseif ($user_date < $now) {
                    echo "<script>alert('Date entrée non valide.');</script>";
                } elseif ($heure < $debut || $heure > $fin) {
                    echo "<script>alert('Veuillez entrer une heure entre 8:00 et 18:00.');</script>";
                } elseif ($number <= 0 || $number > 20) {
                    echo "<script>alert('Le nombre de participants doit être compris entre 1 et 20.');</script>";
                } else {
                    echo "<script>alert('Erreur inconnue. Veuillez vérifier vos données.');</script>";
                }
            }
        } 
        else 
        {
            echo "<script>alert('Veuillez remplir tous les champs.');</script>";
        }
    }
} 
else 
{
    echo "<script>
            alert(\"Vous n'êtes pas connecté. Veuillez vous connecter pour passer une réservation.\");
            window.location.href = '../connexion_inscription/connexion.php';
          </script>";
}

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
        <h1>Réservez vos activités </h1>

        <p>
            Choisissez vos activités, indiquez vos coordonnées et la date souhaitée.
        </p>
    </div>

    <form action="" method="post">
        <fieldset>
            <legend>Formulaire de Réservation</legend><br>

            <label for="full_name">Nom et prénom : </label><br>
            <input type="text" id="full_name" name="full_name" placeholder="Entrez votre nom et votre prénom" required><br>

            <label for="email">Adresse email : </label><br>
            <input type="email" id="email" name="email" placeholder="Entrez votre adresse e-mail" value="<?= htmlspecialchars($user_email) ?>" readonly required><br>

            <label for="telephone">Numéro de téléphone : </label><br>
            <input type="tel" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" required><br>

            <label for="date">Date de réservation : </label><br>
            <input type="date" id="date" name="date" required><br>

            <label for="time">Heure de réservation : </label><br>
            <input type="time" id="time" name="time" min="08:00" max="18:00" required><br>

            <label for="activities">Choisissez une activité :</label><br>
            <select name="activities" id="activities" required>
                <option value="">Choisissez une activité</option>
                <optgroup label="Activités">
                    <?php foreach ($games as $game) : ?>
                        <option value="<?= htmlspecialchars($game['activity_id']) ?>">
                            <?= htmlspecialchars($game['activity_title']) ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            </select><br>

            <label for="number">Nombre de personnes : </label><br>
            <input type="number" id="number" name="number" placeholder="Entrez le nombre de personnes" min="1" max="20" required><br>

            <input type="checkbox" value="condition" name="condition" id="condition" required>
            <label for="condition">J’accepte les conditions générales</label><br>

            <button type="submit" name="submit">Réservez</button>

        </fieldset>
    </form>
    
    <script src="../assets/script.js"></script>
</body>
</html>
