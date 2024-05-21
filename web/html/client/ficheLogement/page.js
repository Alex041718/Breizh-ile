document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popup2');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const subtractAdultBtn = document.getElementById('subtractAdultBtn');
    const addAdultBtn = document.getElementById('addAdultBtn');
    const adultCount = document.getElementById('adultCount');
    const subtractChildBtn = document.getElementById('subtractChildBtn');
    const addChildBtn = document.getElementById('addChildBtn');
    const childCount = document.getElementById('childCount');
    const body = document.querySelector('body'); // Sélectionnez le corps du document
    const overlay = document.getElementById('overlay'); // Sélectionnez l'élément overlay

    let adultCountValue = parseInt(adultCount.textContent); // Nombre initial d'adultes
    let childCountValue = parseInt(childCount.textContent); // Nombre initial d'enfants

    // Fonction pour ouvrir la pop-up
    function openPopup() {
        popup.style.display = 'block';
        overlay.style.display = 'block';
        body.classList.add('popup-active'); // Ajoute la classe 'popup-active' pour assombrir le fond
    }

    // Fonction pour fermer la pop-up
    function closePopup() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
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

    // Fermer la pop-up en cliquant sur l'overlay
    overlay.addEventListener('click', closePopup);

    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/%7Bz%7D/%7By%7D/%7Bx%7D', {
        attribution: 'ArcGIS'
    }).addTo(map);


    let MyControlClass =  L.Control.extend({

        options: {
            position: 'topleft'
        },

        onAdd: function(map) {
            var div = L.DomUtil.create('div', 'leaflet-bar my-control');
            var myButton = L.DomUtil.create('button', 'my-button-class', div);


            let myImage = L.DomUtil.create('img', '', myButton);
            myImage.src = "https://zestedesavoir.com/media/galleries/16186/1b4da67d-cb8b-4c29-85cb-4633005ea1e9.svg";
            myImage.style = "margin-left:0px;width:20px;height:20px";
            L.DomEvent.on(myButton, 'click', function() { changeBackground(); }, this);

            return div;
        },

        onRemove: function(map) {
        }
    });

    let myControl = new MyControlClass().addTo(map);

    function changeBackground(){
        if(tileType == "OpenStreetMap")
            {
                tileType = "ArcGis";
                L.tileLayer('https://tile.openstreetmap.org/%7Bz%7D/%7Bx%7D/%7By%7D.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }
            else
            {
              tileType = "OpenStreetMap";

              selectedTile = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/%7Bz%7D/%7By%7D/%7Bx%7D', {
                attribution: 'ArcGIS'
              }).addTo(map);
        }
    }

    var circle = L.circle([51.508, -0.11], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(map);

    // Récupération des éléments avec infobulle
    const tooltips = document.querySelectorAll('.tooltip');

    tooltips.forEach(function (tooltip) {
        // Gestionnaire d'événement pour le survol
        tooltip.addEventListener('mouseover', function () {
            const tooltipText = tooltip.querySelector('.tooltip-text');
            tooltipText.style.visibility = 'visible';
            tooltipText.style.opacity = 1;
        });

        // Gestionnaire d'événement pour la fin du survol
        tooltip.addEventListener('mouseout', function () {
            const tooltipText = tooltip.querySelector('.tooltip-text');
            tooltipText.style.visibility = 'hidden';
            tooltipText.style.opacity = 0;
        });
    });

    const popupOverlaSsavoir = document.getElementById('popup-overlay-savoir');
    // Fonction pour afficher la pop-up avec le texte complet de la description
    function showPopup() {
        var truncatedText = document.getElementById('truncate-text').textContent;
        document.getElementById('full-description').textContent = truncatedText;
        popupOverlaSsavoir.style.display = 'block';
        document.getElementById('popup-savoir').style.display = 'block';
        // Ajouter la classe pour verrouiller le défilement du corps
        body.classList.add('popup-savoir-open');
    }

    // Fonction pour cacher la pop-up
    function closePopupSavoir() {
        document.getElementById('popup-overlay-savoir').style.display = 'none';
        document.getElementById('popup-savoir').style.display = 'none';
        
        // Retirer la classe pour rétablir le défilement du corps
        body.classList.remove('popup-savoir-open');
    }

    // Ajout de l'événement de clic sur le bouton "En savoir +"
    document.getElementById('button-savoir').addEventListener('click', showPopup);

    // Ajout de l'événement de clic sur le bouton "Fermer" de la pop-up
    document.getElementById('close-popup').addEventListener('click', closePopupSavoir);

    popupOverlaSsavoir.addEventListener('click', closePopupSavoir);

    // Fonction pour afficher la pop-up
    function showPopupCriteres() {
        document.getElementById('popup-critere').classList.add('show');
        document.getElementById('overlay-critere').style.display = 'block';
        body.classList.add('popup-active'); // Empêche le défilement de la page
    }

    // Fonction pour cacher la pop-up
    function closePopupCriteres() {
        document.getElementById('popup-critere').classList.remove('show');
        document.getElementById('overlay-critere').style.display = 'none';
        body.classList.remove('popup-active'); // Réactive le défilement de la page
    }

    // Ajout de l'événement de clic sur le bouton "Afficher les critères"
    document.querySelector('.criteres').addEventListener('click', showPopupCriteres);

    // Ajout de l'événement de clic sur le bouton "Fermer" de la pop-up
    document.getElementById('closePopupCritereBtn').addEventListener('click', closePopupCriteres);

    document.getElementById('overlay-critere').addEventListener('click', closePopupCriteres);

    const inputs = document.querySelectorAll(".datepicker input[type=date]");

    inputs.forEach((input) => {
        flatpickr(input, {
            dateFormat: "d-m-Y",
            minDate: "today",
            maxDate: new Date().fp_incr(365)
        });
    });


  
});
