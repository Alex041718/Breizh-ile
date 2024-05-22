const pages_title = ["description", "localisation", "specifications", "arrangements", "activities"];
const pages = pages_title.map(page => document.getElementById(page));

pages.forEach(page => {
    page.addEventListener("click", () => {
        pages.forEach(p => {
            const content = document.querySelector(`.${p.id}`);
            if (content) { content.style.display = "none"; }
            p.classList.remove("active");
        });
        page.classList.add("active");
        const content = document.querySelector(`.${page.id}`);
        if (content) { content.style.display = "flex"; }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var longitude = document.getElementById('longitude');
    var latitude = document.getElementById('latitude');
    var adresse = document.getElementById('adresse');
    var tileType = "OpenStreetMap";

    var map = L.map('map').setView([latitude.innerText, longitude.innerText], 13);

    var marker = L.marker([latitude.innerText, longitude.innerText]).addTo(map)
        .bindPopup(adresse)
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

});
