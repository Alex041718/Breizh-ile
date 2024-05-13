
const searchBar = document.getElementsByClassName('search-bar')[0];
const btn = document.querySelector(".search-bar__search-btn button");
const grid = document.querySelector(".search-bar__grid-container");
const inputs = document.querySelectorAll(".search-bar__grid-container__search-element input");

const elements = document.querySelectorAll(".search-bar__grid-container__search-element");

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
    searchBar.style.height = '85px';
    searchBar.style.width = '945';
    searchBar.style.padding = "0px 10px 0px 40px"

    grid.style.gridTemplateColumns = "2.5fr 1.5fr 1.5fr 2.5fr";

    inputs.forEach((inp) => {
        inp.style.display = 'block';
    });

    btn.style.width = '70px';
    btn.style.height = '70px';
}

const closeSearchBar = () => {
    //if there are data in inputs, don't close the search bar
    if(inputs[0].value || inputs[1].value || inputs[2].value || inputs[3].value){
        return;
    }
    searchBar.style.height = '55px';
    searchBar.style.width = '830px';
    searchBar.style.padding = "0px 5px 0px 30px"

    grid.style.gridTemplateColumns = "2.5fr 1.5fr 1.5fr 2.5fr";

    inputs.forEach((inp) => {
        inp.style.display = 'none';
    });

    btn.style.width = '43px';
    btn.style.height = '43px';
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
    if (!searchBar.contains(event.target)) {
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


