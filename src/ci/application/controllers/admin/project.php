<?php
/**
 * User: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('lb_project_manage');
        $this->load->model('admin/Projects_Model','projModel');
        $this->load->library('form_validation');
    }

    /**
     * 
    */
    public function index()
    {
        $projects = $this->projModel->getAll('pk_lb_projects');
        $numProj = $this->projModel->countAllProjects();
        $projTable = new MY_LB_Project_Manage();
        $projTable->prepare_items($projects, $numProj);
//         var_dump($projects);
//         die();
        $this->load->view('admin/project/view_all', 
                            array('projTable' => $projTable
                        ));
    }

    /**
     * 
     */
    public function edit()
    {
        if(!is_admin()) {
            die('You dont have permission to edit');
        };
        $projId = (int)$this->input->get('proj');
        if($projId <= 0)
        {
            echo 'Invalid Proj ID';
            return;
        }
        $projects = $this->projModel->getAll('pk_lb_projects');
        $statusValues = array(0, 1, 2);
        foreach ($statusValues as $value) {
            $statusNames[] = $this->projModel->getNameStatusByNumber($value);
        }
        var_dump($statusNames);
        $proj = $this->projModel->getProjById($projId);
        $this->load->view('admin/project/edit', array(
                                                    'proj' => $proj,
                                                    'statusNames' =>$statusNames
        ));
    }

    public function update()
    {
        $this->form_validation->set_rules('proj-name', 'proj-name', 'required');
        $this->load->helper('url');
        var_dump($_POST);
        if($this->form_validation->run()==FALSE)
        {
            return $this->edit();
        } else {
            $name = $this->input->post('proj-name');
            $status = $this->input->post('status');
            $id = $this->input->post('lb_project_id');
            $proj = array(
                            'lb_project_id' => $id,
                            'name' => $name,
                            'status' => $status
            );
            if ($this->projModel->updateProject($proj)) {
                redirect('admin/project/index');
            } else { 
                die('xxxx');
            }
        }
    }
    public function importProjects()
    {
        $this->load->view('admin/project/import_projects');
    }

}