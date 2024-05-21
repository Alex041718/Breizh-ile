<?php

class OwnerNavBar {
    public static function render($navbarIndex = 0) {
        $pages = array(
            array("Page d'accueil", ""),
            array("Logements", "/back/logements"),
            array("Réservations", "/back/reservations"),
        );

        $render = /*html*/ '
            <link rel="stylesheet" href="../../components/OwnerNavBar/ownerNavBar.css">
            <nav class="owner-nav-bar">
                <ul>
        ';

        for ($i = 0; $i < count($pages); $i++) {
            $render .= '<li class="' . ($navbarIndex == $i ? 'active' : '') . '"><a href="' . $pages[$i][1] . '">' . $pages[$i][0] . '</a></li>';
        }

        $render .= /*html*/ '
                </ul>
            </nav>
        ';

        echo $render;
    }
}

?>