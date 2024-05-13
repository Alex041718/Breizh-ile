<?php
class Address
{
    private ?int $addressID; // l'id peut être null puisse que c'est la base de données qui s'en charge
    private string $city;
    private string $postalCode;
    private string $postalAddress;

    public function __construct(?int $addressID, string $city, string $postalCode, string $postalAddress)
    {
        $this->addressID = $addressID;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->postalAddress = $postalAddress;
    }

    /**
     * @return int
     */
    public function getAddressID(): int
    {
        return $this->addressID;
    }

    /**
     * @param int $addressID
     */
    public function setAddressID(?int $addressID): void
    {
        $this->addressID = $addressID;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getPostalAddress(): string
    {
        return $this->postalAddress;
    }

    /**
     * @param string $postalAddress
     */
    public function setPostalAddress(string $postalAddress): void
    {
        $this->postalAddress = $postalAddress;
    }


}
?>
