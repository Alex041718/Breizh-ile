<?php
class ImagePicker {
    public static function render($class = "", $id = "", $required = false) {
        $render =  /*html*/ '
            <link rel="stylesheet" href="/components/ImagePicker/ImagePicker.css">
            <div class="image-picker '. $class . ' " id="' . $id . '">
                <label class="image-picker__label" for="drop-area" id="drop-area">
                    <input type="file" name="input-file" id="input-file" accept="image/*" hidden ' . ($required ? 'required' : '') . '>
                    <input type="text" name="file-name" hidden>
                    <div id="img-view" class="image-picker__preview">
                        <img src="/assets/icons/upload.svg" alt="Image preview" class="image-picker__preview__img">
                        <p>Faites glisser une image ici<br>ou<br>cliquez pour en choisir une</p>
                    </div>
                </label>
            </div>
            <script type="module" src="/components/ImagePicker/ImagePicker.js"></script>
        ';

        echo $render;
    }
}
?>