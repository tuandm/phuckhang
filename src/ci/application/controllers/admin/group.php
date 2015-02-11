<?php
/**
 * User: Storm
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Group_Model', 'groupModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $groups = $this->groupModel->getListGroups();

        foreach ($groups as &$group) {
            $totalUsers = $this->groupModel->countUsersInGroup($group['term_id']);
            $group['count_users_in_group'] = $totalUsers;
        }

        $this->load->view('admin/group/view_all', array(
            'groups' => $groups
        ));
    }

    public function addNewGroup()
    {
        $this->form_validation->set_rules('txtName', 'Name', 'required');
        $this->form_validation->set_rules('txtDescription', 'Description', 'required');

        if ($this->form_validation->run()==FALSE)
        {
            return $this->index();
        } else {
            $txtName = $this->input->post('txtName');
            $txtSlug = $this->input->post('txtSlug');

            $groupId = $this->groupModel->addNewGroup([
                'slug'  => $txtSlug == "" ? preg_replace("/[\s_]/", "-", $txtName) : $txtSlug,
                'name'  => $txtName
            ]);

            $txtDescription = $this->input->post('txtDescription');
            $groups = array(
                'taxonomy' => 'sc_group',
                'term_id' => $groupId,
                'description' => $txtDescription
            );
            $result = $this->groupModel->addNewGroupTaxonomy($groups);

            if (!empty($result))
            {
                echo "Add success!";
                $this->index();
            } else {
                echo "Add failed!";
            }
        }

    }

    public function edit()
    {
        $groupId = (int)$this->input->get('groupId');

        if ($groupId <= 0)
        {
            echo "Invalid Group ID";
            return;
        }

        $group = $this->groupModel->getGroupById($groupId);
        $this->load->view('admin/group/edit', array(
            'group' => $group
        ));
    }

    public function updateGroup()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run()==FALSE)
        {
            return $this->edit();
        } else {
            $name = $this->input->post('name');
            $slug = $this->input->post('slug');
            $description = $this->input->post('description');
            $id = $this->input->post('id');

            $this->groupModel->saveGroup([
                'slug'  => $slug == "" ? preg_replace("/[\s_]/", "-", $name) : $slug,
                'name'  => $name,
                'term_id' => $id
            ]);

            $des = array(
                'term_id' => $id,
                'description' => $description
            );
            $this->groupModel->updateGroupDescription($des);

            echo "Edit success";
            $this->index();
        }
    }

}