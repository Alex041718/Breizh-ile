
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/ui.css">
    <link rel="stylesheet" href="./home/home.css">
    <link rel="stylesheet" href="./components/HousingCard/HousingCard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
</head>
<body>
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
            <div class='hero-banner__scrolldown'>
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
                for ($i=0; $i < 8; $i++) {
                    require_once("./components/HousingCard/HousingCard.php");
                    HousingCard::render(
                        "Appartement pipou",
                        60,
                        "./assets/images/test.jpg",
                        "Un superbe appartement avec vue mer, près du centre. Une occasion parfaite pour voyager ! ",
                        "Lannion",
                        "22300",
                        4,
                        "./assets/images/pp-test.jpg",
                        "Benoît Tottereau",
                        "housing-card--home",""
                    );
                }

                ?>

            </div>
        </section>
    </main>
    <script>
        var scene = document.getElementById('scene');
        var parallaxInstance = new Parallax(scene, {
            relativeInput: false
        });
    </script>
</body>
</html>