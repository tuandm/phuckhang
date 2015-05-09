<?php
/**
 * Util class which helps create URLs
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */

class LandBook_Util_Url {

    /**
     * Helper method to build the URL that points to the user profile page
     * @param int $userId ID of the user that the URL points to
     * @param array|null $params Additional parameters passed to the URL's query string
     * @return string
     */
    public static function buildUserProfileUrl($userId, $params = array()) {
        if ($params == null) {
            $params = array();
        }
        $params['userId'] = $userId;
        return site_url('social-userprofilepage?' . build_query($params));
    }

    /**
     * Helper method to build the URL that points to the home page
     * @param int $statusId ID that the URL points to
     * @param array|null $params Additional parameters passed to the URL's query string
     * @return string
     */
    public static function buildUserStatusUrl($statusId, $params = array()) {
        if ($params == null) {
            $params = array();
        }
        $params['statusId'] = $statusId;
        return site_url('social-homepage?' . build_query($params));
    }

    /**
     * Helper method to build the URL that points to the user profile page
     * @param int $groupId ID of the user that the URL points to
     * @param array|null $params Additional parameters passed to the URL's query string
     * @return string
     */
    public static function buildGroupProfileUrl($groupId, $params = array()) {
        if ($params == null) {
            $params = array();
        }
        $params['groupId'] = $groupId;
        // TODO: pass group URL here
        return site_url('XXX' . build_query($params));
    }

}