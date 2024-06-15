
<?php



class Header {

        public static function render($isScrolling = false, $isBackOffice = false, $isAuthenticated = false, $redirectAuthPath = "/") {

            $tagToScroll = $isScrolling;

            $render = /*html*/ '

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                <title>Breizh\'Ile</title>
                <link rel="stylesheet" href="/components/SearchBar/SearchBar.css">
                <link rel="icon" type="image/x-icon" href="/assets/icons/favicon.png">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
                <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
                <script src="/components/Helper/autocompletionHelper.js" defer></script>
                <script src="/components/SearchBar/SearchBar.js" defer></script>
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="/components/Header/header.js"></script>
                <link rel="stylesheet" href="/components/Header/header.css">

                <header class="">
                    <div data-tag="' . $tagToScroll . '" class="header '. ($isScrolling === true ? 'scroll scrolling rm-anim' : '' ). ' '. ($isBackOffice ? 'header--backoffice' : '' ). '">

                        <a class="logo" href="/">
                            <img class="logo-big" src="/assets/images/logo_breizh_noir.png" id="logo" alt="logo_breizh">
                            <img class="logo-small" src="/assets/icons/logo.svg" alt="logo_breizh">
                        </a>
            ';
            echo $render;

            define('__HEADER__', dirname(dirname(__FILE__)));

            if (__HEADER__ == 'www/var'){
                require_once(__HEADER__ . "/html/components/SearchBar/SearchBar.php");
            }
            else{
                require_once(__HEADER__ . "/SearchBar/SearchBar.php");
            }

            if (!$isBackOffice) {
                SearchBar::render("search-bar search-bar--header","","/#logements", true);
            }

            // gestion du menu
            $menu = '';

            if ($isBackOffice) {
                $urlLogout = "/logout?redirect=" . urlencode($redirectAuthPath);
            } else {
                $urlLogout = "/logout?redirect=" . urlencode($redirectAuthPath);
            }

            if ($isAuthenticated) {

                // Réccupération des informations du user connecté
                // ça peut être un client ou un propriétaire
                if ($isBackOffice) {
                    $owner = OwnerService::getOwnerById($_SESSION['user_id']);
                    // OWNER !!!!!!!!!!!!!!!!
                    // OWNER !!!!!!!!!!!!!!!!
                    $menu = '
                        <div class="option__container">
                            <p>Bienvenue ' . $owner->getFirstname() . '</p>
                            <a href="/back/profile">Mon Compte</a>
                            <a href="/back/ownerReservations">Mes réservations</a>
                            <a href="">Qui sommes nous</a>
                            <a href="' . $urlLogout . '">Se déconnecter</a>
                        </div>
                    ';
                } else {
                    $client = ClientService::getClientById($_SESSION['user_id']);
                    // CLIENT !!!!!!!!!!!!!!!!
                    // CLIENT !!!!!!!!!!!!!!!!
                    $menu = '
                    <div class="option__container">
                        <p href="">Bienvenue ' . $client->getFirstname() . '</p>
                        <a href="/client/profile">Mon Compte</a>
                        <a href="/client/reservations-liste">Mes réservations</a>
                        <a href="">Qui sommes nous</a>
                        <a href="' . $urlLogout . '">Se déconnecter</a>
                    </div>

                ';
                }
            } else {

                if ($isBackOffice) {
                    $urlConnexion = "/back/connection?redirect=" . urlencode($redirectAuthPath);
                } else {
                    $urlConnexion = "/client/connection?redirect=" . urlencode($redirectAuthPath);
                }

                $menu = '
                    <div class="option__container">
                        <a href="'. $urlConnexion .'">Se connecter</a>
                        <a href="">S\'inscrire</a>
                    </div>
                ';
            }

            if($isBackOffice && $isAuthenticated) {
                $user = $owner;
            }
            else if($isAuthenticated) $user = $client;

            $hiddenInputs = "";

            foreach ($_POST as $key => $value) {
                $hiddenInputs = $hiddenInputs . '<input type="hidden" name="'. $key . '" value="' . $value . '" />';
            }

            $render =  /*html*/ '

                        <div class="header__right">
                            <i id="oeuil" class="fa-solid fa-eye"></i>
                            ' . ($isAuthenticated ? '<img id="profil" class="profilImg" src="' . $user->getImage()->getImageSrc() . '" />' : '<i id="profil" class="fa-solid fa-user"></i>') .
                        '</div>
                        <div id="options" style="display: none;">
                        
                            '. $menu .'
                            
                        </div>
                    </div>
                    <div class="popup__search">
                        <form method="POST" class="popup__search__content" action="/#logements">
                            <div class="popup__search__content__filter" type="where">
                                <p>Où ?</p>
                                <span class="autocomplete">
                                    <input id="text-input" name="searchText" type="text" value="' . (isset($_POST["searchText"]) ? $_POST["searchText"] : "") . '" placeholder="Rechercher une destination">
                                </span>
                            </div>
                            <div class="popup__search__content__filter">
                                <p>Arrivée ?</p>
                                <input class="beginDate para--14px" name="startDate" id="start-date" type="date" value="' . (isset($_POST["startDate"]) ? $_POST["startDate"] : "") .'" placeholder="Ajouter une date">
                            </div>
                            <div class="popup__search__content__filter">
                                <p>Départ ?</p>
                                <input class="endDate para--14px" name="endDate" id="end-date" type="date" value="' . (isset($_POST["endDate"]) ? $_POST["endDate"] : "") .'" placeholder="Ajouter une date">
                            </div>
                            <div class="popup__search__content__filter">
                                <p>Combien de personnes ?</p>
                                <input min="0" type="number" name="peopleNumber" value="' . (isset($_POST["peopleNumber"]) ? $_POST["peopleNumber"] : "") .'" placeholder="Ajouter un nombre" />
                            </div>
                            <button type="submit">Rechercher</button>
                        </form>
                    </div>
                    <div class="header-mobile">
                        <div id="open-mobile-settings" class="header-mobile__icon">
                            <i class="fa-solid fa-sliders"></i>
                            <p>Filtres</p>
                        </div>
                        <i id="open-search" class="fa-solid fa-magnifying-glass"></i>
                        <div class="header-mobile__icon">

                        ' . ($isAuthenticated ? '<img id="mobile-profil" class="profilImg" src="' . $user->getImage()->getImageSrc() . '" />' : '<i id="mobile-profil" class="fa-solid fa-user"></i>') .
                            '<p>Mon profil</p>
                            <div id="mobile-options" style="display: none;">
                                '. $menu .'
                            </div>
                        </div>
                    </div>
                    <div id="popup__filter__header" class="popup__filter">
                        <form method="POST" action="./#logements" class="popup__filter__content">' .
                            $hiddenInputs .
                            '<input type="hidden" />
                            <div class="popup__filter__top">
                                <h2>Filtres</h2>
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                            <div class="popup__filter__container">
                                <h3>Prix</h3>
                                <div class="popup__filter__container__prices">
                                    <div class="price-input-container">
                                        <div class="price-input">
                                            <div class="price-field">
                                                <span>Prix Minimum</span>
                                                <input type="number"
                                                    name="minPrice"
                                                    class="min-input"
                                                    value="' . (isset($_POST["minPrice"]) ? $_POST["minPrice"] : "0") .'">
                                            </div>
                                            <div class="price-field">
                                                <span>Prix Maximum</span>
                                                <input type="number"
                                                    name="maxPrice"
                                                    class="max-input"
                                                    value="' . (isset($_POST["minPrice"]) ? $_POST["minPrice"] : "500").'">
                                            </div>
                                        </div>
                                        <div class="slider-container">
                                            <div class="price-slider">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slider -->
                                    <div class="range-input">
                                        <input type="range"
                                            class="min-range"
                                            min="0"
                                            max="500"
                                            value="0"
                                            step="1">
                                        <input type="range"
                                            class="max-range"
                                            min="0"
                                            max="500"
                                            value="500"
                                            step="1">
                                    </div>
                                </div>
                                <hr>
                                <div class="popup__filter__container__category">
                                    <h3>Catégorie</h3>
                                    <div class="popup__filter__container__choices">
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>Appartement</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>Chalet</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>Maison</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>Bateau</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>Villa d\'exception</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>Logement insolite</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="popup__filter__container__type">
                                    <h3>Type</h3>
                                    <div class="popup__filter__container__choices">
                                    <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>T1</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>T2</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>T3</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>T4</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>T5</p>
                                        </div>
                                        <div class="popup__filter__box">
                                            <input type="checkbox" />
                                            <p>T6</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="popup__filter__bottom">
                                <button type="submit" id="filter_submit__header" class="btn"a>Valider</a>
                            </div>
                        </form>
                    </div>
                    <div id="popup__access" class="popup__access">
                        <div class="popup__content" >
                            <i id="closeAccess" class="fa-solid fa-xmark"></i>
                            <h2>Accessibilité</h2>
                            <div class="popup__options">
                                <div class="popup__options__couleurfont">
                                    <div id="parent__couleurs">
                                        <p class="para--18px" id="couleurs">Couleurs daltonisme</p>
                                    </div>
                                    <div id="parent__animations">   
                                        <p class="para--18px" id="animations">Animations</p>
                                    </div>
                                </div>
                                <div>
                                    <div id="parent__taille">   
                                        <p class="para--18px" id="taille">Police taille</p>
                                    </div>
                                    <div id="parent__font">
                                        <p class="para--18px" id="font">Font police</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    

            </header>
        ';

        echo $render;
    }
}

?>

