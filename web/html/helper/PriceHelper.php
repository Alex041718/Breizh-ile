<?php

class PriceHelper
{

    public float $nbPerson;
    public float $nbNight;
    public float $priceUniqueNight;
    public float $serviceFee;
    public float $priceMultipleNight;
    public float $touristTax;
    public float $totalHT;
    public float $TVA;
    public float $totalTVA;
    public float $totalTTC;

    public function __construct(float $nbPerson, float $nbNight, float $priceUniqueNight)
    {
        $this->nbPerson = $nbPerson;
        $this->nbNight = $nbNight;
        $this->priceUniqueNight = $priceUniqueNight;
        $this->TVA = 0.2;

        // calcul à faire

        $this->priceMultipleNight = round($this->priceUniqueNight * $this->nbNight, 2);
        $this->serviceFee = round($this->priceMultipleNight * 0.01, 2);
        $this->touristTax = round($this->nbNight * $this->nbPerson, 2);
        $this->totalHT = round($this->priceMultipleNight + $this->serviceFee + $this->touristTax, 2);
        $this->totalTVA = round($this->totalHT * $this->TVA, 2);
        $this->totalTTC = round($this->totalHT + $this->totalTVA, 2);
    }

    public function getNbPerson(): float
    {
        return $this->nbPerson;
    }

    public function getNbNight(): float
    {
        return $this->nbNight;
    }

    public function getPriceUniqueNight(): float
    {
        return $this->priceUniqueNight;
    }

    public function getServiceFee(): float
    {
        return $this->serviceFee;
    }

    public function getPriceMultipleNight(): float
    {
        return $this->priceMultipleNight;
    }

    public function getTouristTax(): float
    {
        return $this->touristTax;
    }

    public function getTotalHT(): float
    {
        return $this->totalHT;
    }

    public function getTVA(): float
    {
        return $this->TVA;
    }

    public function getTotalTVA(): float
    {
        return $this->totalTVA;
    }

    public function getTotalTTC(): float
    {
        return $this->totalTTC;
    }


}