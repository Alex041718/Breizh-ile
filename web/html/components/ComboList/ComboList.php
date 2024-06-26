<?php
class ComboList {

    public static function render($class = "", $id = "", $label = "", $name = '', $options = [], $defaultOption = '', $required = false, $selectedValue = '') {

        $requiredAttribute = $required ? ' required' : '';
        // default option
        $optionsHtml = "<option value='' disabled hidden>" . $defaultOption . "</option>";
        foreach ($options as $option) {
            $isSelected = ($option == $selectedValue) ? ' selected' : '';
            $optionsHtml .= '<option value="' . $option . '"' . $isSelected . '>' . $option . '</option>';
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