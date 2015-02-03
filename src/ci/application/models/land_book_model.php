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
    }

    protected function create($table,array $data)
    {
        $result = $this->db->insert($table, $data);
        if ($result == true) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    protected function getAll()
    {
        $row = $this->db->get($this->tableName)->result_array();
        return $row;
    }

    protected function updateGroup($table,array $data)
    {
        $where = array('term_id' => $data['term_id']);
        unset($data['term_id']);
        return $this->db->update($table, $data, $where);
    }

}