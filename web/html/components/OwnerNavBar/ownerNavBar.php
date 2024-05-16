<?php

class OwnerNavBar {
    public static function render($navbarIndex = 0) {
        $pages = array(
            array("Page d'accueil", ""),
            array("Logements", ""),
            array("Réservations", "")
        );

        $render = /*html*/ '
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