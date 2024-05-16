<?php
// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Image.php';
class ImageService extends Service{

    // CreateImage
    public static function CreateImage(Image $image): Image
    {
        // la méthode crée une image
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Image (src) VALUES (:imageSrc)');
        $stmt->execute(['imageSrc' => $image->getImageSrc()]);
        return new Image($pdo->lastInsertId(), $image->getImageSrc());
    }

    public static function GetImageById(int $imageID): Image
    {
        // la méthode réccupère une image par son ID, méthode assez géneraliste
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Image WHERE imageID = ' . $imageID);
        $row = $stmt->fetch();
        return new Image($row['imageID'], $row['src']);
    }

    public static function GetHousingImages(int $housingID): Image
    {
        // la méthode réccupère toutes les images d'un logement
        // Grace à la table _Housing_Image qui fait le lien entre les images et les logements
        // Etape 1 : réccupérer les imagesID de la table _Housing_Image par rapport à l'ID du logement

        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Housing_Image WHERE housingID = ' . $housingID);
        $imagesID = [];

        while ($row = $stmt->fetch()) {
            $imagesID[] = $row['imageID'];
        }

        // Etape 2 : réccupérer les images par rapport aux imagesID
        $images = [];
        foreach ($imagesID as $imageID) {
            $images[] = self::GetImageById($imageID);
        }

        return $images;
    }
}
?>
