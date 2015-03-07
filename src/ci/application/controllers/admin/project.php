<?php
/**
 * User: Phat Nguyen Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    private $statusValues = array(1, 2, 3);
    private $statusNames;
    private $projTable;
    private $projects;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('lb_project_manage');
        $this->load->model('admin/Projects_Model', 'projModel');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url');
        $this->projTable = new MY_LB_Project_Manage();

        foreach ($this->statusValues as $value) {
            $this->statusNames[$value] = $this->projModel->getNameStatusByNumber($value);
        }
    }

    /**
     * 
     */
    public function index()
    {
        $msg = '';
        $this->projects = $this->projModel->getAll('pk_lb_projects');
        $numProj = $this->projModel->countAllProjects();
        $this->projTable->prepare_items($this->projects, $numProj);
        $this->load->view('admin/project/view_all', 
                            array(
                                'projTable'     => $this->projTable,
                                'msg'           => $msg,
                                'statusNames'   => $this->statusNames
                            ));
    }

    public function addProject()
    {
        if(!is_admin()) {
            die('You dont have permission to add a project');
        };
        $this->load->view('admin/project/add_project', array('statusNames' =>$this->statusNames));
    }

    public function createProject()
    {
        $name = $this->input->post('proj-name');
        $status = $this->input->post('status');
        $args = array(
                    'name'      => $name,
                    'status'    => $status
                    );
        if ($this->projModel->create('pk_lb_projects', $args)) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-projects');
        } else {
            die('Server is busy');
        }
    }

    /**
     * 
     */
    public function edit()
    {
        if(!is_admin()) {
            die('You dont have permission to edit');
        }
        $projId = (int)$this->input->get('proj');
        if($projId <= 0) {
            echo 'Invalid Proj ID';
            return;
        }
        $projects = $this->projModel->getAll('pk_lb_projects');
        $proj = $this->projModel->getProjById($projId);
        $this->load->view('admin/project/edit', array(
                                                    'proj'          => $proj,
                                                    'statusNames'   => $this->statusNames
                                                ));
    }

    public function delete()
    {
        global $msg;
        if(!is_admin()) {
            die('You dont have permission to delete');
        }
        $projId = (int)$this->input->get('proj');
        if($projId <= 0) {
            echo 'Invalid Proj ID';
            return;
        }
        if ($this->projModel->deleteProject($projId)) {
            $msg = "Project $projId is deleted";
            wp_redirect(get_option('siteurl') .'/wp-admin/admin.php?page=landbook-projects');
        } else {
            echo 'Can not delete this project';
            return;
        }
    }
    public function update()
    {
        $this->form_validation->set_rules('proj-name', 'proj-name', '|min_length[5]|max_length[12]|is_unique[pk_lb_projects.name]');
        if($this->form_validation->run()==FALSE) {
            return $this->edit();
        } else {
            $name = $this->input->post('proj-name');
            $status = $this->input->post('status');
            $id = $this->input->post('proj-id');
            $proj = array(
                            'lb_project_id'     => $id,
                            'name'              => $name,
                            'status'            => $status
                );
            if ($this->projModel->updateProject($proj)) {
                wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-projects');
            } else { 
                die('Server is busy');
            }
        }
    }

    public function filterAction()
    {
        $projects = $this->projModel->getAll('pk_lb_projects');
        $numProj = $this->projModel->countAllProjects();
        $projTable = new MY_LB_Project_Manage();
        $projTable->prepare_items($projects, $numProj);
        $this->load->view('admin/project/view_all', array('projTable' => $projTable));
    }

    public function importProjects()
    {
        $this->load->view('admin/project/import_projects');
    }

}
