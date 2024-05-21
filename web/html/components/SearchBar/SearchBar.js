
const searchBars = document.querySelectorAll('.search-bar');

searchBars.forEach(searchBar => {
    const btn = searchBar.querySelector(".search-bar__search-btn button");
    const grid = searchBar.querySelector(".search-bar__grid-container");
    const inputs = searchBar.querySelectorAll(".search-bar__grid-container__search-element input");
    const begin = searchBar.querySelector(".beginDate");
    const end = searchBar.querySelector(".endDate");

    const elements = searchBar.querySelectorAll(".search-bar__grid-container__search-element");

    const endPickr = flatpickr(end, {
        dateFormat: "Y-m-d",
        maxDate: new Date().fp_incr(365),
        disable: [
            function(date) {
                // Désactiver toutes les dates
                return true;
            }
        ]
    });


    const beginPickr = flatpickr(begin, {
        dateFormat: "Y-m-d",
        minDate: "today",
        maxDate: new Date().fp_incr(365),
        onChange: function(selectedDates, dateStr, instance) {
            if(selectedDates == "") {
                endPickr.set('disable', [
                    function(date) {
                        // Désactiver toutes les dates
                        return true;
                    }
                ])

                endPickr.clear()
            }
            else {
                endPickr.set('disable', [])
                endPickr.set('minDate', selectedDates[0]);
                endPickr.toggle();
            }
        },
    });
    
    if(begin.value && !end.value) {
        endPickr.set('disable', [])
        endPickr.set('minDate', new Date(begin.value).fp_incr(1));
    }

    // Initialiser Flatpickr pour l'input de fin 


    // transition function
    const openSearchBar = () => {
        searchBar.classList.add("search-bar--open");
    }

    const closeSearchBar = () => {
        searchBar.classList.remove("search-bar--open");

    }


    elements.forEach((element) => {
        element.addEventListener('click', () => {
            openSearchBar();
            element.getElementsByTagName("input")[0].focus();
        });
    });


    inputs[1].addEventListener('change', () => {
        if(inputs[1].value){
            inputs[2].focus();
        }
    });
    inputs[2].addEventListener('change', () => {
        if(inputs[2].value){
            inputs[3].focus();
        }
    });


    document.addEventListener('click', function(event) {
            // Vérifier si le clic a été fait à l'extérieur de myDiv
        if (!searchBar.contains(event.target) && !event.target.classList.contains("autocomplete--popup") && !searchBar.classList.contains("no-close")) {
            closeSearchBar();
        }
    });


    // Système de recherche, par auto-complétion

    // On recupère l'input
    const searchText = searchBar.querySelector('#search-text');

    // on recupère les villes Bretonnes

    const myHeaders = new Headers();
    myHeaders.append("sec-ch-ua", "\"Chromium\";v=\"124\", \"Google Chrome\";v=\"124\", \"Not-A.Brand\";v=\"99\"");
    myHeaders.append("Referer", "http://localhost:5555/html/StoryBook.php");
    myHeaders.append("sec-ch-ua-mobile", "?0");
    myHeaders.append("User-Agent", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36");
    myHeaders.append("sec-ch-ua-platform", "\"macOS\"");

    const requestOptions = {
    method: "GET",
    headers: myHeaders,
    redirect: "follow"
    };

    let data;

    fetch("https://geo.api.gouv.fr/communes?codeRegion=53", requestOptions)
    .then((response) => response.text())
    .then((result) => {

        // treat the result
        data = JSON.parse(result);

        // data contient des objets de ville, on va les transformer en tableau de string

        let cityNames = [];

        data.forEach((city) => {
            cityNames.push(`${city.nom} (${city.codesPostaux})`);
        });
        
        
        // from autompletionHelper.js
        // mise en place de lautompletion sur l'input

        autocomplete(searchText, cityNames);

    })
    .catch((error) => console.error(error));
});