<?php

class OwnerNavBar {
<<<<<<< HEAD
    public static function render() {
=======
    public static function render($navbarIndex = 0) {
>>>>>>> 391d68267ef87f5c8983e6ae15284a92a5712688
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

<<<<<<< HEAD
        foreach ($pages as $page) {
            $render .= '<li><a href="' . $page[1] . '">' . $page[0] . '</a></li>';
=======
        for ($i = 0; $i < count($pages); $i++) {
            $render .= '<li class="' . ($navbarIndex == $i ? 'active' : '') . '"><a href="' . $pages[$i][1] . '">' . $pages[$i][0] . '</a></li>';
>>>>>>> 391d68267ef87f5c8983e6ae15284a92a5712688
        }

        $render .= /*html*/ '
                </ul>
            </nav>
        ';

        echo $render;
    }
}

?>