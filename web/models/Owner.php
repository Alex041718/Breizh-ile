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
    private string $identityCardFront;
    private string $identityCardBack;
    private string $bankDetails;
    private string $swiftCode;
    private string $IBAN;
    private ?DateTime $lastConnection;
    private DateTime $creationDate;
    private Image $image;
    private Gender $gender;
    private Address $address;
    private ?string $resetTokenHash;
    private ?DateTime $resetTokenExpiration;

    public function __construct(?int $ownerID,
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
                                string $identityCardFront,
                                string $identityCardBack,
                                string $bankDetails,
                                string $swiftCode,
                                string $IBAN,
                                Image $image,
                                Gender $gender,
                                Address $address,
                                ?string $resetTokenHash,
                                ?DateTime $resetTokenExpiration) {
        $this->ownerID = $ownerID;
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
        $this->identityCardFront = $identityCardFront;
        $this->identityCardBack = $identityCardBack;
        $this->bankDetails = $bankDetails;
        $this->swiftCode = $swiftCode;
        $this->IBAN = $IBAN;
        $this->image = $image;
        $this->gender = $gender;
        $this->address = $address;
        $this->resetTokenHash = $resetTokenHash;
        $this->resetTokenExpiration = $resetTokenExpiration;
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
    public function getIdentityCardFront(): string
    {   
        return $this->identityCardFront;
    }

    /**
     * @param string $identityCardFront
     */
    public function setIdentityCardFront(string $identityCardFront): void
    {
        $this->identityCardFront = $identityCardFront;
    }

    /**
     * @return string
     */
    public function getIdentityCardBack(): string
    {   
        return $this->identityCardBack;
    }

    /**
     * @param string $identityCardBack
     */
    public function setIdentityCardBack(string $identityCardBack): void
    {
        $this->identityCardBack = $identityCardBack;
    }

    /**
     * @return string
     */
    public function getBankDetails(): string
    {
        return $this->bankDetails;
    }

    /**
     * @param string $bankDetails
     */
    public function setBankDetails(string $bankDetails): void
    {
        $this->bankDetails = $bankDetails;
    }
    
    /**
     * @return string
     */
    public function getSwiftCode(): string
    {
        return $this->swiftCode;
    }

    /**
     * @param string $swiftCode
     */
    public function setSwiftCode(string $swiftCode): void
    {
        $this->swiftCode = $swiftCode;
    }

    /**
     * @return string
     */
    public function getIBAN(): string
    {
        return $this->IBAN;
    }

    /**
     * @param string $IBAN
     */
    public function setIBAN(string $IBAN): void
    {
        $this->swiftCode = $IBAN;
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

    public function getResetTokenHash(): ?string
    {
        return $this->resetTokenHash;
    }

    public function setResetTokenHash(?string $resetTokenHash): void
    {
        $this->resetTokenHash = $resetTokenHash;
    }

    public function getResetTokenExpiration(): ?DateTime
    {
        return $this->resetTokenExpiration;
    }

    public function setResetTokenExpiration(?DateTime $resetTokenExpiration): void
    {
        $this->resetTokenExpiration = $resetTokenExpiration;
    }


}

?>
