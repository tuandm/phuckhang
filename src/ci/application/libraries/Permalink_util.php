<?php
/**
 * Util class which helps create URLs
 * @author Duc Duong <duongthienduc@gmail.com>
 * @package LandBook
 */

class Permalink_Util {

    /**
     * Helper method to build the URL that points to the user profile page
     * @param int $userId ID of the user that the URL points to
     * @param array|null $params Additional parameters passed to the URL's query string
     * @return string
     */
    public static function buildUserProfileUrl($userId = null, $params = array()) {
        if ($params == null) {
            $params = array();
        }

        if ($userId != null) {
            $params['userId'] = $userId;
            return site_url('social-user-profile?' . build_query($params));
        } else {
            return site_url('social-user-profile');
        }
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
        return site_url('social-group?' . build_query($params));
    }

    /**
     * Helper method to get the URL that points to the user notifications page
     * @return string
     */
    public static function userNotificationsPage() {
        return site_url('social-user-notifications');
    }

}