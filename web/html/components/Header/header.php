
<?php



class Header
{

    public static function render($isScrolling = false, $isBackOffice = false, $isAuthenticated = false, $redirectAuthPath = "/")
    {

        $tagToScroll = $isScrolling;

        $render =  '
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
                <script type="module" src="/components/Popup/popup.js"></script>
                <link rel="stylesheet" href="/components/Header/header.css">

                <header class="">
                    <div data-tag="' . $tagToScroll . '" class="header ' . ($isScrolling === true ? 'scroll scrolling rm-anim' : '') . ' ' . ($isBackOffice ? 'header--backoffice' : '') . '">

                        <a class="logo" href="/">
                            <img class="logo-big" src="/assets/images/logo_breizh_noir.png" id="logo" alt="logo_breizh">
                            <img class="logo-small" src="/assets/icons/logo.svg" alt="logo_breizh">
                        </a>
            ';
        echo $render;

        define('__HEADER__', dirname(dirname(__FILE__)));

        if (__HEADER__ == 'www/var') {
            require_once(__HEADER__ . "/html/components/SearchBar/SearchBar.php");
        } else {
            require_once(__HEADER__ . "/SearchBar/SearchBar.php");
        }

        if (!$isBackOffice) {
            SearchBar::render("search-bar search-bar--header", "", "/#logements", true);
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
                            <a href="/global/aboutUs/aboutUs.php">Qui sommes nous ?</a>
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
                        <a href="/global/aboutUs/aboutUs.php">Qui sommes nous ?</a>
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
                        <a href="/client/register">S\'inscrire</a>
                        <a href="/global/aboutUs/aboutUs.php">Qui sommes nous ?</a>
                    </div>
                ';
        }

        if ($isBackOffice && $isAuthenticated) {
            $user = $owner;
        } else if ($isAuthenticated) $user = $client;

        $hiddenInputs = "";

        foreach ($_POST as $key => $value) {
            $hiddenInputs = $hiddenInputs . '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }

        if (__HEADER__ == 'www/var') {
            require_once(__HEADER__ . "/html/components/Popup/popup.php");
        } else {
            require_once(__HEADER__ . "/Popup/popup.php");
        }

        $inputs = "";
        foreach ($_POST as $key => $value) {
            $inputs .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }

        $render =  /*html*/ '

                        <div class="header__right">
                            <i id="oeuil" class="fa-solid fa-eye"></i>
                            ' . ($isAuthenticated ? '<img id="profil" class="profilImg" src="' . $user->getImage()->getImageSrc() . '" />' : '<i id="profil" class="fa-solid fa-user"></i>') .
            '</div>
                        <div id="options" style="display: none;">
                        
                            ' . $menu . '
                            
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
                                <input class="beginDate para--14px" name="startDate" id="start-date" type="date" value="' . (isset($_POST["startDate"]) ? $_POST["startDate"] : "") . '" placeholder="Ajouter une date">
                            </div>
                            <div class="popup__search__content__filter">
                                <p>Départ ?</p>
                                <input class="endDate para--14px" name="endDate" id="end-date" type="date" value="' . (isset($_POST["endDate"]) ? $_POST["endDate"] : "") . '" placeholder="Ajouter une date">
                            </div>
                            <div class="popup__search__content__filter">
                                <p>Combien de personnes ?</p>
                                <input min="0" type="number" name="peopleNumber" value="' . (isset($_POST["peopleNumber"]) ? $_POST["peopleNumber"] : "") . '" placeholder="Ajouter un nombre" />
                            </div>
                            <button type="submit">Rechercher</button>
                        </form>
                    </div>
                    <div class="header-mobile">
                        <div id="header__settings" class="header-mobile__icon">
                            <i class="fa-solid fa-sliders"></i>
                            <p>Filtres</p>
                        </div>
                        <i id="open-search" class="fa-solid fa-magnifying-glass"></i>
                        <div class="header-mobile__icon">

                        ' . ($isAuthenticated ? '<img id="mobile-profil" class="profilImg" src="' . $user->getImage()->getImageSrc() . '" />' : '<i id="mobile-profil" class="fa-solid fa-user"></i>') .
            '<p>Mon profil</p>
                            <div id="mobile-options" style="display: none;">
                                ' . $menu . '
                            </div>
                        </div>
                    </div> ';

        $render .= Popup::render(
            "popup__filter",
            "header__settings",
            $inputs .
                '
                        <div class="popup__filter__top">
                            <h2>Filtres</h2>
                        </div>
                        <div class="popup__filter__container">
                            <h3>Prix</h3>
                            <div class="popup__filter__container__prices">
                                <div class="price-input-container">
                                <div class="price-input">
                                        <div class="price-field">
                                            <span>Prix Minimum</span>
                                            <input type="number"
                                                id="minInput"
                                                class="min-input"
                                                value="' . (isset($_POST["minPrice"]) ? $_POST["minPrice"] : "0") . '">
                                        </div>
                                        <div class="price-field">
                                            <span>Prix Maximum</span>
                                            <input type="number"
                                                id="maxInput"
                                                class="max-input"
                                                value="' . (isset($_POST["maxPrice"]) ? $_POST["maxPrice"] : "500") . '">
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
                                        value="' . (isset($_POST["minPrice"]) ? $_POST["minPrice"] : "0") . '"
                                        step="1">
                                    <input type="range"
                                        class="max-range"
                                        min="0"
                                        max="500"
                                        value="' . (isset($_POST["maxPrice"]) ? $_POST["maxPrice"] : "500") . '"
                                        step="1">
                                </div>
                            </div>
                            <hr>
                            <div class="popup__filter__container__category">
                                <h3>Catégorie</h3>
                                <div class="popup__filter__container__choices">
                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="appart"
                                                name="appartement"
                                                value="' . (isset($_POST["appartement"]) ? $_POST["appartement"] : 1) . '"/>
                                                <label for="appart">Appartement</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="chalet"
                                                name="chalet"
                                                value="' . (isset($_POST["chalet"]) ? $_POST["chalet"] : 1) . '"/>
                                                <label for="chalet">Chalet</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="maison"
                                                name="maison"
                                                value="' . (isset($_POST["maison"]) ? $_POST["maison"] : 1) . '"/>
                                                <label for="maison">Maison</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="bateau"
                                                name="bateau"
                                                value="' . (isset($_POST["bateau"]) ? $_POST["bateau"] : 1) . '"/>
                                                <label for="bateau">Bateau</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="villa"
                                                name="villa"
                                                value="' . (isset($_POST["villa"]) ? $_POST["villa"] : 1) . '"/>
                                                <label for="villa">Villa d\'exception</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="insol"
                                                name="insol"
                                                value="' . (isset($_POST["insol"]) ? $_POST["insol"] : 1) . '"/>
                                                <label for="insol">Logement insolite</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="popup__filter__container__type">
                                <h3>Type</h3>
                                <div class="popup__filter__container__choices">

                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="t1"
                                                name="t1"
                                                value="' . (isset($_POST["t1"]) ? $_POST["t1"] : 1) . '"/>
                                                <label for="t1">T1</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="t2"
                                                name="t2"
                                                value="' . (isset($_POST["t2"]) ? $_POST["t2"] : 1) . '"/>
                                                <label for="t2">T2</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="t3"
                                                name="t3"
                                                value="' . (isset($_POST["t3"]) ? $_POST["t3"] : 1) . '"/>
                                                <label for="t3">T3</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="f1"
                                                name="f1"
                                                value="' . (isset($_POST["f1"]) ? $_POST["f1"] : 1) . '"/>
                                                <label for="f1">F1</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="f2"
                                                name="f2"
                                                value="' . (isset($_POST["f2"]) ? $_POST["f2"] : 1) . '"/>
                                                <label for="f2">F2</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="f3"
                                                name="f3"
                                                value="' . (isset($_POST["f3"]) ? $_POST["f3"] : 1) . '"/>
                                                <label for="f3">F3</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="t4"
                                                name="t4"
                                                value="' . (isset($_POST["t4"]) ? $_POST["t4"] : 1) . '"/>
                                                <label for="t4">T4</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="t5"
                                                name="t5"
                                                value="' . (isset($_POST["t5"]) ? $_POST["t5"] : 1) . '"/>
                                                <label for="t5">T5 et plus</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="t6"
                                                name="t6"
                                                value="' . (isset($_POST["t6"]) ? $_POST["t6"] : 1) . '"/>
                                                <label for="t6">Studio</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="f4"
                                                name="f4"
                                                value="' . (isset($_POST["f4"]) ? $_POST["f4"] : 1) . '"/>
                                                <label for="f4">F4</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="f5"
                                                name="f5"
                                                value="' . (isset($_POST["f5"]) ? $_POST["f5"] : 1) . '"/>
                                                <label for="f5">F5 et plus</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="popup__filter__container__activity">
                                <h3>Activité</h3>
                                <div class="popup__filter__container__choices">
                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="baignade"
                                                name="baignade"
                                                value="' . (isset($_POST["baignade"]) ? $_POST["baignade"] : 1) . '"/>
                                                <label for="baignade">Baignade</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="voile"
                                                name="voile"
                                                value="' . (isset($_POST["voile"]) ? $_POST["voile"] : 1) . '"/>
                                                <label for="voile">Voile</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="canoe"
                                                name="canoe"
                                                value="' . (isset($_POST["canoe"]) ? $_POST["canoe"] : 1) . '"/>
                                                <label for="canoe">Canoë</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="golf"
                                                name="golf"
                                                value="' . (isset($_POST["golf"]) ? $_POST["golf"] : 1) . '"/>
                                                <label for="golf">Golf</label>
                                            </div>  
                                        </div>
                                    </div>

                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="equitation"
                                                name="equitation"
                                                value="' . (isset($_POST["equitation"]) ? $_POST["equitation"] : 1) . '"/>
                                                <label for="equitation">Equitation</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="accrobranche"
                                                name="accrobranche"
                                                value="' . (isset($_POST["accrobranche"]) ? $_POST["accrobranche"] : 1) . '"/>
                                                <label for="accrobranche">Accrobranche</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="randonnee"
                                                name="randonnee"
                                                value="' . (isset($_POST["randonnee"]) ? $_POST["randonnee"] : 1) . '"/>
                                                <label for="randonnee">Randonnée</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="popup__filter__container__amenagement">
                                <h3>Aménagement</h3>
                                <div class="popup__filter__container__choices">
                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="jardin"
                                                name="jardin"
                                                value="' . (isset($_POST["jardin"]) ? $_POST["jardin"] : 1) . '"/>
                                                <label for="jardin">Jardin</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="balcon"
                                                name="balcon"
                                                value="' . (isset($_POST["balcon"]) ? $_POST["balcon"] : 1) . '"/>
                                                <label for="balcon">Balcon</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="terrasse"
                                                name="terrasse"
                                                value="' . (isset($_POST["terrasse"]) ? $_POST["terrasse"] : 1) . '"/>
                                                <label for="terrasse">Terrasse</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="popup__filter__container__choices__row">
                                        <div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox" 
                                                id="piscine"
                                                name="piscine"
                                                value="' . (isset($_POST["piscine"]) ? $_POST["piscine"] : 1) . '"/>
                                                <label for="piscine">Piscine</label>
                                            </div>
                                            <div class="popup__filter__box">
                                                <input type="checkbox"
                                                id="jacuzzi"
                                                name="jacuzzi"
                                                value="' . (isset($_POST["jacuzzi"]) ? $_POST["jacuzzi"] : 1) . '"/>
                                                <label for="jacuzzi">Jacuzzi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="popup__filter__bottom">
                            <button type="submit" id="filter_submit" class="btn">Valider</button>
                        </div>
                    '
        );

        $render .=  Popup::render(
            "popup__access",
            "oeuil",

            '
                            <h2>Accessibilité</h2>
                            <div class="popup__options">
                                <div class="popup__options__couleurfont">
                                    <div id="parent__deute">
                                        <p class="para--18px" id="deute">Mode deutéranope</p>
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
                        '

        ) . '                

            </header>
        ';

        echo $render;
    }
}

?>

