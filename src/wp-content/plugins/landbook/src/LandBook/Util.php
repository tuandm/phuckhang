<?php
/**
 * LandBook Util class
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */
 

class LandBook_Util
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * Get current time base on format
     *
     * @param string $format
     * @return bool|string
     */
    static function now($format = '')
    {
        if ('' == $format) {
            $format = static::DATE_FORMAT;
        }
        return date($format);
    }
}
