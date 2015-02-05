<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 1/31/15
 * Time: 1:24 PM
 */
class Group_Model extends Land_Book_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getListGroups()
    {
        $sql = "SELECT pk_term_taxonomy.*, pk_terms.*, (SELECT COUNT(pk_sc_user_groups.user_id) FROM pk_sc_user_groups WHERE pk_sc_user_groups.group_id = pk_term_taxonomy.term_taxonomy_id ) as count_user_in_group FROM pk_term_taxonomy
                    LEFT JOIN pk_terms ON pk_terms.term_id = pk_term_taxonomy.term_id
                    WHERE pk_term_taxonomy.taxonomy = ?
                    ORDER BY pk_terms.name ASC";
        $groups = $this->db->query($sql, 'sc_group')->result_array();
        return $groups;
    }

    public function countUsersInGroup($taxonomyId)
    {
        $sql = "SELECT COUNT(pk_sc_user_groups.user_id) as count_users_in_group FROM pk_sc_user_groups
                    WHERE pk_sc_user_groups.group_id = ?";
        $count = $this->db->query($sql,$taxonomyId)->result_array();
        return $count[0]['count_users_in_group'];
    }

    public function getGroupsByTermId($termId)
    {
        $sql = "SELECT pk_term_taxonomy.*, pk_terms.* FROM pk_term_taxonomy
                    LEFT JOIN pk_terms ON pk_terms.term_id = pk_term_taxonomy.term_id AND pk_terms.term_id = ?
                    WHERE pk_term_taxonomy.taxonomy = ? AND pk_term_taxonomy.term_id = ?
                    ORDER BY pk_terms.name ASC";
        $groups = $this->db->query($sql, array($termId, 'sc_group', $termId))->result_array();
        return $groups[0];
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