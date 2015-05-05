<?php
/**
 * Feed Model for admin
 * @author Storm
 * @package LandBook
 */


class LandBook_Model_Project extends LandBook_Model
{
    public function getProducts($where = null)
    {
        $products = $this->getWpdb()->get_results(
            "SELECT *
             FROM pk_lb_products
             ".$where."
            ");
        return $products;
    }

    public function searchKeywork($status, $area, $price)
    {
        $keyword = '';

        if (!empty($status) && $status != 'Tình Trạng') {
            $keyword .= " AND status ='".$status."'";
        }

        if (!empty($area) && $area != 'Diện Tích') {
            $keyword .= " AND area ='".$area."'";
        }

        if (!empty($price) && $price != 'Giá') {
            $keyword .= " AND price ='".$price."'";
        }

        return $keyword;
    }
}
