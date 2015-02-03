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
        //"SELECT *,(SELECT COUNT(*) FROM $users LEFT JOIN $user_groups AS u2 ON (u2.user_id =$users.ID) WHERE u2.group_id = u1.group_id) as user_count FROM $user_groups u1 LEFT JOIN $term_taxonomy t1 ON (t1.term_taxonomy_id = u1.group_id)  WHERE 1=1 GROUP BY (u1.group_id) ORDER BY u1.sc_user_groups_id ASC"

        $sql = "SELECT pk_term_taxonomy.*,pk_terms.* FROM pk_term_taxonomy
                    LEFT JOIN pk_terms ON pk_terms.term_id = pk_term_taxonomy.term_id
                    WHERE pk_term_taxonomy.taxonomy = 'sc_group'
                    ORDER BY pk_terms.name ASC";
        $groups = $this->db->query($sql)->result_array();
        return $groups;
    }

    public function getGroupByTermId($termid)
    {
        $sql = "SELECT pk_term_taxonomy.*,pk_terms.* FROM pk_term_taxonomy
                    LEFT JOIN pk_terms ON pk_terms.term_id = pk_term_taxonomy.term_id AND pk_terms.term_id = ?
                    WHERE pk_term_taxonomy.taxonomy = 'scgroup' AND pk_term_taxonomy.term_id =" .$termid.
                    " ORDER BY pk_terms.name ASC";
        $groups = $this->db->query($sql,$termid)->result_array();
        return $groups;
    }

    public function addNewGroupTaxonomy(array $data)
    {
        return $this->create('pk_term_taxonomy',$data);
    }

    public function addNewTerm(array $data)
    {
        return $this->create('pk_terms',$data);
    }

    public function updateTerm(array $term)
    {
        return $this->updateGroup('pk_terms',$term);
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
        return $this->updateGroup('pk_term_taxonomy',$des);
    }

}