<?php

class Input {

    public static function render($class = "", $id = "", $type = "text", $label = "", $placeholder = "") {

        $render =  /*html*/ '
    <link rel="stylesheet" href="/views/components/Input/Input.css">

    <div class="input '. $class . ' " id=" ' . $id . ' ">
        <label class="input__label para--18px">' . $label . '</label>
        
        '. ($type == "textarea" ? '<textarea class="input__textarea" placeholder="' . $placeholder . '"></textarea>' : '<input type="' . $type . '" class="input__input" placeholder="' . $placeholder . '">') .'
        
    </div>
';

        echo $render;

    }
}
?>
