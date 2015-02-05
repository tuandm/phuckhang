<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 1/31/15
 * Time: 1:24 PM
 */
require_once('land_book_model.php');
class Group_Model extends Land_Book_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getListGroups()
    {
        $this->db
            ->select('pk_terms.name, pk_terms.slug, pk_term_taxonomy.description, pk_term_taxonomy.term_id')
            ->from('pk_term_taxonomy')
            ->join('pk_terms', 'pk_terms.term_id = pk_term_taxonomy.term_id', 'left')
            ->where('pk_term_taxonomy.taxonomy', 'sc_group')
            ->order_by('pk_terms.name', 'ASC');
        $groups = $this->db->get()->result_array();
        return $groups;
    }

    public function countUsersInGroup($termId)
    {
        $select =   array(
            'count(pk_sc_user_groups.user_id) as count_users_in_group'
        );
        $this->db
            ->select($select)
            ->from('pk_sc_user_groups')
            ->where('pk_sc_user_groups.group_id', $termId);
        $count = $this->db->get()->result_array();
        return $count[0]['count_users_in_group'];
    }

    public function getGroupsByTermId($termId)
    {
        $this->db
            ->select('pk_terms.name, pk_terms.slug, pk_term_taxonomy.description, pk_term_taxonomy.term_id')
            ->from('pk_term_taxonomy')
            ->join('pk_terms', 'pk_terms.term_id = pk_term_taxonomy.term_id AND pk_terms.term_id = ' .$termId, 'left')
            ->where('pk_term_taxonomy.taxonomy', 'sc_group')
            ->where('pk_term_taxonomy.term_id', $termId);
        $groups = $this->db->get()->row();
        return $groups;
    }

    public function addNewGroupTaxonomy(array $data)
    {
        return $this->create('pk_term_taxonomy', $data);
    }

    public function addNewTerm(array $data)
    {
        return $this->create('pk_terms', $data);
    }

    public function updateTerm(array $term)
    {
        return $this->update('pk_terms', $term);
    }

    public function saveTerm(array $term)
    {
        if (isset($term['term_id'])) {
            return $this->updateTerm($term);
        } else {
            return $this->addNewTerm($term);
        }
    }

    public function updateDescriptionGroup(array $des)
    {
        return $this->update('pk_term_taxonomy', $des);
    }

}