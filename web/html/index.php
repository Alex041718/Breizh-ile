
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        Header::render(false);
    ?>
    <main>
        <section class="hero-banner">
            <?php
                require_once("./components/SearchBar/SearchBar.php");
                SearchBar::render("search-bar--home search-bar--open no-close","","./monSuperFormulaireQuiVaEtreTraiter");
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
        <section class="logements">
            <h2>Nos logements</h2>
            <div class="logements__filters">
                <label>Trier par :</label>
                <select>
                    <option>Prix (Croissant)</option>
                    <option>Prix (Croissant)</option>
                    <option>Prix (Croissant)</option>
                    <option>Prix (vraiment très croissant)</option>
                </select>
                <button>Filtre</button>
            </div>
            <div class="logements__container">
                <?php
                require_once("../services/HousingService.php");
                require_once("../services/OwnerService.php");
                require_once("../services/TypeService.php");
                require_once("../services/CategoryService.php");
                require_once("../services/ArrangementService.php");


                $housings = HousingService::GetAllHousings();


                for ($i=0; $i < 9; $i++) {
                    require_once("./components/HousingCard/HousingCard.php");
                    require_once("../models/Housing.php");
                    require_once("../models/Type.php");
                    require_once("../models/Image.php");
                    require_once("../models/Address.php");
                    require_once("../models/Category.php");
                    require_once("../models/Owner.php");
                    require_once("../models/Gender.php");

                    HousingCard::render($housings[$i]);
                }

                ?>

            </div>
            <hr>
            <a class="btn btn--center">Voir d'avantage</a>
        </section>
    </main>
    <?php 
        require_once("./components/Footer/footer.php");
        Footer::render();
    ?>
</body>
</html>