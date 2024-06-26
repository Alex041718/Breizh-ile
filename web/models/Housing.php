<?php
class Housing {
    private ?int $housingID; // l'id peut être null puisse que c'est la base de données qui s'en charge
    private string $title;
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
    private bool $isOnline;
    private int $noticeCount;
    private DateTime $beginDate;
    private DateTime $endDate;
    private DateTime $creationDate;
    private float $surfaceInM2;
    private Type $type;
    private Category $category;
    private Address $address;
    private Owner $owner;
    private Image $image;

    public function __construct(int $housingID,
                                string $title,
                                string $shortDesc,
                                string $longDesc,
                                float $priceExcl,
                                float $priceIncl,
                                int $nbPerson,
                                int $nbRoom,
                                int $nbDoubleBed,
                                int $nbSimpleBed,
                                float $longitude,
                                float $latitude,
                                bool $isOnline,
                                int $noticeCount,
                                DateTime $beginDate,
                                DateTime $endDate,
                                DateTime $creationDate,
                                float $surfaceInM2,
                                Type $type,
                                Category $category,
                                Address $address,
                                Owner $owner,
                                Image $image) {
        $this->housingID = $housingID;
        $this->title = $title;
        $this->shortDesc = $shortDesc;
        $this->longDesc = $longDesc;
        $this->priceExcl = $priceExcl;
        $this->priceIncl = $priceIncl;
        $this->nbPerson = $nbPerson;
        $this->nbRoom = $nbRoom;
        $this->nbDoubleBed = $nbDoubleBed;
        $this->nbSimpleBed = $nbSimpleBed;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->isOnline = $isOnline;
        $this->noticeCount = $noticeCount;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
        $this->creationDate = $creationDate;
        $this->surfaceInM2 = $surfaceInM2;
        $this->type = $type;
        $this->category = $category;
        $this->address = $address;
        $this->owner = $owner;
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getHousingID(): int
    {
        return $this->housingID;
    }

    /**
     * @param int $housingID
     */
    public function setHousingID(?int $housingID): void
    {
        $this->housingID = $housingID;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getShortDesc(): string
    {
        return $this->shortDesc;
    }

    /**
     * @param string $shortDesc
     */
    public function setShortDesc(string $shortDesc): void
    {
        $this->shortDesc = $shortDesc;
    }

    /**
     * @return string
     */
    public function getLongDesc(): string
    {
        return $this->longDesc;
    }

    /**
     * @param string $longDesc
     */
    public function setLongDesc(string $longDesc): void
    {
        $this->longDesc = $longDesc;
    }

    /**
     * @return float
     */
    public function getPriceExcl(): float
    {
        return $this->priceExcl;
    }

    /**
     * @param float $priceExcl
     */
    public function setPriceExcl(float $priceExcl): void
    {
        $this->priceExcl = $priceExcl;
    }

    /**
     * @return float
     */
    public function getPriceIncl(): float
    {
        return $this->priceIncl;
    }

    /**
     * @param float $priceIncl
     */
    public function setPriceIncl(float $priceIncl): void
    {
        $this->priceIncl = $priceIncl;
    }

    /**
     * @return int
     */
    public function getNbPerson(): int
    {
        return $this->nbPerson;
    }

    /**
     * @param int $nbRoom
     */
    public function setNbPerson(int $nbPerson): void
    {
        $this->nbPerson = $nbPerson;
    }

    /**
     * @return int
     */
    public function getNbRoom(): int
    {
        return $this->nbRoom;
    }

    /**
     * @param int $nbRoom
     */
    public function setNbRoom(int $nbRoom): void
    {
        $this->nbRoom = $nbRoom;
    }

    /**
     * @return int
     */
    public function getNbDoubleBed(): int
    {
        return $this->nbDoubleBed;
    }

    /**
     * @param int $nbDoubleBed
     */
    public function setNbDoubleBed(int $nbDoubleBed): void
    {
        $this->nbDoubleBed = $nbDoubleBed;
    }

    /**
     * @return int
     */
    public function getNbSimpleBed(): int
    {
        return $this->nbSimpleBed;
    }

    /**
     * @param int $nbSimpleBed
     */
    public function setNbSimpleBed(int $nbSimpleBed): void
    {
        $this->nbSimpleBed = $nbSimpleBed;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return bool
     */
    public function getIsOnline(): bool
    {
        return $this->isOnline;
    }

    /**
     * @param bool $isOnline
     */
    public function setIsOnline(bool $isOnline): void
    {
        $this->isOnline = $isOnline;
    }

    /**
     * @return int
     */
    public function getNoticeCount(): int
    {
        return $this->noticeCount;
    }

    /**
     * @param int $noticeCount
     */
    public function setNoticeCount(int $noticeCount): void
    {
        $this->noticeCount = $noticeCount;
    }

    /**
     * @return DateTime
     */
    public function getBeginDate(): DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param DateTime $beginDate
     */
    public function setBeginDate(DateTime $beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
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
     * @return float
     */
    public function getSurfaceInM2(): float
    {
        return $this->surfaceInM2;
    }

    /**
     * @param float $surfaceInM2
     */
    public function setSurfaceInM2(float $surfaceInM2): void
    {
        $this->surfaceInM2 = $surfaceInM2;
    }

    /**
     * @return string
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
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

    /**
     * @return Owner
     */
    public function getOwner(): Owner
    {
        return $this->owner;
    }

    /**
     * @param Owner $owner
     */
    public function setOwner(Owner $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return array
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @param array $image
     */
    public function setImages(Image $image): void
    {
        $this->image = $image;
    }

    public function __toString(): string
    {
        return "title" . $this->getAddress()->getPostalAddress();
    }
}
?>
