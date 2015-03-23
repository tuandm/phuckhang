<?php
/**
 * LandBook general model
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package
 */
 

class LandBook_Model
{
    /**
     * @var wpdb
     */
    protected $wpdb;

    /**
     * @return wpdb
     */
    public function getWpdb()
    {
        if (!$this->wpdb) {
            global $wpdb;
            $this->wpdb = $wpdb;
        }
        return $this->wpdb;
    }

}
