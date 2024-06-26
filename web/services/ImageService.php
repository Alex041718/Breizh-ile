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
        $source =$image->getImageSrc();
        //FIXME solution temporaire
        if(str_contains($source, "=")){
            $source = explode("=", $source)[1];
        }
        $stmt = $pdo->prepare('INSERT INTO _Image (src) VALUES (:imageSrc)');
        $stmt->bindParam(':imageSrc', $source);
        $stmt->execute();
        //$stmt->execute(['imageSrc' => $image->getImageSrc()]);
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


}
?>
