<?php
class ImageGetter {
    public static function getSrc($fileName): string {
        return '/components/Image/get-image.php?img=' . $fileName;
    }
}
?>