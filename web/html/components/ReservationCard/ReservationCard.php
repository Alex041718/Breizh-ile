<?php

//require_once '../../../services/ReservationService.php';

class ReservationCard
{
    public static function render($class = "", $id = "", $data = "")
    {
        $housing = $data->getHousingId();
        $reservation = ReservationService::getReservationByID($data->getId());
        $defaultImage = "../../assets/images/default-house-image.png";
        $imageSrc = $housing->getImage()->getImageSrc();
        $reservation_nbJours =  ReservationService::getNbJoursReservation($reservation->getBeginDate(), $reservation->getEndDate());
        $prixTTC = $housing->getPriceIncl() * $reservation_nbJours + $reservation->getServiceCharge() + $reservation->getTouristTax();
        $render =  /*html*/
            '
            <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="/components/ReservationCard/ReservationCard.css">
            <div class="reservation-card' . ' " id=" ' . $id . '" onclick="redirectToReservationDetails(' . $data->getId() . ')">
                <div class="reservation-card__img-container">
                    <img src=" ' . $imageSrc . '" alt="" onerror=this.src="/FILES/images/default-house-image.png">
                </div>
                <div class="reservation-card__data-container">
                    <h4 class="reservation-card__data-container__title" title="' . $housing->getTitle() . '">' . $housing->getTitle() . '</h4>
                    <div class="reservation-card__data-container__description">
                        ' . $housing->getShortDesc() . '
                    </div>
                    <div class="reservation-card__data-container__down">
                        <div class="reservation-card__data-container__down__ville">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>' . $housing->getAddress()->getPostalCode(). ' - '. $housing->getAddress()->getCity() .'</div>
                        </div>
                        <div class="reservation-card__data-container__down__personne">
                            <i class="fa-solid fa-user"></i>
                            <div>' . $data->getNbPerson() . '</div>
                        </div>
                    </div>
                    
                </div>
                <div class="reservation-card__right">
                    <div class="reservation-card__right__prix"> ' . $prixTTC  . '€ TTC</div>
                    <div class="reservation-card__right__date">' . $reservation->getBeginDate()->format('d/m/Y') . '</div>
                </div>
                
            </div>
        
        ';

        echo $render;
    }
}
