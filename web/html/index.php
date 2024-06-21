<?php

// imports
// Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
require_once '../models/Client.php';
require_once '../services/ClientService.php';
require_once '../services/SessionService.php'; // pour le menu du header
$isAuthenticated = SessionService::isClientAuthenticated();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/ui.css">
    <link rel="stylesheet" href="./home/home.css">
    <link rel="stylesheet" href="./components/HousingCard/HousingCard.css">
    <link rel="stylesheet" href="/components/SearchBar/SearchBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script src="./home/script.js"></script>
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>

    <?php // Date picker ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>

    <?php

        require_once("./components/Header/header.php");

        Header::render("search-bar--home", false, $isAuthenticated, $_SERVER['REQUEST_URI']);        

    ?>
    <main>
        <section class="hero-banner">
            <?php
                require_once("./components/SearchBar/SearchBar.php");
                SearchBar::render("search-bar--home search-bar--open no-close","",".#logements");
            ?>
            <div class="hero-banner__parallax" id="scene">
                <img data-depth="0.1" class="house layer" src="assets/images/Houses.png" />
                <img data-depth="0.2" class="breizh layer" src="assets/images/Breizh.png" />
            </div>
            <img class="hero-banner__wave" src="assets/images/wave.png">
            <div id="scrolldown" class='hero-banner__scrolldown'>
                <div class="chevrons">
                    <div class='chevrondown'></div>
                    <div class='chevrondown'></div>
                </div>
            </div>
        </section>
        <section id="logements" class="logements">
            <h2>Nos logements</h2>
            <div class="logements__filters">
                <label>Trier par :</label>
                <select id="sorter">
                    <option value="1">Prix (Croissant)</option>
                    <option value="2">Prix (Décroissant)</option>
                    <option value="3">Date de mise en ligne (Croissant)</option>
                    <option value="4">Date de mise en ligne (Décroissant)</option>
                </select>
                <div class="filter__button">
                    <button id="header__settings">Filtres</button>
                    <?= sizeof($_POST) > 0 ? '<a href="/"><i class="fa-solid fa-xmark"></i></a>' : "" ?>
                </div>
            </div>
            <div class="logements__container">
            <script>
                const container = document.querySelector(".logements__container")
                const sorter = document.getElementById("sorter")
                const filter_submit = document.getElementById("filter_submit")

                let nbPerson = <?= json_encode($_POST['peopleNumber'] ?? null) ?>;
                let beginDate = <?= json_encode($_POST['startDate'] ?? null) ?>;
                let endDate = <?= json_encode($_POST['endDate'] ?? null) ?>;
                let city = <?= json_encode($_POST['searchText'] ?? null) ?>;

                let rawMinPrice = <?= json_encode($_POST['minPrice'] ?? null) ?>;
                let rawMaxPrice = <?= json_encode($_POST['maxPrice'] ?? null) ?>;

                let rawAppartement = <?= json_encode($_POST['appartement'] ?? null) ?>;


                if(city) city = city.split(' ')[0];

                let sort;
                let desc = 0;
                let cpt = 0

                showUser(0, "_Housing.priceIncl", false, false, true);


                filter_submit.addEventListener("click", function() {
                    const popupFilter = filter_submit.parentNode.parentNode;
                    popupFilter.parentNode.classList.remove("popup--open");
                    document.body.style.overflow = '';
                    showUser(cpt, sort, desc, true);
                })
                
                sorter.addEventListener("change", function() {
                    if(sorter.value == 1) { sort = "_Housing.priceIncl"; desc = 0; }
                    else if(sorter.value == 2) { sort = "_Housing.priceIncl"; desc = 1; }
                    else if(sorter.value == 3) { sort = "_Housing.creationDate"; desc = 0; }
                    else if(sorter.value == 4) { sort = "_Housing.creationDate"; desc = 1; }
                    showUser(cpt, sort, desc, true);
                })

                function showUser(cpt, sort, desc, isFirst, isVeryFirst = false) {

                    const minPrice = rawMinPrice && isVeryFirst ? rawMinPrice : document.getElementById("minInput").value;
                    const maxPrice = rawMaxPrice && isVeryFirst ? rawMaxPrice : document.getElementById("maxInput").value;

                    console.log(document.getElementById("minInput").value);
                    console.log(document.getElementById("maxInput").value);
                    console.log(rawMinPrice);
                    console.log(rawMaxPrice);
                    console.log( document.getElementById("appart").value);


                    const appartement = rawAppartement && isVeryFirst ? rawAppartement : document.getElementById("appart").value;
                    console.log( rawAppartement);
                    console.log( isVeryFirst);
                    
                    console.log(appartement);

                    if(isFirst) cpt = 0;
                    const itemsToHide = document.querySelectorAll(".show-more");

                    itemsToHide.forEach(itemToHide => {
                        itemToHide.remove();
                    });
                    const loader = document.createElement("span");
                    loader.classList.add("loader");
                    container.appendChild(loader);

                    var xmlhttp = new XMLHttpRequest();
                    const params = `q=${cpt}&sort=${sort}&desc=${desc}&nbPerson=${nbPerson}&beginDate=${beginDate}&endDate=${endDate}&city=${city}&minPrice=${minPrice}&maxPrice=${maxPrice}&appartement=${appartement}`;

                    xmlhttp.open("POST", "./components/HousingCard/getHousing.php", true);

                    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            container.removeChild(loader)
                            if(isFirst) container.innerHTML = this.responseText;
                            else container.innerHTML += this.responseText;
                        }
                    }

                    xmlhttp.send(params);
                    cpt++;

                }
            </script>
            </div>
        </section>
    </main>
    <?php
        require_once("./components/Footer/footer.php");
        Footer::render();
    ?>



</body>
</html>
