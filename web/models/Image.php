<?php
require_once dirname(dirname(__FILE__)) . '/html/components/Image/Image.php';

class Image {
    private ?int $imageID;
    private string $imageSrc;

    public function __construct(?int $imageID, string $imageSrc) {
        $this->imageID = $imageID;
        $this->imageSrc = $imageSrc;
    }

    /**
     * @return int
     */
    public function getImageID(): int
    {
        return $this->imageID;
    }

    /**
     * @param int $imageID
     */
    public function setImageID(?int $imageID): void
    {
        $this->imageID = $imageID;
    }

    /**
     * @return string
     */
    public function getImageSrc(): string
    {
        if (filter_var($this->imageSrc, FILTER_VALIDATE_URL)) {
            return $this->imageSrc;
        } else {
            return ImageGetter::getSrc($this->imageSrc);
        }
    }

    /**
     * @param string $imageSrc
     */
    public function setImageSrc(string $imageSrc): void
    {
        $this->imageSrc = $imageSrc;
    }

}
?>
