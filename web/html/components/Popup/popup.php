<?php

    class popup {
        public static function render($name, $btn_name, $content) {

            $render = /*html*/ '
                <link rel="stylesheet" href="../../components/Popup/popup.css">
                <script src="../../components/Popup/popup.js"></script>
                <div data-btn="' . $btn_name . '" class="popup ' . $name .'">
                    <div class="popup__content" >
                        <i class="popup--close fa-solid fa-xmark"></i>
                        ' . $content . '
                    </div>
                </div>
            ';

            echo $render;
        }
    }
?>