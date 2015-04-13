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

    /**
     * Insert a row into a table.
     *
     * @param string $table table name
     * @param array $data Data to insert (in column => value pairs).
     * @param array|string $format Optional. An array of formats to be mapped to each of the value in $data. If string, that format will be used for all of the values in $data.
     * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.
     * @return int|false The number of rows inserted, or false on error.
     */
    public function insert( $table, $data, $format = null ) {
        return $this->getWpdb()->insert($table, $data, $format);
    }

    /**
     * Retrieve one row from the database.
     *
     * @param string|null $query SQL query.
     * @param @param array|mixed $args The array of variables to substitute into the query's placeholders
     * @return mixed Database query result in OBJECT format or null on failure
     */
    public function getRow($query, $params)
    {
        return $this->getWpdb()->get_row($this->_prepareQuery($query, $params));
    }

    /**
     * Retrieve an entire SQL result set from the database.
     *
     * @param string|null $query SQL query.
     * @param @param array|mixed $args The array of variables to substitute into the query's placeholders
     * @return mixed Database query result in OBJECT format or null on failure
     */
    public function getResults($query, $params)
    {
        return $this->getWpdb()->get_results($this->_prepareQuery($query, $params));
    }

    /**
     * Prepare the query if needed
     * @param string $query
     * @param array|null $params
     * @return string Prepared query
     */
    private function _prepareQuery($query, $params)
    {
        if (empty($params)) {
            return $query;
        }
        return $this->getWpdb()->prepare($query, $params);
    }
}
