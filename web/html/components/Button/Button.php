<?php

class ButtonType {
    const Client = 'Client';
    const Owner = 'Owner';
    const Delete = 'Delete';
    const Basic = 'Basic';
}

class Button {

    public static function render($class = "",
                                  $id = "",
                                  $text = "",
                                  $type = ButtonType::Client,
                                  $onClick = "",
                                  $isSecondary = true,
                                  $submit = false,
                                  $icon = "") {

        $isSubmit = $submit ? 'submit' : 'button';

        // un switch pour gérer le type de bouton
        $secondaryClass = $isSecondary ? '--secondary' : '';

        switch ($type) {
            case ButtonType::Client:
                $class .= ' button--client' . $secondaryClass . ' button--vert' ;
                break;
            case ButtonType::Owner:
                $class .= ' button--owner' . $secondaryClass  . ' button--bleu' ;
                break;
            case ButtonType::Delete:
                $class .= ' button--delete' . $secondaryClass . ' button--rouge' ;
                break;
            case ButtonType::Basic:
                $class .= ' button--basic' . $secondaryClass . ' button--gris' ;
                break;
        }

        $render = /*html*/ '
            <link rel="stylesheet" href="/components/Button/Button.css">
            
            <button type="' . $isSubmit . '" class="button '. $class . ' " id="' . $id . '" onclick="' . $onClick . '">
                ' . $icon . '
                ' . $text . '
            </button>
            
        ';

        echo $render;
    }
}

?>
