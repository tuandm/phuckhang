<?php
/**
 * User: Phat Nguyen
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
    private $userTable;
    private $users;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ScUserManage');
        $this->load->model('admin/Users_Model','userModel');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url');
        $this->userTable = new MY_SCUserManage();
    }
    
    /**
     * Show All Users
     */
    public function index()
    {
        $orderBy = !empty($this->input->get('orderBy')) ? $this->input->get('orderBy') : 'ID';
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $this->users = $this->userModel->getAllUsers($order, $orderBy);
        foreach ($this->users as &$user) {
            $user['group_ids'] = $this->userModel->getGroupsByUserId($user['ID']);
        }
        $numUser = $this->userModel->countAllUsers();
        $this->userTable->prepare_items($this->users, $numUser);
        $this->load->view('admin/user/view_all', array('userTable' => $this->userTable));
    }

}

//     /**
//      *
//      */
//     public function addProject()
//     {
//         $addStatusVal = array(1, 2, 3);
//         foreach ($addStatusVal as $value) {
//             $addStatusNames[$value] = $this->projModel->getNameStatusByNumber($value);
//         }
//         if(!is_admin()) {
//             die('You dont have permission to add a project');
//         }
//         $this->load->view('admin/project/add_project', array('statusNames' => $addStatusNames));
//     }

//     /**
//      *
//      */
//     public function createProject()
//     {
//         $this->form_validation->set_rules('proj-name', 'proj-name', '|min_length[5]|max_length[12]|is_unique[pk_lb_projects.name]');
//         if($this->form_validation->run()==FALSE) {
//             return $this->addProject();
//         } else {
//             $name = $this->input->post('proj-name');
//             $status = $this->input->post('status');
//             $args = array(
//                             'name'      => $name,
//                             'status'    => $status
//             );
//             if ($this->projModel->create('pk_lb_projects', $args)) {
//                 wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-projects');
//             } else {
//                 die('Server is busy');
//             }
//         }
//     }

//     /**
//      *
//      */
//     public function edit()
//     {
//         $orderBy = !empty($this->input->get('orderBy')) ? $this->input->get('orderBy') : 'lb_project_id';
//         $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
//         if(!is_admin()) {
//             die('You dont have permission to edit');
//         }
//         $projId = $this->input->get('proj');
//         if($projId <= 0) {
//             echo 'Invalid Proj ID';
//             return;
//         }
//         $projects = $this->projModel->getAllProjects($order, $orderBy);;
//         $proj = $this->projModel->getProjById($projId);
//         $this->load->view('admin/project/edit', array(
//                         'proj'          => $proj,
//                         'statusNames'   => $this->statusNames
//         ));
//     }

//     /**
//      *
//      */
//     public function delete()
//     {
//         global $msg;
//         if(!is_admin()) {
//             die('You dont have permission to delete');
//         }
//         $projId = (int)$this->input->get('proj');
//         if($projId <= 0) {
//             echo 'Invalid Proj ID';
//             return;
//         }
//         if ($this->projModel->deleteProject($projId)) {
//             $msg = "Project $projId is deleted";
//             wp_redirect(get_option('siteurl') .'/wp-admin/admin.php?page=landbook-projects');
//         } else {
//             echo 'Can not delete this project';
//             return;
//         }
//     }

//     /**
//      *
//      */
//     public function update()
//     {
//         $name = $this->input->post('proj-name');
//         $status = $this->input->post('status');
//         $id = $this->input->post('proj-id');
//         $proj = array(
//                         'lb_project_id' => $id,
//                         'name'          => $name,
//                         'status'        => $status
//         );
//         if ($this->projModel->updateProject($proj)) {
//             wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-projects');
//         } else {
//             die('Server is busy');
//         }
//     }

//     /**
//      *
//      */
//     public function filterAction()
//     {
//         $s = $this->input->post('s');
//         $status = $this->input->post('status');
//         $orderBy = !empty($this->input->get('orderBy')) ? $this->input->get('orderBy') : 'lb_project_id';
//         $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
//         $projects = $this->projModel->filterProject($s, $status, $orderBy, $order);
//         $numProj = $this->projModel->countFilterProject($s, $status);
//         $projTable = new MY_LB_Project_Manage();
//         $projTable->prepare_items($projects, $numProj);
//         $this->load->view('admin/project/view_all', array(
//                         'projTable'     => $projTable,
//                         'statusNames'   => $this->statusNames
//         ));
//     }

//     /**
//      *
//      */
//     public function importProjects()
//     {
//         $this->load->view('admin/project/import_projects');
//     }

// }
