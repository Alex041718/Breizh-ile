<?php

namespace views\components;

class HousingCard {

    public static function render($class = "", $id = "", $action = "") {


        $render =  /*html*/ '
            <link rel="stylesheet" href="/views/components/HousingCard/HousingCard.css">
            
            
            <div class="housing-card '. $class . ' " id=" ' . $id . ' ">
            
            </div>
        ';

        echo $render;
    }
}
?>
