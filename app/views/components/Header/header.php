<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/views/style/ui.css">
    <link rel="stylesheet" href="/views/components/Header/header.css">
</head>

<?php

class Header {

        public static function render() {
            $render = /*html*/ '
                <script src="/views/components/Header/header.js"></script>
                <header class="header">
                    <a class="logo" href="">
                        <img class="logo-big" src="/views/assets/images/logo_breizh_noir.png" id="logo" alt="logo_breizh">
                        <img class="logo-small" src="/views/assets/icons/logo.svg" alt="logo_breizh">
                    </a>

        ';
        echo $render;

            require_once("../SearchBar/SearchBar.php");
            SearchBar::render("search-bar search-bar--header","","./monSuperFormulaireQuiVaEtreTraiter", true);

            $render =  /*html*/ '

                    <div class="header__right">
                        <i class="fa-sharp fa-regular fa-eye"></i>
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

            </header>
        ';

        echo $render;
    }
}

?>

</html>