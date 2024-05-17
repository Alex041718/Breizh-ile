<?php

class OwnerNavBar {
    public static function render() {
        $pages = array(
            array("Page d'accueil", ""),
            array("Logements", ""),
            array("Réservations", "")
        );

        $render = /*html*/ '
            <link rel="stylesheet" href="../../components/OwnerNavBar/ownerNavBar.css">
            <nav class="owner-nav-bar">
                <ul>
        ';

        foreach ($pages as $page) {
            $render .= '<li><a href="' . $page[1] . '">' . $page[0] . '</a></li>';
        }

        $render .= /*html*/ '
                </ul>
            </nav>
        ';

        echo $render;
    }
}

?>