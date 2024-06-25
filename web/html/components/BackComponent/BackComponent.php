<?php

class BackComponent {

    public static function render($class = "",
                                  $id = "",
                                  $text = "",
                                  $redirection = "") {


        if ($redirection != "") {
            $script = "window.location.href='$redirection';";
        } else {
            $script = 'window.history.back();';
        }


        $render = /*html*/ '

        <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="/components/BackComponent/BackComponent.css">
        
        <div onclick='.$script.' class="back-component '. $class .'" id="'. $id .'">
            <a  class="back-component__arrow">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <p class="back-component__text">' . $text . '</p>
        </div>
    ';

        echo $render;


    }
}