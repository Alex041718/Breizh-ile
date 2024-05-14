<?php


class HousingCard {

    public static function render(
        $housing_name = "",
        $housing_price = "",
        $housing_thumbnail = "",
        $housing_content = "",
        $housing_city = "",
        $housing_postal_code = "",
        $housing_nb_personn = "",
        $owner_pp = "",
        $owner_name = "",
        $class = "",
        $id = "",
        $action = ""
    ) {


        $render =  /*html*/ '            
            
        <div class="housing-card '. $class . ' " id=" ' . $id . ' ">
            <img class="housing-card__thumbnail" src="' . $housing_thumbnail . '">
            <div class="housing-card__content">
                <div class="housing-card__content__owner">
                    <img src="' . $owner_pp . '">
                    <p>' . $owner_name . '</p>
                </div>
                <h3>' . $housing_name . '</h3>
                <p>' . $housing_content . '</p>
                <div class="housing-card__content__bottom">
                    <div class="housing-card__content__bottom__infos">
                        <div class="housing-card__content__bottom__infos__picto">
                            <img src="/views/assets/icons/location.svg">
                            <p>' . $housing_postal_code . " - " . $housing_city . '</p>
                        </div>
                        <div class="housing-card__content__bottom__infos__picto">
                            <img src="/views/assets/icons/account-black.svg" />
                            <p>' . $housing_nb_personn . ' personnes</p>
                        </div>
                    </div>
                    <h3>' . $housing_price . '€<span>/nuit</span></h3>
                </div>
            </div>
        </div>
        ';

        echo $render;
    }
}
?>

