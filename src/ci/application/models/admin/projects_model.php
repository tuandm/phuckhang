<?php
/**
 * User: Phat Nguyen
 * 
 */
require_once(dirname(dirname(__FILE__)) . "/land_book_model.php");
class Projects_Model extends Land_Book_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllProjects()
    {
        $this->db
            ->select('*')
            ->from('pk_lb_projects')
            ->order_by('pk_lb_projects.name', 'ASC');
        $projects = $this->db->get()->result_array();
        return $projects;
    }

    public function countAllProjects()
    {
        return $this->db
                    ->select('*')
                    ->from('pk_lb_projects')
                    ->count_all_results();
    }

    public function getProjById($projId)
    {
        $this->db
            ->select('pk_lb_projects.name, pk_lb_projects.status, pk_lb_projects.lb_project_id')
            ->from('pk_lb_projects')
            ->where('pk_lb_projects.lb_project_id', $projId);
        $proj = $this->db->get()->row();
        return $proj;
    }

    public function getNameStatusByNumber($statusNum)
    {
        $statusName = '';
        switch($statusNum) {
            case 1: $statusName = 'sold';
                break;
            case 2: $statusName = 'selling';
                break;
            case 3: $statusName = 'unsold';
                break;
        }
        return $statusName;
    }

    public function updateProject(array $data)
    {
        $where = array('lb_project_id' => $data['lb_project_id']);
        unset($data['lb_project_id']);
        return $this->db->update('pk_lb_projects', $data, $where);
    }

    public function create($table, array $data)
    {
        $result = $this->db->insert($table, $data);
        if ($result == true) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * 
     * @param unknown $data
    */
    public function deleteProject($data)
    {
        return $this->db->delete('pk_lb_projects', array('lb_project_id' => $data));
    }

}
