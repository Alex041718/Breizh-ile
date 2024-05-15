document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popup');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const subtractAdultBtn = document.getElementById('subtractAdultBtn');
    const addAdultBtn = document.getElementById('addAdultBtn');
    const adultCount = document.getElementById('adultCount');
    const subtractChildBtn = document.getElementById('subtractChildBtn');
    const addChildBtn = document.getElementById('addChildBtn');
    const childCount = document.getElementById('childCount');
    const body = document.querySelector('body'); // Sélectionnez le corps du document

    let adultCountValue = parseInt(adultCount.textContent); // Nombre initial d'adultes
    let childCountValue = parseInt(childCount.textContent); // Nombre initial d'enfants

    // Fonction pour ouvrir la pop-up
    function openPopup() {
        popup.style.display = 'block';
        body.classList.add('popup-active'); // Ajoute la classe 'popup-active' pour assombrir le fond
    }

    // Fonction pour fermer la pop-up
    function closePopup() {
        popup.style.display = 'none';
        body.classList.remove('popup-active'); // Retire la classe 'popup-active' pour annuler l'assombrissement du fond
    }

    // Gestionnaire d'événement pour le bouton de fermeture de la pop-up
    closePopupBtn.addEventListener('click', closePopup);

    // Gestionnaire d'événement pour le bouton de soustraction d'adulte
    subtractAdultBtn.addEventListener('click', function () {
        if (adultCountValue > 0) {
            adultCountValue--;
            updateAdultCount();
        }
    });

    // Gestionnaire d'événement pour le bouton d'ajout d'adulte
    addAdultBtn.addEventListener('click', function () {
        adultCountValue++;
        updateAdultCount();
    });

    // Gestionnaire d'événement pour le bouton de soustraction d'enfant
    subtractChildBtn.addEventListener('click', function () {
        if (childCountValue > 0) {
            childCountValue--;
            updateChildCount();
        }
    });

    // Gestionnaire d'événement pour le bouton d'ajout d'enfant
    addChildBtn.addEventListener('click', function () {
        childCountValue++;
        updateChildCount();
    });

    // Fonction pour mettre à jour le nombre d'adultes affiché
    function updateAdultCount() {
        adultCount.textContent = adultCountValue;
        liveTravelersCount.textContent = adultCountValue + childCountValue;
    }

    // Fonction pour mettre à jour le nombre d'enfants affiché
    function updateChildCount() {
        childCount.textContent = childCountValue;
        liveTravelersCount.textContent = adultCountValue + childCountValue;
    }

    // Gestionnaire d'événement pour le bouton "Ajouter des voyageurs"
    addTravelersBtn.addEventListener('click', openPopup);
});



const inputs = document.querySelectorAll(".datepicker input[type=date]");

inputs.forEach((input) => {
    flatpickr(input, {
        dateFormat: "d-m-Y",
        minDate: "today",
        maxDate: new Date().fp_incr(365)
    });
});
