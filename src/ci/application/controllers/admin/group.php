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
    }

    public function index()
    {
        $groups = $this->groupModel->getListGroups();

        foreach ($groups as &$group)
        {
            $totalUsers = $this->groupModel->countUsersInGroup($group['term_id']);
            $group['count_users_in_group'] = $totalUsers;
        }

        $this->load->view('admin/group/view_all', array(
            'groups' => $groups
        ));
    }

    public function addNewGroup()
    {
        $txtName = $this->input->post('txtName');
        $txtSlug = $this->input->post('txtSlug');
        $txtDescription = $this->input->post('txtDescription');

        $term = array(
            'name' => $txtName,
            'slug' => $txtSlug
        );
        $termId = $this->groupModel->addNewTerm($term);

        $groups = array(
            'taxonomy' => 'sc_group',
            'term_id' => $termId,
            'description' => $txtDescription
        );
        $result = $this->groupModel->addNewGroupTaxonomy($groups);

        if (!empty($result)) {
            echo "Add success!";
        } else {
            echo "Add failed!";
        }
    }

    public function edit()
    {
        $termId = intval($this->input->get('termId'));

        if($termId <= 0)
        {
            echo "Invalid Group ID";
            return;
        }

        $group = $this->groupModel->getGroupsByTermId($termId);
        $this->load->view('admin/group/edit', array(
            'group' => $group
        ));
    }

    public function updateGroup()
    {
        $name = $this->input->post('name');
        $slug = $this->input->post('slug');
        $description = $this->input->post('description');
        $id = $this->input->post('id');

        $group = array(
            'term_id' => $id,
            'name' => $name,
            'slug' => $slug
        );
        $this->groupModel->saveTerm($group);

        $des = array(
            'term_id' => $id,
            'description' => $description
        );
        $this->groupModel->updateDescriptionGroup($des);

        echo "Edit success";
    }

}