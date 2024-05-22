
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
                    <div class="popup__">
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
                        <ul>
                            <li><a href="">Bienvenue ' . $owner->getFirstname() . '</a></li>
                            <li><a href="">Mon Compte</a></li>
                            <li><a href="/owner/consulter_reservations/consulter_reservations.php">Mes réservations</a></li>
                            <li><a href="">Qui sommes nous</a></li>
                            <li><a href="' . $urlLogout . '">Se déconnecter</a></li>
                        </ul>
                    ';
                } else {
                    $client = ClientService::getClientById($_SESSION['user_id']);
                    // CLIENT !!!!!!!!!!!!!!!!
                    // CLIENT !!!!!!!!!!!!!!!!
                    $menu = '
                    <ul>
                        <li><a href="">Bienvenue ' . $client->getFirstname() . '</a></li>
                        <li><a href="/client/profil">Mon Compte</a></li>
                        <li><a href="/client/reservations-liste">Mes réservations</a></li>
                        <li><a href="">Qui sommes nous</a></li>
                        <li><a href="' . $urlLogout . '">Se déconnecter</a></li>
                    </ul>
                ';
                }
            } else {

                if ($isBackOffice) {
                    $urlConnexion = "/back/connection?redirect=" . urlencode($redirectAuthPath);
                } else {
                    $urlConnexion = "/client/connection?redirect=" . urlencode($redirectAuthPath);
                }

                $menu = '
                    <ul>
                        <li><a href="'. $urlConnexion .'">Se connecter</a></li>
                        <li><a href="">S\'inscrire</a></li>
                    </ul>
                ';
            }

            if($isBackOffice && $isAuthenticated) {
                $user = $owner;
            }
            else if($isAuthenticated) $user = $client;


            $render =  /*html*/ '

                        <div class="header__right">
                            <i id="oeuil" class="fa-solid fa-eye"></i>
                            ' . ($isAuthenticated ? '<img id="profil" class="profilImg" src="' . $user->getImage()->getImageSrc() . '" />' : '<i id="profil" class="fa-solid fa-user"></i>') .
                        '</div>
                        <div id="options" style="display: none;">
                        
                            '. $menu .'
                            
                        </div>
                    </div>
                    <div class="header-mobile">
                        <div class="header-mobile__icon">
                            <i class="fa-sharp fa-solid fa-location-dot"></i>
                            <p>Réservation</p>
                        </div>
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <div class="header-mobile__icon">
                        ' . ($isAuthenticated ? '<img id="profil" class="profilImg" src="' . $user->getImage()->getImageSrc() . '" />' : '<i id="profil" class="fa-solid fa-user"></i>') .
                            '<p>Mon profil</p>
                        </div>
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

