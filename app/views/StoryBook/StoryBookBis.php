<html>
    <head>
        <meta charset="utf-8"/>
        <title></title>
        <link rel="stylesheet" href="StoryBook.css">
        <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>

        <!-- Import du fichier CSS ui.css, super important pour appliquer le style général de l'appli -->
        <link rel="stylesheet" href="../style/ui.css">
    </head>
    <body>

    <h1>Story Book du Projet</h1>
    <p>Cette page présente les composants et style de notre projet.</p>
    <br>
    <h2>Style global géré par :</h2>
    <ul>
        <li>ui.scss</li>
        <li>variables.scss</li>
    </ul>
    <h2>Sommaire</h2>
    <ul>
        <li><a href="#title">Titres</a></li>
        <li><a href="#text">Textes</a></li>
        <li><a href="#color">Couleurs</a></li>
    </ul>
    <hr>
    <h2 id="title">Style des titres :</h2>
    <br>
    <div class="title-box">
        <h1>Titre 1</h1>
        <h2>Titre 2</h2>
        <h3>Titre 3</h3>
        <h4>Titre 4</h4>
    </div>
    <hr>
    <h2 id="text">Style des textes :</h2>
    <br>
    <div class="text-box">
        <p>Texte normal - 16px --------- "< p >" par défaut</p>
        <p class="para--bold">Texte en gras - 16px --------- "para--bold"</p>
        <p class="para--14px">Texte petit - 14px --------- "para--14px"</p>
        <p class="para--14px para--bold">Texte petit et en gras - 14px --------- "para--14px para--bold"</p>
        <p class="para--18px">Texte grand - 18px --------- "para--18px"</p>
        <p class="para--18px para--bold">Texte grand et en gras - 18px --------- "para--18px para--bold"</p>
        <p class="para--20px">Texte très grand - 20px --------- "para--20px"</p>
        <p class="para--20px para--bold">Texte très grand et en gras - 20px --------- "para--20px para--bold"</p>
    </div>
    <hr>
    <h2 id="color">Style des couleur :</h2>
    <br>
    <div class="color-box">
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--clientPrimaryColor"></div>
            <p>$clientPrimaryColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--ownerPrimaryColor"></div>
            <p>$ownerPrimaryColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--secondaryColor"></div>
            <p>$secondaryColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--blackColor"></div>
            <p>$blackColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--whiteColor"></div>
            <p>$whiteColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--grey1"></div>
            <p>$grey1</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--grey2"></div>
            <p>$grey2</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--grey3"></div>
            <p>$grey3</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--grey4"></div>
            <p>$grey4</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--grey5"></div>
            <p>$grey5</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--successColor"></div>
            <p>$successColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--errorColor"></div>
            <p>$errorColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--warningColor"></div>
            <p>$warningColor</p>
        </div>
        <div class="color-box__container">
            <div class="color-box__container__square color-box__container__square--infoColor"></div>
            <p>$infoColor</p>
        </div>


    </div>

    <hr>
    <h2 id="text">Style des composants :</h2>
    <br>
    <h3 id="text">SearchBar</h3>
    <br>
    <p>Si vous souhaiter maintenir la searchBar ouverte, ajoutez les classes "search-bar--open" et "no-close"</p>
    <br>

    <?php
        require_once("../components/SearchBar/SearchBar.php");
        SearchBar::render("search-bar--storybook","","./monSuperFormulaireQuiVaEtreTraiter");
    ?>

    <br>
    <h4>Comment importer ce composant dans une vue ?</h4>
    <pre>
        <code class="language-php">
            <\?php
                require_once("../components/SearchBar/SearchBar.php");
                SearchBar::render("search-bar--storybook","","./monSuperFormulaireQuiVaEtreTraiter");
            \?>
        </code>
    </pre>
    <script>hljs.highlightAll();</script>

    <br>
    <h3 id="text">HousingCard</h3>
    <br>

    <?php
        require_once("../components/HousingCard/HousingCard.php");
        HousingCard::render("housing-card--storybook","");
    ?>

    <pre>
        <code class="language-php">
            <\?php
                require_once("../components/HousingCard/HousingCard.php");
                HousingCard::render("housing-card--storybook","");
            \?>
        </code>
    </pre>

    </body>
</html>
