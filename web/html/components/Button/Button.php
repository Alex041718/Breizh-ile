<?php

class ButtonType {
    const Client = 'Client';
    const Owner = 'Owner';
    const Delete = 'Delete';
}

class Button {

    public static function render($class = "",
                                  $id = "",
                                  $text = "",
                                  $type = ButtonType::Client,
                                  $onClick = "",
                                  $isSecondary = true,
                                  $submit = false) {

        $isSubmit = $submit ? 'submit' : 'button';

        // un switch pour gérer le type de bouton
        $secondaryClass = $isSecondary ? '--secondary' : '';

        switch ($type) {
            case ButtonType::Client:
                $class .= ' button--client' . $secondaryClass ;
                break;
            case ButtonType::Owner:
                $class .= ' button--owner' . $secondaryClass ;
                break;
            case ButtonType::Delete:
                $class .= ' button--delete' . $secondaryClass ;
                break;
        }
        $render = /*html*/ '
            <link rel="stylesheet" href="/components/Button/Button.css">
            
            <button type="' . $isSubmit . '" class="button '. $class . ' " id=" ' . $id . ' " onclick="' . $onClick . '">
                ' . $text . '
            </button>
            
        ';
        echo $render;
    }

}

?>
