<?php
class Image {
    public static function getSrc($fileName) {
        echo '/components/Image/get-image.php?img=' . $fileName;
    }
}
?>