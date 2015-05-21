<?php
/**
 * Util class which helps process CI input items
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */

class Input_Util {

    /**
     * Helper method to get the value of an CI input object
     * @param string $input Name of the input
     * @param string $name Name of the input
     * @param object|null $default In case the input value is unset or NULL, a default value will be returned instead
     * @return string
     */
    public function getInputValue($input, $name, $default = null)
    {
        $value = $input->get($name);
        if ($value == null && $default != null) {
            return $default;
        }
        return $value;
    }

}
