
<?php

class Header {

        public static function render($isScrolling = false) {
            $render = /*html*/ '

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                <link rel="stylesheet" href="/components/SearchBar/SearchBar.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
                <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
                <script src="/components/Helper/autocompletionHelper.js" defer></script>
                <script src="/components/SearchBar/SearchBar.js" defer></script>
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="/components/Header/header.js"></script>
                <link rel="stylesheet" href="/components/Header/header.css">

                <header class="">
                    <div class="header '. ($isScrolling ? 'scroll scrolling' : '' ). '">
                        <a class="logo" href="">
                            <img class="logo-big" src="/assets/images/logo_breizh_noir.png" id="logo" alt="logo_breizh">
                            <img class="logo-small" src="/assets/icons/logo.svg" alt="logo_breizh">
                        </a>


        ';
        echo $render;


          require_once(__ROOT__."/html/components/SearchBar/SearchBar.php");

          
            SearchBar::render("search-bar search-bar--header","","./monSuperFormulaireQuiVaEtreTraiter", true);

            $render =  /*html*/ '

                        <div class="header__right">
                            <i class="fa-solid fa-eye"></i>
                            <i id="profil" class="fa-solid fa-user"></i>
                        </div>
                        <div id="options" style="display: none;">
                            <ul>
                                <li><a href="">Compte</a></li>
                                <li><a href="">Mes réservations</a></li>
                                <li><a href="">Qui sommes nous</a></li>
                                <li><a href="">Se déconnecter</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-mobile">
                        <div class="header-mobile__icon">
                            <i class="fa-sharp fa-solid fa-location-dot"></i>
                            <p>Réservation</p>
                        </div>
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <div class="header-mobile__icon">
                            <i class="fa-solid fa-user"></i>
                            <p>Mon profil</p>
                        </div>
                    </div>
            </header>
        ';

        echo $render;
    }
}

?>

