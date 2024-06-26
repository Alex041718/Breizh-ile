<?php

    class popup {
        public static function render($name, $btn_name, $content) {

            $render = /*html*/ '
                <link rel="stylesheet" href="../../components/Popup/popup.css">

                <div data-btn="' . $btn_name . '" class="popup ' . $name .'">
                    <div class="popup__content" >
                        <i class="popup--close fa-solid fa-xmark" id="xClose"></i>
                        ' . $content . '
                    </div>
                </div>
            ';

            echo $render;
        }
    }
?>