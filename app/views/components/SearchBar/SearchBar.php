<?php

class SearchBar {

    public static function render($class = "", $id = "", $action = "", $showSettings = false) {


        $render =  /*html*/ '
        
        <div data-depth="0" class="search-bar '. $class . ' " id=" ' . $id . ' ">
            <form action=" '. $action .' " method="get" autocomplete="off">
            <div class="search-bar__grid-container">
                <div class="search-bar__grid-container__search-element" type="where">
                    <p class="para--bold para--18px">Où ?</p>
                    <span class="autocomplete">
                        <input class="para--14px" id="search-text" name="searchText" type="text" placeholder="Rechercher une destination">
                    </span>
                </div>
                <div class="search-bar__grid-container__search-element" type="dateStart">
                    <p class="para--bold para--18px">Arrivée</p>
                    <input class="para--14px" name="startDate" id="start-date" type="date" placeholder="Ajouter une date">
                </div>
                <div class="search-bar__grid-container__search-element" type="dateBack">
                    <p class="para--bold para--18px">Départ</p>
                    <input class="para--14px" name="endDate" id="end-date" type="date" placeholder="Ajouter une date">
                </div>
                <div class="search-bar__grid-container__search-element" type="nbPeople">
                    <p class="para--bold para--18px">Combien de personnes ?</p>
                    <input class="para--14px" name="peopleNumber" type="number" placeholder="Ajouter un nombre">
                </div>
            </div>
            ' . ($showSettings ? '<i class="fa-solid fa-sliders"></i>' : '') . '
            <div class="search-bar__search-btn">
                <button type="submit" class=""><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            </form>      
        </div>
        ';

        echo $render;
    }
}

?>
