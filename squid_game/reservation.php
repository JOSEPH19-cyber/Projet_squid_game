<?php


// Inclure la BDD
require_once "../includes/config-db.php";

// Inclure les fonctions utilitaires
require_once "../includes/util.php";

// Démarrer la session
init_session();

// Récupérer les infos si l'utilisateur est connecté
if (is_logged()) {
    $user_name  = $_SESSION['user_name'] ?? null;
    $user_id    = $_SESSION['user_id'] ?? null;
    $user_email = $_SESSION['user_email'] ?? null;
} else {
    echo "<script>
            alerte('Vous n'êtes pas connecté. veuillez vous connecté pour passer une réservation.');
            window.location.href = 'connexion.php';
          </script>";
}

//préparer et executer la requête pour les activités
$sql = $pdo->prepare("SELECT activity_title FROM activities");
$sql->execute();

//Récupérer les données des activités
$games = $sql->fetchAll(PDO::FETCH_ASSOC);

// Vérification de la soumission du formulaire
if (isset($_POST['submit'])) {
    // Récupérer et nettoyer les données
    $full_name       = trim($_POST['full_name'] ?? null);
    $phone_number    = trim($_POST['telephone'] ?? null);
    $activity_choice = trim($_POST['activities'] ?? null);
    $number          = trim($_POST['number'] ?? null);
    $date            = trim($_POST['date'] ?? null);
    $time            = trim($_POST['time'] ?? null);

    // Vérifier que les champs ne sont pas vides
    if (!empty($full_name) && !empty($phone_number) && !empty($activity_choice) && !empty($number) && !empty($date) && !empty($time)) {
        // Vérifier que l'activité existe
        $traitement = $pdo->prepare("SELECT * FROM activities WHERE activity_title = :activities");
        $traitement->bindParam(":activities", $activity_choice);
        $traitement->execute();
        $activity = $traitement->fetch();

        // s'assurer du timezone serveur
        date_default_timezone_set('Africa/Kinshasa');

        //vérifier si la date entrée par l'utilisateur est valide
        $now = new DateTime();
        $user_datetime = new DateTime($date . '' . $time);

        // Vérifier plage horaire (08:00 - 18:00)
        $hours = (int)$userDateTime->format('H');
        $minutes = (int)$userDateTime->format('i');
        $userTotalMinutes = $hours * 60 + $minutes;
        $minMinutes = 8 * 60;
        $maxMinutes = 18 * 60;

        // caster number en entier de façon sûre
        $number_raw = (int)$number;


        if (
            $activity &&
            $user_datetime >= $now &&
            $minMinutes <= $userTotalMinutes  &&
            $userTotalMinutes  <= $maxMinutes &&
            $number_raw > 0 &&
            $number_raw <= 20)
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
            if (!$activity) {
                echo "<script>alert('Activité non trouvé.');</script>";
            } elseif ($user_datetime < $now) {
                echo "<script>alert('date entrée non valide.');</script>";
            } elseif ($minMinutes >  $userTotalMinutes ||  $userTotalMinutes > $maxMinutes) {
                echo "<script>alert('Veuillez entrer une heure entre 8:00 et 18:00.');</script>";
            } elseif ($number_raw < 1) {
                echo "<script>alert('Le nombre de participants doit être compris entre 1 et 20.');</script>";
            } elseif ($number_raw > 20) {
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
            Choisissez vos activités, indiquez vos coordonnée et la date souhaitée.
            Un email de confirmation vous sera envoyé.
        </p>
    </div>

    <form action="" method="post" id="registration-form">
        <fieldset>
            <legend>Formulaire de Réservation</legend><br>

            <label for="full_name">Nom et prénom : </label><br>
            <input type="text" id="full_name" name="full_name" placeholder="Entrez votre nom et votre prénom" required><br>

            <label for="email">Addresse email : </label><br>
            <input type="email" id="email" name="email" placeholder="Entrez votre addresse e-mail" value="<?= htmlspecialchars($user_email) ?>" readonly required><br>

            <label for="telephone">Numéro de téléphone : </label><br>
            <input type="tel" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" required><br>

            <label for="date">Date de réservation : </label><br>
            <input type="date" id="date" name="date" required><br>

            <label for="time">Heure de réservation : </label><br>
            <input type="time" id="time" name="time" require><br>

            <select name="activities" id="activities">
                <option value="choisir">Choisissez une activité</option>
                <optgroup label="activités">
                    <?php foreach ($games as $game) : ?>
                        <option value="<?= htmlspecialchars($game['activity_title']) ?>">
                            <?= htmlspecialchars($game['activity_title']) ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            </select><br>

            <label for="number">Nombre des personnes : </label><br>
            <input type="number" id="number" name="number" placeholder="Entrez le Nombre des personnes" required><br>

            <input type="checkbox" value="condition" name="condition" id="condition" required><label for="condition">J’accepte les conditions générales</label><br>

            <button type="submit" name="submit">Réservez</button>

        </fieldset>
    </form>

    <script src="../assets/script.js"></script>
</body>

</html>