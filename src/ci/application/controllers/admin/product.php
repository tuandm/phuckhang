<?php
/**
 * User: Storm
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . "./third_party/PHPExcel/IOFactory.php";

class Product extends CI_Controller {

    private $statusValues = array(0, 1, 2, 3);
    private $statusNames;
    private $productTable;
    private $products;
    private $order;
    private $orderBy;
    private $checkHeader;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('lb_product_management');
        $this->load->model('admin/Products_Model', 'productModel');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('url');
        $this->productTable = new Lb_Product_Management();
        $this->load->library('upload');
        foreach ($this->statusValues as $value) {
            $this->statusNames[$value] = $this->productModel->getNameStatusByNumber($value);
        }
        $this->checkHeader = $this->input->get('noheader');
        if (isset($this->checkHeader)) {
            require_once(ABSPATH . 'wp-admin/admin-header.php');
        }
        $this->orderBy = !empty($this->input->get('orderby')) ? $this->input->get('orderby') : 'code';
        $this->order = !empty($this->input->get('order')) ? $this->input->get('order') : 'ASC';
    }
    
    /**
     *
     */
    public function index()
    {
        $this->products = $this->productModel->getAllProducts($this->order, $this->orderBy);
        $numProduct = $this->productModel->countAllProducts();
        $this->productTable->prepare_items($this->products, $numProduct);
        $this->load->view('admin/product/view_all',
                array(
                                'productTable'  => $this->productTable,
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
        if (!is_admin()) {
            die('You dont have permission to edit');
        }
        $productId = $this->input->get('proc') ? $this->input->get('proc') : $this->input->post('product-id');
        if ($productId <= 0) {
            echo 'Invalid Proj ID';
            return;
        }
        $product = $this->productModel->getProductById($productId);
        $projectName = $this->productModel->getProjectById($product->lb_project_id);
        $projects = $this->productModel->getAllProjects();
        $projectsNameArray = wp_list_pluck($projects, 'name', 'lb_project_id');
        $this->load->view('admin/product/edit', array(
            'product'       => $product,
            'statusNames'   => $statusEditNames,
            'projects'      => $projectsNameArray,
            'projectName'   => $projectName
        ));
    }

    /**
     *
     */
    public function delete()
    {
        if(!is_admin()) {
            die('You dont have permission to delete');
        }
        $productId = (int) $this->input->get('proc');
        if($productId <= 0) {
            echo 'Invalid Product ID';
            return;
        }
        if ($this->productModel->deleteProduct($productId)) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-products');
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
        $this->form_validation->set_rules('product-code', 'Code', 'min_length[3]|max_length[10]|required|callback_checkProductCode');
        $this->form_validation->set_rules('price', 'Price', 'required|is_natural_no_zero');
        if ($this->form_validation->run() == FALSE) {
            return $this->edit();
        } else {
            $code = $this->input->post('product-code');
            $status = $this->input->post('status');
            $price = $this->input->post('price');
            $projId = $this->input->post('project-name');
            $productId = $this->input->post('product-id');
            $product = array(
                            'lb_product_id'     => $productId,
                            'code'              => $code,
                            'status'            => $status,
                            'price'             => $price,
                            'lb_project_id'     => $projId
            );
            if ($this->productModel->updateProduct($product)) {
                wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=landbook-products');
            } else {
                die('Server is busy');
            }
        }
    }

    public function checkProductCode()
    {
        $id = $this->input->post('product-id');
        $code = $this->input->post('product-code');
        $checkedProductId = $this->productModel->getProductByCode($code);
        if (($id == $checkedProductId->lb_product_id) || empty($checkedProductId)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkProductCode', 'This code is used by another product');
            return FALSE;
        }
    }

    /**
     *
     */
    public function filterAction()
    {
        $s = $this->input->get('s');
        $status = $this->input->get('status');
        $this->products = $this->productModel->filterProduct($s, $status, $this->orderBy, $this->order);
        $numProduct = $this->productModel->countFilterProduct($s, $status);
        $this->productTable->prepare_items($this->products, $numProduct);
        $this->load->view('admin/product/view_all', array(
            'productTable'  => $this->productTable,
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
