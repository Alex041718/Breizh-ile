<?php

class Input {

    public static function render($class = "", $id = "", $type = "text", $label = "",$name = '', $placeholder = "", $required = false, $value = "") {

        $requiredAttribute = $required ? ' required' : '';

        // switch case
        switch ($type) {

            case "textarea":
                $input = '<textarea class="input__textarea" placeholder="' . $placeholder . '"> ' . $value . '</textarea>';
                break;
            case "date":
                $input = '<input name="' . $name . '" type="' . $type . '" class="input__input" placeholder="' . $placeholder . '"' . $requiredAttribute . ' value="' . $value . '"  >';
                break;
            default:
                $input = '<input name="' . $name . '" type="' . $type . '" class="input__input" placeholder="' . $placeholder . '"' . $requiredAttribute . ' value="' . $value . '" >';

        }


        $render =  /*html*/ '


                <link rel="stylesheet" href="/components/Input/Input.css">
            
                <div class="input '. $class . ' " id=" ' . $id . ' ">
                    <label class="input__label para--18px" for="' . $name . '">' . $label . '</label>
                    
                    '. $input .'
                    
                </div>
';

        echo $render;

    }
}
?>
