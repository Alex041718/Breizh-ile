document.addEventListener("DOMContentLoaded", function() {
    const divs = document.querySelectorAll('.content__selector > div');
    const security = document.querySelector('.content__security');
    const personalData = document.querySelector('.content__personnal-data');

    // Activer par défaut le contenu "Informations Personnelles"
    personalData.style.display = "block";
    divs[0].classList.add('content__selector--current');

    // Ajouter un écouteur d'événement à chaque élément du sélecteur
    divs.forEach((div, index) => {
        div.addEventListener('click', () => {
            // Masquer tous les contenus
            security.style.display = "none";
            personalData.style.display = "none";

            // Retirer la classe active de tous les éléments du sélecteur
            divs.forEach((item) => {
                item.classList.remove('content__selector--current');
            });

            // Afficher le contenu correspondant à l'élément cliqué
            if (index === 0) {
                personalData.style.display = "block";
            } else {
                security.style.display = "block";
            }

            // Ajouter la classe active à l'élément cliqué
            div.classList.add('content__selector--current');
        });
    });
});
