<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/views/style/ui.css">
    <link rel="stylesheet" href="/views/components/Header/header.css">
</head>
<body>
    
    <?php

    class Header {

        public static function render() {
            $render = /*html*/ '
                <script src="/views/components/Header/header.js"></script>
                <header>
                    <a href="">
                        <img src="/views/assets/images/logo_breizh_noir.png" id="logo" alt="logo_breizh">
                    </a>

            ';
            echo $render;

            require_once("../components/SearchBar/SearchBar.php");
            SearchBar::render("search-bar--home search-bar--open no-close","","./monSuperFormulaireQuiVaEtreTraiter");

            $render =  /*html*/ '
                    <img src="/views/assets/images/oeuil_ouvert.png" id="oeuil_ouvert" alt="oeuil_ouvert">
                    <img src="/views/assets/images/oeuil_ferme.png" id="oeuil_ferme" alt="oeuil_ferme" style="display: none;">
                    
                    <img src="/views/assets/images/profil.png" id="profil" alt="profil">
                    <div id="options" style="display: none;">
                        <ul>
                            <li><a href="">Compte</a></li>
                            <li><a href="">Mes réservations</a></li>
                            <li><a href="">Qui sommes nous</a></li>
                            <li><a href="">Se déconnecter</a></li>
                        </ul>
                    </div>

                </header>
            ';

            echo $render;
        }
    }

    ?>
    
</body>
</html>