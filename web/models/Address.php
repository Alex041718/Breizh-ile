<?php
class Address
{
    private ?int $addressID; // l'id peut être null puisse que c'est la base de données qui s'en charge
    private string $city;
    private string $postalCode;
    private string $postalAddress;
    private string $complementAddress;
    private string $streetNumber;
    private string $country;

    public function __construct(?int $addressID, string $city, string $postalCode, string $postalAddress, string $complementAddress, string $streetNumber, string $country)
    {
        $this->addressID = $addressID;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->postalAddress = $postalAddress;
        $this->complementAddress = $complementAddress;
        $this->streetNumber = $streetNumber;
        $this->country = $country;
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

    /**
     * @return string
     */
    public function getComplementAddress(): string
    {
        return $this->complementAddress;
    }

    /**
     * @param string $complementAddress
     */
    public function setComplementAddress(string $complementAddress): void
    {
        $this->complementAddress = $complementAddress;
    }

    /**
     * @return string
     */
    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetNumber
     */
    public function setStreetNumber(string $streetNumber): void
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

}
?>
