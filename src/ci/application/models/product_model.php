<?php
/**
 * Created by PhpStorm.
 * User: Storm
 * Date: 2/9/15
 * Time: 11:32 AM
 */
require_once('land_book_model.php');
class Product_Model extends Land_Book_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addProduct($product)
    {
        return $this->create('pk_lb_products', $product);
    }
}