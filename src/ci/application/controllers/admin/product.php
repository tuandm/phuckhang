<?php
/**
 * User: Storm
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."./third_party/PHPExcel/IOFactory.php";

class Product extends CI_Controller {

    private $statusValues = array(0, 1, 2, 3);
    private $statusNames;
    private $productTable;
    private $products;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('lbProductManage');
        $this->load->model('admin/Products_Model', 'productModel');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url');
        $this->productTable = new MY_LBProductManage();
        $this->load->library('upload');
        foreach ($this->statusValues as $value) {
            $this->statusNames[$value] = $this->productModel->getNameStatusByNumber($value);
        }
    }
    
    /**
     *
     */
    public function index()
    {
        $msg = '';
        $orderBy = !empty($this->input->get('orderby')) ? $this->input->get('orderby') : 'code';
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $this->products = $this->productModel->getAllProducts($order, $orderBy);
        $numProduct = $this->productModel->countAllProducts();
        $this->productTable->prepare_items($this->products, $numProduct);
        $this->load->view('admin/product/view_all',
                array(
                                'productTable'     => $this->productTable,
                                'msg'           => $msg,
                                'statusNames'   => $this->statusNames,
                ));
    }

    /**
     *
     */
    public function edit()
    {
        $statusEditValues = array(1, 2, 3);
        foreach ($statusEditValues as $value) {
            $statusEditNames[$value] = $this->productModel->getNameStatusByNumber($value);
        }
        $orderBy = !empty($this->input->get('orderBy')) ? $this->input->get('orderBy') : 'code';
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        if(!is_admin()) {
            die('You dont have permission to edit');
        }
        $productId = $this->input->get('proc');
        if($productId <= 0) {
            echo 'Invalid Proj ID';
            return;
        }
        $product = $this->productModel->getProductById($productId);
        $this->load->view('admin/product/edit', array(
            'product'       => $product,
            'statusNames'   => $statusEditNames
        ));
    }

    /**
     *
     */
    public function delete()
    {
        global $msg;
        if(!is_admin()) {
            die('You dont have permission to delete');
        }
        $productId = (int)$this->input->get('proc');
        if($productId <= 0) {
            echo 'Invalid Product ID';
            return;
        }
        if ($this->productModel->deleteProduct($productId)) {
            $msg = "Product $productId is deleted";
            wp_redirect(get_option('siteurl') .'/wp-admin/admin.php?page=landbook-products');
        } else {
            echo 'Can not delete this product';
            return;
        }
    }

    /**
     *
     */
    public function update()
    {
        $this->form_validation->set_rules('product-code', 'Code', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('proj-id', 'Project Id', 'required|is_natural_no_zero');
        if ($this->form_validation->run() == FALSE)
        {
            return $this->edit();
        } else {
            $code = $this->input->post('product-code');
            $status = $this->input->post('status');
            $price = $this->input->post('price');
            $projId = $this->input->post('proj-id');
            $productId = $this->input->post('product-id');
            $product = array(
                            'lb_product_id'     => $productId,
                            'code'              => $code,
                            'status'            => $status,
                            'price'             => $price,
                            'lb_project_id'     => $projId,
            );
            if ($this->productModel->updateProduct($product)) {
                wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-products');
            } else {
                die('Server is busy');
            }
        }
    }

    /**
     *
     */
    public function filterAction()
    {
        $s = $this->input->post('s');
        $status = $this->input->post('status');
        $orderBy = !empty($this->input->get('orderBy')) ? $this->input->get('orderBy') : 'code';
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
        $products = $this->productModel->filterProduct($s, $status, $orderBy, $order);
        $numProduct = $this->productModel->countFilterProduct($s, $status);
        $productTable = new MY_LB_Product_Manage();
        $productTable->prepare_items($products, $numProduct);
        $this->load->view('admin/product/view_all', array(
            'productTable'  => $productTable,
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

    public function addProduct()
    {
        if ($this->upload->do_upload('myFile'))
        {
            $data = $this->upload->data();
            //$inputFileName = APPPATH. "./upload/Bang_gia_30_lÃ´.xls";
            $inputFileName = $data['full_path'];

            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow() - 1;
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 6; $row <= $highestRow; $row++){
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE);
                $rowProduct = $rowData[0];
                $product = array (
                    'code' => $rowProduct[1],
                    'price' => $rowProduct[7],
                    'length' => $rowProduct[4],
                    'width' => $rowProduct[3],
                    'area' => $rowProduct[5],
                    'status' => $this->getProductStatus($rowProduct[8])
                );
                $this->productModel->addProduct($product);
            }
        } else {
            $errors = $this->upload->display_errors();
        }
    }

    protected function getProductStatus($value)
    {
       switch ($value) {
           case '' :
               return '3';
           case 'Ä�Ã£ bÃ¡n' :
               return '2';
           case 'Book' :
               return '1';
       }
    }

}
