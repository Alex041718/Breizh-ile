<?php

class Gender {
    private ?int $genderID; // l'id peut être null puisse que c'est la base de données qui s'en charge
    private string $label;

    public function __construct(?int $genderID, string $label) {
        $this->genderID = $genderID;
        $this->label = $label;
    }

    /**
     * @return int|null
     */
    public function getGenderID(): ?int
    {
        return $this->genderID;
    }

    /**
     * @param int|null $genderID
     */
    public function setGenderID(?int $genderID): void
    {
        $this->genderID = $genderID;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }


}


?>
