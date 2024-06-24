<?php

class HousingCard {

    public static function render(Housing $housing, $class = "", $id = "", $action = "") {
        $housing_id = $housing->getHousingID();
        $housing_name = $housing->getTitle();
        $housing_price = $housing->getPriceIncl();
        $housing_thumbnail = $housing->getImage()->getImageSrc();
        $housing_content = $housing->getShortDesc();
        $housing_city = $housing->getAddress()->getCity();
        $housing_postal_code = $housing->getAddress()->getPostalCode();
        $housing_nb_personn = $housing->getNbPerson();
        $owner_pp = $housing->getOwner()->getImage()->getImageSrc();
        $owner_name = $housing->getOwner()->getNickname();


        $render =  /*html*/ '   
        <link rel="stylesheet" href="/components/HousingCard/HousingCard.css">         

        <a href="/logement?id='. $housing_id .'" class="housing-card '. $class . ' " id=" ' . $id . ' ">
            <img class="housing-card__thumbnail" src="' . $housing_thumbnail . '">
            <div class="housing-card__content">
                <div class="housing-card__content__owner">
                    <img src="' . $owner_pp . '">
                    <p>' . $owner_name . '</p>
                </div>
                <h4>' . $housing_name . '</h4>
                <p>' . $housing_content . '</p>
                <div class="housing-card__content__bottom">
                    <div class="housing-card__content__bottom__infos">
                        <div class="housing-card__content__bottom__infos__picto">
                            <i class="fa-sharp fa-solid fa-location-dot"></i>
                            <p>' . $housing_postal_code . " - " . $housing_city . '</p>
                        </div>
                        <div class="housing-card__content__bottom__infos__picto">
                            <i class="fa-solid fa-user"></i>
                            <p>' . $housing_nb_personn . ' personnes</p>
                        </div>
                    </div>
                    <h3>' . number_format($housing_price, 2, ",") . '€<span>/nuit</span></h3>
                </div>
            </div>
        </a>
        ';

        echo $render;
    }
}
?>

