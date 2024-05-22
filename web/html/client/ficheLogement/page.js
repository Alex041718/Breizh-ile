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
    const nbVoyageurs = document.getElementById('nbVoyageurs');

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
        if (adultCountValue > 1) {
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

    function updateAdultCount() {
        const maxVoyageurs = parseInt(nbVoyageurs.textContent, 10);
        const totalTravelers = adultCountValue + childCountValue;

        if (totalTravelers > maxVoyageurs) {
            // Ajuster adultCountValue pour ne pas dépasser nbVoyageurs
            adultCountValue = maxVoyageurs - childCountValue;
        }

        // Mettre à jour les éléments HTML avec les nouvelles valeurs
        adultCount.textContent = adultCountValue;
        liveTravelersCount.value = adultCountValue + childCountValue;
    }

    function updateChildCount() {
        const maxVoyageurs = parseInt(nbVoyageurs.textContent, 10);
        const totalTravelers = adultCountValue + childCountValue;

        if (totalTravelers > maxVoyageurs) {
            // Ajuster childCountValue pour ne pas dépasser nbVoyageurs
            childCountValue = maxVoyageurs - adultCountValue;
        }

        // Mettre à jour les éléments HTML avec les nouvelles valeurs
        childCount.textContent = childCountValue;
        liveTravelersCount.value = adultCountValue + childCountValue;
    }

    // Gestionnaire d'événement pour le bouton "Ajouter des voyageurs"
    addTravelersBtn.addEventListener('click', openPopup);

    // Fermer la pop-up en cliquant sur l'overlay
    if(overlay) overlay.addEventListener('click', closePopup);

    // MAP GESTION

    let mapObj = document.getElementById('map');
    var longitude = mapObj.dataset.long;
    var latitude = mapObj.dataset.lat;
    var tileType = "OpenStreetMap";

    var map = L.map('map').setView([latitude, longitude], 13);



                L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'ArcGIS'
                }).addTo(map);

    var circle = L.circle([latitude, longitude], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
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
                    onRemove: function(map) {}
                });

                let myControl = new MyControlClass().addTo(map);

    function changeBackground(){
        if(tileType == "OpenStreetMap")
            {
                tileType = "ArcGis";
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }
            else
            {
              tileType = "OpenStreetMap";

              selectedTile = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'ArcGIS'
              }).addTo(map);
        }
    }


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

    let arriveePicker, departPicker;
    const nightCountElement = document.getElementById('night-count');
    const finalTotalElement = document.getElementById('final-total');
    const totalCostElement = document.getElementById('total-cost');
    const nightPriceElement = document.getElementById('nightPrice');
    const costPerNight = parseFloat(nightPriceElement.textContent);

    inputs.forEach((input) => {
        const options = {
            dateFormat: "d-m-Y",
            minDate: "today",
            maxDate: new Date().fp_incr(365)
        };

        if (input.id === 'start-date') {
            options.onChange = function(selectedDates) {
                // Update the minimum date for the departure date
                const minDepartDate = selectedDates[0];
                departPicker.set('minDate', minDepartDate);
                calculateAndDisplayNights();
            };
            arriveePicker = flatpickr(input, options);
        } else if (input.id === 'end-date') {
            options.onChange = function() {
                calculateAndDisplayNights();
            };
            departPicker = flatpickr(input, options);
        } else {
            flatpickr(input, options);
        }
    });

    const priceDisplay = document.querySelector('.prix');
    const buttonDisplay = document.querySelector("#reserverBtn");


    function calculateAndDisplayNights() {
        const startDate = arriveePicker.selectedDates[0];
        const endDate = departPicker.selectedDates[0];

        if (startDate && endDate) {
            const timeDifference = endDate - startDate;
            let nightCount = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

            if (nightCount == 0) {
                nightCount = 1;
            }

            nightCountElement.textContent = nightCount;
            const totalCost = nightCount * costPerNight;
            totalCostElement.textContent = totalCost + " €";
            finalTotalElement.textContent = totalCost + " €";
        } else {
            nightCountElement.textContent = 0;
            totalCostElement.textContent = "0 €";
            finalTotalElement.textContent = "0 €";
        }

        displayPriceDetails();
    }

    function displayPriceDetails() {
        const nightCount = parseInt(nightCountElement.textContent, 10);

        if (nightCount > 0) {
            priceDisplay.style.display = 'flex';
            buttonDisplay.disabled = false;
        } else {
            priceDisplay.style.display = 'none';
            buttonDisplay.disabled = true;
        }
    }

    // Initial call to set the correct values on page load
    calculateAndDisplayNights();

});
