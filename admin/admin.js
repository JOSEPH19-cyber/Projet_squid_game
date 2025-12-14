// admin.js

// -----------------------------
// SÉLECTION DES ÉLÉMENTS
// -----------------------------
const hamburgerOpen = document.querySelector(".hamburger-open");
const hamburgerClose = document.querySelector(".hamburger-close");
const navList = document.querySelector(".navlist");
const overlay = document.querySelector(".overlay");

// -----------------------------
// FONCTIONS OUVERTURE / FERMETURE
// -----------------------------
function openMenu() {
    navList.classList.add("active");
    overlay.classList.add("active");

    // Gestion des icônes
    hamburgerOpen.style.display = "none";   
    hamburgerClose.style.display = "block"; 
}

function closeMenu() {
    navList.classList.remove("active");
    overlay.classList.remove("active");

    // Gestion des icônes
    hamburgerOpen.style.display = "block";  
    hamburgerClose.style.display = "none";  
}

// -----------------------------
// ÉVÉNEMENTS
// -----------------------------
hamburgerOpen.addEventListener("click", openMenu);
hamburgerClose.addEventListener("click", closeMenu);
overlay.addEventListener("click", closeMenu);

// Fermeture automatique du menu si on clique sur un lien
document.querySelectorAll(".navlist a").forEach(link => {
    link.addEventListener("click", closeMenu);
});

// -----------------------------
// LIEN ACTIF DANS LA NAVBAR (DESKTOP)
// -----------------------------
const navbarLinks = document.querySelectorAll(".navbar a");

function updateActiveLink() {
    // Récupérer le chemin actuel en ignorant query params et ancres
    const currentPath = window.location.pathname.split("/").pop().split("?")[0].split("#")[0];

    navbarLinks.forEach(link => {
        const linkPath = link.getAttribute("href").split("/").pop().split("?")[0].split("#")[0];

        if (linkPath === currentPath || (linkPath === "index.php" && currentPath === "")) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
}

// Appliquer dès le chargement
updateActiveLink();

// Si SPA ou navigation dynamique → on gère aussi le clic
navbarLinks.forEach(link => {
    link.addEventListener("click", () => {
        navbarLinks.forEach(l => l.classList.remove("active"));
        link.classList.add("active");
    });
});
