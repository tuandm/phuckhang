<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 1/31/15
 * Time: 1:21 PM
 */
class Land_Book_Model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Description: Function add a row to database
     * @param $table
     * @param array $data
     * @return bool
     */
    protected function create($table,array $data)
    {
        $result = $this->db->insert($table, $data);
        if ($result == true) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Description: Function get all rows of a table
     * @return array rows of the table depend on the table name
     */
    protected function getAll($table)
    {
        $rows = $this->db->get($table)->result_array();
        return $rows;
    }

    /**
     * Description:
     * @param $table
     * @param array $data
     * @return mixed
     */
    protected function update($table,array $data)
    {
        $where = array('term_id' => $data['term_id']);
        unset($data['term_id']);
        return $this->db->update($table, $data, $where);
    }
}