<?php

class Button {

    public static function render($class = "", $id = "", $text = "", $submit = false) {

        $buttonType = $submit ? 'submit' : 'button';

        $render = /*html*/ '
            <link rel="stylesheet" href="/views/components/Button/Button.css">
            
            <button type="' . $buttonType . '" class="button '. $class . ' " id=" ' . $id . ' " >
                ' . $text . '
            </button>
            
        ';
        echo $render;
    }

}

?>
