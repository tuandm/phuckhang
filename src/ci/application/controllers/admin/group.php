<?php
/**
 * User: Duc Duong
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("Land_Book_Model");
        $this->load->model('Group_Model', 'Group_Model');
    }

    public function index()
    {
        if (isset($_POST['update']))
        {
            echo "aaa";
        }
        $groups = $this->Group_Model->getListGroups();
        $this->load->view('admin/group/view_all', array(
            'groups' => $groups,
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
        $termID = $this->Group_Model->addNewTerm($term);
        $groups = array(
            'taxonomy' => 'sc_group',
            'term_id' => $termID,
            'description' => $txtDescription
        );
        $check = $this->Group_Model->addNewGroupTaxonomy($groups);
        if (!empty($check)) {
            echo "Add success!";
        } else {

        }
    }

    public function edit()
    {
        $termId = intval($_REQUEST['termid']);
        $groups = $this->Group_Model->getGroupByTermId($termId);
        $this->load->view('admin/group/edit', array(
            'groups' => $groups,
        ));
    }

    public function editGroup()
    {
        $name = $this->input->post('name');
        $slug = $this->input->post('slug');
        $description = $this->input->post('description');
        $id = $this->input->post('id');
        $egroup = array(
            'term_id' => $id,
            'name' => $name,
            'slug' => $slug
        );
        $this->Group_Model->saveTerm($egroup);
        $des = array(
            'term_id' => $id,
            'description' => $description,
        );
        $this->Group_Model->updateDescriptionGroup($des);
        echo "Edit success";
    }

}