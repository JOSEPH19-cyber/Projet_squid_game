<!------------------- Header des pages -------------------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<header>
    <!-- Overlay pour le menu hamburger -->
    <div class="header_overlay"></div>

    <!-- Logo -->
    <div class="logo">SQUID GAME !</div>

    <!-- Menu principal -->
    <nav class="navbar">
        <ul>
            <li><a href="../squid_game/index.php">Accueil</a></li>
            <li><a href="../squid_game/activites.php">Activités</a></li>
            <li><a href="../squid_game/delices.php">Délices</a></li>
            <li><a href="../squid_game/reservation.php">Réservation</a></li>
            <li><a href="../squid_game/contact.php">Contact</a></li>
        </ul>
    </nav>

    <!-- Icône utilisateur / connexion -->
    <a href="../connexion_inscription/connexion.php" aria-label="Mon compte">
        <i class="fas fa-user"></i>
    </a>

    <!-- Menu hamburger -->
    <div class="hamburger">
        <!-- Bouton ouvrir/fermer -->
        <div class="hamburger-open">
            <i class="fas fa-bars"></i>
        </div>
        <div class="hamburger-close">
            <i class="fas fa-times"></i>
        </div>

        <!-- Liste des liens dans le menu hamburger -->
        <nav class="navlist">
            <ul>
                <li><a href="../squid_game/index.php">Accueil</a></li>
                <li><a href="../squid_game/activites.php">Activités</a></li>
                <li><a href="../squid_game/delices.php">Délices</a></li>
                <li><a href="../squid_game/reservation.php">Réservation</a></li>
                <li><a href="../squid_game/contact.php">Contact</a></li>
                <li><a href="../connexion_inscription/connexion.php">Connexion</a></li>
                <li><a href="../connexion_inscription/inscription.php">Inscription</a></li>
            </ul>
        </nav>

        <!-- Overlay -->
        <div class="overlay"></div>
    </div>

    <!-- Barre de recherche -->
    <div class="search">
        <input type="text" placeholder="Rechercher une activité">
    </div>

    <!-- Slogan / Hero texte -->
    <div class="slogan">
        <p>Vivez les aventures de SQUID GAME</p>
    </div>
</header>
