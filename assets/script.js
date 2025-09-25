/* =========================================
   SCRIPT HEADER - MENU HAMBURGER & RECHERCHE
   ========================================= */

// -----------------------------
// MENU HAMBURGER
// -----------------------------
const hamburger = document.querySelector(".hamburger");
const openBtn = document.querySelector(".hamburger-open");
const closeBtn = document.querySelector(".hamburger-close");
const navlist = document.querySelector(".navlist");
const overlay = document.querySelector(".hamburger .overlay");

function openHamburger() { hamburger.classList.add("active"); }
function closeHamburger() { hamburger.classList.remove("active"); }

openBtn.addEventListener("click", openHamburger);
closeBtn.addEventListener("click", closeHamburger);
overlay.addEventListener("click", closeHamburger);

navlist.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => {
        navlist.querySelectorAll("a").forEach(l => l.classList.remove("active"));
        link.classList.add("active");
        closeHamburger();
    });
});

/// -----------------------------
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


// -----------------------------
// RECHERCHE AVEC SUGGESTIONS
// -----------------------------
const searchInput = document.getElementById("search-input");
const searchResults = document.getElementById("search-results");

const activities = [
    "Auto temponeuses",
    "Carrousel",
    "Tobbogan aquatique",
    "Montagne russe",
    "Squid game",
    "Réalité virtuelle",
    "Vélo",
    "Nage",
    "Grande roue",
    "Tyrolienne"
];

let currentFocus = -1;

function showSuggestions(value) {
    searchResults.innerHTML = "";
    if (!value) { searchResults.style.display = "none"; return; }

    const filtered = activities.filter(act =>
        act.toLowerCase().startsWith(value.toLowerCase())
    );

    if (filtered.length === 0) { searchResults.style.display = "none"; return; }

    filtered.forEach(act => {
        const div = document.createElement("div");
        div.textContent = act;
        div.addEventListener("click", () => {
            redirectToActivity(act);
            searchResults.style.display = "none";
        });
        searchResults.appendChild(div);
    });

    searchResults.style.display = "block";
}

searchInput.addEventListener("keydown", function(e) {
    const items = searchResults.querySelectorAll("div");
    if (!items) return;

    if (e.key === "ArrowDown") {
        currentFocus++;
        addActive(items);
        e.preventDefault();
    } else if (e.key === "ArrowUp") {
        currentFocus--;
        addActive(items);
        e.preventDefault();
    } else if (e.key === "Enter") {
        e.preventDefault();
        if (currentFocus > -1 && items[currentFocus]) {
            redirectToActivity(items[currentFocus].textContent);
            searchResults.style.display = "none";
        }
    }
});

function addActive(items) {
    if (!items) return;
    removeActive(items);
    if (currentFocus >= items.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = items.length - 1;
    items[currentFocus].classList.add("search-active");
}

function removeActive(items) {
    items.forEach(item => item.classList.remove("search-active"));
}

searchInput.addEventListener("input", function() {
    currentFocus = -1;
    showSuggestions(this.value);
});

document.addEventListener("click", function(e) {
    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
        searchResults.style.display = "none";
    }
});

// -----------------------------
// REDIRECTION VERS L'ACTIVITE
// -----------------------------
function slugify(title) {
    return "activite-" + title.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, "")
        .replace(/\s+/g, '-')
        .replace(/[^a-z0-9\-]/g, '');
}

function redirectToActivity(activityTitle) {
    const slug = slugify(activityTitle);
    window.location.href = `activites.php#${slug}`;
}

// -----------------------------
// BOUTONS "EN SAVOIR PLUS"
// -----------------------------
document.querySelectorAll(".btn-details").forEach(btn => {
    btn.addEventListener("click", () => {
        const activityTitle = btn.closest(".activity_card").querySelector("h2").textContent;
        redirectToActivity(activityTitle);
    });
});

// -----------------------------
// CAROUSEL - DEFILEMENT DES CARTES
// -----------------------------
const carousels = document.querySelectorAll(".carousel");

carousels.forEach(carousel => {
    const prevBtn = carousel.parentElement.querySelector(".carousel-btn.prev");
    const nextBtn = carousel.parentElement.querySelector(".carousel-btn.next");

    const cardWidth = carousel.querySelector("article")?.offsetWidth || 300;
    const gap = 16; // ajuster selon le CSS

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener("click", () => {
            carousel.scrollBy({ left: -(cardWidth + gap), behavior: "smooth" });
        });

        nextBtn.addEventListener("click", () => {
            carousel.scrollBy({ left: cardWidth + gap, behavior: "smooth" });
        });
    }
});
a