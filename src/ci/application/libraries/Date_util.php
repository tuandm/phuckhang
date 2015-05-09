<?php
/**
 * Util class which helps processing date
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */

class Date_Util {

    /**
     * Calculate elapsed time
     * @param string $dateTime
     * @param bool $full
     * @return string
     */
    public static function getTimeElapsedString($dateTime, $full = false)
    {
        $now = new DateTime();
        $ago = new DateTime($dateTime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' trước' : 'vừa mới';
    }

    /**
     * Format date conditionally by today, yesterday
     * @param string $dateTime
     * @return string
     */
    public static function getDateAsString($dateTime)
    {
        $dateTimeValue = strtotime($dateTime);
        if ($dateTimeValue >= strtotime('today 00:00')) {
            return 'Hôm nay';
        } else if ($dateTimeValue >= strtotime('yesterday 00:00')) {
            return 'Hôm qua';
        }
        return (new DateTime($dateTime))->format('d.m.Y');
    }

}