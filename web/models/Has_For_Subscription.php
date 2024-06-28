<?php
class HasForSubscription
{
    private int $housingID;
    private int $reservationID ;

    public function __construct(int $housingID, int $reservationID )
    {
        $this->housingID = $housingID;
        $this->arrangementID = $reservationID ;
    }

    public function getHousingID(): int
    {
        return $this->housingID;
    }

    public function getReservationID (): int
    {
        return $this->reservationID ;
    }

    public function setHousingID(int $housingID): void
    {
       $this->housingID = $housingID;
    }

    public function setReservationID(int $reservationID): void
    {
        $this->reservationID = $reservationID;
    }
}