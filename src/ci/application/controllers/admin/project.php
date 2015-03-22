<?php
/**
 * User: Phat Nguyen
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    private $statusValues = array(0, 1, 2, 3);
    private $statusNames;
    private $projTable;
    private $projects;
    private $order;
    private $orderBy;
    private $checkHeader;

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
        $this->orderBy = !empty($this->input->get('orderby')) ? $this->input->get('orderby') : 'lb_project_id';
        $this->order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $this->checkHeader = $this->input->get('noheader');
        if (isset($this->checkHeader)) {
            require_once(ABSPATH . 'wp-admin/admin-header.php');
        }
    }

    /**
     * 
     */
    public function index()
    {
        $this->projects = $this->projModel->getAllProjects($this->order, $this->orderBy);
        $numProj = $this->projModel->countAllProjects();
        $this->projTable->prepare_items($this->projects, $numProj);
        $this->load->view('admin/project/view_all', array(
            'projTable'     => $this->projTable,
            'statusNames'   => $this->statusNames
        ));
    }

    /**
     * 
     */
    public function addProject()
    {
        $addStatusValues = array(1, 2, 3);

        if (!empty($this->input->post('proj-name'))) {
            $postData = $this->input->post();
        } else {
            $postData = array(
                'proj-name' => '',
                'status'    => '1'
            );
        }
        foreach ($addStatusValues as $value) {
            $addStatusNames[$value] = $this->projModel->getNameStatusByNumber($value);
        }
        if (is_admin()) {
            $this->load->view('admin/project/add_project', array(
                'statusNames'   => $addStatusNames,
                'postData'      => $postData
            ));
        } else {
            die('You dont have permission to add a project');
        }
    }

    /**
     * 
     */
    public function createProject()
    {
        $this->form_validation->set_rules('proj-name', 'proj-name', 'required|min_length[5]|max_length[100]|is_unique[pk_lb_projects.name]');
        if ($this->form_validation->run() == FALSE) {
            $this->addProject();
        } else {
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
    }

    /**
     * 
     */
    public function edit()
    {
        if(!is_admin()) {
            die('You dont have permission to edit');
        }
        $projId = $this->input->post('proj-id') ? $this->input->post('proj-id') : $projId = $this->input->get('proj');
        if ($projId <= 0) {
            echo 'Invalid Proj ID';
            return;
        }
        $projects = $this->projModel->getAllProjects($this->order, $this->orderBy);;
        $proj = $this->projModel->getProjById($projId);
        $this->load->view('admin/project/edit', array(
            'proj'          => $proj,
            'statusNames'   => $this->statusNames
        ));
    }

    /**
     * 
     */
    public function delete()
    {
        if (!is_admin()) {
            die('You dont have permission to delete');
        }
        $projId = (int) $this->input->get('proj');
        if ($projId <= 0) {
            echo 'Invalid Proj ID';
            return;
        }
        if ($this->projModel->deleteProject($projId)) {
            wp_redirect(get_option('siteurl') .'/wp-admin/admin.php?page=landbook-projects');
        } else {
            echo 'Can not delete this project';
            return;
        }
    }

    /**
     * 
     */
    public function update()
    {
        $name = $this->input->post('proj-name');
        $status = $this->input->post('status');
        $id = $this->input->post('proj-id');
        $this->form_validation->set_rules('proj-name', 'proj-name', 'required|min_length[5]|max_length[100]|callback_checkProjectName');
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $proj = array(
                'lb_project_id' => $id,
                'name'          => $name,
                'status'        => $status
            );
            if ($this->projModel->updateProject($proj)) {
                wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-projects');
            } else {
                die('Server is busy');
            }
        }
    }

    public function checkProjectName()
    {
        $id = $this->input->post('proj-id');
        $name = $this->input->post('proj-name');
        $checkedProjId = $this->projModel->getProjByName($name);
        if (($id == $checkedProjId->lb_project_id) || empty($checkedProjId)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkProjectName', 'This name is used by another project');
            return FALSE;
        }
    }

    /**
     * 
     */
    public function filterAction()
    {
        $s = $this->input->get('s');
        $status = $this->input->get('status');
        $this->projects = $this->projModel->filterProject($s, $status, $this->orderBy, $this->order);
        $numProj = $this->projModel->countFilterProject($s, $status);
        $this->projTable->prepare_items($this->projects, $numProj);
        $this->load->view('admin/project/view_all', array(
            'projTable'     => $this->projTable,
            'statusNames'   => $this->statusNames
        ));
    }

    /**
     * 
     */
    public function importProjects()
    {
        $this->load->view('admin/project/import_projects');
    }

}
