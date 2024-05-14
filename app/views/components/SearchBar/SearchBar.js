
const searchBars = document.querySelectorAll('.search-bar');

searchBars.forEach(searchBar => {
    const btn = searchBar.querySelector(".search-bar__search-btn button");
    const grid = searchBar.querySelector(".search-bar__grid-container");
    const inputs = searchBar.querySelectorAll(".search-bar__grid-container__search-element input");

    const elements = searchBar.querySelectorAll(".search-bar__grid-container__search-element");

    // create inputs with flatpickr for the two dates
    inputs.forEach((inp) => {
        if(inp.id === 'start-date' || inp.id === 'end-date'){
            flatpickr(inp, {
                dateFormat: "d-m-Y",
                minDate: "today",
                maxDate: new Date().fp_incr(365)
            });
            return;
        }
    });

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
        if (!searchBar.contains(event.target) && !searchBar.classList.contains("no-close")) {
            closeSearchBar();
        }
    });


    // Système de recherche, par auto-complétion

    // On recupère l'input
    const searchText = document.getElementById('search-text');

    // on recupère les villes Bretonnes

    const myHeaders = new Headers();
    myHeaders.append("sec-ch-ua", "\"Chromium\";v=\"124\", \"Google Chrome\";v=\"124\", \"Not-A.Brand\";v=\"99\"");
    myHeaders.append("Referer", "http://localhost:5555/views/StoryBook.php");
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