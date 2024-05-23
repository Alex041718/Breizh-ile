<?php
class ComboList {

    public static function render($class = "", $id = "", $label = "", $name = '', $options = [], $defaultOption = '', $required = false) {

        $requiredAttribute = $required ? ' required' : '';
        // default option
        $optionsHtml = "<option value='' disabled selected hidden>" . $defaultOption . "</option>";
        foreach ($options as $option) {
            $optionsHtml .= '<option value="' . $option . '">' . $option . '</option>';
        }

        $render =  /*html*/ '
                <link rel="stylesheet" href="/components/ComboList/ComboList.css">
                <div class="comboList '. $class . ' " id="' . $id . '">
                    <label class="comboList__label para--18px" for="' . $name . '">' . $label . ($requiredAttribute ? '<span class="require">*</span>' :''). '</label>
                    <select name="' . $name . '" class="comboList__select" id="' . $name . '" ' . $requiredAttribute . '>
                        ' . $optionsHtml . '
                    </select>
                </div>';
                
        echo $render;
    }
}
?>