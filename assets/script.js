// Gérer l'heure de la réservation
let form = document.getElementById("registration-form");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 

    let user_date = document.getElementById("date").value;
    let enteredDate = new Date(user_date);
    let currentDate = new Date();

    if (enteredDate > currentDate) {
        alert("Réservation enregistrée !");
        form.submit();
    } else {
        alert("Date entrée non valide !");
    }
});
