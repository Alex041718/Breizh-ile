const pages_title = ["description", "localisation", "specifications", "arrangements", "activities"];
const pages = pages_title.map(page => document.getElementById(page));
const addButtonArrangements = document.getElementById("addButtonArrangements");
const addButtonActivities = document.getElementById("addButtonActivities");
const itemsArrangements = document.querySelector(".items-arrangements");
const itemsActivities = document.querySelector(".items-activities");
const inputsTypes = ["input", "textarea", "select"];
const inputs = document.querySelectorAll("input, textarea, select");
const imagePicker = document.querySelector("#imagePicker #drop-area");
const trashButtons = [];
const buttonNext = document.querySelectorAll("#nextButton");
const buttonValidateList = document.querySelectorAll("#validateButton");
const buttonCancelList = document.querySelectorAll("#cancelButton");

let activities = [];
let arrangements = [];

function applyTrashButtons() {
    document.querySelectorAll(".item-arrangement .fa-trash, .item-activity .fa-trash").forEach(trashButton => {
        trashButton.addEventListener("click", () => {
            trashButton.parentElement.remove();
        });
    });
}

// Appelez cette fonction pour les boutons existants
applyTrashButtons();


pages.forEach(page => {
    page.addEventListener("click", () => {
        pages.forEach(p => {
            const content = document.querySelector(`.${p.id}`);
            if (content) {
                content.style.position = "fixed";
                content.style.visibility = "hidden";
            }
            p.classList.remove("active");
        });
        page.classList.add("active");
        const content = document.querySelector(`.${page.id}`);
        if (content) {
            content.style.position = "relative";
            content.style.visibility = "visible";
        }
    });
});

buttonNext.forEach(button => {
    button.addEventListener("click", () => {
        const indexNext = pages_title.indexOf(document.querySelector(".active").id) + 1;
        pages.forEach(p => {
            const content = document.querySelector(`.${p.id}`);
            if (content) {
                content.style.position = "fixed";
                content.style.visibility = "hidden";
            }
            p.classList.remove("active");
        });
        pages[indexNext].classList.add("active");
        const content = document.querySelector(`.${pages[indexNext].id}`);
        if (content) {
            content.style.position = "relative";
            content.style.visibility = "visible";
        }
    });
});

addButtonArrangements.addEventListener("click", () => {
    if (document.getElementsByName("arrangement")[0].value === "") { return; }

    const itemsList = document.querySelectorAll(".item-arrangement");
    for (let i = 0; i < itemsList.length; i++) {
        if (itemsList[i].textContent === document.getElementsByName("arrangement")[0].value) { return; }
    }

    const item = document.createElement("div");
    const p = document.createElement("p");
    item.className = "item-arrangement item";

    p.innerHTML = document.getElementsByName("arrangement")[0].value;

    item.appendChild(p);
    item.innerHTML += '<i class="fa-solid fa-trash"></i>';
    trashButtons.push(item.querySelector("i"));
    applyTrashButtons();

    arrangements.push(document.getElementsByName("arrangement")[0].selectedIndex);

    itemsArrangements.appendChild(item);
});

addButtonActivities.addEventListener("click", () => {
    if (document.getElementsByName("activity")[0].value === "") { return; }
    if (document.getElementsByName("perimeter")[0].value === "") { return; }

    const itemsList = document.querySelectorAll(".activity-text");
    for (let i = 0; i < itemsList.length; i++) {
        if (itemsList[i].querySelectorAll("p")[0].textContent === document.getElementsByName("activity")[0].value &&
            itemsList[i].querySelectorAll("p")[1].textContent === document.getElementsByName("perimeter")[0].value) {
            return;
        }
    }

    const item = document.createElement("div");
    const text = document.createElement("div");
    text.className = "activity-text";
    const p1 = document.createElement("p");
    const p2 = document.createElement("p");

    item.className = "item-activity item";

    p1.innerHTML = document.getElementsByName("activity")[0].value;
    p2.innerHTML = document.getElementsByName("perimeter")[0].value;

    text.appendChild(p1);
    text.appendChild(p2);
    item.appendChild(text);
    item.innerHTML += '<i class="fa-solid fa-trash"></i>';
    trashButtons.push(item.querySelector("i"));
    applyTrashButtons();

    activities.push([document.getElementsByName("activity")[0].selectedIndex, document.getElementsByName("perimeter")[0].selectedIndex]);

    itemsActivities.appendChild(item);
});

//Actions à la validation
buttonValidateList.forEach(buttonValidate => {
    buttonValidate.addEventListener("click", () => {
        console.log("validate");
        let xhr = new XMLHttpRequest();
        const inputFile = document.getElementsByName("file-name")[0];
        let params = `housingID=${document.getElementById("housingID").value}
                            &title=${document.getElementById("title").querySelector("input").value}
                            &shortDesc=${document.getElementById("shortdesc").querySelector("textarea").value}
                            &longDesc=${document.getElementById("longdesc").querySelector("textarea").value}
                            &price=${document.getElementById("priceHT").querySelector("input").value}
                            &nbPerson=${document.getElementById("nbPerson").querySelector("input").value}
                            &nbRooms=${document.getElementById("nbRooms").querySelector("input").value}
                            &nbSimpleBed=${document.getElementById("nbSimpleBed").querySelector("input").value}
                            &nbDoubleBed=${document.getElementById("nbDoubleBed").querySelector("input").value}
                            &beginDate=${document.getElementById("beginDate").querySelector("input").value.split("/").reverse().join("-")}
                            &endDate=${document.getElementById("endDate").querySelector("input").value.split("/").reverse().join("-")}
                            &surfaceInM2=${document.getElementById("surface").querySelector("input").value}
                            &latitude=${document.getElementById("latitude").querySelector("input").value}
                            &longitude=${document.getElementById("longitude").querySelector("input").value}
                            &postalAddress=${document.getElementById("postalAddress").querySelector("input").value}
                            &city=${document.getElementById("city").querySelector("input").value}
                            &country=${document.getElementById("country").querySelector("input").value}
                            &complementAddress=${document.getElementById("complementAddress").querySelector("input").value}
                            &streetNumber=${document.getElementById("streetNumber").querySelector("input").value}
                            &postalCode=${document.getElementById("postalCode").querySelector("input").value}
                            &arrangements=${arrangements.join(",")}
                            &activities=${activities.map(activity => activity.join("|")).join(",")}
                            &image=${inputFile.textContent}
                            &type=${document.getElementById("type").querySelector("select").selectedIndex}
                            &category=${document.getElementById("category").querySelector("select").selectedIndex}`;

        console.log(params);

        // xhr.open("POST", "/owner/creer_un_logement/createHousing.php", true);
        xhr.open("POST", "/owner/modifier_logement/process_modification_logement.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        Toast("Logement mis à jour", "success");
        xhr.send(params);
    });
});

//Actions à l'annulation
buttonCancelList.forEach(buttonCancel => {
    buttonCancel.addEventListener("click", () => {
        window.location.href = "/back/logements";
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var longitude = document.getElementsByName('longitude')[0];
    var latitude = document.getElementsByName('latitude')[0];
    var adresse = document.getElementsByName('postalAddress')[0];
    var city = document.getElementsByName('city')[0];
    var postalCode = document.getElementsByName('postalCode')[0];
    var inputsLocation = [adresse, city, postalCode];
    var inputsGeolocation = [longitude, latitude];

    var tileType = "OpenStreetMap";

    var map = L.map('map').setView([48.202047, -2.932644], 10);

    var marker = L.marker([48.202047, -2.932644]).addTo(map)
        .bindPopup("Votre logement")
        .openPopup();

    L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
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

    inputsLocation.forEach(input => {
        input.addEventListener("input", () => {
            if (input.value.length < 5) { return; }
            setTimeout(() => {
                let address = document.getElementsByName("postalAddress")[0].value;
                let city = document.getElementsByName("city")[0].value;
                let postalCode = document.getElementsByName("postalCode")[0].value;
                let fullAddress = address + " " + city + " " + postalCode;

                fetch(`https://nominatim.openstreetmap.org/search?q=${fullAddress}&format=json&limit=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) { return; }
                        let lat = data[0].lat;
                        let lon = data[0].lon;
                        latitude.value = lat;
                        longitude.value = lon;
                        map.setView([lat, lon], 10);
                        marker.setLatLng([lat, lon]);
                    })
                    .catch(error => {});
            }, 1000);
        });
    });

    inputsGeolocation.forEach(input => {
        input.addEventListener("input", () => {
            if (input.value.length < 5 || input.value.match(/[^0-9.-]/)) { return; }
            setTimeout(() => {
                let lat = document.getElementsByName("latitude")[0].value;
                let lon = document.getElementsByName("longitude")[0].value;

                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) { return; }
                        let address = data.address.road;
                        let city = data.address.city;
                        let postalCode = data.address.postcode;
                        let fullAddress = address + " " + city + " " + postalCode;
                        adresse.value = address;
                        city.value = city;
                        postalCode.value = postalCode;
                        map.setView([lat, lon], 10);
                        marker.setLatLng([lat, lon]);
                    })
                    .catch(error => {});
            }, 1000);
        });
    });
});
