<?php
/**
 * Feed Model for admin
 * @author Storm
 * @package LandBook
 */


class LandBook_Model_Project extends LandBook_Model
{
    public function getProducts($projectId)
    {
        $query = "SELECT *
                  FROM pk_lb_products
                  WHERE lb_project_id = $projectId";
        $products = $this->getResults($query, $projectId);
        return $products;
    }
}
