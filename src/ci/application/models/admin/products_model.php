<?php
/**
 * Created by PhpStorm.
 * User: Phat Nguyen
 * Date: 10/02/15
 */

require_once(dirname(dirname(__FILE__)) . "/land_book_model.php");
class Products_Model extends Land_Book_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addProduct($product)
    {
        return $this->create('pk_lb_products', $product);
    }

    public function getAllProducts($order, $orderBy)
    {
        $this->db
        ->select('*')
        ->from('pk_lb_products')
        ->order_by($orderBy, $order);
        $products = $this->db->get()->result_array();
        return $products;
    }

    public function countAllProducts()
    {
        return $this->db
        ->select('*')
        ->from('pk_lb_products')
        ->count_all_results();
    }

    public function getProductById($productId)
    {
        $this->db
        ->select('pk_lb_products.lb_product_id, pk_lb_products.price, pk_lb_products.code, pk_lb_products.status, pk_lb_products.lb_project_id')
        ->from('pk_lb_products')
        ->where('pk_lb_products.lb_product_id', $productId);
        $product = $this->db->get()->row();
        return $product;
    }

    public function getProductByCode($code)
    {
        $this->db
        ->select('pk_lb_products.lb_product_id')
        ->from('pk_lb_products')
        ->where('pk_lb_products.code', $code);
        $productId = $this->db->get()->row();
        return $productId;
    }

    public function getProjectById($projectId)
    {
        $this->db
        ->select('pk_lb_projects.name')
        ->from('pk_lb_projects')
        ->where('pk_lb_projects.lb_project_id', $projectId);
        $project = $this->db->get()->row();
        return $project;
    }

    public function getProjectByName($projectName)
    {
        $this->db
        ->select('pk_lb_projects.lb_project_id')
        ->from('pk_lb_projects')
        ->where('pk_lb_projects.name', $projectName);
        $project = $this->db->get()->row();
        return $project;
    }

    public function getAllProjects()
    {
        $this->db
        ->select('pk_lb_projects.lb_project_id, pk_lb_projects.name')
        ->from('pk_lb_projects');
        $projects = $this->db->get()->result_array();
        return $projects;
    }
    

    public function getNameStatusByNumber($statusNum)
    {
        $statusName = '';
        switch($statusNum) {
            case 0: $statusName = 'All Status';
            break;
            case 1: $statusName = 'Deposited';
            break;
            case 2: $statusName = 'Sold';
            break;
            case 3: $statusName = 'Unsold';
            break;
        }
        return $statusName;
    }

    public function updateProduct(array $data)
    {
        $where = array('lb_product_id' => $data['lb_product_id']);
        unset($data['lb_product_id']);
        return $this->db->update('pk_lb_products', $data, $where);
    }

    /**
     *
     * @param unknown $data
     */
    public function deleteProduct($data)
    {
        return $this->db->delete('pk_lb_products', array('lb_product_id' => $data));
    }

    public function filterProduct($code, $status, $orderBy, $order)
    {
        if ($status == 0) {
            $this->db->select('*')
            ->like('code',$code)
            ->order_by($orderBy, $order);;
            $results = $this->db->get('pk_lb_products')->result_array();
        } else {
            $this->db->select('*')
            ->where('status', $status)
            ->like('code',$code)
            ->order_by($orderBy, $order);;
            $results = $this->db->get('pk_lb_products')->result_array();
        }
        return $results;
    }

    public function countFilterProduct($code, $status)
    {
        if ($status == 0) {
            $results = $this->db->select('*')
            ->like('code',$code)
            ->from('pk_lb_products')
            ->count_all_results();
        } else {
            $results = $this->db->select('*')
            ->from('pk_lb_products')
            ->where('status', $status)
            ->like('code', $code)
            ->count_all_results();
        }
        return $results;
    }

}
