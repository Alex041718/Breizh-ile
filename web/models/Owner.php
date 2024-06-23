<?php

class Owner {
    private ?int $ownerID;
    private string $identityCard;
    private string $mail;
    private string $firstname;
    private string $lastname;
    private string $nickname;
    private string $password;
    private string $phoneNumber;
    private DateTime $birthDate;
    private bool $consent;
    private bool $isValidated;
    private ?DateTime $lastConnection;
    private DateTime $creationDate;
    private Image $image;
    private Gender $gender;
    private Address $address;

    public function __construct(?int $ownerID,
                                string $identityCard,
                                string $mail,
                                string $firstname,
                                string $lastname,
                                string $nickname,
                                string $password,
                                string $phoneNumber,
                                DateTime $birthDate,
                                bool $consent,
                                ?DateTime $lastConnection,
                                DateTime $creationDate,
                                bool $isValidated,
                                Image $image,
                                Gender $gender,
                                Address $address) {
        $this->ownerID = $ownerID;
        $this->identityCard = $identityCard;
        $this->mail = $mail;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->birthDate = $birthDate;
        $this->consent = $consent;
        $this->lastConnection = $lastConnection;
        $this->creationDate = $creationDate;
        $this->isValidated = $isValidated;
        $this->image = $image;
        $this->gender = $gender;
        $this->address = $address;
    }


    public function getIsValidated(): bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): void
    {
        $this->isValidated = $isValidated;
    }

    /**
     * @return int
     */
    public function getOwnerID(): int
    {
        return $this->ownerID;
    }

    /**
     * @param int $ownerID
     */
    public function setOwnerID(?int $ownerID): void
    {
        $this->ownerID = $ownerID;
    }

    /**
     * @return string
     */
    public function getIdentityCard(): string
    {
        return $this->identityCard;
    }

    /**
     * @param string $identityCard
     */
    public function setIdentityCard(string $identityCard): void
    {
        $this->identityCard = $identityCard;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return DateTime
     */
    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     */
    public function setBirthDate(DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return bool
     */
    public function getConsent(): bool
    {
        return $this->consent;
    }

    /**
     * @param bool $consent
     */
    public function setConsent(bool $consent): void
    {
        $this->consent = $consent;
    }

    /**
     * @return DateTime
     */
    public function getLastConnection(): ?DateTime
    {
        return $this->lastConnection;
    }

    /**
     * @param DateTime $lastConnection
     */
    public function setLastConnection(DateTime $lastConnection): void
    {
        $this->lastConnection = $lastConnection;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param DateTime $creationDate
     */
    public function setCreationDate(DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image): void
    {
        $this->image = $image;
    }

    /**
     * @return Gender
     */
    public function getGender(): Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender $gender
     */
    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }


}

?>
