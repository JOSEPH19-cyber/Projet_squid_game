<?php

// Vérifier si le formulaire a été soumis
if(isset($_POST['submit'])){

    // Récupérer les données envoyées par le formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier que les champs ne sont pas vides
    if(!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {

        // Vérifier que les mots de passe correspondent
        if($password === $confirm_password) {

            // Connexion à la base
            require_once  "../includes/config-db.php";

            // Vérifier si l’email existe déjà
            $emailCheckStmt = $pdo->prepare("SELECT user_id FROM users WHERE user_email = :email");
            $emailCheckStmt->bindParam(":email", $email);
            $emailCheckStmt->execute();
            $user = $emailCheckStmt->fetch();

            if($user) {
                echo "Cet email est déjà utilisé.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (:username, :email, :password)");
                $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword]);

                echo "<script>
                        alert('Inscription réussie ! Vous allez être redirigé vers la page de connexion.');
                        window.location.href = 'connexion.php';
                    </script>";
            }

        } else {
            echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
        }

    } else {
        echo "<script>alert('Veuillez remplir tous les champs.');</script>";

    }

} else {
    echo "<script>alert('Accès interdit.');</script>";
}
?>
