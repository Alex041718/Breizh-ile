<?php

class SearchBar {

    public static function render($class = "", $id = "", $action = "") {


        $render =  /*html*/ '

        <link rel="stylesheet" href="/views/components/SearchBar/SearchBar.css">
        <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>

        <script src="/views/components/Helper/autocompletionHelper.js" defer></script>
        <script src="/views/components/SearchBar/SearchBar.js" defer></script>
        

        <?php // Date picker ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        
        <div class="search-bar '. $class . ' " id=" ' . $id . ' ">
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
