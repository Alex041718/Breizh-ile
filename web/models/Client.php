<?php
require_once 'Image.php';
require_once 'Address.php';
require_once 'Gender.php';
class Client
{
    private ?int $clientID;
    private bool $isBlocked;
    private string $mail;
    private string $firstname;
    private string $lastname;
    private string $nickname;
    private string $password;
    private string $phoneNumber;
    private DateTime $birthDate;
    private bool $consent;
    private DateTime $lastConnection;
    private DateTime $creationDate;
    private Image $image;
    private Gender $gender;
    private Address $address;

    public function __construct(?int $clientID, bool $isBlocked, string $mail, string $firstname, string $lastname, string $nickname, string $password, string $phoneNumber, DateTime $birthDate, bool $consent, DateTime $lastConnection, DateTime $creationDate, Image $image, Gender $gender, Address $address)
    {
        $this->clientID = $clientID;
        $this->isBlocked = $isBlocked;
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
        $this->image = $image;
        $this->gender = $gender;
        $this->address = $address;
    }


    public function getClientID(): ?int
    {
        return $this->clientID;
    }

    public function setClientID(?int $clientID): void
    {
        $this->clientID = $clientID;
    }

    public function getIsBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): void
    {
        $this->isBlocked = $isBlocked;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getConsent(): bool
    {
        return $this->consent;
    }

    public function setConsent(bool $consent): void
    {
        $this->consent = $consent;
    }

    public function getLastConnection(): DateTime
    {
        return $this->lastConnection;
    }

    public function setLastConnection(DateTime $lastConnection): void
    {
        $this->lastConnection = $lastConnection;
    }

    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function setImage(Image $image): void
    {
        $this->image = $image;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}

?>
