<?php
/**
 * User: Storm
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."./third_party/PHPExcel/IOFactory.php";

class Product extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Product_Model', 'productModel');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('admin/product/view_all');
    }

    public function addProduct()
    {
        $config['upload_path'] = 'upload';
        $config['allowed_types'] = 'xls|xlsx';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('myFile')) {
            $error = $this->upload->display_errors();
            echo $error;
        }
        else {
            $project = $this->input->post('txtProject');
            $projectName = array(
                'name' => $project
            );
            $projectId = $this->productModel->addProject($projectName);

            $data = $this->upload->data();
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

                $products = array (
                    'code' => $rowProduct[1],
                    'price' => $rowProduct[7],
                    'length' => $rowProduct[4],
                    'width' => $rowProduct[3],
                    'area' => $rowProduct[5],
                    'status' => $this->getProductStatus($rowProduct[8]),
                    'lb_project_id' => $projectId
                );

                $this->productModel->addProduct($products);
            }
        }

    }

    protected function getProductStatus($value)
    {
       switch ($value) {
           case '' :
               return '3';
           case 'Đã bán' :
               return '2';
           case 'Book' :
               return '1';
       }
    }
}