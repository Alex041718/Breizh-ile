<?php
// it's a first draft
class Housing {
    private int $housingID;
    private string  $title;
    private string $shortDesc;
    private string $longDesc;
    private float $priceExcl;
    private float $priceIncl;
    private int $nbPerson;
    private int $nbRoom;
    private int $nbDoubleBed;
    private int $nbSimpleBed;
    private float $longitude;
    private float $latitude;
    private string $noticeDate;
    private bool $isOnline;
    private ?string $beginDate;
    private ?string $endDate;
    private string $creationDate;
    private int $addressID;
    private int $ownerID;

    // Getters and Setters for each property
    // For example:
    public function getHousingID() {
        return $this->housingID;
    }

    public function setHousingID($housingID) {
        $this->housingID = $housingID;
    }

    // Continue with the rest of the properties...
}
?>
