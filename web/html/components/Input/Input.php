<?php

class Input {

    public static function render($class = "", $id = "", $type = "text", $label = "",$name = '', $placeholder = "", $required = false, $value = "", $minLength = "", $maxLength = "", $pattern = "") {

        $requiredAttribute = $required ? ' required' : '';

        // switch case
        switch ($type) {

            case "textarea":
                $input = '<textarea class="input__textarea" placeholder="' . $placeholder . '"' . $requiredAttribute . ' value="' . $value . '" minlenght="' . $minLength . '" maxlength="' . $maxLength . '"' . ($pattern == "" ? "" : ' pattern="' . $pattern . '"') . '>' . $value . '</textarea>';
                break;
            case "date":
                $input = '<input name="' . $name . '" type="' . $type . '" class="input__input" placeholder="' . $placeholder . '"' . $requiredAttribute . ' value="' . $value . '" minlenght="' . $minLength . '" maxlength="' . $maxLength . '"' . ($pattern == "" ? "" : ' pattern="' . $pattern . '"') . '>';
                break;
            default:
                $input = '<input name="' . $name . '" type="' . $type . '" class="input__input" placeholder="' . $placeholder . '"' . $requiredAttribute . ' value="' . $value . '" minlenght="' . $minLength . '" maxlength="' . $maxLength . '"' . ($pattern == "" ? "" : ' pattern="' . $pattern . '"') . '>';

        }


        $render =  /*html*/ '


                <link rel="stylesheet" href="/components/Input/Input.css">
            
                <div class="input '. $class . ' " id="' . $id . '">
                    <label class="input__label para--18px" for="' . $name . '">' . $label . ($requiredAttribute ? '<span class="require">*</span>' :''). '</label>
                    
                    '. $input .'
                    
                </div>
';

        echo $render;

    }
}