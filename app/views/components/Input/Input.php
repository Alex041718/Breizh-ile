<?php

class Input {

    public static function render($class = "", $id = "", $type = "text", $label = "",$name = '', $placeholder = "", $required = false) {

        $requiredAttribute = $required ? ' required' : '';

        $render =  /*html*/ '
    <link rel="stylesheet" href="/views/components/Input/Input.css">

    <div class="input '. $class . ' " id=" ' . $id . ' ">
        <label class="input__label para--18px" for="' . $name . '">' . $label . '</label>
        
        '. ($type == "textarea" ? '<textarea class="input__textarea" placeholder="' . $placeholder . '"></textarea>' : '<input name="' . $name . '" type="' . $type . '" class="input__input" placeholder="' . $placeholder . '"' . $requiredAttribute . ' >') .'
        
    </div>
';

        echo $render;

    }
}
?>
