<?php

class CheckBox {
    public static function render($class = "", $id = "", $name = '', $required = false) {

        $requiredAttribute = $required ? ' required' : '';

        $render =  /*html*/ '
            <link rel="stylesheet" href="../../components/CheckBox/CheckBox.css">
        
            <div class="checkbox '. $class . ' " id=" ' . $id . ' ">
                <input name="' . $name . '" type="checkbox" class="checkbox__input" ' . $requiredAttribute . ' >
            </div>
        ';

        echo $render;
    }
}
?>