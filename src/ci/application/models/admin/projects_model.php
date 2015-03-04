<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 1/31/15
 * Time: 1:24 PM
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
//             ->join('pk_terms', 'pk_terms.term_id = pk_term_taxonomy.term_id', 'left')
//             ->where('pk_term_taxonomy.taxonomy', 'sc_group')
            ->order_by('pk_lb_projects.name', 'ASC');
//         var_dump($projects);
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

    public function addNewProject(array $data)
    {
        return $this->create('pk_term_taxonomy', $data);
    }

    public function updateProject(array $data)
    {
        $where = array('lb_project_id' => $data['lb_project_id']);
        unset($data['lb_project_id']);
        return $this->db->update('pk_lb_projects', $data, $where);
    }

    public function saveTerm(array $term)
    {
        if (isset($term['term_id'])) {
            return $this->updateTerm($term);
        } else {
            return $this->addNewTerm($term);
        }
    }

    public function updateGroupDescription(array $des)
    {
        return $this->update('pk_term_taxonomy', $des);
    }

}