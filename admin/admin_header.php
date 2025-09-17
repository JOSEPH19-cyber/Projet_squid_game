<!------------------- Header des pages -------------------->
<link rel="stylesheet" href="../assets/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<header>

   <div class="header-container">

        <!-- Logo -->
        <div class="logo">
            <p>SQUID GAME</p>
        </div>

        <!-- Menu principal -->
        <nav class="navbar">
            <ul>
                <li><a href="dashboard.php" target="_blank">Accueil</a></li>
                <li><a href="admin_activities.php" target="_blank">Activités</a></li>
                <li><a href="" target="_blank">Délices</a></li>
                <li><a href="admin_reservation.php" target="_blank">Réservation</a></li>
                <li><a href="messages.php" target="_blank">Messages</a></li>
                <li><a href="settings.php" target="_blank">Paramètres</a></li>
            </ul>
        </nav>


        <!-- Menu hamburger -->
        <div class="hamburger">
            <!-- Bouton ouvrir/fermer -->
            <div class="hamburger-open">
                <i class="fas fa-bars"></i>
            </div>
            <div class="hamburger-close">
                <i class="fas fa-times"></i>
            </div> 

            <!-- Liste des liens dans le menu hamburger-->
            <nav class="navlist">
                <ul>
                    <li><a href="../squid_game/index.php">Accueil</a></li>
                    <li><a href="../squid_game/activites.php">Activités</a></li>
                    <li><a href="../squid_game/delices.php">Délices</a></li>
                    <li><a href="../squid_game/reservation.php">Réservation</a></li>
                    <li><a href="../squid_game/reservations.php">Mes réservations</a></li>
                    <li><a href="../squid_game/contact.php">Contact</a></li>
                    <li><a href="../connexion_inscription/connexion.php">Connexion</a></li>
                    <li><a href="../connexion_inscription/inscription.php">Inscription</a></li>
                    <li><a href="../connexion_inscription/deconnexion.php">Connexion</a></li>
                </ul>
            </nav>

            <!-- Overlay -->
            <div class="overlay"></div>
        </div>

    </div>

</header>
